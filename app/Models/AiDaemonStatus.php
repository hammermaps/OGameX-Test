<?php

namespace OGame\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $pid
 * @property string $status
 * @property Carbon|null $started_at
 * @property Carbon|null $last_heartbeat_at
 * @property int $players_processed
 * @property int $total_actions_executed
 * @property int $memory_usage
 * @property string|null $error_log
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 */
class AiDaemonStatus extends Model
{
    public $timestamps = false;

    protected $table = 'ai_daemon_status';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'pid',
        'status',
        'started_at',
        'last_heartbeat_at',
        'players_processed',
        'total_actions_executed',
        'memory_usage',
        'error_log',
        'updated_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'last_heartbeat_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Check if the daemon is currently running (heartbeat within last 2 minutes).
     */
    public function isRunning(): bool
    {
        if ($this->status !== 'running') {
            return false;
        }

        if ($this->last_heartbeat_at === null) {
            return false;
        }

        return $this->last_heartbeat_at->diffInSeconds(now()) < 120;
    }

    /**
     * Get the uptime as a human-readable string.
     */
    public function getUptime(): string
    {
        if ($this->started_at === null || $this->status !== 'running') {
            return '-';
        }

        return $this->started_at->diffForHumans(now(), true);
    }

    /**
     * Get memory usage as a formatted string.
     */
    public function getFormattedMemoryUsage(): string
    {
        if ($this->memory_usage === 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->memory_usage;
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
