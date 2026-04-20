<?php

namespace OGame\Services\AiPlayer\Strategies;

use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Neutral strategy: balanced approach with a mix of economy, research, and military.
 */
class NeutralStrategy extends AbstractStrategy
{
    public function getBuildingPriorityList(): array
    {
        return [
            'metal_mine',
            'crystal_mine',
            'solar_plant',
            'deuterium_synthesizer',
            'robot_factory',
            'shipyard',
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
            'computer_technology',
            'combustion_drive',
            'espionage_technology',
            'weapon_technology',
            'shielding_technology',
            'armor_technology',
            'impulse_drive',
            'astrophysics',
            'hyperspace_technology',
            'hyperspace_drive',
            'laser_technology',
            'ion_technology',
            'plasma_technology',
        ];
    }

    /**
     * Build a balanced mix of units.
     */
    public function decideUnitBuild(PlanetService $planet): array
    {
        $units = [];
        $priorities = [
            'light_fighter' => 5,
            'heavy_fighter' => 3,
            'cruiser' => 2,
            'small_cargo' => 3,
            'large_cargo' => 2,
            'espionage_probe' => 5,
            'rocket_launcher' => 5,
            'light_laser' => 3,
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
     * Neutral players occasionally send espionage probes or expeditions.
     *
     * Randomly alternates between espionage scouting and expedition missions.
     * Expeditions are preferred when a small cargo is available; espionage is
     * used as a fallback or as the primary action one-third of the time.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        $ships = $this->getAvailableShips($planet);

        // Occasionally send expeditions (1-in-3 chance when a cargo ship is available).
        if (isset($ships['small_cargo']) && $ships['small_cargo'] >= 1 && rand(1, 3) === 1) {
            $smallCargo = ObjectService::getShipObjectByMachineName('small_cargo');
            return [
                'mission_type' => 15, // Expedition
                'target' => [
                    'galaxy' => $planet->getPlanetCoordinates()->galaxy,
                    'system' => $planet->getPlanetCoordinates()->system,
                    'position' => 16,
                ],
                'ships' => [$smallCargo->id => 1],
            ];
        }

        // Otherwise spy on nearby systems.
        if (isset($ships['espionage_probe']) && $ships['espionage_probe'] >= 2) {
            $espionageProbe = ObjectService::getShipObjectByMachineName('espionage_probe');
            return [
                'mission_type' => 6, // Espionage
                'target' => $this->getRandomNearbyTarget($planet, 8),
                'ships' => [$espionageProbe->id => 2],
            ];
        }

        return null;
    }

    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->planetCount() < 5;
    }
}
