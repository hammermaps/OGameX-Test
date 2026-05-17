@extends('ingame.layouts.main')

@section('content')

    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('AI Activity Log')</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('AI Activity Log – All Accounts')</h2>
            </div>
            <div class="content">
                <div class="buddylistContent" style="margin-bottom: 60px;">

                    {{-- ===== PER-ACCOUNT STATISTICS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Activity Summary by Account')</p>
                    @if ($accountStats->isEmpty())
                        <div class="group bborder" style="display: block;">
                            <p style="text-align: center; padding: 10px;">@lang('No AI players found.')</p>
                        </div>
                    @else
                        <table class="table569" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('Account')</th>
                                    <th>@lang('Profile')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Total Actions')</th>
                                    <th>@lang('Today')</th>
                                    <th>@lang('✓ Success')</th>
                                    <th>@lang('✗ Failed')</th>
                                    <th>@lang('⊘ Skipped')</th>
                                    <th>@lang('Last Action')</th>
                                    <th>@lang('Filter')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accountStats as $stat)
                                    <tr>
                                        <td>{{ $stat['username'] }}</td>
                                        <td>{{ ucfirst($stat['profile']) }}</td>
                                        <td>
                                            @if ($stat['is_active'])
                                                <span style="color: #00cc00;">@lang('Active')</span>
                                            @else
                                                <span style="color: #cc0000;">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td style="text-align: center;">{{ number_format($stat['total_actions']) }}</td>
                                        <td style="text-align: center;">{{ number_format($stat['actions_today']) }}</td>
                                        <td style="text-align: center; color: #00cc00;">{{ number_format($stat['success_today']) }}</td>
                                        <td style="text-align: center; color: #cc0000;">{{ number_format($stat['failed_today']) }}</td>
                                        <td style="text-align: center; color: #cccc00;">{{ number_format($stat['skipped_today']) }}</td>
                                        <td style="font-size: 11px;">{{ $stat['last_action_at']?->diffForHumans() ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.ai-players.activity-log', ['ai_player_id' => $stat['id']]) }}" class="btn_blue" style="font-size: 10px; padding: 2px 6px;">@lang('View')</a>
                                            <a href="{{ route('admin.ai-players.logs', $stat['id']) }}" class="btn_blue" style="font-size: 10px; padding: 2px 6px;">@lang('Full Log')</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    {{-- ===== FILTERS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Filters')</p>
                    <form action="{{ route('admin.ai-players.activity-log') }}" method="get">
                        <div class="group bborder" style="display: block;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Account:')</label>
                                <div class="thefield">
                                    <select name="ai_player_id" class="w200">
                                        <option value="">@lang('All Accounts')</option>
                                        @foreach ($aiPlayers as $player)
                                            <option value="{{ $player->id }}" {{ $filterAiPlayerId === $player->id ? 'selected' : '' }}>
                                                {{ $player->user?->username ?? 'N/A' }} ({{ ucfirst($player->profile) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Action Type:')</label>
                                <div class="thefield">
                                    <select name="action_type" class="w150">
                                        <option value="">@lang('All')</option>
                                        @foreach (['build', 'research', 'unit_build', 'fleet_send', 'espionage', 'attack', 'transport', 'colonize', 'sleep_skip', 'idle_skip'] as $type)
                                            <option value="{{ $type }}" {{ $filterActionType === $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Status:')</label>
                                <div class="thefield">
                                    <select name="status" class="w150">
                                        <option value="">@lang('All')</option>
                                        @foreach (['success', 'failed', 'skipped'] as $s)
                                            <option value="{{ $s }}" {{ $filterStatus === $s ? 'selected' : '' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Date From:')</label>
                                <div class="thefield">
                                    <input type="date" class="textInput w120 textCenter textBeefy" name="date_from" value="{{ $filterDateFrom }}">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Date To:')</label>
                                <div class="thefield">
                                    <input type="date" class="textInput w120 textCenter textBeefy" name="date_to" value="{{ $filterDateTo }}">
                                </div>
                            </div>
                            <div class="fieldwrapper" style="text-align: center; margin-top: 10px;">
                                <input type="submit" class="btn_blue" value="@lang('Apply Filters')">
                                <a href="{{ route('admin.ai-players.activity-log') }}" class="btn_blue">@lang('Reset')</a>
                            </div>
                        </div>
                    </form>

                    {{-- ===== LOG TABLE ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Activity Log') ({{ $logs->total() }} @lang('entries'))</p>
                    @if ($logs->isEmpty())
                        <div class="group bborder" style="display: block;">
                            <p style="text-align: center; padding: 10px;">@lang('No log entries found for the selected filters.')</p>
                        </div>
                    @else
                        <table class="table569" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('ID')</th>
                                    <th>@lang('Time')</th>
                                    <th>@lang('Account')</th>
                                    <th>@lang('Profile')</th>
                                    <th>@lang('Action')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody id="ai-activity-log-tbody">
                                @foreach ($logs as $log)
                                    <tr data-created-at="{{ $log->created_at?->toIso8601String() }}">
                                        <td>{{ $log->id }}</td>
                                        <td style="white-space: nowrap;">{{ $log->created_at?->format('Y-m-d H:i:s') ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('admin.ai-players.activity-log', ['ai_player_id' => $log->ai_player_id]) }}" style="color: #99ccff;">
                                                {{ $log->aiPlayer?->user?->username ?? '#' . $log->ai_player_id }}
                                            </a>
                                        </td>
                                        <td>{{ ucfirst($log->aiPlayer?->profile ?? '-') }}</td>
                                        <td>{{ $log->action_type }}</td>
                                        <td>
                                            @if ($log->status === 'success')
                                                <span style="color: #00cc00;">{{ $log->status }}</span>
                                            @elseif ($log->status === 'failed')
                                                <span style="color: #cc0000;">{{ $log->status }}</span>
                                            @else
                                                <span style="color: #cccc00;">{{ $log->status }}</span>
                                            @endif
                                        </td>
                                        <td style="font-size: 10px; max-width: 280px; word-wrap: break-word;">
                                            @if ($log->error_message)
                                                <span style="color: #cc0000;">{{ $log->error_message }}</span>
                                            @elseif ($log->action_data)
                                                {{ json_encode($log->action_data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div style="text-align: center; padding: 10px;">
                            @if ($logs->previousPageUrl())
                                <a href="{{ $logs->previousPageUrl() }}" class="btn_blue" style="font-size: 11px;">@lang('Previous')</a>
                            @endif
                            <span style="margin: 0 10px;">@lang('Page') {{ $logs->currentPage() }} / {{ $logs->lastPage() }}</span>
                            @if ($logs->nextPageUrl())
                                <a href="{{ $logs->nextPageUrl() }}" class="btn_blue" style="font-size: 11px;">@lang('Next')</a>
                            @endif
                        </div>
                    @endif

                    <div class="group bborder" style="display: block; text-align: center; padding: 10px;">
                        <a href="{{ route('admin.ai-players.index') }}" class="btn_blue">@lang('Back to AI Players')</a>
                        <a href="{{ route('admin.ai-players.daemon') }}" class="btn_blue">@lang('Daemon Monitor')</a>
                        <button type="button" id="toggleAutoRefresh" class="btn_blue" onclick="toggleAutoRefresh()">@lang('Auto-Refresh: ON')</button>
                        <span id="autoRefreshUpdatedAt" class="textTip" style="margin-left: 10px;">@lang('Updated:') -</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Live tail: poll new log entries via JSON and prepend them to the table. --}}
    <script>
        (function () {
            var feedUrl = @json(route('admin.ai-players.activity-log.json'));
            var intervalSeconds = @json(max(1, (int) $settings->autoupdate_logs_interval_seconds));
            var autoRefreshEnabled = true;
            var autoRefreshTimer = null;
            var lastSeen = null;

            var tbody = document.getElementById('ai-activity-log-tbody');

            // Seed lastSeen from the newest server-rendered row (table is desc).
            // Fallback to current time when there is no rendered row timestamp.
            if (tbody && tbody.firstElementChild) {
                var newestTimestamp = tbody.firstElementChild.getAttribute('data-created-at');
                lastSeen = newestTimestamp ? newestTimestamp : new Date().toISOString();
            } else {
                lastSeen = new Date().toISOString();
            }

            function escapeHtml(value) {
                if (value === null || value === undefined) return '';
                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function statusColor(status) {
                if (status === 'success') return '#00cc00';
                if (status === 'failed') return '#cc0000';
                return '#cccc00';
            }

            function renderEntry(entry) {
                var details = entry.error_message
                    ? '<span style="color: #cc0000;">' + escapeHtml(entry.error_message) + '</span>'
                    : (entry.action_data ? escapeHtml(JSON.stringify(entry.action_data)) : '-');

                var profile = entry.profile ? entry.profile.charAt(0).toUpperCase() + entry.profile.slice(1) : '-';
                var name = entry.username ? entry.username : ('#' + entry.ai_player_id);

                return '<tr data-created-at="' + escapeHtml(entry.created_at || '') + '" style="background-color: rgba(255, 255, 0, 0.08);">' +
                    '<td>' + escapeHtml(entry.id) + '</td>' +
                    '<td style="white-space: nowrap;">' + escapeHtml((entry.created_at || '').replace('T', ' ').replace(/\+.*$/, '').slice(0, 19)) + '</td>' +
                    '<td>' + escapeHtml(name) + '</td>' +
                    '<td>' + escapeHtml(profile) + '</td>' +
                    '<td>' + escapeHtml(entry.action_type) + '</td>' +
                    '<td><span style="color: ' + statusColor(entry.status) + ';">' + escapeHtml(entry.status) + '</span></td>' +
                    '<td style="font-size: 10px; max-width: 280px; word-wrap: break-word;">' + details + '</td>' +
                    '</tr>';
            }

            function refresh() {
                if (tbody === null) return;
                var url = feedUrl + (lastSeen ? ('?since=' + encodeURIComponent(lastSeen)) : '');
                fetch(url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                    .then(function (resp) { return resp.ok ? resp.json() : null; })
                    .then(function (data) {
                        if (data === null || !data.entries) return;
                        // entries are newest first; prepend in oldest-first order so newest ends up on top.
                        for (var i = data.entries.length - 1; i >= 0; i--) {
                            var entry = data.entries[i];
                            tbody.insertAdjacentHTML('afterbegin', renderEntry(entry));
                            if (entry.created_at && (lastSeen === null || entry.created_at > lastSeen)) {
                                lastSeen = entry.created_at;
                            }
                        }
                        var el = document.getElementById('autoRefreshUpdatedAt');
                        if (el) el.textContent = '@lang('Updated:') ' + new Date().toLocaleTimeString();
                    })
                    .catch(function () { /* ignore transient errors */ });
            }

            function start() {
                if (autoRefreshTimer === null) {
                    autoRefreshTimer = setInterval(refresh, intervalSeconds * 1000);
                }
            }
            function stop() {
                if (autoRefreshTimer !== null) {
                    clearInterval(autoRefreshTimer);
                    autoRefreshTimer = null;
                }
            }
            window.toggleAutoRefresh = function () {
                autoRefreshEnabled = !autoRefreshEnabled;
                var btn = document.getElementById('toggleAutoRefresh');
                if (autoRefreshEnabled) {
                    if (btn) btn.textContent = '@lang('Auto-Refresh: ON')';
                    start();
                } else {
                    if (btn) btn.textContent = '@lang('Auto-Refresh: OFF')';
                    stop();
                }
            };

            start();
        })();
    </script>

@endsection
