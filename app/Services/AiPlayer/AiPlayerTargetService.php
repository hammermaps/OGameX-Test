<?php

namespace OGame\Services\AiPlayer;

use OGame\Enums\AiPlayerProfile;
use OGame\Services\AiPlayer\Strategies\AggressiveStrategy;
use OGame\Services\AiPlayer\Strategies\AiPlayerStrategyInterface;
use OGame\Services\AiPlayer\Strategies\DefensiveStrategy;
use OGame\Services\AiPlayer\Strategies\MinerStrategy;
use OGame\Services\AiPlayer\Strategies\NeutralStrategy;
use OGame\Services\AiPlayer\Strategies\RaiderStrategy;
use OGame\Services\AiPlayer\Strategies\TurtleStrategy;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Service for finding targets for AI player fleet actions.
 */
class AiPlayerTargetService
{
    /**
     * Resolve the strategy implementation for a given profile.
     */
    public function resolveStrategy(string $profile): AiPlayerStrategyInterface
    {
        $profileEnum = AiPlayerProfile::from($profile);

        return match ($profileEnum) {
            AiPlayerProfile::AGGRESSIVE => new AggressiveStrategy(),
            AiPlayerProfile::NEUTRAL => new NeutralStrategy(),
            AiPlayerProfile::DEFENSIVE => new DefensiveStrategy(),
            AiPlayerProfile::MINER => new MinerStrategy(),
            AiPlayerProfile::RAIDER => new RaiderStrategy(),
            AiPlayerProfile::TURTLE => new TurtleStrategy(),
        };
    }

    /**
     * Find nearby planets for espionage.
     *
     * @param PlanetService $planet
     * @param int $range System range to search.
     * @return list<array{galaxy: int, system: int, position: int}>
     */
    public function findEspionageTargets(PlanetService $planet, int $range = 10): array
    {
        $coords = $planet->getPlanetCoordinates();
        $targets = [];

        for ($i = 0; $i < 5; $i++) {
            $system = max(1, $coords->system + rand(-$range, $range));
            $position = rand(1, 15);

            // Don't target own coordinates
            if ($system === $coords->system && $position === $coords->position) {
                continue;
            }

            $targets[] = [
                'galaxy' => $coords->galaxy,
                'system' => $system,
                'position' => $position,
            ];
        }

        return $targets;
    }

    /**
     * Find a suitable colonization target near the player's homeworld.
     *
     * Prefers orbital positions 4–12 (which tend to have larger planet sizes)
     * and avoids galaxy/system positions already occupied by the player's
     * existing planets.
     *
     * @param PlayerService $player
     * @return array{galaxy: int, system: int, position: int}|null
     */
    public function findColonizationTarget(PlayerService $player): ?array
    {
        $homePlanet = $player->planets->current();
        $coords = $homePlanet->getPlanetCoordinates();

        // Collect all positions already occupied by the player to avoid collisions.
        $occupiedPositions = [];
        foreach ($player->planets->allPlanets() as $planet) {
            $c = $planet->getPlanetCoordinates();
            $occupiedPositions[] = $c->galaxy . ':' . $c->system . ':' . $c->position;
        }

        // Try up to 10 random candidates, picking the first unoccupied one.
        for ($attempt = 0; $attempt < 10; $attempt++) {
            $system   = max(1, $coords->system + rand(-20, 20));
            $position = rand(4, 12); // positions 4-12 tend to yield larger planets

            $key = $coords->galaxy . ':' . $system . ':' . $position;
            if (!in_array($key, $occupiedPositions, true)) {
                return [
                    'galaxy'   => $coords->galaxy,
                    'system'   => $system,
                    'position' => $position,
                ];
            }
        }

        return null;
    }

    /**
     * Find a colonization target optimized for large planet size (Miner profile).
     *
     * Prefers the central positions 6–10 which statistically yield the most building
     * fields, and avoids positions already owned by the player.
     *
     * @param PlayerService $player
     * @return array{galaxy: int, system: int, position: int}|null
     */
    public function findLargePlanetColonizationTarget(PlayerService $player): ?array
    {
        $homePlanet = $player->planets->current();
        $coords = $homePlanet->getPlanetCoordinates();

        $occupiedPositions = [];
        foreach ($player->planets->allPlanets() as $planet) {
            $c = $planet->getPlanetCoordinates();
            $occupiedPositions[] = $c->galaxy . ':' . $c->system . ':' . $c->position;
        }

        for ($attempt = 0; $attempt < 10; $attempt++) {
            $system   = max(1, $coords->system + rand(-20, 20));
            $position = rand(6, 10); // optimal range for large planets

            $key = $coords->galaxy . ':' . $system . ':' . $position;
            if (!in_array($key, $occupiedPositions, true)) {
                return [
                    'galaxy'   => $coords->galaxy,
                    'system'   => $system,
                    'position' => $position,
                ];
            }
        }

        return null;
    }
}
