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
use OGame\Models\Planet\Coordinate;
use OGame\Models\Resources;
use OGame\Services\AiPlayer\Strategies\AiPlayerStrategyInterface;
use OGame\Services\BuildingQueueService;
use OGame\Services\FleetMissionService;
use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;
use OGame\Services\ResearchQueueService;
use OGame\Services\UnitQueueService;

/**
 * Core decision engine for AI players.
 *
 * Processes each AI player's turn: checking queues, building, researching,
 * constructing units, dispatching fleets, and colonizing new planets.
 */
class AiPlayerActionService
{
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
     * Attempt to add a building to the queue.
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

        $buildingId = $strategy->decideBuildingPriority($planet, $playerService);
        if ($buildingId === null) {
            return 0;
        }

        try {
            $this->buildingQueueService->add($planet, $buildingId);
            $this->logAction($aiPlayer, 'build', [
                'planet_id' => $planet->getPlanetId(),
                'object_id' => $buildingId,
            ], 'success');
            return 1;
        } catch (Exception $e) {
            $this->logAction($aiPlayer, 'build', [
                'planet_id' => $planet->getPlanetId(),
                'object_id' => $buildingId,
            ], 'failed', $e->getMessage());
            return 0;
        }
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
