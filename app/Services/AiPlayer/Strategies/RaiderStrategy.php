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
     * Raiders attack with light fighters when a strike force is ready, and fall
     * back to frequent espionage scouting otherwise.
     *
     * A raid requires at least 5 light fighters to form a meaningful strike force.
     * Small cargo ships are included to carry plundered resources back.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        $ships = $this->getAvailableShips($planet);

        // Launch a raid when a strike force of light fighters is available.
        if (
            isset($ships['light_fighter'])
            && $ships['light_fighter'] >= 5
            && isset($ships['small_cargo'])
            && $ships['small_cargo'] >= 2
        ) {
            $lightFighter = ObjectService::getShipObjectByMachineName('light_fighter');
            $smallCargo   = ObjectService::getShipObjectByMachineName('small_cargo');

            return [
                'mission_type' => 1, // Attack
                'target' => $this->getRandomNearbyTarget($planet, 10),
                'ships' => [
                    $lightFighter->id => min($ships['light_fighter'], 8),
                    $smallCargo->id   => min($ships['small_cargo'], 3),
                ],
            ];
        }

        // Fall back to espionage scouting.
        if (isset($ships['espionage_probe']) && $ships['espionage_probe'] >= 3) {
            $espionageProbe = ObjectService::getShipObjectByMachineName('espionage_probe');
            return [
                'mission_type' => 6, // Espionage
                'target' => $this->getRandomNearbyTarget($planet, 10),
                'ships' => [$espionageProbe->id => 3],
            ];
        }

        return null;
    }

    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->planetCount() < 6;
    }
}
