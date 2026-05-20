<?php

namespace OGame\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $universe_identifier
 * @property string $name
 * @property string $base_url
 * @property string $status
 * @property string $registration_direction
 * @property string $shared_secret
 * @property Carbon|null $registered_at
 * @property Carbon|null $last_seen_at
 * @property array<string,mixed>|null $metadata
 * @method static Builder<static>|UniverseGateServer active()
 */
class UniverseGateServer extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_ERROR = 'error';

    protected $fillable = [
        'universe_identifier',
        'name',
        'base_url',
        'status',
        'registration_direction',
        'shared_secret',
        'registered_at',
        'last_seen_at',
        'metadata',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'metadata' => 'array',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function missions(): HasMany
    {
        return $this->hasMany(UniverseGateMission::class);
    }
}
