<?php

namespace OGame\Console\Commands\AiPlayer;

use Illuminate\Console\Command;
use OGame\Enums\AiPlayerProfile;
use OGame\Services\AiPlayer\AiPlayerService;

/**
 * Create one or more AI players.
 */
class AiPlayerCreateCommand extends Command
{
    protected $signature = 'ogamex:ai:create
        {profile : AI profile (aggressive, neutral, defensive, miner, raider, turtle)}
        {--count=1 : Number of AI players to create}
        {--difficulty=3 : Difficulty level (1-5)}
        {--activate : Activate players immediately}';

    protected $description = 'Create AI players with a specified profile';

    public function handle(AiPlayerService $aiPlayerService): int
    {
        $profile = $this->argument('profile');
        $count = (int) $this->option('count');
        $difficulty = (int) $this->option('difficulty');
        $activate = (bool) $this->option('activate');

        // Validate profile
        $validProfile = AiPlayerProfile::tryFrom($profile);
        if ($validProfile === null) {
            $validProfiles = implode(', ', array_map(fn ($p) => $p->value, AiPlayerProfile::cases()));
            $this->error("Invalid profile '{$profile}'. Valid profiles: {$validProfiles}");
            return 1;
        }

        // Validate difficulty
        if ($difficulty < 1 || $difficulty > 5) {
            $this->error('Difficulty must be between 1 and 5.');
            return 1;
        }

        $this->info("Creating {$count} AI player(s) with profile '{$profile}' (difficulty: {$difficulty})...");
        $bar = $this->output->createProgressBar($count);

        $created = 0;
        for ($i = 0; $i < $count; $i++) {
            try {
                $aiPlayer = $aiPlayerService->createAiPlayer($profile, [
                    'difficulty_level' => $difficulty,
                    'is_active' => $activate,
                ]);
                $user = $aiPlayer->user;
                $this->line(" → Created: {$user->username} (ID: {$user->id})");
                $created++;
            } catch (\Throwable $e) {
                $this->error("Failed to create AI player: " . $e->getMessage());
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully created {$created}/{$count} AI players.");

        return 0;
    }
}
