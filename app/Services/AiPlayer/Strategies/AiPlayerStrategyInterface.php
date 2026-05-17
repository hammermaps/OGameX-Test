<?php

namespace OGame\Services\AiPlayer\Strategies;

use OGame\Models\Resources;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Interface for AI player strategy implementations.
 *
 * Each strategy defines priorities for buildings, research, ships, and fleet actions
 * based on the AI player's profile (aggressive, miner, defensive, etc.).
 */
interface AiPlayerStrategyInterface
{
    /**
     * Decide which building to construct next on the given planet.
     *
     * @param PlanetService $planet
     * @param PlayerService $player
     * @param list<string> $alreadyQueued Machine names of buildings already scheduled in the queue
     *                                    (either from previous turns or added earlier this turn).
     *                                    Buildings in this list are skipped so the AI diversifies
     *                                    its build queue instead of always picking the same building.
     * @return int|null The building object ID, or null if nothing should be built.
     */
    public function decideBuildingPriority(PlanetService $planet, PlayerService $player, array $alreadyQueued = []): ?int;

    /**
     * Decide which research to start next.
     *
     * @param PlayerService $player
     * @param PlanetService $planet
     * @return int|null The research object ID, or null if nothing should be researched.
     */
    public function decideResearchPriority(PlayerService $player, PlanetService $planet): ?int;

    /**
     * Decide which ships or defense units to build.
     *
     * @param PlanetService $planet
     * @return array<int, int> Map of object_id => amount to build.
     */
    public function decideUnitBuild(PlanetService $planet): array;

    /**
     * Decide a fleet action (espionage, attack, transport, expedition).
     *
     * @param PlayerService $player
     * @param PlanetService $planet
     * @return array{mission_type: int, target: array{galaxy: int, system: int, position: int}, ships: array<int, int>}|null
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array;

    /**
     * Whether this strategy recommends expanding (colonizing new planets).
     *
     * @param PlayerService $player
     * @return bool
     */
    public function shouldExpand(PlayerService $player): bool;

    /**
     * Get the ordered list of building machine names this strategy prioritizes.
     *
     * @return list<string>
     */
    public function getBuildingPriorityList(): array;

    /**
     * Get the ordered list of research machine names this strategy prioritizes.
     *
     * @return list<string>
     */
    public function getResearchPriorityList(): array;

    /**
     * Get the building priority list used for small resource-colony planets.
     *
     * @return list<string>
     */
    public function getResourceColonyBuildingPriorityList(): array;

    /**
     * Determine whether the given planet should be treated as a resource colony.
     *
     * A resource colony is a non-homeworld planet with limited building fields that
     * is best specialized for pure resource production and transport, rather than
     * carrying the full infrastructure (shipyard, research lab, etc.).
     *
     * @param PlanetService $planet
     * @param PlayerService $player
     * @return bool
     */
    public function isResourceColony(PlanetService $planet, PlayerService $player): bool;

    /**
     * Check whether the given resource cost exceeds the planet's current storage capacity
     * for any resource. Returns the object ID of the first storage building that should be
     * upgraded to resolve the bottleneck, or null if storage is sufficient.
     *
     * @param Resources $cost
     * @param PlanetService $planet
     * @return int|null
     */
    public function getStorageBottleneck(Resources $cost, PlanetService $planet): ?int;

    /**
     * Determine whether the planet can afford the given cost within a reasonable timeframe
     * (current resources + hourly production extrapolated over $maxWaitSeconds). When
     * $maxWaitSeconds is null a strategy-specific default is used.
     *
     * @param Resources $cost
     * @param PlanetService $planet
     * @param int|null $maxWaitSeconds
     * @return bool
     */
    public function canAffordSoon(Resources $cost, PlanetService $planet, ?int $maxWaitSeconds = null): bool;

    /**
     * Compute the missing amount per resource needed to afford the given cost on the planet.
     *
     * @param Resources $cost
     * @param PlanetService $planet
     * @return array{metal: float, crystal: float, deuterium: float}
     */
    public function getMissingResources(Resources $cost, PlanetService $planet): array;

    /**
     * Get information about the most recent resource-based skip that the strategy
     * recorded during decideBuildingPriority/decideResearchPriority. Returns null
     * when the most recent decision call did not skip due to insufficient resources.
     *
     * @return array{kind: string, object_id: int, missing: array{metal: float, crystal: float, deuterium: float}}|null
     */
    public function getLastResourceSkip(): ?array;
}
