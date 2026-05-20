<?php

namespace OGame\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use OGame\Http\Controllers\Controller;
use OGame\Models\UniverseGateMission;
use OGame\Models\UniverseGateServer;
use OGame\Services\SettingsService;
use OGame\Services\UniverseGateService;

class UniverseGateController extends Controller
{
    public function __construct(private UniverseGateService $universeGateService, private SettingsService $settingsService)
    {
    }

    public function status(): JsonResponse
    {
        return $this->universeGateService->apiResponse([
            'enabled' => $this->universeGateService->isEnabled(),
            'server_time' => Date::now()->timestamp,
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'universe_identifier' => ['required', 'string', 'max:64'],
            'name' => ['required', 'string', 'max:120'],
            'base_url' => ['required', 'url', 'max:255'],
            'shared_secret' => ['required', 'string', 'min:32', 'max:255'],
            'api_version' => ['nullable', 'string', 'max:16'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('validation_failed', $validator->errors()->first(), 422);
        }

        if ($request->string('universe_identifier')->toString() === $this->universeGateService->localIdentifier()) {
            return $this->errorResponse('self_registration_rejected', 'A universe cannot register itself.', 409);
        }

        $server = UniverseGateServer::updateOrCreate(
            ['universe_identifier' => $request->string('universe_identifier')->toString()],
            [
                'name' => $request->string('name')->toString(),
                'base_url' => rtrim($request->string('base_url')->toString(), '/'),
                'status' => UniverseGateServer::STATUS_PENDING,
                'registration_direction' => 'incoming',
                'shared_secret' => $request->string('shared_secret')->toString(),
                'last_seen_at' => Date::now(),
                'metadata' => [
                    'api_version' => $request->input('api_version', UniverseGateService::API_VERSION),
                ],
            ]
        );

        return $this->universeGateService->apiResponse([
            'status' => 'pending',
            'server_id' => $server->id,
            'message' => 'Registration request stored. An administrator must activate this universe before fleet exchange is allowed.',
        ], 202);
    }

    public function heartbeat(Request $request): JsonResponse
    {
        $server = $this->requireSignedServer($request);
        if ($server instanceof JsonResponse) {
            return $server;
        }

        return $this->universeGateService->apiResponse([
            'status' => $server->status,
            'server_time' => Date::now()->timestamp,
        ]);
    }

    public function storeMission(Request $request): JsonResponse
    {
        $server = $this->requireSignedServer($request);
        if ($server instanceof JsonResponse) {
            return $server;
        }

        $validator = Validator::make($request->all(), [
            'remote_mission_uuid' => ['required', 'string', 'max:64'],
            'mission_type' => ['required', 'integer', 'in:1'],
            'target.galaxy' => ['required', 'integer', 'min:1'],
            'target.system' => ['required', 'integer', 'min:1'],
            'target.position' => ['required', 'integer', 'min:1'],
            'target.type' => ['required', 'integer', 'in:1,3'],
            'fleet' => ['required', 'array'],
            'resources' => ['nullable', 'array'],
            'idempotency_key' => ['required', 'string', 'max:120'],
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('validation_failed', $validator->errors()->first(), 422);
        }

        $existing = UniverseGateMission::where('idempotency_key', $request->string('idempotency_key')->toString())->first();
        if ($existing !== null) {
            return $this->universeGateService->apiResponse([
                'status' => $existing->status,
                'mission_uuid' => $existing->uuid,
                'duplicate' => true,
            ]);
        }

        $mission = UniverseGateMission::create([
            'uuid' => (string)Str::uuid(),
            'universe_gate_server_id' => $server->id,
            'remote_mission_uuid' => $request->string('remote_mission_uuid')->toString(),
            'direction' => UniverseGateMission::DIRECTION_INCOMING,
            'status' => UniverseGateMission::STATUS_REMOTE_ACCEPTED,
            'mission_type' => 1,
            'target_galaxy' => (int)$request->input('target.galaxy'),
            'target_system' => (int)$request->input('target.system'),
            'target_position' => (int)$request->input('target.position'),
            'target_type' => (int)$request->input('target.type'),
            'fleet_payload' => $request->input('fleet'),
            'resource_payload' => $request->input('resources', []),
            'idempotency_key' => $request->string('idempotency_key')->toString(),
            'remote_dispatched_at' => Date::now(),
        ]);

        return $this->universeGateService->apiResponse([
            'status' => $mission->status,
            'mission_uuid' => $mission->uuid,
        ], 202);
    }

    public function missionResult(Request $request, string $uuid): JsonResponse
    {
        $server = $this->requireSignedServer($request);
        if ($server instanceof JsonResponse) {
            return $server;
        }

        $mission = UniverseGateMission::where('uuid', $uuid)
            ->where('universe_gate_server_id', $server->id)
            ->first();

        if ($mission === null) {
            return $this->errorResponse('mission_not_found', 'Mission not found.', 404);
        }

        $mission->result_payload = $request->input('result', []);
        $mission->status = UniverseGateMission::STATUS_RETURNING;
        $mission->save();

        return $this->universeGateService->apiResponse(['status' => $mission->status]);
    }

    public function missionReturn(Request $request, string $uuid): JsonResponse
    {
        $server = $this->requireSignedServer($request);
        if ($server instanceof JsonResponse) {
            return $server;
        }

        $mission = UniverseGateMission::where('uuid', $uuid)
            ->where('universe_gate_server_id', $server->id)
            ->first();

        if ($mission === null) {
            return $this->errorResponse('mission_not_found', 'Mission not found.', 404);
        }

        $mission->return_payload = $request->input('return', []);
        $mission->status = UniverseGateMission::STATUS_COMPLETED;
        $mission->completed_at = Date::now();
        $mission->save();

        return $this->universeGateService->apiResponse(['status' => $mission->status]);
    }

    private function requireSignedServer(Request $request): UniverseGateServer|JsonResponse
    {
        $server = $this->universeGateService->verifySignedRequest($request);
        if ($server === null) {
            return $this->errorResponse('invalid_signature', 'Missing or invalid Universe Gate signature.', 401);
        }

        return $server;
    }

    private function errorResponse(string $code, string $message, int $status): JsonResponse
    {
        return $this->universeGateService->apiResponse([
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ], $status);
    }
}
