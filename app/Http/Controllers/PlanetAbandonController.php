<?php

namespace OGame\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use OGame\Services\PlanetService;
use OGame\Services\PlayerService;

class PlanetAbandonController extends OGameController
{
    /**
     * Returns the planet abandon/rename overlay popup.
     *
     * @param PlayerService $player
     * @return View
     */
    public function overlay(PlayerService $player): View
    {
        return view('ingame.planetabandon.overlay')->with([
            'currentPlanet' => $player->planets->current(),
            'isMoon' => $player->planets->current()->isMoon(),
            'isCurrentPlanetHomePlanet' => $player->planets->current()->getPlanetId() === $player->planets->first()->getPlanetId(),
        ]);
    }

    /**
     * Rename the current planet.
     *
     * @param PlayerService $player
     * @return JsonResponse
     */
    public function rename(PlayerService $player): JsonResponse
    {
        // Get form data
        $planetName = request('newPlanetName');

        // Validate planet name
        if ($player->planets->current()->isValidPlanetName($planetName) === false) {
            $errorText = $player->planets->current()->isMoon() ? __('t_ingame.planet_abandon.msg_invalid_moon_name') : __('t_ingame.planet_abandon.msg_invalid_planet_name');

            return response()->json([
                'status' => 'error',
                'errorbox' => [
                    'type' => 'fadeBox',
                    'text' => $errorText,
                    'failed' => true,
                ],
            ]);
        }

        // Update planet name
        $player->planets->current()->setPlanetName($planetName);

        $successText = $player->planets->current()->isMoon() ? __('t_ingame.planet_abandon.msg_moon_renamed') : __('t_ingame.planet_abandon.msg_planet_renamed');

        // Return JSON response
        return response()->json([
            'status' => 'success',
            'errorbox' => [
                'type' => 'fadeBox',
                'text' => $successText,
                'failed' => false,
            ],
        ]);
    }

    /**
     * Shows confirm popup for abandoning the current planet.
     *
     * @param PlayerService $player
     * @return JsonResponse
     */
    public function abandonConfirm(PlayerService $player): JsonResponse
    {
        // Get form data
        $password = request('password');

        // Validate password
        if (!$player->isPasswordValid($password)) {
            return response()->json([
                'status' => 'error',
                'errorbox' => [
                    'type' => 'fadeBox',
                    'text' => __('t_ingame.planet_abandon.msg_wrong_password'),
                    'failed' => true,
                ],
                'newAjaxToken' => csrf_token(),
            ]);
        }

        // Resolve the planet to abandon using the explicitly provided planet_id so that
        // a current-planet switch between overlay open and form submit cannot affect the wrong planet.
        $planetToDelete = $this->resolveRequestedPlanet($player);
        if ($planetToDelete === null) {
            return $this->invalidPlanetResponse();
        }

        $isMoon = $planetToDelete->isMoon();

        // Return JSON response to ask user to confirm.
        return response()->json([
            'errorbox' => [
                'type' => 'decision',
                'title' => __('t_ingame.planet_abandon.msg_confirm_title'),
                'text' => __('t_ingame.planet_abandon.msg_confirm_deletion', [
                    'type' => $isMoon ? __('t_ingame.planet_abandon.type_moon') : __('t_ingame.planet_abandon.type_planet'),
                    'coordinates' => $planetToDelete->getPlanetCoordinates()->asString(),
                    'name' => $planetToDelete->getPlanetName()
                ]),
                'buttonOk' => __('t_ingame.planet_abandon.msg_yes'),
                'buttonNOk' => __('t_ingame.planet_abandon.msg_no'),
                'okFunction' => 'submit_planet_delete_form',
                'nokFunction' => 'reload',
            ],
            'password_checked' => true,
            'planet_id' => $planetToDelete->getPlanetId(),
            'intent' => route('planetabandon.abandon'),
            'newAjaxToken' => csrf_token(),
            // TODO: the original code includes "productionBox" key with HTML inside of it, check later if it's needed?
        ]);
    }

    /**
     * Actually abandon the current planet.
     *
     * @param PlayerService $player
     * @return JsonResponse
     * @throws Exception
     */
    public function abandon(PlayerService $player): JsonResponse
    {
        // Get form data
        $password = request('password');

        // Resolve the planet to abandon using the explicitly provided planet_id.
        $planetToDelete = $this->resolveRequestedPlanet($player);
        if ($planetToDelete === null) {
            return $this->invalidPlanetResponse();
        }
        $isMoon = $planetToDelete->isMoon();

        // Validate password
        if (!$player->isPasswordValid($password)) {
            return response()->json([
                'status' => 'error',
                'errorbox' => [
                    'type' => 'fadeBox',
                    'text' => __('t_ingame.planet_abandon.msg_wrong_password'),
                    'failed' => true,
                ],
                'newAjaxToken' => csrf_token(),
            ]);
        }

        try {
            // Abandon the planet.
            $planetToDelete->abandonPlanet();
        } catch (Exception $e) {
            // Exception occured, return error.
            return response()->json([
                'status' => 'error',
                'errorbox' => [
                    'type' => 'fadeBox',
                    'text' => $e->getMessage(),
                    'failed' => true,
                ],
                'newAjaxToken' => csrf_token(),
            ]);
        }

        // Return success message.
        return response()->json([
            'status' => 'success',
            'errorbox' => [
                'type' => 'notify',
                'title' => __('t_ingame.planet_abandon.msg_reference'),
                'text' => __('t_ingame.planet_abandon.msg_abandoned', [
                    'type' => $isMoon ? __('t_ingame.planet_abandon.msg_type_moon') : __('t_ingame.planet_abandon.msg_type_planet')
                ]),
                'buttonOk' => __('t_ingame.planet_abandon.msg_ok'),
                'okFunction' => 'reloadPage',
            ],
            'newAjaxToken' => csrf_token(),
            // TODO: the original code includes "productionBox" key with HTML inside of it, check later if it's needed?
        ]);
    }

    private function resolveRequestedPlanet(PlayerService $player): ?PlanetService
    {
        $requestedPlanetId = (int)request('planet_id');
        if ($requestedPlanetId < 1 || !$player->planets->planetExistsAndOwnedByPlayer($requestedPlanetId)) {
            return null;
        }

        return $player->planets->getById($requestedPlanetId);
    }

    private function invalidPlanetResponse(): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'errorbox' => [
                'type' => 'fadeBox',
                'text' => __('Target planet does not exist'),
                'failed' => true,
            ],
            'newAjaxToken' => csrf_token(),
        ]);
    }
}
