<?php

namespace OGame\Services\AiPlayer;

use OGame\Models\User;

/**
 * Generates unique names for AI players.
 */
class AiPlayerNameGenerator
{
    /**
     * Sci-fi themed first names.
     *
     * @var list<string>
     */
    private array $firstNames = [
        'Zephyr', 'Nexus', 'Orion', 'Titan', 'Nova',
        'Vortex', 'Axion', 'Cyrus', 'Darius', 'Erebos',
        'Falcon', 'Gideon', 'Helios', 'Icarus', 'Jaxon',
        'Kael', 'Lyra', 'Mira', 'Nyx', 'Phoenix',
        'Quasar', 'Rex', 'Sirius', 'Theron', 'Ulric',
        'Vega', 'Wraith', 'Xander', 'Zenith', 'Astra',
        'Blaze', 'Cosmo', 'Drake', 'Echo', 'Flux',
        'Galactica', 'Havoc', 'Ion', 'Jet', 'Kronos',
        'Luna', 'Maverick', 'Nebula', 'Omega', 'Pyro',
        'Quantum', 'Rogue', 'Storm', 'Talon', 'Vector',
    ];

    /**
     * Sci-fi themed last names.
     *
     * @var list<string>
     */
    private array $lastNames = [
        'Starforge', 'Nebular', 'Darkstar', 'Ironclad', 'Skywrath',
        'Voidborn', 'Starblade', 'Moonshard', 'Sunfire', 'Frostbane',
        'Thunderhawk', 'Silvermoon', 'Shadowveil', 'Stormrider', 'Dawnbreaker',
        'Nightfall', 'Ashborne', 'Firestorm', 'Icewing', 'Steelheart',
        'Blazeward', 'Duskwalker', 'Galewing', 'Ironhelm', 'Lightstrike',
        'Novaflare', 'Onyx', 'Pulsarion', 'Quicksilver', 'Runekeeper',
        'Solaris', 'Titanium', 'Umbra', 'Voidseeker', 'Warpgate',
        'Xenon', 'Yarrow', 'Zephyrus', 'Arcturus', 'Blitz',
        'Celestis', 'Drakon', 'Eclipse', 'Forge', 'Grimstar',
        'Horizon', 'Inferno', 'Juggernaut', 'Kinetic', 'Lumin',
    ];

    /**
     * The AI name suffix to identify AI players.
     */
    public const AI_SUFFIX = ' [ AI ]';

    /**
     * Generate a unique AI player name.
     *
     * @return string The generated name with AI suffix.
     */
    public function generate(): string
    {
        $maxAttempts = 20;

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {
            $name = $this->generateBaseName();

            if ($attempt >= 5) {
                $name .= ' ' . rand(100, 9999);
            }

            $fullName = $name . self::AI_SUFFIX;

            if (!User::where('username', $fullName)->exists()) {
                return $fullName;
            }
        }

        // Fallback: use timestamp for guaranteed uniqueness
        return $this->generateBaseName() . ' ' . time() . self::AI_SUFFIX;
    }

    /**
     * Generate a random base name from the name pools.
     */
    private function generateBaseName(): string
    {
        $firstName = $this->firstNames[array_rand($this->firstNames)];
        $lastName = $this->lastNames[array_rand($this->lastNames)];

        return $firstName . ' ' . $lastName;
    }
}
