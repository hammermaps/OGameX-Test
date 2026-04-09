<?php

namespace OGame\Services\AiPlayer\Strategies;

use OGame\Services\ObjectService;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

/**
 * Miner strategy: maximizes resource production with minimal military presence.
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
            'nanite_factory',
        ];
    }

    public function getResearchPriorityList(): array
    {
        return [
            'energy_technology',
            'computer_technology',
            'combustion_drive',
            'espionage_technology',
            'astrophysics',
            'impulse_drive',
            'plasma_technology',
            'shielding_technology',
            'armour_technology',
            'weapons_technology',
            'hyperspace_technology',
            'hyperspace_drive',
        ];
    }

    /**
     * Build mostly cargo ships and a few defense units.
     */
    public function decideUnitBuild(PlanetService $planet): array
    {
        $units = [];
        $priorities = [
            'small_cargo' => 5,
            'large_cargo' => 3,
            'rocket_launcher' => 5,
            'light_laser' => 3,
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

    /**
     * Miners primarily transport resources between their own planets.
     */
    public function decideFleetAction(PlayerService $player, PlanetService $planet): ?array
    {
        // Transport excess resources between planets if available
        $ships = $this->getAvailableShips($planet);

        if (isset($ships['large_cargo']) && $ships['large_cargo'] >= 2) {
            // Send resources to another own planet
            $planets = $player->planets->all();
            if (count($planets) > 1) {
                foreach ($planets as $targetPlanet) {
                    if ($targetPlanet->getPlanetId() !== $planet->getPlanetId()) {
                        $largeCargo = ObjectService::getShipObjectByMachineName('large_cargo');
                        return [
                            'mission_type' => 3, // Transport
                            'target' => [
                                'galaxy' => $targetPlanet->getPlanetCoordinates()->galaxy,
                                'system' => $targetPlanet->getPlanetCoordinates()->system,
                                'position' => $targetPlanet->getPlanetCoordinates()->position,
                            ],
                            'ships' => [$largeCargo->id => 2],
                        ];
                    }
                }
            }
        }

        return null;
    }

    /**
     * Miners like to expand to more planets.
     */
    public function shouldExpand(PlayerService $player): bool
    {
        return $player->planets->count() < 8;
    }
}
