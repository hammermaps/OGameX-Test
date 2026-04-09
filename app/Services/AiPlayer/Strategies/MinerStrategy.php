<?php

namespace OGame\Services\AiPlayer\Strategies;

use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Miner strategy: maximizes resource production with minimal military presence.
 *
 * Colony planets with limited building fields are treated as resource colonies and
 * receive a focused build list (mines + storage + robot factory only).  The main
 * planet (homeworld) keeps the full infrastructure list.
 *
 * Excess resources on small colony planets are transported to the largest planet
 * once they exceed 50 % of the planet's storage capacity.
 */
class MinerStrategy extends AbstractStrategy
{
    public function getBuildingPriorityList(): array
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
            'research_lab',
            'shipyard',
            'nano_factory',
        ];
    }

    public function getResearchPriorityList(): array
    {
        return [
            'energy_technology',
            'computer_technology',
            'combustion_drive',
            'espionage_technology',
            'impulse_drive',
            'astrophysics',
            'laser_technology',
            'shielding_technology',
            'armor_technology',
            'weapon_technology',
            'hyperspace_technology',
            'hyperspace_drive',
        ];
    }

    /**
     * Build mostly cargo ships and a few defense units.
     *
     * On resource-colony planets only build cargo ships (no shipyard means only
     * units available after the shipyard is eventually added will matter, but we
     * still guard with canBuildObject to be safe).
     */
    public function decideUnitBuild(PlanetService $planet): array
    {
        $units = [];
        $priorities = [
            'large_cargo'      => 5,
            'small_cargo'      => 3,
            'rocket_launcher'  => 5,
            'light_laser'      => 3,
            'espionage_probe'  => 3,
        ];

        foreach ($priorities as $machineName => $amount) {
            if ($this->canBuildObject($machineName, $planet)) {
                $object = ObjectService::getObjectByMachineName($machineName);
                $units[$object->id] = $amount;
            }
        }

        return $units;
    }

    /**
     * Miners transport excess resources from small colony planets to their largest planet.
     *
     * Transport is triggered when any resource on the current planet exceeds 50 % of
     * the planet's storage capacity for that resource.  The destination is the planet
     * with the most building fields (the "main" planet).  At least 2 large cargo ships
     * must be present to trigger a transport.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        $ships = $this->getAvailableShips($planet);

        if (!isset($ships['large_cargo']) || $ships['large_cargo'] < 2) {
            return null;
        }

        $allPlanets = $player->planets->allPlanets();
        if (count($allPlanets) <= 1) {
            return null;
        }

        // Only transport from this planet when resources are ≥ 50 % of storage.
        $hasExcess = false;
        $metalCap     = $planet->metalStorage()->get();
        $crystalCap   = $planet->crystalStorage()->get();
        $deuteriumCap = $planet->deuteriumStorage()->get();

        if ($metalCap > 0 && $planet->metal()->get() >= $metalCap * 0.5) {
            $hasExcess = true;
        } elseif ($crystalCap > 0 && $planet->crystal()->get() >= $crystalCap * 0.5) {
            $hasExcess = true;
        } elseif ($deuteriumCap > 0 && $planet->deuterium()->get() >= $deuteriumCap * 0.5) {
            $hasExcess = true;
        }

        if (!$hasExcess) {
            return null;
        }

        // Find the largest planet (most building fields) to use as the transport target.
        // We skip the current planet itself and moons.
        $targetPlanet = null;
        $maxFields    = 0;

        foreach ($allPlanets as $candidate) {
            if ($candidate->getPlanetId() === $planet->getPlanetId()) {
                continue;
            }

            $fields = $candidate->getPlanetFieldMax();
            if ($fields > $maxFields) {
                $maxFields    = $fields;
                $targetPlanet = $candidate;
            }
        }

        if ($targetPlanet === null) {
            return null;
        }

        $largeCargo = ObjectService::getShipObjectByMachineName('large_cargo');

        return [
            'mission_type' => 3, // Transport
            'target'       => [
                'galaxy'   => $targetPlanet->getPlanetCoordinates()->galaxy,
                'system'   => $targetPlanet->getPlanetCoordinates()->system,
                'position' => $targetPlanet->getPlanetCoordinates()->position,
            ],
            'ships' => [$largeCargo->id => min($ships['large_cargo'], 5)],
        ];
    }

    /**
     * Miners treat all non-homeworld planets as resource colonies regardless of size,
     * so that every colony is optimized purely for production.
     */
    public function isResourceColony(PlanetService $planet, PlayerService $player): bool
    {
        // The homeworld is the planet with the lowest ID (created first).
        $homeworldId = null;
        foreach ($player->planets->allPlanets() as $p) {
            if ($homeworldId === null || $p->getPlanetId() < $homeworldId) {
                $homeworldId = $p->getPlanetId();
            }
        }

        // Homeworld is never a resource colony.
        if ($homeworldId === $planet->getPlanetId()) {
            return false;
        }

        // For miners every colony planet (not just small ones) is a resource colony.
        return true;
    }

    /**
     * Miners like to expand to more planets.
     */
    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->planetCount() < 8;
    }
}
