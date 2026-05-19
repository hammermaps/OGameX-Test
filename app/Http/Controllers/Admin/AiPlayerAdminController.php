<?php

namespace OGame\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\JsonResponse;
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
            'settings' => $aiPlayerService->getGlobalSettings(),
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
            'settings' => $aiPlayerService->getGlobalSettings(),
        ]);
    }

    /**
     * Show logs for a specific AI player (or all).
     */
    public function logs(int $id, Request $request, AiPlayerService $aiPlayerService): View
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
            'settings' => $aiPlayerService->getGlobalSettings(),
        ]);
    }

    /**
     * Global activity log across all AI players, separated by account.
     */
    public function activityLog(Request $request, AiPlayerService $aiPlayerService): View
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
            'settings' => $aiPlayerService->getGlobalSettings(),
        ]);
    }

    /**
     * Show the global AI settings form.
     */
    public function settings(AiPlayerService $aiPlayerService): View
    {
        return view('ingame.admin.ai-players.settings')->with([
            'settings' => $aiPlayerService->getGlobalSettings(),
        ]);
    }

    /**
     * Persist the global AI settings.
     */
    public function updateSettings(Request $request, AiPlayerService $aiPlayerService): RedirectResponse
    {
        $validated = $request->validate([
            'daemon_enabled' => ['sometimes', 'boolean'],
            'max_concurrent_players' => ['required', 'integer', 'min:1', 'max:10000'],
            'default_action_interval_min' => ['required', 'integer', 'min:10'],
            'default_action_interval_max' => ['required', 'integer', 'min:10'],
            'default_sleep_start' => ['required', 'date_format:H:i'],
            'default_sleep_end' => ['required', 'date_format:H:i'],
            'log_retention_days' => ['required', 'integer', 'min:0', 'max:3650'],
            'autoupdate_daemon_interval_seconds' => ['required', 'integer', 'min:1', 'max:3600'],
            'autoupdate_logs_interval_seconds' => ['required', 'integer', 'min:1', 'max:3600'],
        ]);

        $validated['daemon_enabled'] = !empty($validated['daemon_enabled']);

        if ($validated['default_action_interval_min'] > $validated['default_action_interval_max']) {
            return redirect()->back()
                ->withInput()
                ->with('error', __('Action interval minimum must be less than or equal to the maximum.'));
        }

        $aiPlayerService->updateGlobalSettings($validated);

        return redirect()->route('admin.ai-players.settings')
            ->with('status', __('AI settings updated.'));
    }

    /**
     * JSON: live daemon status snapshot used by the admin auto-update UI.
     */
    public function daemonStatusJson(AiPlayerService $aiPlayerService): JsonResponse
    {
        $daemonStatus = $aiPlayerService->getDaemonStatus();
        $totalPlayers = AiPlayer::count();
        $activeCount = AiPlayer::where('is_active', true)->count();
        $actionsToday = AiPlayerLog::where('created_at', '>=', now()->startOfDay())->count();
        $failuresToday = AiPlayerLog::where('created_at', '>=', now()->startOfDay())
            ->where('status', 'failed')
            ->count();

        return response()->json([
            'now' => now()->toIso8601String(),
            'daemon' => [
                'status' => $daemonStatus->status,
                'is_running' => $daemonStatus->isRunning(),
                'pid' => $daemonStatus->pid,
                'uptime' => $daemonStatus->getUptime(),
                'memory' => $daemonStatus->getFormattedMemoryUsage(),
                'memory_usage_bytes' => (int) $daemonStatus->memory_usage,
                'last_heartbeat_at' => $daemonStatus->last_heartbeat_at?->toIso8601String(),
                'last_heartbeat_human' => $daemonStatus->last_heartbeat_at?->diffForHumans(),
                'players_processed' => (int) $daemonStatus->players_processed,
                'total_actions_executed' => (int) $daemonStatus->total_actions_executed,
                'error_log' => $daemonStatus->error_log,
            ],
            'counts' => [
                'total_players' => $totalPlayers,
                'active_players' => $activeCount,
                'actions_today' => $actionsToday,
                'failures_today' => $failuresToday,
            ],
        ]);
    }

    /**
     * JSON: incremental activity log feed. Returns log entries newer than `since`
     * (ISO 8601 timestamp). Limited to 200 rows per request to keep payloads small.
     */
    public function activityLogJson(Request $request): JsonResponse
    {
        $since = $this->parseSince($request->input('since'));
        $limit = min(200, max(1, (int) $request->input('limit', 50)));

        $query = AiPlayerLog::with(['aiPlayer.user'])
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit($limit);

        if ($since !== null) {
            $query->where('created_at', '>', $since);
        }

        return response()->json([
            'now' => now()->toIso8601String(),
            'entries' => $this->mapLogEntries($query->get()->all()),
        ]);
    }

    /**
     * JSON: incremental log feed for a specific AI player.
     */
    public function playerLogsJson(int $id, Request $request): JsonResponse
    {
        $aiPlayer = AiPlayer::with('user')->findOrFail($id);
        $since = $this->parseSince($request->input('since'));
        $limit = min(200, max(1, (int) $request->input('limit', 50)));

        $query = AiPlayerLog::where('ai_player_id', $aiPlayer->id)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit($limit);

        if ($since !== null) {
            $query->where('created_at', '>', $since);
        }

        return response()->json([
            'now' => now()->toIso8601String(),
            'ai_player_id' => $aiPlayer->id,
            'entries' => $this->mapLogEntries($query->get()->all()),
        ]);
    }

    /**
     * Parse a `since` query parameter (ISO 8601 string) into a Carbon instance, or
     * return null when the parameter is missing or malformed.
     */
    private function parseSince(mixed $raw): ?\Illuminate\Support\Carbon
    {
        if (!is_string($raw) || $raw === '') {
            return null;
        }

        try {
            return \Illuminate\Support\Carbon::parse($raw);
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Convert AiPlayerLog rows into a stable JSON shape for the admin UI.
     *
     * @param list<AiPlayerLog> $logs
     * @return list<array<string, mixed>>
     */
    private function mapLogEntries(array $logs): array
    {
        $entries = [];
        foreach ($logs as $log) {
            $entries[] = [
                'id' => $log->id,
                'ai_player_id' => $log->ai_player_id,
                'username' => $log->aiPlayer?->user?->username,
                'profile' => $log->aiPlayer?->profile,
                'action_type' => $log->action_type,
                'action_data' => $log->action_data,
                'status' => $log->status,
                'error_message' => $log->error_message,
                'created_at' => $log->created_at?->toIso8601String(),
                'created_at_human' => $log->created_at?->diffForHumans(),
            ];
        }
        return $entries;
    }
}
