<?php

namespace OGame\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OGame\Factories\PlanetServiceFactory;
use OGame\Services\BuildingQueueService;
use OGame\Services\DarkMatterService;
use OGame\Services\FleetMissionService;
use OGame\Services\PlanetMoveService;
use OGame\Services\PlayerService;
use OGame\Services\ResearchQueueService;
use OGame\Services\SettingsService;
use OGame\Services\UnitQueueService;
use Throwable;

class GlobalGame
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Throwable
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            // Load current player and make it available as a request singleton via PlayerService.
            $player = resolve(PlayerService::class, ['player_id' => $request->user()->id]);

            /** @var PlayerService $player */
            app()->instance(PlayerService::class, $player);

            // Check if current planet change querystring parameter exists, if so, change current planet.
            if (!empty($request->query('cp'))) {
                $player->setCurrentPlanetId((int)$request->query('cp'));
            }

            // Update player.
            $player->update();

            // Update current planet of player.
            // Note: due to how planet-update locking works, the player and all its planets are
            // loaded above. This second update() call re-fetches the current planet to obtain
            // the latest data after any concurrent updates (e.g. fleet missions processed just
            // above). The redundant SELECT is a minor performance cost; a future improvement
            // would be to consolidate the initial load and this update into a single read.
            $player->planets->current()->update();

            // Update all fleet missions of player that are associated with any of the player's planets.
            $player->updateFleetMissions();

            // Process any due planet moves.
            $planetMoveService = resolve(PlanetMoveService::class);
            $planetMoveService->processDueMoves(
                resolve(PlanetServiceFactory::class),
                resolve(DarkMatterService::class),
                resolve(SettingsService::class),
                resolve(BuildingQueueService::class),
                resolve(ResearchQueueService::class),
                resolve(UnitQueueService::class),
                resolve(FleetMissionService::class),
            );

            // Share planet_move_in_progress for all views.
            $activeMove = $planetMoveService->getActiveMoveForPlanet($player->planets->current());
            view()->share('planet_move_in_progress', $activeMove !== null);
        }

        return $next($request);
    }
}
