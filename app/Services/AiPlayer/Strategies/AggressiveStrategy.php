<?php

namespace OGame\Services\AiPlayer\Strategies;

use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Aggressive strategy: focuses on weapons research, combat ships, and active attacks.
 */
class AggressiveStrategy extends AbstractStrategy
{
    public function getBuildingPriorityList(): array
    {
        return [
            'robot_factory',
            'shipyard',
            'metal_mine',
            'crystal_mine',
            'solar_plant',
            'deuterium_synthesizer',
            'research_lab',
            'nano_factory',
            'metal_store',
            'crystal_store',
            'deuterium_store',
        ];
    }

    public function getResearchPriorityList(): array
    {
        return [
            'energy_technology',
            'combustion_drive',
            'weapon_technology',
            'shielding_technology',
            'armor_technology',
            'impulse_drive',
            'espionage_technology',
            'hyperspace_technology',
            'hyperspace_drive',
            'computer_technology',
            'astrophysics',
            'laser_technology',
            'ion_technology',
            'plasma_technology',
        ];
    }

    /**
     * Build combat-focused units.
     */
    public function decideUnitBuild(PlanetService $planet): array
    {
        $units = [];
        $shipPriorities = [
            'cruiser' => 5,
            'battleship' => 3,
            'bomber' => 2,
            'light_fighter' => 10,
            'heavy_fighter' => 5,
            'espionage_probe' => 5,
        ];

        foreach ($shipPriorities as $machineName => $amount) {
            if ($this->canBuildObject($machineName, $planet)) {
                $object = ObjectService::getObjectByMachineName($machineName);
                $units[$object->id] = $amount;
            }
        }

        return $units;
    }

    /**
     * Aggressive players actively seek espionage and attack targets.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        $ships = $this->getAvailableShips($planet);

        // Send espionage probes if available
        if (isset($ships['espionage_probe']) && $ships['espionage_probe'] >= 2) {
            $espionageProbe = ObjectService::getShipObjectByMachineName('espionage_probe');
            return [
                'mission_type' => 6, // Espionage
                'target' => $this->getRandomNearbyTarget($planet),
                'ships' => [$espionageProbe->id => 2],
            ];
        }

        return null;
    }

    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->planetCount() < 7;
    }

    /**
     * Generate a random nearby target coordinate for espionage/attacks.
     *
     * @return array{galaxy: int, system: int, position: int}
     */
    private function getRandomNearbyTarget(PlanetService $planet): array
    {
        $galaxy = $planet->getPlanetCoordinates()->galaxy;
        $system = $planet->getPlanetCoordinates()->system;
        $position = rand(1, 15);
        $systemOffset = rand(-5, 5);

        return [
            'galaxy' => $galaxy,
            'system' => max(1, $system + $systemOffset),
            'position' => $position,
        ];
    }
}
