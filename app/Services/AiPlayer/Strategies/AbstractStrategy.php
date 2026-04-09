<?php

namespace OGame\Services\AiPlayer\Strategies;

use Illuminate\Support\Facades\Log;
use OGame\Models\Resources;
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
     * Storage building machine names indexed by resource type.
     * Used to upgrade storage when a target building's cost exceeds the planet's capacity.
     */
    protected const STORAGE_BUILDINGS = [
        'metal' => 'metal_store',
        'crystal' => 'crystal_store',
        'deuterium' => 'deuterium_store',
    ];

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
            if (!$this->canBuildObject($machineName, $planet)) {
                continue;
            }

            // Before queuing this building, verify that its cost does not exceed the planet's
            // current storage capacity for any resource. If it does, the planet can never
            // accumulate enough resources to build it, so we upgrade storage first.
            try {
                $cost = ObjectService::getObjectPrice($machineName, $planet);
                $storageUpgradeId = $this->getStorageBottleneck($cost, $planet);
                if ($storageUpgradeId !== null) {
                    Log::channel('ai')->info('Storage bottleneck detected – upgrading storage before building', [
                        'planet_id'       => $planet->getPlanetId(),
                        'target_building' => $machineName,
                        'storage_upgrade' => $storageUpgradeId,
                    ]);
                    return $storageUpgradeId;
                }
            } catch (\Throwable $e) {
                Log::channel('ai')->warning('Failed to check storage bottleneck for building', [
                    'machine_name' => $machineName,
                    'planet_id'    => $planet->getPlanetId(),
                    'error'        => $e->getMessage(),
                ]);
            }

            $object = ObjectService::getObjectByMachineName($machineName);
            return $object->id;
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
     * Check whether the given resource cost exceeds the planet's current storage capacity
     * for any resource. Returns the object ID of the first storage building that should be
     * upgraded to resolve the bottleneck, or null if storage is sufficient.
     */
    protected function getStorageBottleneck(Resources $cost, PlanetService $planet): ?int
    {
        $checks = [
            [$cost->metal->get(), $planet->metalStorage()->get(), self::STORAGE_BUILDINGS['metal']],
            [$cost->crystal->get(), $planet->crystalStorage()->get(), self::STORAGE_BUILDINGS['crystal']],
            [$cost->deuterium->get(), $planet->deuteriumStorage()->get(), self::STORAGE_BUILDINGS['deuterium']],
        ];

        foreach ($checks as [$resourceCost, $storageCapacity, $storageMachineName]) {
            if ($resourceCost > 0 && $storageCapacity > 0 && $resourceCost > $storageCapacity) {
                if ($this->canBuildObject($storageMachineName, $planet)) {
                    return ObjectService::getObjectByMachineName($storageMachineName)->id;
                }
            }
        }

        return null;
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
