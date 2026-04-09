<?php

namespace OGame\Enums;

use OGame\Enums\CharacterClass;

enum AiPlayerProfile: string
{
    case AGGRESSIVE = 'aggressive';
    case NEUTRAL = 'neutral';
    case DEFENSIVE = 'defensive';
    case MINER = 'miner';
    case RAIDER = 'raider';
    case TURTLE = 'turtle';

    /**
     * Get the display name of the profile.
     */
    public function getName(): string
    {
        return match ($this) {
            self::AGGRESSIVE => 'Aggressive',
            self::NEUTRAL => 'Neutral',
            self::DEFENSIVE => 'Defensive',
            self::MINER => 'Miner',
            self::RAIDER => 'Raider',
            self::TURTLE => 'Turtle',
        };
    }

    /**
     * Get a description of the profile behavior.
     */
    public function getDescription(): string
    {
        return match ($this) {
            self::AGGRESSIVE => 'Focuses on weapons research, combat ships, and active attacks.',
            self::NEUTRAL => 'Balanced strategy with a mix of economy and military.',
            self::DEFENSIVE => 'Prioritizes defense installations, shields, and armor.',
            self::MINER => 'Maximizes resource production with minimal military.',
            self::RAIDER => 'Fast fleet, frequent espionage, and attacks on weak targets.',
            self::TURTLE => 'Maximum defense, resource security, minimal fleet.',
        };
    }

    /**
     * Get default priority weights for this profile.
     *
     * @return array{building: int, research: int, fleet: int}
     */
    public function getDefaultPriorities(): array
    {
        return match ($this) {
            self::AGGRESSIVE => ['building' => 3, 'research' => 5, 'fleet' => 9],
            self::NEUTRAL => ['building' => 5, 'research' => 5, 'fleet' => 5],
            self::DEFENSIVE => ['building' => 6, 'research' => 5, 'fleet' => 3],
            self::MINER => ['building' => 9, 'research' => 4, 'fleet' => 2],
            self::RAIDER => ['building' => 3, 'research' => 4, 'fleet' => 8],
            self::TURTLE => ['building' => 7, 'research' => 4, 'fleet' => 1],
        };
    }

    /**
     * Get the preferred CharacterClass for this AI profile.
     *
     * - Collector: economic bonuses (mine production, transporter, crawler) – suits mining/turtle profiles.
     * - General:   combat bonuses (ship speed, combat research, fleet slots) – suits aggressive/raider/defensive profiles.
     * - Discoverer: research & expedition bonuses (research speed, expedition gains) – suits neutral profile.
     */
    public function getPreferredCharacterClass(): CharacterClass
    {
        return match ($this) {
            self::MINER => CharacterClass::COLLECTOR,
            self::TURTLE => CharacterClass::COLLECTOR,
            self::AGGRESSIVE => CharacterClass::GENERAL,
            self::RAIDER => CharacterClass::GENERAL,
            self::DEFENSIVE => CharacterClass::GENERAL,
            self::NEUTRAL => CharacterClass::DISCOVERER,
        };
    }
}
