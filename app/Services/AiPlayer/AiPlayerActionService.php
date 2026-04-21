<?php

namespace OGame\Services\AiPlayer;

use Exception;
use Illuminate\Support\Facades\Log;
use OGame\Enums\AiPlayerProfile;
use OGame\Factories\PlayerServiceFactory;
use OGame\GameObjects\Models\Units\UnitCollection;
use OGame\Models\AiPlayer;
use OGame\Models\AiPlayerLog;
use OGame\Models\Enums\PlanetType;
use OGame\Models\Planet;
use OGame\Models\Planet\Coordinate;
use OGame\Models\Resources;
use OGame\Models\User;
use OGame\Exceptions\QueueFullException;
use OGame\Services\AiPlayer\Strategies\AiPlayerStrategyInterface;
use OGame\Services\BuildingQueueService;
use OGame\Services\FleetMissionService;
use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;
use OGame\Services\ResearchQueueService;
use OGame\Services\UnitQueueService;
use OGame\ViewModels\Queue\Abstracts\QueueListViewModel;

/**
 * Core decision engine for AI players.
 *
 * Processes each AI player's turn: checking queues, building, researching,
 * constructing units, dispatching fleets, and colonizing new planets.
 */
class AiPlayerActionService
{
    /**
     * Maximum number of items allowed in the building queue.
     *
     * Delegates to the single source of truth in QueueListViewModel so that
     * changing the queue limit in one place is reflected everywhere.
     */
    private const MAX_BUILDING_QUEUE_SLOTS = QueueListViewModel::BUILDING_QUEUE_SLOT_LIMIT;

    public function __construct(
        private PlayerServiceFactory $playerServiceFactory,
        private BuildingQueueService $buildingQueueService,
        private ResearchQueueService $researchQueueService,
        private UnitQueueService $unitQueueService,
        private AiPlayerTargetService $targetService,
    ) {
    }

    /**
     * Process a single AI player's turn.
     *
     * @param AiPlayer $aiPlayer
     * @return int Number of actions taken.
     */
    public function processPlayer(AiPlayer $aiPlayer): int
    {
        // Skip if sleeping
        if ($aiPlayer->isSleeping()) {
            $this->logAction($aiPlayer, 'sleep_skip', [], 'skipped');
            $aiPlayer->scheduleNextAction();
            return 0;
        }

        // Human-like: occasional "forget" (5% chance at difficulty < 4)
        if ($aiPlayer->difficulty_level < 4 && rand(1, 20) === 1) {
            $this->logAction($aiPlayer, 'idle_skip', ['reason' => 'human_variance'], 'skipped');
            $aiPlayer->scheduleNextAction();
            return 0;
        }

        $strategy = $this->targetService->resolveStrategy($aiPlayer->profile);
        $playerService = $this->playerServiceFactory->make($aiPlayer->user_id, true);
        $actionsExecuted = 0;

        // Update the user's last activity timestamp so the AI player does not
        // appear as inactive/offline in the galaxy view.
        $user = $playerService->getUser();
        $user->time = (string) now()->timestamp;
        $user->save();

        // Try to colonize a new planet (once per turn, not per planet).
        $actionsExecuted += $this->tryColonize($aiPlayer, $strategy, $playerService);

        // Process each planet
        foreach ($playerService->planets->allPlanets() as $planet) {
            $actionsExecuted += $this->processPlanet($aiPlayer, $strategy, $playerService, $planet);
        }

        // Schedule next action with randomized delay
        $aiPlayer->scheduleNextAction();

        return $actionsExecuted;
    }

    /**
     * Process actions for a single planet.
     */
    private function processPlanet(
        AiPlayer $aiPlayer,
        AiPlayerStrategyInterface $strategy,
        PlayerService $playerService,
        PlanetService $planet,
    ): int {
        $actions = 0;

        // 1. Try to build a building
        $actions += $this->tryBuildBuilding($aiPlayer, $strategy, $playerService, $planet);

        // 2. Try to start research
        $actions += $this->tryStartResearch($aiPlayer, $strategy, $playerService, $planet);

        // 3. Try to build units (ships/defense)
        $actions += $this->tryBuildUnits($aiPlayer, $strategy, $planet);

        // 4. Try to dispatch a fleet action (transport, espionage, expedition)
        $actions += $this->tryFleetAction($aiPlayer, $strategy, $playerService, $planet);

        return $actions;
    }

    /**
     * Attempt to add buildings to the queue for the planet.
     *
     * Loops until the queue is full or no more buildable buildings remain,
     * filling the queue with diverse buildings from the strategy's priority list.
     * Each iteration skips buildings already scheduled so the AI considers all
     * buildings rather than always queuing the same one.
     *
     * Success events are aggregated into a single log entry per planet/turn to
     * avoid unbounded DB write growth when the queue fills up in one shot.
     */
    private function tryBuildBuilding(
        AiPlayer $aiPlayer,
        AiPlayerStrategyInterface $strategy,
        PlayerService $playerService,
        PlanetService $planet,
    ): int {
        // Only act based on building priority weight
        if (rand(1, 10) > $aiPlayer->priority_building) {
            return 0;
        }

        // Collect machine names already present in the building queue so that
        // decideBuildingPriority can skip them and pick the next priority building.
        $queueItems = $this->buildingQueueService->retrieveQueueItems($planet);
        $alreadyQueued = [];
        foreach ($queueItems as $item) {
            try {
                $object = ObjectService::getObjectById($item->object_id);
                $alreadyQueued[] = $object->machine_name;
            } catch (\Throwable) {
                // Ignore unknown objects.
            }
        }

        // Only try to add as many buildings as there are free slots in the queue.
        $remainingSlots = self::MAX_BUILDING_QUEUE_SLOTS - $queueItems->count();
        if ($remainingSlots <= 0) {
            return 0;
        }

        $addedObjectIds = [];

        // Try to fill the available queue slots with diverse buildings from the priority list.
        for ($i = 0; $i < $remainingSlots; $i++) {
            $buildingId = $strategy->decideBuildingPriority($planet, $playerService, $alreadyQueued);
            if ($buildingId === null) {
                break;
            }

            try {
                $this->buildingQueueService->add($planet, $buildingId);
                $object = ObjectService::getObjectById($buildingId);
                $alreadyQueued[] = $object->machine_name;
                $addedObjectIds[] = $buildingId;
            } catch (QueueFullException $e) {
                // Queue is already full – no point trying further buildings this turn.
                $this->logAction($aiPlayer, 'build', [
                    'planet_id' => $planet->getPlanetId(),
                    'object_id' => $buildingId,
                ], 'failed', $e->getMessage());
                break;
            } catch (Exception $e) {
                $this->logAction($aiPlayer, 'build', [
                    'planet_id' => $planet->getPlanetId(),
                    'object_id' => $buildingId,
                ], 'failed', $e->getMessage());

                // For other errors (unmet requirements, invalid planet type, …) skip this
                // building and continue attempting the remaining priorities.
                try {
                    $object = ObjectService::getObjectById($buildingId);
                    $alreadyQueued[] = $object->machine_name;
                } catch (\Throwable) {
                    // Cannot resolve object – stop to avoid an infinite loop.
                    break;
                }
            }
        }

        // Emit a single aggregated success log entry for this planet/turn instead
        // of one entry per building to keep DB write load proportional.
        if (!empty($addedObjectIds)) {
            $this->logAction($aiPlayer, 'build', [
                'planet_id'  => $planet->getPlanetId(),
                'object_ids' => $addedObjectIds,
                'count'      => count($addedObjectIds),
            ], 'success');
        }

        return count($addedObjectIds);
    }

    /**
     * Attempt to start a research.
     */
    private function tryStartResearch(
        AiPlayer $aiPlayer,
        AiPlayerStrategyInterface $strategy,
        PlayerService $playerService,
        PlanetService $planet,
    ): int {
        // Only act based on research priority weight
        if (rand(1, 10) > $aiPlayer->priority_research) {
            return 0;
        }

        $researchId = $strategy->decideResearchPriority($playerService, $planet);
        if ($researchId === null) {
            return 0;
        }

        try {
            $this->researchQueueService->add($playerService, $planet, $researchId);
            $this->logAction($aiPlayer, 'research', [
                'planet_id' => $planet->getPlanetId(),
                'object_id' => $researchId,
            ], 'success');
            return 1;
        } catch (Exception $e) {
            $this->logAction($aiPlayer, 'research', [
                'planet_id' => $planet->getPlanetId(),
                'object_id' => $researchId,
            ], 'failed', $e->getMessage());
            return 0;
        }
    }

    /**
     * Attempt to build units (ships and defense).
     */
    private function tryBuildUnits(
        AiPlayer $aiPlayer,
        AiPlayerStrategyInterface $strategy,
        PlanetService $planet,
    ): int {
        // Only act based on fleet priority weight
        if (rand(1, 10) > $aiPlayer->priority_fleet) {
            return 0;
        }

        $units = $strategy->decideUnitBuild($planet);
        if (empty($units)) {
            return 0;
        }

        $actionsCount = 0;

        foreach ($units as $objectId => $amount) {
            // Skip units whose per-unit cost exceeds storage capacity – such units can never
            // be afforded as resources cannot accumulate beyond the storage limit.
            try {
                $object = ObjectService::getObjectById($objectId);
                $cost = ObjectService::getObjectPrice($object->machine_name, $planet);
                if ($strategy->getStorageBottleneck($cost, $planet) !== null) {
                    Log::channel('ai')->info('Skipping unit build – cost exceeds storage capacity', [
                        'planet_id' => $planet->getPlanetId(),
                        'object_id' => $objectId,
                    ]);
                    continue;
                }
            } catch (\Throwable $e) {
                // If we cannot determine the cost, proceed and let the queue service
                // handle the validation failure with its own error reporting.
                Log::channel('ai')->warning('Failed to check unit cost vs. storage', [
                    'object_id' => $objectId,
                    'planet_id' => $planet->getPlanetId(),
                    'error'     => $e->getMessage(),
                ]);
            }

            try {
                $this->unitQueueService->add($planet, $objectId, $amount);
                $this->logAction($aiPlayer, 'unit_build', [
                    'planet_id' => $planet->getPlanetId(),
                    'object_id' => $objectId,
                    'amount' => $amount,
                ], 'success');
                $actionsCount++;
            } catch (Exception $e) {
                $this->logAction($aiPlayer, 'unit_build', [
                    'planet_id' => $planet->getPlanetId(),
                    'object_id' => $objectId,
                    'amount' => $amount,
                ], 'failed', $e->getMessage());
            }
        }
        return $actionsCount;
    }

    /**
     * Attempt to dispatch a fleet action (transport, espionage, expedition) from a planet.
     *
     * The strategy returns a description of the desired action. This method validates
     * that the required ships are actually on the planet, builds the UnitCollection,
     * determines the resources to carry (for transport missions all current resources
     * are included), and dispatches the mission via FleetMissionService.
     */
    private function tryFleetAction(
        AiPlayer $aiPlayer,
        AiPlayerStrategyInterface $strategy,
        PlayerService $playerService,
        PlanetService $planet,
    ): int {
        // Only act based on fleet priority weight
        if (rand(1, 10) > $aiPlayer->priority_fleet) {
            return 0;
        }

        $action = $strategy->decideFleetAction($playerService, $planet);
        if ($action === null) {
            return 0;
        }

        // Do not attack or spy on players who are in the same alliance as the AI.
        if ($this->isAllyTarget($aiPlayer, $action['target'])) {
            $this->logAction($aiPlayer, 'fleet_action', [
                'planet_id'    => $planet->getPlanetId(),
                'mission_type' => $action['mission_type'],
                'target'       => $action['target'],
            ], 'skipped', 'Target belongs to alliance member');
            return 0;
        }

        try {
            $units = $this->buildUnitCollection($action['ships'], $planet);
            if ($units === null) {
                return 0;
            }

            $target = new Coordinate(
                (int) $action['target']['galaxy'],
                (int) $action['target']['system'],
                (int) $action['target']['position'],
            );

            // For transport missions carry all current resources on the planet.
            $resources = new Resources(0, 0, 0, 0);
            if ((int) $action['mission_type'] === 3) {
                $resources = $planet->getResources();
                // Strip the energy component – Resources stores energy in the fourth slot.
                $resources = new Resources(
                    (int) $resources->metal->get(),
                    (int) $resources->crystal->get(),
                    (int) $resources->deuterium->get(),
                    0,
                );
            }

            $fleetMissionService = resolve(FleetMissionService::class, ['player' => $playerService]);
            $fleetMissionService->createNewFromPlanet(
                $planet,
                $target,
                PlanetType::Planet,
                (int) $action['mission_type'],
                $units,
                $resources,
                10.0,
            );

            $this->logAction($aiPlayer, 'fleet_action', [
                'planet_id'    => $planet->getPlanetId(),
                'mission_type' => $action['mission_type'],
                'target'       => $action['target'],
                'ships'        => $action['ships'],
            ], 'success');

            return 1;
        } catch (\Throwable $e) {
            $this->logAction($aiPlayer, 'fleet_action', [
                'planet_id'    => $planet->getPlanetId(),
                'mission_type' => $action['mission_type'] ?? null,
                'target'       => $action['target'] ?? null,
            ], 'failed', $e->getMessage());
            return 0;
        }
    }

    /**
     * Attempt to colonize a new planet if the strategy recommends expanding.
     *
     * Checks all planets for an available colony ship, obtains a colonization
     * target from the target service (preferring large-planet positions for the
     * Miner profile), and dispatches a colonization mission.
     *
     * Colonization is gated by the fleet priority weight so that profiles with a
     * low fleet priority (e.g. Turtle) colonize much less aggressively.
     */
    private function tryColonize(
        AiPlayer $aiPlayer,
        AiPlayerStrategyInterface $strategy,
        PlayerService $playerService,
    ): int {
        // Gate by fleet priority
        if (rand(1, 10) > $aiPlayer->priority_fleet) {
            return 0;
        }

        if (!$strategy->shouldExpand($playerService)) {
            return 0;
        }

        // Find the first planet that has at least one colony ship available.
        $sourcePlanet = null;
        foreach ($playerService->planets->allPlanets() as $planet) {
            if ($planet->getObjectAmount('colony_ship') > 0) {
                $sourcePlanet = $planet;
                break;
            }
        }

        if ($sourcePlanet === null) {
            return 0;
        }

        // Pick a colonization target. Miners prefer positions known for large planets.
        $isMiner = $aiPlayer->profile === AiPlayerProfile::MINER->value;
        $target = $isMiner
            ? $this->targetService->findLargePlanetColonizationTarget($playerService)
            : $this->targetService->findColonizationTarget($playerService);

        if ($target === null) {
            return 0;
        }

        try {
            $colonyShipObject = ObjectService::getShipObjectByMachineName('colony_ship');
            $units = new UnitCollection();
            $units->addUnit($colonyShipObject, 1);

            $targetCoordinate = new Coordinate(
                $target['galaxy'],
                $target['system'],
                $target['position'],
            );

            $fleetMissionService = resolve(FleetMissionService::class, ['player' => $playerService]);
            $fleetMissionService->createNewFromPlanet(
                $sourcePlanet,
                $targetCoordinate,
                PlanetType::Planet,
                7, // Colonisation
                $units,
                new Resources(0, 0, 0, 0),
                10.0,
            );

            $this->logAction($aiPlayer, 'colonize', [
                'planet_id' => $sourcePlanet->getPlanetId(),
                'target'    => $target,
            ], 'success');

            return 1;
        } catch (\Throwable $e) {
            $this->logAction($aiPlayer, 'colonize', [
                'planet_id' => $sourcePlanet->getPlanetId(),
                'target'    => $target,
            ], 'failed', $e->getMessage());
            return 0;
        }
    }

    /**
     * Check whether the target coordinate belongs to a player who is in the same
     * alliance as the AI player. Returns true when both the AI and the target
     * player are members of the same alliance (i.e. the target must not be attacked).
     *
     * @param AiPlayer $aiPlayer
     * @param array{galaxy: int, system: int, position: int} $target
     */
    private function isAllyTarget(AiPlayer $aiPlayer, array $target): bool
    {
        // Determine the AI player's alliance. Use the already-loaded relationship
        // to avoid an extra query when the user is already eager-loaded.
        $aiUser = $aiPlayer->user;
        if ($aiUser === null || empty($aiUser->alliance_id)) {
            return false;
        }

        $aiAllianceId = (int) $aiUser->alliance_id;

        // Look up the planet at the target coordinates.
        $planet = Planet::where('galaxy', $target['galaxy'])
            ->where('system', $target['system'])
            ->where('planet', $target['position'])
            ->where('planet_type', PlanetType::Planet->value)
            ->first();

        if ($planet === null) {
            return false;
        }

        // Retrieve the owner of the target planet.
        $targetUser = User::find($planet->user_id);
        if ($targetUser === null || empty($targetUser->alliance_id)) {
            return false;
        }

        return (int) $targetUser->alliance_id === $aiAllianceId;
    }

    /**
     * Build a UnitCollection from a map of object_id => amount.
     *
     * Verifies that the source planet actually has each ship in the required quantity.
     * Returns null if any required ship is missing (preventing a failed mission dispatch).
     *
     * @param array<int, int> $ships
     * @param PlanetService $planet
     * @return UnitCollection|null
     */
    private function buildUnitCollection(array $ships, PlanetService $planet): ?UnitCollection
    {
        $units = new UnitCollection();

        foreach ($ships as $objectId => $amount) {
            try {
                $unitObject = ObjectService::getObjectById($objectId);
                $available = $planet->getObjectAmount($unitObject->machine_name);
                if ($available < $amount) {
                    return null;
                }
                $units->addUnit($unitObject, $amount);
            } catch (\Throwable $e) {
                Log::channel('ai')->warning('Failed to resolve ship object for fleet action', [
                    'object_id' => $objectId,
                    'planet_id' => $planet->getPlanetId(),
                    'error'     => $e->getMessage(),
                ]);
                return null;
            }
        }

        return $units;
    }

    /**
     * Log an AI player action.
     */
    private function logAction(
        AiPlayer $aiPlayer,
        string $actionType,
        mixed $actionData,
        string $status,
        ?string $errorMessage = null,
    ): void {
        // Write failures and errors to the dedicated AI log channel for debugging.
        if ($status === 'failed' || $errorMessage !== null) {
            Log::channel('ai')->error('AI player action failed', [
                'ai_player_id' => $aiPlayer->id,
                'action_type' => $actionType,
                'action_data' => $actionData,
                'error_message' => $errorMessage,
            ]);
        }

        try {
            AiPlayerLog::create([
                'ai_player_id' => $aiPlayer->id,
                'action_type' => $actionType,
                'action_data' => $actionData,
                'status' => $status,
                'error_message' => $errorMessage,
                'created_at' => now(),
            ]);
        } catch (Exception $e) {
            Log::channel('ai')->error('Failed to persist AI player action log: ' . $e->getMessage(), [
                'ai_player_id' => $aiPlayer->id,
                'action_type' => $actionType,
                'status' => $status,
            ]);
        }
    }
}
