<?php

namespace OGame\Services\AiPlayer;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use OGame\Enums\AiPlayerProfile;
use OGame\Factories\PlanetServiceFactory;
use OGame\Factories\PlayerServiceFactory;
use OGame\Models\AiDaemonStatus;
use OGame\Models\AiPlayer;
use OGame\Models\AiPlayerLog;
use OGame\Models\User;
use OGame\Models\UserTech;
use OGame\Services\MessageService;
use OGame\Services\SettingsService;

/**
 * Main service for managing AI players.
 */
class AiPlayerService
{
    public function __construct(
        private PlayerServiceFactory $playerServiceFactory,
        private PlanetServiceFactory $planetServiceFactory,
        private SettingsService $settings,
        private AiPlayerNameGenerator $nameGenerator,
    ) {
    }

    /**
     * Create a new AI player.
     *
     * @param string $profile The AI profile (from AiPlayerProfile enum).
     * @param array{difficulty_level?: int, priority_building?: int, priority_research?: int, priority_fleet?: int, action_interval_min?: int, action_interval_max?: int, sleep_start?: string, sleep_end?: string, is_active?: bool} $options
     * @return AiPlayer
     * @throws Exception
     */
    public function createAiPlayer(string $profile, array $options = []): AiPlayer
    {
        $profileEnum = AiPlayerProfile::from($profile);
        $defaults = $profileEnum->getDefaultPriorities();

        // Create user account
        $username = $this->nameGenerator->generate();

        $user = User::create([
            'lang' => 'en',
            'username' => $username,
            'email' => 'ai_' . time() . '_' . rand(1000, 9999) . '@ai.ogamex.local',
            'password' => Hash::make(bin2hex(random_bytes(16))),
        ]);

        $user->is_ai_player = true;
        $user->save();

        // Create initial game data
        $this->createInitialGameDataForUser($user);

        // Create the AI player record
        $aiPlayer = AiPlayer::create([
            'user_id' => $user->id,
            'profile' => $profile,
            'is_active' => $options['is_active'] ?? false,
            'difficulty_level' => $options['difficulty_level'] ?? 3,
            'priority_building' => $options['priority_building'] ?? $defaults['building'],
            'priority_research' => $options['priority_research'] ?? $defaults['research'],
            'priority_fleet' => $options['priority_fleet'] ?? $defaults['fleet'],
            'action_interval_min' => $options['action_interval_min'] ?? 60,
            'action_interval_max' => $options['action_interval_max'] ?? 300,
            'sleep_start' => $options['sleep_start'] ?? '01:00',
            'sleep_end' => $options['sleep_end'] ?? '07:00',
        ]);

        return $aiPlayer;
    }

    /**
     * Delete an AI player and its associated user account.
     */
    public function deleteAiPlayer(int $aiPlayerId): bool
    {
        $aiPlayer = AiPlayer::find($aiPlayerId);
        if ($aiPlayer === null) {
            return false;
        }

        $user = User::find($aiPlayer->user_id);

        // Delete AI player record (logs cascade)
        $aiPlayer->delete();

        // Delete user account
        if ($user !== null) {
            $user->delete();
        }

        return true;
    }

    /**
     * Toggle AI player active state.
     */
    public function toggleAiPlayer(int $aiPlayerId, bool $active): void
    {
        $aiPlayer = AiPlayer::findOrFail($aiPlayerId);
        $aiPlayer->is_active = $active;

        if ($active && $aiPlayer->next_action_at === null) {
            $aiPlayer->next_action_at = now();
        }

        $aiPlayer->save();
    }

    /**
     * Get all AI players with their user data.
     *
     * @return Collection<int, AiPlayer>
     */
    public function getAiPlayers(): Collection
    {
        return AiPlayer::with('user')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Get active AI players that are due for action.
     *
     * @return Collection<int, AiPlayer>
     */
    public function getActiveDuePlayers(): Collection
    {
        return AiPlayer::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('next_action_at')
                    ->orWhere('next_action_at', '<=', now());
            })
            ->with('user')
            ->get();
    }

    /**
     * Get statistics for an AI player.
     *
     * @return array{total_actions: int, actions_today: int, last_action: string|null, profile: string, status: string}
     */
    public function getAiPlayerStats(int $aiPlayerId): array
    {
        $aiPlayer = AiPlayer::findOrFail($aiPlayerId);
        $totalActions = AiPlayerLog::where('ai_player_id', $aiPlayerId)->count();
        $actionsToday = AiPlayerLog::where('ai_player_id', $aiPlayerId)
            ->where('created_at', '>=', now()->startOfDay())
            ->count();

        return [
            'total_actions' => $totalActions,
            'actions_today' => $actionsToday,
            'last_action' => $aiPlayer->last_action_at?->toDateTimeString(),
            'profile' => $aiPlayer->profile,
            'status' => $aiPlayer->is_active ? 'active' : 'inactive',
        ];
    }

    /**
     * Get the daemon status record (creates one if it doesn't exist).
     */
    public function getDaemonStatus(): AiDaemonStatus
    {
        $status = AiDaemonStatus::first();

        if ($status === null) {
            $status = AiDaemonStatus::create([
                'status' => 'stopped',
                'players_processed' => 0,
                'total_actions_executed' => 0,
                'memory_usage' => 0,
            ]);
        }

        return $status;
    }

    /**
     * Create initial game data for a new AI user (tech record, planets, welcome message).
     */
    private function createInitialGameDataForUser(User $user): void
    {
        $tech = new UserTech();
        $tech->user_id = $user->id;
        $tech->save();

        $playerService = $this->playerServiceFactory->make($user->id);
        $planetNames = ['Homeworld', 'Colony'];

        for ($i = 0; $i < $this->settings->registrationPlanetAmount(); $i++) {
            $this->planetServiceFactory->createInitialPlanetForPlayer(
                $playerService,
                $planetNames[$i === 0 ? 0 : 1],
            );
        }

        $message = new MessageService($playerService);
        $message->sendWelcomeMessage();
    }
}
