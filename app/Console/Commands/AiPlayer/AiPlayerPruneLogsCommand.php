<?php

namespace OGame\Console\Commands\AiPlayer;

use Illuminate\Console\Command;
use OGame\Models\AiPlayerLog;
use OGame\Services\AiPlayer\AiPlayerService;

/**
 * Prune AI player log entries older than the configured retention window.
 *
 * The retention window is configured via the global AI settings (admin UI):
 * `log_retention_days`. A value of 0 disables pruning.
 */
class AiPlayerPruneLogsCommand extends Command
{
    protected $signature = 'ogamex:ai:prune-logs
        {--days= : Override the configured retention window (in days)}';

    protected $description = 'Prune AI player log entries older than the configured retention window';

    public function handle(AiPlayerService $aiPlayerService): int
    {
        $retentionDays = $this->option('days') !== null
            ? (int) $this->option('days')
            : $aiPlayerService->getGlobalSettings()->log_retention_days;

        if ($retentionDays <= 0) {
            $this->info('Log retention is disabled (log_retention_days <= 0). Nothing to do.');
            return self::SUCCESS;
        }

        $threshold = now()->subDays($retentionDays);
        $deleted = AiPlayerLog::where('created_at', '<', $threshold)->delete();

        $this->info("Deleted {$deleted} AI player log entries older than {$retentionDays} day(s).");

        return self::SUCCESS;
    }
}
