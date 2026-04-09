<?php

namespace OGame\Services\AiPlayer\Strategies;

use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Defensive strategy: prioritizes defense installations, shields, and armor research.
 */
class DefensiveStrategy extends AbstractStrategy
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
            'shielding_technology',
            'armor_technology',
            'weapon_technology',
            'computer_technology',
            'espionage_technology',
            'combustion_drive',
            'laser_technology',
            'ion_technology',
            'impulse_drive',
            'astrophysics',
            'hyperspace_technology',
            'plasma_technology',
        ];
    }

    /**
     * Build defense-heavy units.
     */
    public function decideUnitBuild(PlanetService $planet): array
    {
        $units = [];
        $priorities = [
            'rocket_launcher' => 10,
            'light_laser' => 8,
            'heavy_laser' => 4,
            'gauss_cannon' => 2,
            'ion_cannon' => 3,
            'small_shield_dome' => 1,
            'large_shield_dome' => 1,
            'espionage_probe' => 3,
        ];

        foreach ($priorities as $machineName => $amount) {
            if ($this->canBuildObject($machineName, $planet)) {
                $object = ObjectService::getObjectByMachineName($machineName);
                $units[$object->id] = $amount;
            }
        }

        return $units;
    }

    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->count() < 4;
    }
}
