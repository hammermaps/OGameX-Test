<?php

namespace OGame\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $uuid
 * @property int $universe_gate_server_id
 * @property int|null $user_id
 * @property int|null $planet_id_from
 * @property int|null $fleet_mission_id
 * @property string|null $remote_mission_uuid
 * @property string $direction
 * @property string $status
 * @property int $mission_type
 * @property int $target_galaxy
 * @property int $target_system
 * @property int $target_position
 * @property int $target_type
 * @property array<string,mixed> $fleet_payload
 * @property array<string,mixed>|null $resource_payload
 * @property array<string,mixed>|null $result_payload
 * @property array<string,mixed>|null $return_payload
 * @property string $idempotency_key
 * @property int|null $cooldown_until
 * @property Carbon|null $remote_dispatched_at
 * @property Carbon|null $completed_at
 */
class UniverseGateMission extends Model
{
    use HasFactory;

    public const DIRECTION_OUTGOING = 'outgoing';
    public const DIRECTION_INCOMING = 'incoming';

    public const STATUS_PENDING_REMOTE = 'pending_remote';
    public const STATUS_REMOTE_ACCEPTED = 'remote_accepted';
    public const STATUS_REMOTE_REJECTED = 'remote_rejected';
    public const STATUS_RETURNING = 'returning';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'uuid',
        'universe_gate_server_id',
        'user_id',
        'planet_id_from',
        'fleet_mission_id',
        'remote_mission_uuid',
        'direction',
        'status',
        'mission_type',
        'target_galaxy',
        'target_system',
        'target_position',
        'target_type',
        'fleet_payload',
        'resource_payload',
        'result_payload',
        'return_payload',
        'idempotency_key',
        'cooldown_until',
        'remote_dispatched_at',
        'completed_at',
    ];

    protected $casts = [
        'fleet_payload' => 'array',
        'resource_payload' => 'array',
        'result_payload' => 'array',
        'return_payload' => 'array',
        'remote_dispatched_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(UniverseGateServer::class, 'universe_gate_server_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function originPlanet(): BelongsTo
    {
        return $this->belongsTo(Planet::class, 'planet_id_from');
    }

    public function fleetMission(): BelongsTo
    {
        return $this->belongsTo(FleetMission::class);
    }
}
