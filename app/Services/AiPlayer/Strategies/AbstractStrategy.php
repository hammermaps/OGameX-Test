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
     * Stores information about the most recent resource-based skip (building/research)
     * so that AiPlayerActionService can emit a `resource_wait` log entry.
     *
     * @var array{kind: string, object_id: int, missing: array{metal: float, crystal: float, deuterium: float}}|null
     */
    private ?array $lastResourceSkip = null;

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
     * Threshold (in fields) below which a non-homeworld planet is treated as a resource colony.
     */
    protected const RESOURCE_COLONY_FIELD_THRESHOLD = 140;

    /**
     * Default maximum number of seconds to wait for resources to accumulate before
     * considering a building/research too expensive to queue right now.
     *
     * Equivalent to 4 hours.
     */
    protected const DEFAULT_MAX_AFFORD_WAIT_SECONDS = 14400;

    /**
     * Resource producers used as fallback when the next priority building is not yet
     * affordable. Listed in order of preference.
     *
     * @var list<string>
     */
    protected const RESOURCE_PRODUCERS = [
        'metal_mine',
        'crystal_mine',
        'deuterium_synthesizer',
        'solar_plant',
    ];

    /**
     * Find the first building in the priority list that can be built on the planet.
     *
     * When the planet's energy balance is negative (consumption exceeds production)
     * the method first tries to queue an energy-producing building so that resource
     * mines keep running at full efficiency.
     *
     * On small resource-colony planets the method delegates to the
     * resource-colony priority list instead of the regular one.
     *
     * Buildings listed in $alreadyQueued (machine names) are skipped so that
     * consecutive calls within the same turn produce diverse queue entries instead
     * of repeatedly queuing the same building.
     *
     * Also performs an affordability check: if the next priority building cannot be
     * afforded within a reasonable timeframe (current resources + production within
     * DEFAULT_MAX_AFFORD_WAIT_SECONDS) the strategy first tries to schedule a
     * resource-producing fallback building so the planet keeps progressing. When
     * neither the target nor a useful resource producer can be afforded soon, the
     * skip reason is recorded for the caller via getLastResourceSkip().
     *
     * @param PlanetService $planet
     * @param PlayerService $player
     * @param list<string> $alreadyQueued Machine names of buildings already scheduled in the queue.
     * @return int|null
     */
    public function decideBuildingPriority(PlanetService $planet, PlayerService $player, array $alreadyQueued = []): ?int
    {
        $this->lastResourceSkip = null;

        // If energy is negative, try to build an energy producer first.
        if ($planet->energy()->get() < 0) {
            foreach (self::ENERGY_PRODUCERS as $machineName) {
                if (in_array($machineName, $alreadyQueued, true)) {
                    continue;
                }
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

        // Use the focused resource-colony build list for small non-homeworld planets.
        $priorityList = $this->isResourceColony($planet, $player)
            ? $this->getResourceColonyBuildingPriorityList()
            : $this->getBuildingPriorityList();

        $firstUnaffordable = null;

        foreach ($priorityList as $machineName) {
            // Skip buildings that are already scheduled in the queue so the AI
            // diversifies its build queue rather than always queuing the same building.
            if (in_array($machineName, $alreadyQueued, true)) {
                continue;
            }

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
                    // Only suggest the storage upgrade if it is not already queued.
                    $storageMachineName = ObjectService::getObjectById($storageUpgradeId)->machine_name;
                    if (!in_array($storageMachineName, $alreadyQueued, true)) {
                        Log::channel('ai')->info('Storage bottleneck detected – upgrading storage before building', [
                            'planet_id'       => $planet->getPlanetId(),
                            'target_building' => $machineName,
                            'storage_upgrade' => $storageUpgradeId,
                        ]);
                        return $storageUpgradeId;
                    }
                    // Storage upgrade already queued; skip this building for now.
                    continue;
                }

                // Resource-awareness: if we cannot afford this building soon, remember the
                // first such occurrence (used later to record a `resource_wait` skip) and
                // continue scanning the priority list for a cheaper option.
                if (!$this->canAffordSoon($cost, $planet)) {
                    if ($firstUnaffordable === null) {
                        $object = ObjectService::getObjectByMachineName($machineName);
                        $firstUnaffordable = [
                            'object_id' => $object->id,
                            'missing'   => $this->getMissingResources($cost, $planet),
                        ];
                    }
                    continue;
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

        // No regular priority building was affordable. Try to fall back to a resource
        // producer so the planet keeps growing instead of stalling completely.
        $fallback = $this->pickResourceProducerFallback($planet, $alreadyQueued);
        if ($fallback !== null) {
            Log::channel('ai')->info('No affordable priority building – falling back to resource producer', [
                'planet_id' => $planet->getPlanetId(),
                'fallback'  => $fallback,
            ]);
            return $fallback;
        }

        // No affordable building at all – record the skip so AiPlayerActionService can log it.
        if ($firstUnaffordable !== null) {
            $this->lastResourceSkip = [
                'kind'      => 'build',
                'object_id' => $firstUnaffordable['object_id'],
                'missing'   => $firstUnaffordable['missing'],
            ];
        }

        return null;
    }

    /**
     * Find the first research in the priority list that can be researched.
     *
     * Also performs an affordability check (see canAffordSoon). If no research in
     * the priority list is affordable in the near future, the skip reason for the
     * first unaffordable research is recorded so AiPlayerActionService can emit a
     * `resource_wait` log entry.
     *
     * @param PlayerService $player
     * @param PlanetService $planet
     * @return int|null
     */
    public function decideResearchPriority(PlayerService $player, PlanetService $planet): ?int
    {
        $this->lastResourceSkip = null;

        $firstUnaffordable = null;

        foreach ($this->getResearchPriorityList() as $machineName) {
            if (!$this->canResearchObject($machineName, $planet)) {
                continue;
            }

            try {
                $cost = ObjectService::getObjectPrice($machineName, $planet);
                if (!$this->canAffordSoon($cost, $planet)) {
                    if ($firstUnaffordable === null) {
                        $object = ObjectService::getObjectByMachineName($machineName);
                        $firstUnaffordable = [
                            'object_id' => $object->id,
                            'missing'   => $this->getMissingResources($cost, $planet),
                        ];
                    }
                    continue;
                }
            } catch (\Throwable $e) {
                Log::channel('ai')->warning('Failed to check affordability for research', [
                    'machine_name' => $machineName,
                    'planet_id'    => $planet->getPlanetId(),
                    'error'        => $e->getMessage(),
                ]);
                continue;
            }

            $object = ObjectService::getObjectByMachineName($machineName);
            return $object->id;
        }

        if ($firstUnaffordable !== null) {
            $this->lastResourceSkip = [
                'kind'      => 'research',
                'object_id' => $firstUnaffordable['object_id'],
                'missing'   => $firstUnaffordable['missing'],
            ];
        }

        return null;
    }

    /**
     * Get information about the most recent resource-based skip recorded by
     * decideBuildingPriority/decideResearchPriority, or null when the most recent
     * decision did not skip due to resources.
     *
     * @return array{kind: string, object_id: int, missing: array{metal: float, crystal: float, deuterium: float}}|null
     */
    public function getLastResourceSkip(): ?array
    {
        return $this->lastResourceSkip;
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
        return $player->planets->planetCount() < 5;
    }

    /**
     * Default resource-colony building priority list.
     *
     * Focused on pure resource extraction with storage, no combat or research infrastructure.
     *
     * @return list<string>
     */
    public function getResourceColonyBuildingPriorityList(): array
    {
        return [
            'metal_mine',
            'crystal_mine',
            'solar_plant',
            'deuterium_synthesizer',
            'metal_store',
            'crystal_store',
            'deuterium_store',
            'robot_factory',
        ];
    }

    /**
     * Determine whether the given planet should be treated as a resource colony.
     *
     * By default a planet is considered a resource colony when it is not the player's
     * homeworld (first planet) and has fewer building fields than the threshold.
     *
     * @param PlanetService $planet
     * @param PlayerService $player
     * @return bool
     */
    public function isResourceColony(PlanetService $planet, PlayerService $player): bool
    {
        // The homeworld is the planet with the lowest ID (created first).  It is never
        // treated as a resource colony regardless of its field count.
        $homeworldId = null;
        foreach ($player->planets->allPlanets() as $p) {
            if ($homeworldId === null || $p->getPlanetId() < $homeworldId) {
                $homeworldId = $p->getPlanetId();
            }
        }

        if ($homeworldId === $planet->getPlanetId()) {
            return false;
        }

        return $planet->getPlanetFieldMax() < self::RESOURCE_COLONY_FIELD_THRESHOLD;
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
    public function getStorageBottleneck(Resources $cost, PlanetService $planet): ?int
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
     * Determine whether the planet can afford a given cost within the configured
     * waiting window using current resources plus hourly production.
     *
     * A cost is considered affordable when, for every non-zero resource required,
     *   current_amount + production_per_second * maxWaitSeconds >= cost
     *
     * Resources whose production is zero (or negative) and whose current amount
     * is below the requirement are never affordable through waiting, so this
     * method returns false.
     *
     * Storage capacity is **not** re-checked here – getStorageBottleneck() is
     * already used by decideBuildingPriority to detect cases where the cost
     * structurally exceeds storage.
     */
    public function canAffordSoon(Resources $cost, PlanetService $planet, ?int $maxWaitSeconds = null): bool
    {
        $maxWaitSeconds = $maxWaitSeconds ?? self::DEFAULT_MAX_AFFORD_WAIT_SECONDS;
        if ($maxWaitSeconds < 0) {
            $maxWaitSeconds = 0;
        }

        $checks = [
            [$cost->metal->get(),     $planet->metal()->get(),     $planet->getMetalProductionPerSecond()],
            [$cost->crystal->get(),   $planet->crystal()->get(),   $planet->getCrystalProductionPerSecond()],
            [$cost->deuterium->get(), $planet->deuterium()->get(), $planet->getDeuteriumProductionPerSecond()],
        ];

        foreach ($checks as [$needed, $available, $perSecond]) {
            if ($needed <= 0) {
                continue;
            }
            if ($available >= $needed) {
                continue;
            }
            if ($perSecond <= 0) {
                // No production – cannot accumulate the missing amount by waiting.
                return false;
            }
            $missing = $needed - $available;
            if ($missing / $perSecond > $maxWaitSeconds) {
                return false;
            }
        }

        return true;
    }

    /**
     * Compute the per-resource shortfall between a cost and what is currently
     * available on the planet. Values are clamped to be non-negative.
     *
     * @return array{metal: float, crystal: float, deuterium: float}
     */
    public function getMissingResources(Resources $cost, PlanetService $planet): array
    {
        return [
            'metal'     => max(0.0, $cost->metal->get()     - $planet->metal()->get()),
            'crystal'   => max(0.0, $cost->crystal->get()   - $planet->crystal()->get()),
            'deuterium' => max(0.0, $cost->deuterium->get() - $planet->deuterium()->get()),
        ];
    }

    /**
     * When no priority building is affordable in the near future, pick the first
     * affordable resource producer (metal/crystal/deuterium/solar) that is not
     * already queued, so the planet keeps progressing towards future builds.
     *
     * @param list<string> $alreadyQueued Machine names of buildings already in the queue.
     */
    protected function pickResourceProducerFallback(PlanetService $planet, array $alreadyQueued): ?int
    {
        foreach (self::RESOURCE_PRODUCERS as $machineName) {
            if (in_array($machineName, $alreadyQueued, true)) {
                continue;
            }
            if (!$this->canBuildObject($machineName, $planet)) {
                continue;
            }
            try {
                $cost = ObjectService::getObjectPrice($machineName, $planet);
                if ($this->getStorageBottleneck($cost, $planet) !== null) {
                    continue;
                }
                if (!$this->canAffordSoon($cost, $planet)) {
                    continue;
                }
                $object = ObjectService::getObjectByMachineName($machineName);
                return $object->id;
            } catch (\Throwable $e) {
                Log::channel('ai')->warning('Failed to evaluate resource producer fallback', [
                    'machine_name' => $machineName,
                    'planet_id'    => $planet->getPlanetId(),
                    'error'        => $e->getMessage(),
                ]);
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

    /**
     * Generate a random nearby target coordinate for espionage or attack missions.
     *
     * Re-rolls if the generated coordinates match the source planet to avoid
     * targeting one's own position, which would cause mission validation failures.
     *
     * @param PlanetService $planet The planet to use as a reference for the target.
     * @param int $systemRange Maximum system offset from the reference planet.
     * @return array{galaxy: int, system: int, position: int}
     */
    protected function getRandomNearbyTarget(PlanetService $planet, int $systemRange = 5): array
    {
        $coordinates   = $planet->getPlanetCoordinates();
        $galaxy        = $coordinates->galaxy;
        $sourceSystem  = $coordinates->system;
        $sourcePosition = $coordinates->position;
        $systemRange   = abs($systemRange);

        do {
            $position    = rand(1, 15);
            $systemOffset = rand(-$systemRange, $systemRange);
            $targetSystem = max(1, $sourceSystem + $systemOffset);
        } while ($targetSystem === $sourceSystem && $position === $sourcePosition);

        return [
            'galaxy' => $galaxy,
            'system' => $targetSystem,
            'position' => $position,
        ];
    }
}
