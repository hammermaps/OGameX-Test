<?php

namespace OGame\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use OGame\Enums\AiPlayerProfile;

/**
 * @property int $id
 * @property int $user_id
 * @property string $profile
 * @property bool $is_active
 * @property int $difficulty_level
 * @property int $priority_building
 * @property int $priority_research
 * @property int $priority_fleet
 * @property Carbon|null $last_action_at
 * @property Carbon|null $next_action_at
 * @property int $action_interval_min
 * @property int $action_interval_max
 * @property string $sleep_start
 * @property string $sleep_end
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 */
class AiPlayer extends Model
{
    protected $table = 'ai_players';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'profile',
        'is_active',
        'difficulty_level',
        'priority_building',
        'priority_research',
        'priority_fleet',
        'last_action_at',
        'next_action_at',
        'action_interval_min',
        'action_interval_max',
        'sleep_start',
        'sleep_end',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'last_action_at' => 'datetime',
        'next_action_at' => 'datetime',
    ];

    /**
     * Get the user account associated with this AI player.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the action logs for this AI player.
     */
    public function logs(): HasMany
    {
        return $this->hasMany(AiPlayerLog::class);
    }

    /**
     * Get the profile as an enum.
     */
    public function getProfileEnum(): AiPlayerProfile
    {
        return AiPlayerProfile::from($this->profile);
    }

    /**
     * Check if the AI player is currently in its sleep period.
     */
    public function isSleeping(): bool
    {
        $now = now()->format('H:i:s');
        $start = $this->sleep_start;
        $end = $this->sleep_end;

        // Handle overnight sleep (e.g., 23:00 - 07:00)
        if ($start > $end) {
            return $now >= $start || $now <= $end;
        }

        return $now >= $start && $now <= $end;
    }

    /**
     * Check if the AI player is due for its next action.
     */
    public function isDueForAction(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->next_action_at === null) {
            return true;
        }

        return $this->next_action_at->isPast();
    }

    /**
     * Schedule the next action with a random delay based on the configured interval.
     */
    public function scheduleNextAction(): void
    {
        $delay = rand($this->action_interval_min, $this->action_interval_max);
        $this->next_action_at = now()->addSeconds($delay);
        $this->last_action_at = now();
        $this->save();
    }
}
