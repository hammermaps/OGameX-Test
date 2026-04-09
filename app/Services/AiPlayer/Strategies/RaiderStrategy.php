<?php

namespace OGame\Services\AiPlayer\Strategies;

use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Raider strategy: fast fleet, frequent espionage, and attacks on weak targets.
 */
class RaiderStrategy extends AbstractStrategy
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
            'metal_store',
            'crystal_store',
            'deuterium_store',
            'nano_factory',
        ];
    }

    public function getResearchPriorityList(): array
    {
        return [
            'energy_technology',
            'combustion_drive',
            'espionage_technology',
            'weapon_technology',
            'impulse_drive',
            'computer_technology',
            'laser_technology',
            'ion_technology',
            'shielding_technology',
            'armor_technology',
            'hyperspace_technology',
            'hyperspace_drive',
            'astrophysics',
        ];
    }

    /**
     * Build fast combat ships and espionage probes.
     */
    public function decideUnitBuild(PlanetService $planet): array
    {
        $units = [];
        $priorities = [
            'light_fighter' => 15,
            'small_cargo' => 5,
            'espionage_probe' => 10,
            'cruiser' => 3,
            'heavy_fighter' => 5,
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
     * Raiders frequently spy on neighbors.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        $ships = $this->getAvailableShips($planet);

        // Send espionage probes frequently
        if (isset($ships['espionage_probe']) && $ships['espionage_probe'] >= 3) {
            $espionageProbe = ObjectService::getShipObjectByMachineName('espionage_probe');
            return [
                'mission_type' => 6, // Espionage
                'target' => $this->getRandomNearbyTarget($planet),
                'ships' => [$espionageProbe->id => 3],
            ];
        }

        return null;
    }

    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->count() < 6;
    }

    /**
     * Generate a random nearby target for espionage.
     *
     * @return array{galaxy: int, system: int, position: int}
     */
    private function getRandomNearbyTarget(PlanetService $planet): array
    {
        $galaxy = $planet->getPlanetCoordinates()->galaxy;
        $system = $planet->getPlanetCoordinates()->system;
        $position = rand(1, 15);
        $systemOffset = rand(-10, 10);

        return [
            'galaxy' => $galaxy,
            'system' => max(1, $system + $systemOffset),
            'position' => $position,
        ];
    }
}
