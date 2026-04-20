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
            'battle_ship' => 3,
            'bomber' => 2,
            'light_fighter' => 10,
            'heavy_fighter' => 5,
            'small_cargo' => 3,
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
     * Aggressive players actively attack and run espionage missions.
     *
     * When a strong combat fleet (≥ 3 cruisers) and at least one cargo ship are
     * available, a raid attack is dispatched. Otherwise falls back to espionage
     * probes to scout nearby targets.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        $ships = $this->getAvailableShips($planet);

        // Launch a raid when a meaningful combat fleet is available.
        if (
            isset($ships['cruiser']) && $ships['cruiser'] >= 3
            && isset($ships['small_cargo']) && $ships['small_cargo'] >= 1
        ) {
            $cruiser    = ObjectService::getShipObjectByMachineName('cruiser');
            $smallCargo = ObjectService::getShipObjectByMachineName('small_cargo');

            // Build the attack fleet: cruisers as the core, optional light fighter escort,
            // and cargo ships to haul back plundered resources.
            $lightFighterEntry = (isset($ships['light_fighter']) && $ships['light_fighter'] >= 3)
                ? [ObjectService::getShipObjectByMachineName('light_fighter')->id => min($ships['light_fighter'], 5)]
                : [];

            $attackShips = array_merge(
                [$cruiser->id => min($ships['cruiser'], 5)],
                $lightFighterEntry,
                [$smallCargo->id => min($ships['small_cargo'], 3)],
            );

            return [
                'mission_type' => 1, // Attack
                'target' => $this->getRandomNearbyTarget($planet, 5),
                'ships' => $attackShips,
            ];
        }

        // Fall back to espionage scouting.
        if (isset($ships['espionage_probe']) && $ships['espionage_probe'] >= 2) {
            $espionageProbe = ObjectService::getShipObjectByMachineName('espionage_probe');
            return [
                'mission_type' => 6, // Espionage
                'target' => $this->getRandomNearbyTarget($planet, 5),
                'ships' => [$espionageProbe->id => 2],
            ];
        }

        return null;
    }

    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->planetCount() < 7;
    }
}
