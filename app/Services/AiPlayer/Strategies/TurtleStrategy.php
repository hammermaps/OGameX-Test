<?php

namespace OGame\Services\AiPlayer\Strategies;

use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Turtle strategy: maximum defense, resource security, minimal fleet.
 */
class TurtleStrategy extends AbstractStrategy
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
            'shipyard',
            'research_lab',
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
            'laser_technology',
            'ion_technology',
            'computer_technology',
            'espionage_technology',
            'combustion_drive',
            'impulse_drive',
            'astrophysics',
            'plasma_technology',
        ];
    }

    /**
     * Build maximum defense, almost no fleet.
     */
    public function decideUnitBuild(PlanetService $planet): array
    {
        $units = [];
        $priorities = [
            'rocket_launcher' => 20,
            'light_laser' => 15,
            'heavy_laser' => 5,
            'gauss_cannon' => 3,
            'ion_cannon' => 5,
            'plasma_turret' => 1,
            'small_shield_dome' => 1,
            'large_shield_dome' => 1,
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
     * Turtles rarely engage in fleet actions.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        return null;
    }

    /**
     * Turtles expand slowly.
     */
    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->planetCount() < 3;
    }
}
