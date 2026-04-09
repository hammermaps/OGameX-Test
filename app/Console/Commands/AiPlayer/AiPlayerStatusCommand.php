<?php

namespace OGame\Console\Commands\AiPlayer;

use Illuminate\Console\Command;
use OGame\Services\AiPlayer\AiPlayerService;

/**
 * Show the status of the AI daemon.
 */
class AiPlayerStatusCommand extends Command
{
    protected $signature = 'ogamex:ai:status';

    protected $description = 'Show the status of the AI player daemon';

    public function handle(AiPlayerService $aiPlayerService): int
    {
        $daemonStatus = $aiPlayerService->getDaemonStatus();
        $aiPlayers = $aiPlayerService->getAiPlayers();

        $this->info('=== AI Player Daemon Status ===');
        $this->newLine();

        $isAlive = $daemonStatus->isRunning();
        $statusLabel = $isAlive ? '<fg=green>Running</>' : '<fg=red>' . ucfirst($daemonStatus->status) . '</>';

        $this->line("Status:           {$statusLabel}");
        $this->line("PID:              " . ($daemonStatus->pid ?? '-'));
        $this->line("Uptime:           " . $daemonStatus->getUptime());
        $this->line("Last Heartbeat:   " . ($daemonStatus->last_heartbeat_at?->diffForHumans() ?? '-'));
        $this->line("Memory Usage:     " . $daemonStatus->getFormattedMemoryUsage());
        $this->line("Players Processed:" . $daemonStatus->players_processed);
        $this->line("Total Actions:    " . $daemonStatus->total_actions_executed);

        if ($daemonStatus->error_log) {
            $this->newLine();
            $this->warn("Last Error: " . $daemonStatus->error_log);
        }

        $this->newLine();
        $this->info('=== AI Players Summary ===');
        $activeCount = $aiPlayers->where('is_active', true)->count();
        $this->line("Total AI Players: {$aiPlayers->count()}");
        $this->line("Active:           {$activeCount}");
        $this->line("Inactive:         " . ($aiPlayers->count() - $activeCount));

        return 0;
    }
}
