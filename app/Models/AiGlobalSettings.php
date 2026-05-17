<?php

namespace OGame\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Singleton-style global configuration for the AI player subsystem.
 *
 * @property int $id
 * @property bool $daemon_enabled
 * @property int $max_concurrent_players
 * @property int $default_action_interval_min
 * @property int $default_action_interval_max
 * @property string $default_sleep_start
 * @property string $default_sleep_end
 * @property int $log_retention_days
 * @property int $autoupdate_daemon_interval_seconds
 * @property int $autoupdate_logs_interval_seconds
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 */
class AiGlobalSettings extends Model
{
    protected $table = 'ai_global_settings';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'daemon_enabled',
        'max_concurrent_players',
        'default_action_interval_min',
        'default_action_interval_max',
        'default_sleep_start',
        'default_sleep_end',
        'log_retention_days',
        'autoupdate_daemon_interval_seconds',
        'autoupdate_logs_interval_seconds',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'daemon_enabled' => 'boolean',
        'max_concurrent_players' => 'integer',
        'default_action_interval_min' => 'integer',
        'default_action_interval_max' => 'integer',
        'log_retention_days' => 'integer',
        'autoupdate_daemon_interval_seconds' => 'integer',
        'autoupdate_logs_interval_seconds' => 'integer',
    ];

    /**
     * Get the singleton settings row, creating it with sensible defaults when missing.
     */
    public static function singleton(): self
    {
        $row = self::first();

        if ($row === null) {
            $row = self::create([
                'daemon_enabled' => true,
                'max_concurrent_players' => 50,
                'default_action_interval_min' => 60,
                'default_action_interval_max' => 300,
                'default_sleep_start' => '01:00',
                'default_sleep_end' => '07:00',
                'log_retention_days' => 30,
                'autoupdate_daemon_interval_seconds' => 5,
                'autoupdate_logs_interval_seconds' => 10,
            ]);
        }

        return $row;
    }
}
