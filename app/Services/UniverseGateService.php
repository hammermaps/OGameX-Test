<?php

namespace OGame\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use OGame\GameObjects\Models\Units\UnitCollection;
use OGame\Models\Enums\PlanetType;
use OGame\Models\Resources;
use OGame\Models\UniverseGateMission;
use OGame\Models\UniverseGateServer;

class UniverseGateService
{
    public const API_VERSION = '1.0';
    private const SIGNATURE_TOLERANCE_SECONDS = 300;

    public function __construct(
        private SettingsService $settingsService,
        private FleetMissionService $fleetMissionService
    ) {
    }

    public function isEnabled(): bool
    {
        return (bool)(int)$this->settingsService->get('universe_gate_enabled', 0);
    }

    public function localIdentifier(): string
    {
        $identifier = trim($this->settingsService->get('universe_gate_identifier', ''));
        if ($identifier !== '') {
            return $identifier;
        }

        return Str::slug($this->settingsService->universeName()) ?: 'ogamex-universe';
    }

    public function cooldownSeconds(): int
    {
        return max(3600, (int)$this->settingsService->get('universe_gate_cooldown_seconds', 604800));
    }

    public function deuteriumCostMultiplier(): int
    {
        return max(1, (int)$this->settingsService->get('universe_gate_deuterium_cost_multiplier', 10));
    }

    public function isPlayerOptedIn(PlayerService $player): bool
    {
        return (bool)$player->getUser()->universe_gate_enabled;
    }

    public function isOnCooldown(PlayerService $player): bool
    {
        $cooldownUntil = $player->getUser()->universe_gate_cooldown_until;
        return $cooldownUntil !== null && (int)$cooldownUntil > Date::now()->timestamp;
    }

    public function getRemainingCooldown(PlayerService $player): int
    {
        $cooldownUntil = $player->getUser()->universe_gate_cooldown_until;
        if ($cooldownUntil === null) {
            return 0;
        }

        return max(0, (int)$cooldownUntil - Date::now()->timestamp);
    }

    public function setCooldown(PlayerService $player): void
    {
        $player->getUser()->universe_gate_cooldown_until = Date::now()->timestamp + $this->cooldownSeconds();
        $player->save();
    }

    /**
     * @return array<int, UniverseGateServer>
     */
    public function activeServers(): array
    {
        return UniverseGateServer::active()->orderBy('name')->get()->all();
    }

    /**
     * @throws Exception
     */
    public function createOutgoingAttack(
        PlayerService $player,
        PlanetService $planet,
        UniverseGateServer $targetServer,
        PlanetType $targetType,
        int $galaxy,
        int $system,
        int $position,
        UnitCollection $units,
        Resources $resources,
        float $speedPercent
    ): UniverseGateMission {
        $this->assertCanUseGate($player, $planet, $targetServer, $units);

        if ($targetType !== PlanetType::Planet && $targetType !== PlanetType::Moon) {
            throw new Exception(__('Universe Gate attacks can only target planets and moons.'));
        }

        $targetCoordinate = new \OGame\Models\Planet\Coordinate($galaxy, $system, $position);
        $baseConsumption = $this->fleetMissionService->calculateConsumption($planet, $units, $targetCoordinate, 0, $speedPercent);
        $gateConsumption = $baseConsumption * $this->deuteriumCostMultiplier();
        $deductResources = new Resources(
            $resources->metal->get(),
            $resources->crystal->get(),
            $resources->deuterium->get() + $gateConsumption,
            0
        );

        return DB::transaction(function () use ($player, $planet, $targetServer, $targetType, $galaxy, $system, $position, $units, $resources, $deductResources, $gateConsumption) {
            if (!$planet->deductResourcesAndUnitsAtomic($deductResources, $units)) {
                throw new Exception(__('Not enough resources or units on the planet to send the Universe Gate fleet.'));
            }

            $uuid = (string)Str::uuid();
            $mission = UniverseGateMission::create([
                'uuid' => $uuid,
                'universe_gate_server_id' => $targetServer->id,
                'user_id' => $player->getId(),
                'planet_id_from' => $planet->getPlanetId(),
                'direction' => UniverseGateMission::DIRECTION_OUTGOING,
                'status' => UniverseGateMission::STATUS_PENDING_REMOTE,
                'mission_type' => 1,
                'target_galaxy' => $galaxy,
                'target_system' => $system,
                'target_position' => $position,
                'target_type' => $targetType->value,
                'fleet_payload' => $this->unitCollectionToPayload($units),
                'resource_payload' => [
                    'metal' => $resources->metal->getRounded(),
                    'crystal' => $resources->crystal->getRounded(),
                    'deuterium' => $resources->deuterium->getRounded(),
                    'gate_deuterium_cost' => $gateConsumption,
                ],
                'idempotency_key' => $uuid,
                'cooldown_until' => Date::now()->timestamp + $this->cooldownSeconds(),
            ]);

            $this->setCooldown($player);

            return $mission;
        });
    }

    /**
     * @throws Exception
     */
    public function assertCanUseGate(PlayerService $player, PlanetService $planet, UniverseGateServer $targetServer, UnitCollection $units): void
    {
        if (!$this->isEnabled()) {
            throw new Exception(__('Universe Gate is disabled on this server.'));
        }

        if (!$this->isPlayerOptedIn($player)) {
            throw new Exception(__('Enable Universe Gate usage in your profile options first.'));
        }

        if ($targetServer->status !== UniverseGateServer::STATUS_ACTIVE) {
            throw new Exception(__('The target universe is not registered as active.'));
        }

        if ($this->isOnCooldown($player)) {
            throw new Exception(__('Universe Gate is still on cooldown.'));
        }

        if ($planet->getObjectLevel('jump_gate') < 1) {
            throw new Exception(__('A local Jump Gate is required before using the Universe Gate.'));
        }

        if ($units->getAmount() <= 0) {
            throw new Exception(__('No ships were selected!'));
        }
    }

    /**
     * @return array<string,int>
     */
    public function unitCollectionToPayload(UnitCollection $units): array
    {
        $payload = [];
        foreach ($units->units as $unit) {
            $payload[$unit->unitObject->machine_name] = $unit->amount;
        }

        return $payload;
    }

    public function signPayload(UniverseGateServer $server, string $timestamp, string $nonce, string $body): string
    {
        return hash_hmac('sha256', $timestamp . '.' . $nonce . '.' . $body, $server->shared_secret);
    }

    public function verifySignedRequest(Request $request): UniverseGateServer|null
    {
        $identifier = (string)$request->header('X-Universe-Identifier', '');
        $timestamp = (string)$request->header('X-Universe-Timestamp', '');
        $nonce = (string)$request->header('X-Universe-Nonce', '');
        $signature = (string)$request->header('X-Universe-Signature', '');

        if ($identifier === '' || $timestamp === '' || $nonce === '' || $signature === '') {
            return null;
        }

        if (abs(Date::now()->timestamp - (int)$timestamp) > self::SIGNATURE_TOLERANCE_SECONDS) {
            return null;
        }

        $cacheKey = 'universe-gate-nonce:' . $identifier . ':' . $nonce;
        if (Cache::has($cacheKey)) {
            return null;
        }

        $server = UniverseGateServer::where('universe_identifier', $identifier)->first();
        if ($server === null || $server->status !== UniverseGateServer::STATUS_ACTIVE) {
            return null;
        }

        $expected = $this->signPayload($server, $timestamp, $nonce, $request->getContent());
        if (!hash_equals($expected, $signature)) {
            return null;
        }

        Cache::put($cacheKey, true, self::SIGNATURE_TOLERANCE_SECONDS);
        $server->last_seen_at = Date::now();
        $server->save();

        return $server;
    }

    public function apiResponse(array $data = [], int $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json(array_merge([
            'api_version' => self::API_VERSION,
            'universe_identifier' => $this->localIdentifier(),
            'universe_name' => $this->settingsService->universeName(),
        ], $data), $status);
    }
}
