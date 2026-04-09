<?php

namespace OGame\Services\AiPlayer;

use Exception;
use Illuminate\Support\Facades\Log;
use OGame\Factories\PlayerServiceFactory;
use OGame\Models\AiPlayer;
use OGame\Models\AiPlayerLog;
use OGame\Services\AiPlayer\Strategies\AiPlayerStrategyInterface;
use OGame\Services\BuildingQueueService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;
use OGame\Services\ResearchQueueService;
use OGame\Services\UnitQueueService;

/**
 * Core decision engine for AI players.
 *
 * Processes each AI player's turn: checking queues, building, researching,
 * constructing units, and dispatching fleets.
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
        $actions += $this->tryBuildBuilding($aiPlayer, $strategy, $planet);

        // 2. Try to start research
        $actions += $this->tryStartResearch($aiPlayer, $strategy, $playerService, $planet);

        // 3. Try to build units (ships/defense)
        $actions += $this->tryBuildUnits($aiPlayer, $strategy, $planet);

        return $actions;
    }

    /**
     * Attempt to add a building to the queue.
     */
    private function tryBuildBuilding(
        AiPlayer $aiPlayer,
        AiPlayerStrategyInterface $strategy,
        PlanetService $planet,
    ): int {
        // Only act based on building priority weight
        if (rand(1, 10) > $aiPlayer->priority_building) {
            return 0;
        }

        $buildingId = $strategy->decideBuildingPriority($planet);
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
