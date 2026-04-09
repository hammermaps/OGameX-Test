# OGameX – Agent Documentation

## Project Overview

OGameX is an open-source OGame redesign clone built from scratch with **Laravel 13.x** (PHP 8.5) and a high-performance **Rust** battle engine integrated via FFI. It is a multiplayer browser-based space strategy game featuring planet management, fleet operations, research, combat, alliances, and real-time communication.

- **Live Demo (nightly):** https://main.ogamex.dev
- **Live Demo (stable):** https://release.ogamex.dev
- **License:** MIT (backend code); artwork/frontend concepts belong to GameForge GmbH.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend Framework** | Laravel 13.x (PHP 8.5) |
| **Database** | MariaDB 11.3 |
| **Battle Engine** | Rust (via PHP FFI, ~200x faster than PHP fallback) |
| **Frontend** | Blade templates, Laravel Mix (webpack), Vanilla JS |
| **WebSockets** | Laravel Reverb + Pusher.js + Laravel Echo |
| **Containerization** | Docker Compose (dev + prod configs) |
| **Web Server** | Nginx (reverse proxy) + PHP-FPM |
| **Static Analysis** | PHPStan Level 7 (via Larastan) |
| **Code Style** | PSR-12 via Laravel Pint |
| **Refactoring** | Rector with Laravel-specific rules |
| **Testing** | PHPUnit 13 + Paratest (parallel) |
| **Auth** | Laravel Fortify + spatie/laravel-permission |
| **CI/CD** | 10 GitHub Actions workflows |

---

## Repository Structure

```
OGameX/
├── app/                    # Application source code (PHP)
│   ├── Actions/            # Fortify action classes (Command pattern)
│   ├── Console/            # Artisan CLI commands (admin, dev, scheduler, tests)
│   ├── Enums/              # PHP enums (CharacterClass, FleetMissionStatus, etc.)
│   ├── Events/             # Event classes (ChatMessageSent)
│   ├── Exceptions/         # Custom exception handler
│   ├── Facades/            # Laravel facades (AppUtil, GitInfoUtil)
│   ├── Factories/          # Factory classes for services and game objects
│   ├── GameConstants/      # Static game configuration (UniverseConstants)
│   ├── GameMessages/       # In-game notification system (20+ message types)
│   ├── GameMissions/       # Fleet mission logic (10 mission types + battle engine)
│   ├── GameObjects/        # Game unit/building/research definitions
│   ├── Http/               # Controllers (41+), middleware (7), traits, view composers
│   ├── Jobs/               # Queue jobs (CreateLegorMoon)
│   ├── Models/             # Eloquent models (36 models)
│   ├── Observers/          # Model lifecycle observers (User, UserTech)
│   ├── Providers/          # Service providers (App, Fortify)
│   ├── Services/           # Business logic services (36 services)
│   └── ViewModels/         # View model DTOs for Blade templates
├── bootstrap/              # Laravel bootstrap files
├── config/                 # Configuration files (15 configs)
├── database/
│   ├── factories/          # Model factories for testing
│   ├── migrations/         # Database migrations (48 migration files)
│   └── seeds/              # Database seeders
├── docker/                 # Docker support files (entrypoint.sh, phpmyadmin config)
├── docs/                   # Developer documentation
├── nginx/                  # Nginx configuration
├── php/                    # Custom PHP rules
├── public/                 # Public web root (index.php, assets)
├── resources/
│   ├── css/                # Stylesheets (ingame + outgame)
│   ├── js/                 # JavaScript (ingame + outgame, WebSocket support)
│   ├── lang/               # Localization (en, it, nl)
│   └── views/              # Blade templates (107 templates)
├── routes/
│   ├── web.php             # Web routes (40+ authenticated endpoints)
│   ├── api.php             # API routes (minimal)
│   ├── channels.php        # Broadcast channel authorization
│   └── console.php         # Console route definitions
├── rust/                   # Rust battle engine (FFI library)
│   ├── battle_engine_ffi/  # Main FFI shared library
│   ├── battle_engine_debug/# Debug binary for testing
│   ├── test_ffi/           # FFI test harness
│   └── compile.sh          # Build script
├── storage/                # Laravel storage (logs, cache, sessions)
├── tests/
│   ├── Feature/            # Integration tests (60+ files)
│   ├── Unit/               # Unit tests (35+ files)
│   └── Console/            # Console command tests
├── .github/
│   ├── workflows/          # CI/CD pipelines (10 workflows)
│   ├── ISSUE_TEMPLATE/     # Issue templates
│   └── PULL_REQUEST_TEMPLATE.md
├── Dockerfile              # PHP 8.5-FPM + Rust toolchain
├── docker-compose.yml      # Development environment (7 services)
├── docker-compose.prod.yml # Production environment
├── composer.json           # PHP dependencies
├── package.json            # Node.js dependencies (Laravel Mix)
├── phpstan.neon            # PHPStan configuration (Level 7)
├── phpunit.xml             # PHPUnit test configuration
├── pint.json               # Laravel Pint code style (PSR-12)
├── rector.php              # Rector refactoring rules
└── webpack.mix.js          # Laravel Mix (asset compilation)
```

---

## Architecture

### Domain-Driven Design

The application follows a domain-driven approach with dedicated directories for game-specific logic:

- **GameMissions/** – Encapsulates fleet mission lifecycle (dispatch → travel → execute → return). Each mission type extends `Abstracts/GameMission.php`.
- **GameObjects/** – Defines all buildable/researchable items (buildings, ships, defense, research) with their properties, costs, and requirements.
- **GameMessages/** – Polymorphic in-game notification system for battle reports, expedition results, espionage reports, etc.
- **GameConstants/** – Static universe configuration (coordinate ranges, speed multipliers, resource ratios).

### Service Layer

All business logic is encapsulated in `app/Services/` (36 services). Key services:

| Service | Responsibility |
|---------|---------------|
| `PlanetService` | Planet data, resource production, building management (largest service) |
| `PlayerService` | Player account operations, tech levels, planet lists |
| `FleetMissionService` | Mission lifecycle: dispatch, processing, cancellation |
| `ObjectService` | Building/unit validation, cost calculations, tech tree checks |
| `BuildingQueueService` | Construction queue processing and scheduling |
| `ResearchQueueService` | Technology research queue management |
| `HighscoreService` | Player/alliance ranking calculations |
| `AllianceService` | Alliance CRUD, membership, permissions |
| `SettingsService` | Server-wide game configuration |

### Battle Engine (Dual Implementation)

Located in `app/GameMissions/BattleEngine/`:

- **RustBattleEngine** – High-performance implementation via PHP FFI (~200x faster, 4x less memory).
- **PhpBattleEngine** – Pure PHP fallback for environments without Rust/FFI support.

Both extend `BattleEngine.php` (abstract base) and produce identical results.

### HTTP Layer

- **41+ Controllers** in `app/Http/Controllers/` handle all game pages and AJAX endpoints.
- **7 Middleware** enforce authentication, ban checks, locale, admin access, server timing, and onboarding.
- **View Composers** inject shared data (player info, planet list, fleet events) into Blade templates.

### Real-Time Features

- **Laravel Reverb** provides WebSocket support for real-time chat and fleet event updates.
- **Laravel Echo** + **Pusher.js** on the frontend handle WebSocket subscriptions.

---

## Key Models (Eloquent ORM)

### Core
- `User` – Player account (auth, dark matter, vacation mode, character class)
- `Planet` – Planet entity (coordinates, resources, buildings, fields)
- `UserTech` – Research levels per player
- `Resources` – Resource pool (metal, crystal, deuterium) per planet

### Fleet & Combat
- `FleetMission` – Active fleet operation (status, resources, timing, units)
- `BattleReport` – Combat engagement logs
- `WreckField` / `DebrisField` – Post-battle debris
- `EspionageReport` – Intelligence gathered from spy missions
- `FleetTemplate` – Saved fleet compositions

### Queues
- `BuildingQueue` – Planet construction queue
- `ResearchQueue` – Research queue
- `UnitQueue` – Ship/defense construction queue

### Social
- `Alliance`, `AllianceMember`, `AllianceRank`, `AllianceApplication`
- `Message`, `ChatMessage`, `BuddyRequest`, `Note`

---

## Game Missions

All mission types in `app/GameMissions/`:

| Mission | File | Description |
|---------|------|-------------|
| Attack | `AttackMission.php` | Fleet combat against enemy planets/moons |
| Espionage | `EspionageMission.php` | Spy on enemy planets |
| Transport | `TransportMission.php` | Send resources between planets |
| Deployment | `DeploymentMission.php` | Station ships at another planet |
| Colonisation | `ColonisationMission.php` | Establish new planets |
| Recycle | `RecycleMission.php` | Harvest debris fields |
| Expedition | `ExpeditionMission.php` | Explore deep space (random outcomes) |
| Moon Destruction | `MoonDestructionMission.php` | Destroy enemy moons |
| Missile Attack | `MissileAttackMission.php` | Interplanetary missile strikes |
| ACS Defend | `AcsDefendMission.php` | Allied defense support |

---

## Development Commands

### Code Style (PSR-12)
```bash
# Check code style
composer run cs -- --test

# Auto-fix code style
composer run cs
```

### Static Analysis (PHPStan Level 7)
```bash
composer run stan
```

### Automated Refactoring (Rector)
```bash
composer run rector
```

### Tests (PHPUnit)
```bash
# Run all tests
php artisan test

# Run specific test class
php artisan test --filter PlanetServiceTest

# Run with parallel execution
./vendor/bin/paratest
```

### Race Condition Tests
```bash
php artisan test:race-condition-unitqueue
php artisan test:race-condition-game-mission
```

### Battle Engine Performance
```bash
php artisan test:battle-engine-performance rust --fleet='...'
```

### Rust Battle Engine
```bash
# Compile
./rust/compile.sh

# Debug
cargo run --release --package battle_engine_debug
```

### Frontend Assets (Laravel Mix)
```bash
npm run dev        # Development build
npm run production # Production build
npm run watch      # Watch mode
```

---

## CI/CD Pipelines

| Workflow | File | Purpose |
|----------|------|---------|
| Docker Compose Prod Build | `run-docker-compose-prod.yml` | Validates production Docker build |
| Tests | `run-tests-docker-compose.yml` | Full test suite execution in Docker |
| PHPStan Analysis | `run-phpstan-code-analysis.yml` | Static code analysis (Level 7) |
| Laravel Pint | `run-laravel-pint-code-style-checker.yml` | PSR-12 code style validation |
| Rector Analysis | `run-rector-code-analysis.yml` | Automated refactoring compliance |
| Flaky Test Detection | `run-tests-flaky-detection.yml` | Detects non-deterministic tests |
| Deploy Main | `deploy-main.yml` | Deploys main branch to staging |
| Deploy Release | `deploy-release.yml` | Deploys tagged releases to production |
| PR Preview | `pr-preview.yml` | Creates preview environment for PRs |
| PR Preview Teardown | `pr-preview-teardown.yml` | Cleans up PR preview environments |

---

## Docker Setup

### Development
```bash
docker compose up -d
# Access at http://localhost
# PhpMyAdmin at http://localhost:8080
```

### Production
```bash
cp .env.example-prod .env
docker compose -f docker-compose.prod.yml up -d --build --force-recreate
# Access at https://localhost
```

### Services (Development)
| Container | Service |
|-----------|---------|
| `ogamex-db` | MariaDB 11.3.2 |
| `ogamex-app` | PHP-FPM application |
| `ogamex-scheduler` | Laravel task scheduler |
| `ogamex-queue-worker` | Queue job processor |
| `ogamex-webserver` | Nginx reverse proxy |
| `ogamex-reverb` | WebSocket server (Laravel Reverb) |
| `ogamex-phpmyadmin` | Database admin UI |

> **Note:** First startup can take up to 10 minutes due to Composer initialization and Rust compilation.

---

## Database

- **48 migration files** covering the full schema evolution (2017–2025).
- Key tables: `users`, `planets`, `resources`, `user_tech`, `fleet_missions`, `building_queue`, `research_queue`, `unit_queue`, `alliances`, `messages`, `battle_reports`, `highscores`.
- Resources are stored as `float` for precision.
- Queue-based architecture for buildings, research, and unit construction.

---

## Localization

Supported languages in `resources/lang/`:
- **English** (en) – primary
- **Italian** (it)
- **Dutch** (nl)

---

## Coding Conventions

1. **PSR-12** code style enforced via Laravel Pint (`pint.json`).
2. **PHPStan Level 7** static analysis – strict type checking, no short nullable types.
3. **Rector** automated refactoring – type declarations, Laravel-specific transformations.
4. **PHP 8.5** features: enums, typed properties, match expressions, named arguments.
5. **Namespace:** `OGame\` maps to `app/` directory.
6. **Testing namespace:** `Tests\` maps to `tests/` directory.
7. **Consistency over preference:** Match existing conventions in the file you are modifying.
8. **No code golfing:** Prioritize clarity and readability over compactness.
9. **Named methods over anonymous functions:** Extract reusable logic into helper methods.
10. **One issue, one PR:** Each pull request must address a single concern.

---

## Admin Commands

```bash
# Assign admin role
php artisan ogamex:admin:assign-role {username}

# Remove admin role
php artisan ogamex:admin:remove-role {username}
```

The first registered user is automatically assigned the admin role.
