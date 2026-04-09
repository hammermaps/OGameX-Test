# Changelog

All notable changes to OGameX are documented in this file.

## [0.13.1] - 2026-04-09

### Added
- **German (de) Translations**: Complete German language files for all in-game modules (buddies, external, facilities, galaxy, in-game UI, layout, merchant, messages, overview, resources, wreck field).
- **AI Player Error Logging**: `AiPlayerLog` model with dedicated `error_message` column and `ai_player_logs` database table for full error persistence and a dedicated error channel in the AI logger.

## [0.13.0] - 2026-04-09

### Added
- **AI Player System**: Automated bot players with 6 configurable strategy profiles (Miner, Raider, Balanced, Defender, Explorer, Trader). Includes admin UI at `/admin/ai-players`, a background daemon (`ogamex:ai:daemon`), and Docker container integration.
- **Server Administration Panel**: Multi-account detection via shared IP analysis, bot suspect detection based on cross-account mission patterns, and player ban/unban system with audit trail.
- **Changelog page** in admin panel showing all notable changes.
- **Update Check page** in admin panel that fetches `version.xml` to compare installed vs. latest version.

### Changed
- Updated all repository references from `lanedirt/OGameX` to `hammermaps/OGameX-Test`.
- Updated installation guide with Docker data volume documentation.

## [0.12.0] - 2026-04-07

### Fixed
- Moon-origin fleet now correctly returns after moon destruction.
- Space Dock wreck-field repair timers and collection flow fixed.
- Skip last-slot warning for Terraformer and Moon Base.
- Display "Moon Destruction" in fleet widget instead of "Destroy".
- Server administration performance with large databases.
- Character class fadebox state on deactivate.
- Remove crawler from jump gate interface.

### Added
- ACS (Alliance Combat System) enforcement with `alliance_combat_system_on` setting.
- Rapidfire for Pathfinder and Reaper ships.
- Combat reports now include a wreckage-created section.
- Distinction between win and draw for Moon Destruction (MD) missions.

### Changed
- Expedition merchant and black hole outcome weights aligned with official OGame percentages.

## [0.11.0] - 2026-03-28

### Added
- **Laravel 13 Upgrade**: Full framework upgrade to Laravel 13.
- Scrapyard now parses locale-formatted ship counts correctly.
- `processChangepassword()` added with proper translation keys.

### Fixed
- Foreign key constraint violation when deleting a player with espionage reports.
- Base value upgrades corrected.

### Changed
- Dependency updates: Debugbar, Paratest, Pusher, Sail, Reverb, Tinker, Discord Alerts, IDE Helper, Rector Laravel.

## [0.10.0] - 2026-03-24

### Added
- Pathfinder and Reaper rapidfire values added.
- Expedition events: merchant and black hole probability weights tuned.

### Fixed
- Various combat-report wreckage display issues.
- Integer truncation in weighted random selection for expedition outcomes.

## [0.9.0] - 2026-03-20

### Added
- Resource columns (metal/crystal/deuterium) migrated from FLOAT to DOUBLE for improved precision.
- Extended AI Player strategies and daemon improvements.

### Fixed
- Multiple race condition fixes in unit queues.
- Battle engine performance improvements.
