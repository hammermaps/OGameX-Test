<?php

namespace OGame\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use OGame\Enums\AiPlayerProfile;
use OGame\Http\Controllers\OGameController;
use OGame\Models\AiPlayer;
use OGame\Models\AiPlayerLog;
use OGame\Models\User;
use OGame\Services\AiPlayer\AiPlayerService;
use OGame\Services\PlayerService;

class AiPlayerAdminController extends OGameController
{
    /**
     * Dashboard: show all AI players and daemon status.
     */
    public function index(PlayerService $playerService, AiPlayerService $aiPlayerService): View
    {
        $aiPlayers = $aiPlayerService->getAiPlayers();
        $daemonStatus = $aiPlayerService->getDaemonStatus();

        $activeCount = $aiPlayers->where('is_active', true)->count();
        $totalActionsToday = AiPlayerLog::where('created_at', '>=', now()->startOfDay())->count();

        return view('ingame.admin.ai-players.index')->with([
            'aiPlayers' => $aiPlayers,
            'daemonStatus' => $daemonStatus,
            'activeCount' => $activeCount,
            'totalCount' => $aiPlayers->count(),
            'totalActionsToday' => $totalActionsToday,
            'profiles' => AiPlayerProfile::cases(),
        ]);
    }

    /**
     * Show the create AI player form.
     */
    public function create(PlayerService $playerService): View
    {
        return view('ingame.admin.ai-players.create')->with([
            'profiles' => AiPlayerProfile::cases(),
        ]);
    }

    /**
     * Store a new AI player (or batch create).
     */
    public function store(Request $request, AiPlayerService $aiPlayerService): RedirectResponse
    {
        $validated = $request->validate([
            'profile' => ['required', 'string'],
            'count' => ['required', 'integer', 'min:1', 'max:50'],
            'difficulty_level' => ['required', 'integer', 'min:1', 'max:5'],
            'action_interval_min' => ['required', 'integer', 'min:10'],
            'action_interval_max' => ['required', 'integer', 'min:10'],
            'sleep_start' => ['required', 'date_format:H:i'],
            'sleep_end' => ['required', 'date_format:H:i'],
            'priority_building' => ['required', 'integer', 'min:1', 'max:10'],
            'priority_research' => ['required', 'integer', 'min:1', 'max:10'],
            'priority_fleet' => ['required', 'integer', 'min:1', 'max:10'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        // Validate profile
        $profileEnum = AiPlayerProfile::tryFrom($validated['profile']);
        if ($profileEnum === null) {
            return redirect()->back()->with('error', 'Invalid profile selected.');
        }

        $count = (int) $validated['count'];
        $created = 0;

        for ($i = 0; $i < $count; $i++) {
            try {
                $aiPlayerService->createAiPlayer($validated['profile'], [
                    'difficulty_level' => (int) $validated['difficulty_level'],
                    'action_interval_min' => (int) $validated['action_interval_min'],
                    'action_interval_max' => (int) $validated['action_interval_max'],
                    'sleep_start' => $validated['sleep_start'],
                    'sleep_end' => $validated['sleep_end'],
                    'priority_building' => (int) $validated['priority_building'],
                    'priority_research' => (int) $validated['priority_research'],
                    'priority_fleet' => (int) $validated['priority_fleet'],
                    'is_active' => !empty($validated['is_active']),
                ]);
                $created++;
            } catch (Exception $e) {
                return redirect()->route('admin.ai-players.index')
                    ->with('error', "Created {$created}/{$count} players. Error: " . $e->getMessage());
            }
        }

        return redirect()->route('admin.ai-players.index')
            ->with('status', "Successfully created {$created} AI player(s).");
    }

    /**
     * Show details and edit form for an AI player.
     */
    public function show(int $id, PlayerService $playerService, AiPlayerService $aiPlayerService): View
    {
        $aiPlayer = AiPlayer::with('user')->findOrFail($id);
        $stats = $aiPlayerService->getAiPlayerStats($id);
        $recentLogs = AiPlayerLog::where('ai_player_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('ingame.admin.ai-players.show')->with([
            'aiPlayer' => $aiPlayer,
            'stats' => $stats,
            'recentLogs' => $recentLogs,
            'profiles' => AiPlayerProfile::cases(),
        ]);
    }

    /**
     * Update an AI player's settings.
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        $aiPlayer = AiPlayer::findOrFail($id);

        $validated = $request->validate([
            'profile' => ['required', 'string'],
            'difficulty_level' => ['required', 'integer', 'min:1', 'max:5'],
            'action_interval_min' => ['required', 'integer', 'min:10'],
            'action_interval_max' => ['required', 'integer', 'min:10'],
            'sleep_start' => ['required', 'date_format:H:i'],
            'sleep_end' => ['required', 'date_format:H:i'],
            'priority_building' => ['required', 'integer', 'min:1', 'max:10'],
            'priority_research' => ['required', 'integer', 'min:1', 'max:10'],
            'priority_fleet' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        $aiPlayer->update($validated);

        return redirect()->route('admin.ai-players.show', $id)
            ->with('status', 'AI player settings updated.');
    }

    /**
     * Delete an AI player.
     */
    public function destroy(int $id, AiPlayerService $aiPlayerService): RedirectResponse
    {
        $aiPlayerService->deleteAiPlayer($id);

        return redirect()->route('admin.ai-players.index')
            ->with('status', 'AI player deleted.');
    }

    /**
     * Toggle AI player active state.
     */
    public function toggle(int $id, AiPlayerService $aiPlayerService): RedirectResponse
    {
        $aiPlayer = AiPlayer::findOrFail($id);
        $newState = !$aiPlayer->is_active;
        $aiPlayerService->toggleAiPlayer($id, $newState);

        $label = $newState ? 'activated' : 'deactivated';
        return redirect()->back()->with('status', "AI player {$label}.");
    }

    /**
     * Impersonate an AI player (login as that player).
     */
    public function impersonate(int $id, Request $request): RedirectResponse
    {
        $aiPlayer = AiPlayer::findOrFail($id);
        $targetUser = User::findOrFail($aiPlayer->user_id);
        $currentUser = $request->user();

        if ($currentUser === null) {
            return redirect()->back()->with('error', 'Not authenticated.');
        }

        if ($currentUser->id === $targetUser->id) {
            return redirect()->back()->with('error', 'You cannot impersonate yourself.');
        }

        $manager = app('impersonate');
        $manager->take($currentUser, $targetUser);

        return redirect()->route('overview.index')
            ->with('status', "Now observing AI player: {$targetUser->username}");
    }

    /**
     * Show the daemon monitoring page.
     */
    public function daemon(PlayerService $playerService, AiPlayerService $aiPlayerService): View
    {
        $daemonStatus = $aiPlayerService->getDaemonStatus();
        $aiPlayers = $aiPlayerService->getAiPlayers();
        $activeCount = $aiPlayers->where('is_active', true)->count();

        $recentErrors = AiPlayerLog::where('status', 'failed')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        return view('ingame.admin.ai-players.daemon')->with([
            'daemonStatus' => $daemonStatus,
            'activeCount' => $activeCount,
            'totalCount' => $aiPlayers->count(),
            'recentErrors' => $recentErrors,
        ]);
    }

    /**
     * Show logs for a specific AI player (or all).
     */
    public function logs(int $id, Request $request): View
    {
        $aiPlayer = AiPlayer::with('user')->findOrFail($id);
        $query = AiPlayerLog::where('ai_player_id', $id);

        // Apply filters
        if ($request->filled('action_type')) {
            $query->where('action_type', $request->input('action_type'));
        }
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(50);

        return view('ingame.admin.ai-players.logs')->with([
            'aiPlayer' => $aiPlayer,
            'logs' => $logs,
            'filterActionType' => $request->input('action_type', ''),
            'filterStatus' => $request->input('status', ''),
        ]);
    }

    /**
     * Global activity log across all AI players, separated by account.
     */
    public function activityLog(Request $request): View
    {
        $query = AiPlayerLog::with(['aiPlayer.user']);

        // Filter by specific AI player / account
        if ($request->filled('ai_player_id')) {
            $query->where('ai_player_id', (int) $request->input('ai_player_id'));
        }

        // Filter by action type
        if ($request->filled('action_type')) {
            $query->where('action_type', $request->input('action_type'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $dateFrom = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $request->input('date_from'));
            if ($dateFrom !== false) {
                $query->where('created_at', '>=', $dateFrom->startOfDay());
            }
        }
        if ($request->filled('date_to')) {
            $dateTo = \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $request->input('date_to'));
            if ($dateTo !== false) {
                $query->where('created_at', '<=', $dateTo->endOfDay());
            }
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(100)->withQueryString();

        // All AI players for the filter dropdown
        $aiPlayers = AiPlayer::with('user')->orderBy('id')->get();

        // Per-account statistics: one query for totals, one for today's breakdown
        $totalsByPlayer = AiPlayerLog::selectRaw('ai_player_id, COUNT(*) as total_actions')
            ->groupBy('ai_player_id')
            ->pluck('total_actions', 'ai_player_id');

        $todayStart = now()->startOfDay();
        $todayStatsByPlayer = AiPlayerLog::selectRaw(
            'ai_player_id,'
            . ' COUNT(*) as actions_today,'
            . ' SUM(CASE WHEN status = \'success\' THEN 1 ELSE 0 END) as success_today,'
            . ' SUM(CASE WHEN status = \'failed\' THEN 1 ELSE 0 END) as failed_today,'
            . ' SUM(CASE WHEN status = \'skipped\' THEN 1 ELSE 0 END) as skipped_today'
        )
            ->where('created_at', '>=', $todayStart)
            ->groupBy('ai_player_id')
            ->get()
            ->keyBy('ai_player_id');

        $accountStats = $aiPlayers->map(function (AiPlayer $player) use ($totalsByPlayer, $todayStatsByPlayer): array {
            $todayRow = $todayStatsByPlayer->get($player->id);

            return [
                'id' => $player->id,
                'username' => $player->user?->username ?? 'N/A',
                'profile' => $player->profile,
                'is_active' => $player->is_active,
                'total_actions' => (int) ($totalsByPlayer[$player->id] ?? 0),
                'actions_today' => (int) ($todayRow?->actions_today ?? 0),
                'success_today' => (int) ($todayRow?->success_today ?? 0),
                'failed_today' => (int) ($todayRow?->failed_today ?? 0),
                'skipped_today' => (int) ($todayRow?->skipped_today ?? 0),
                'last_action_at' => $player->last_action_at,
            ];
        });

        return view('ingame.admin.ai-players.activity-log')->with([
            'logs' => $logs,
            'aiPlayers' => $aiPlayers,
            'accountStats' => $accountStats,
            'filterAiPlayerId' => (int) $request->input('ai_player_id', 0),
            'filterActionType' => $request->input('action_type', ''),
            'filterStatus' => $request->input('status', ''),
            'filterDateFrom' => $request->input('date_from', ''),
            'filterDateTo' => $request->input('date_to', ''),
        ]);
    }
}
