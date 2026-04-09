<?php

namespace OGame\Console\Commands\AiPlayer;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use OGame\Models\AiDaemonStatus;
use OGame\Models\AiPlayer;
use OGame\Services\AiPlayer\AiPlayerActionService;
use OGame\Services\AiPlayer\AiPlayerService;

/**
 * AI Player Daemon - runs continuously and processes AI player actions.
 */
class AiPlayerDaemonCommand extends Command
{
    protected $signature = 'ogamex:ai:daemon
        {--interval=30 : Sleep interval between cycles in seconds}
        {--max-cycles=0 : Maximum cycles before auto-restart (0 = unlimited)}
        {--memory-limit=256 : Memory limit in MB before auto-restart}
        {--debug : Enable debug output}';

    protected $description = 'Run the AI player daemon that processes AI player actions';

    private bool $shouldStop = false;

    public function handle(AiPlayerActionService $actionService, AiPlayerService $aiPlayerService): int
    {
        $interval = (int) $this->option('interval');
        $maxCycles = (int) $this->option('max-cycles');
        $memoryLimit = (int) $this->option('memory-limit') * 1024 * 1024; // Convert MB to bytes
        $debug = (bool) $this->option('debug');

        $this->info('Starting AI Player Daemon...');
        $this->info("Interval: {$interval}s | Memory limit: " . ($memoryLimit / 1024 / 1024) . 'MB');

        // Register signal handlers for graceful shutdown
        if (extension_loaded('pcntl')) {
            pcntl_async_signals(true);
            pcntl_signal(SIGTERM, function () {
                $this->shouldStop = true;
                $this->info('Received SIGTERM, shutting down gracefully...');
            });
            pcntl_signal(SIGINT, function () {
                $this->shouldStop = true;
                $this->info('Received SIGINT, shutting down gracefully...');
            });
        }

        // Register daemon status
        $daemonStatus = $aiPlayerService->getDaemonStatus();
        $daemonStatus->pid = getmypid() ?: null;
        $daemonStatus->status = 'running';
        $daemonStatus->started_at = now();
        $daemonStatus->last_heartbeat_at = now();
        $daemonStatus->error_log = null;
        $daemonStatus->save();

        $cycle = 0;

        // Main daemon loop
        while (!$this->shouldStop) {
            $cycle++;

            try {
                $playersProcessed = $this->processCycle($actionService, $aiPlayerService, $daemonStatus, $debug);

                // Update heartbeat
                $daemonStatus->last_heartbeat_at = now();
                $daemonStatus->players_processed = $playersProcessed;
                $daemonStatus->memory_usage = memory_get_usage(true);
                $daemonStatus->save();

                if ($debug) {
                    $this->info("[Cycle {$cycle}] Processed {$playersProcessed} players | Memory: " . round(memory_get_usage(true) / 1024 / 1024, 2) . 'MB');
                }
            } catch (\Throwable $e) {
                $errorMessage = "[Cycle {$cycle}] Error: " . $e->getMessage();
                $this->error($errorMessage);
                Log::error('AI Daemon error: ' . $e->getMessage(), ['exception' => $e]);

                $daemonStatus->error_log = $errorMessage;
                $daemonStatus->save();
            }

            // Check memory limit
            if ($memoryLimit > 0 && memory_get_usage(true) > $memoryLimit) {
                $this->warn('Memory limit reached, restarting...');
                break;
            }

            // Check max cycles
            if ($maxCycles > 0 && $cycle >= $maxCycles) {
                $this->info("Max cycles ({$maxCycles}) reached, stopping...");
                break;
            }

            // Sleep between cycles
            for ($i = 0; $i < $interval && !$this->shouldStop; $i++) {
                sleep(1);
            }
        }

        // Mark daemon as stopped
        $daemonStatus->status = 'stopped';
        $daemonStatus->pid = null;
        $daemonStatus->save();

        $this->info('AI Player Daemon stopped.');
        return 0;
    }

    /**
     * Process a single cycle: find due AI players and execute their actions.
     */
    private function processCycle(
        AiPlayerActionService $actionService,
        AiPlayerService $aiPlayerService,
        AiDaemonStatus $daemonStatus,
        bool $debug,
    ): int {
        $duePlayers = $aiPlayerService->getActiveDuePlayers();
        $totalActions = 0;

        /** @var AiPlayer $aiPlayer */
        foreach ($duePlayers as $aiPlayer) {
            try {
                $actions = $actionService->processPlayer($aiPlayer);
                $totalActions += $actions;

                if ($debug && $actions > 0) {
                    $this->line("  → Player #{$aiPlayer->user_id} ({$aiPlayer->profile}): {$actions} actions");
                }
            } catch (\Throwable $e) {
                // Individual player errors should not stop the daemon
                $this->warn("Error processing AI player #{$aiPlayer->id}: " . $e->getMessage());
                Log::warning('AI player processing error', [
                    'ai_player_id' => $aiPlayer->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Update total actions
        $daemonStatus->total_actions_executed += $totalActions;

        return $duePlayers->count();
    }
}
