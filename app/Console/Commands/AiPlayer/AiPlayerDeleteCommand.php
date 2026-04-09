<?php

namespace OGame\Console\Commands\AiPlayer;

use Illuminate\Console\Command;
use OGame\Services\AiPlayer\AiPlayerService;

/**
 * Delete an AI player.
 */
class AiPlayerDeleteCommand extends Command
{
    protected $signature = 'ogamex:ai:delete {id : AI player ID to delete}';

    protected $description = 'Delete an AI player and its associated user account';

    public function handle(AiPlayerService $aiPlayerService): int
    {
        $id = (int) $this->argument('id');

        if (!$this->confirm("Are you sure you want to delete AI player #{$id}? This cannot be undone.")) {
            $this->info('Cancelled.');
            return 0;
        }

        if ($aiPlayerService->deleteAiPlayer($id)) {
            $this->info("AI player #{$id} has been deleted.");
            return 0;
        }

        $this->error("AI player #{$id} not found.");
        return 1;
    }
}
