<?php

namespace OGame\Console\Commands\AiPlayer;

use Illuminate\Console\Command;
use OGame\Services\AiPlayer\AiPlayerService;

/**
 * List all AI players.
 */
class AiPlayerListCommand extends Command
{
    protected $signature = 'ogamex:ai:list';

    protected $description = 'List all AI players with their status';

    public function handle(AiPlayerService $aiPlayerService): int
    {
        $aiPlayers = $aiPlayerService->getAiPlayers();

        if ($aiPlayers->isEmpty()) {
            $this->info('No AI players found.');
            return 0;
        }

        $rows = [];
        foreach ($aiPlayers as $aiPlayer) {
            $rows[] = [
                $aiPlayer->id,
                $aiPlayer->user?->username ?? 'N/A',
                $aiPlayer->user_id,
                $aiPlayer->profile,
                $aiPlayer->difficulty_level,
                $aiPlayer->is_active ? '✓ Active' : '✗ Inactive',
                $aiPlayer->last_action_at?->diffForHumans() ?? 'Never',
                $aiPlayer->next_action_at?->diffForHumans() ?? '-',
            ];
        }

        $this->table(
            ['AI ID', 'Username', 'User ID', 'Profile', 'Difficulty', 'Status', 'Last Action', 'Next Action'],
            $rows,
        );

        $activeCount = $aiPlayers->where('is_active', true)->count();
        $this->info("Total: {$aiPlayers->count()} AI players ({$activeCount} active)");

        return 0;
    }
}
