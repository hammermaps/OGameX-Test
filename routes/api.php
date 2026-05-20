<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OGame\Http\Controllers\Api\UniverseGateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('universe-gate')->group(function () {
    Route::get('/status', [UniverseGateController::class, 'status'])->name('api.universe-gate.status');
    Route::post('/register', [UniverseGateController::class, 'register'])->name('api.universe-gate.register');
    Route::post('/heartbeat', [UniverseGateController::class, 'heartbeat'])->name('api.universe-gate.heartbeat');
    Route::post('/missions', [UniverseGateController::class, 'storeMission'])->name('api.universe-gate.missions.store');
    Route::post('/missions/{uuid}/result', [UniverseGateController::class, 'missionResult'])->name('api.universe-gate.missions.result');
    Route::post('/missions/{uuid}/return', [UniverseGateController::class, 'missionReturn'])->name('api.universe-gate.missions.return');
});
