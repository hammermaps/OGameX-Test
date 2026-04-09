<?php

namespace OGame\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $ai_player_id
 * @property string $action_type
 * @property array<string, mixed>|null $action_data
 * @property string $status
 * @property string|null $error_message
 * @property Carbon|null $created_at
 * @mixin \Eloquent
 */
class AiPlayerLog extends Model
{
    public $timestamps = false;

    protected $table = 'ai_player_logs';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'ai_player_id',
        'action_type',
        'action_data',
        'status',
        'error_message',
        'created_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'action_data' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the AI player that owns this log entry.
     */
    public function aiPlayer(): BelongsTo
    {
        return $this->belongsTo(AiPlayer::class);
    }
}
