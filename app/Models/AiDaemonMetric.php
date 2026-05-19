<?php

namespace OGame\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $memory_usage_bytes
 * @property int $players_processed
 * @property Carbon $recorded_at
 * @mixin \Eloquent
 */
class AiDaemonMetric extends Model
{
    public $timestamps = false;

    protected $table = 'ai_daemon_metrics';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'memory_usage_bytes',
        'players_processed',
        'recorded_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    /**
     * Maximum number of rows to retain. Older rows are pruned after each insert.
     */
    public const MAX_ROWS = 1440;
}
