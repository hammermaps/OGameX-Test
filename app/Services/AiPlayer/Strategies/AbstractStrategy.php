<?php

namespace OGame\Services\AiPlayer\Strategies;

use Illuminate\Support\Facades\Log;
use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Abstract base class for AI player strategies.
 *
 * Provides common helper methods used across all strategy implementations.
 */
abstract class AbstractStrategy implements AiPlayerStrategyInterface
{
    /**
     * Energy-producing building machine names, in order of preference.
     * When the planet has a negative energy balance the AI will try to build
     * one of these before following the normal priority list.
     */
    protected const ENERGY_PRODUCERS = ['solar_plant', 'fusion_plant'];

    /**
     * Find the first building in the priority list that can be built on the planet.
     *
     * When the planet's energy balance is negative (consumption exceeds production)
     * the method first tries to queue an energy-producing building so that resource
     * mines keep running at full efficiency.
     *
     * @param PlanetService $planet
     * @return int|null
     */
    public function decideBuildingPriority(PlanetService $planet): ?int
    {
        // If energy is negative, try to build an energy producer first.
        if ($planet->energy()->get() < 0) {
            foreach (self::ENERGY_PRODUCERS as $machineName) {
                if ($this->canBuildObject($machineName, $planet)) {
                    $object = ObjectService::getObjectByMachineName($machineName);
                    Log::channel('ai')->info('Energy deficit detected – prioritizing energy producer', [
                        'planet_id'    => $planet->getPlanetId(),
                        'building'     => $machineName,
                        'energy_level' => $planet->energy()->get(),
                    ]);
                    return $object->id;
                }
            }
        }

        foreach ($this->getBuildingPriorityList() as $machineName) {
            if ($this->canBuildObject($machineName, $planet)) {
                $object = ObjectService::getObjectByMachineName($machineName);
                return $object->id;
            }
        }

        return null;
    }

    /**
     * Find the first research in the priority list that can be researched.
     *
     * @param PlayerService $player
     * @param PlanetService $planet
     * @return int|null
     */
    public function decideResearchPriority(PlayerService $player, PlanetService $planet): ?int
    {
        foreach ($this->getResearchPriorityList() as $machineName) {
            if ($this->canResearchObject($machineName, $planet)) {
                $object = ObjectService::getObjectByMachineName($machineName);
                return $object->id;
            }
        }

        return null;
    }

    /**
     * Default: build no units. Override in subclasses.
     */
    public function decideUnitBuild(PlanetService $planet): array
    {
        return [];
    }

    /**
     * Default: no fleet action. Override in subclasses.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        return null;
    }

    /**
     * Default: expand when having fewer than 5 planets.
     */
    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->count() < 5;
    }

    /**
     * Check if an object can be built on the planet (requirements met and resources available).
     */
    protected function canBuildObject(string $machineName, PlanetService $planet): bool
    {
        try {
            if (!ObjectService::objectRequirementsMet($machineName, $planet)) {
                return false;
            }

            // Check if the planet type is valid for this object.
            if (!ObjectService::objectValidPlanetType($machineName, $planet)) {
                return false;
            }

            return true;
        } catch (\Throwable $e) {
            Log::channel('ai')->warning('Failed to check build requirements for object', [
                'machine_name' => $machineName,
                'planet_id' => $planet->getPlanetId(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Check if a research object can be researched.
     */
    protected function canResearchObject(string $machineName, PlanetService $planet): bool
    {
        try {
            return ObjectService::objectRequirementsMet($machineName, $planet);
        } catch (\Throwable $e) {
            Log::channel('ai')->warning('Failed to check research requirements for object', [
                'machine_name' => $machineName,
                'planet_id' => $planet->getPlanetId(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Get available ship units on a planet, keyed by machine name.
     *
     * @return array<string, int>
     */
    protected function getAvailableShips(PlanetService $planet): array
    {
        $ships = [];
        foreach (ObjectService::getShipObjects() as $ship) {
            $amount = $planet->getObjectAmount($ship->machine_name);
            if ($amount > 0) {
                $ships[$ship->machine_name] = $amount;
            }
        }
        return $ships;
    }
}
