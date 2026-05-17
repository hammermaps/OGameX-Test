@extends('ingame.layouts.main')

@section('content')

    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('AI Player Logs'): {{ $aiPlayer->user?->username ?? 'N/A' }}</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('AI Player Logs')</h2>
            </div>
            <div class="content">
                <div class="buddylistContent" style="margin-bottom: 60px;">

                    {{-- ===== FILTERS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Filters')</p>
                    <form action="{{ route('admin.ai-players.logs', $aiPlayer->id) }}" method="get">
                        <div class="group bborder" style="display: block;">
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
                                        @foreach (['success', 'failed', 'skipped'] as $status)
                                            <option value="{{ $status }}" {{ $filterStatus === $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="fieldwrapper" style="text-align: center; margin-top: 10px;">
                                <input type="submit" class="btn_blue" value="@lang('Apply Filters')">
                                <a href="{{ route('admin.ai-players.logs', $aiPlayer->id) }}" class="btn_blue">@lang('Reset')</a>
                            </div>
                        </div>
                    </form>

                    {{-- ===== LOG TABLE ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Action Log') ({{ $logs->total() }} @lang('entries'))</p>
                    @if ($logs->isEmpty())
                        <div class="group bborder" style="display: block;">
                            <p style="text-align: center; padding: 10px;">@lang('No log entries found.')</p>
                        </div>
                    @else
                        <table class="table569" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('ID')</th>
                                    <th>@lang('Time')</th>
                                    <th>@lang('Action')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody id="ai-player-logs-tbody">
                                @foreach ($logs as $log)
                                    <tr>
                                        <td>{{ $log->id }}</td>
                                        <td>{{ $log->created_at?->format('Y-m-d H:i:s') ?? '-' }}</td>
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
                                        <td style="font-size: 10px; max-width: 300px; word-wrap: break-word;">
                                            @if ($log->error_message)
                                                <span style="color: #cc0000;">{{ $log->error_message }}</span>
                                            @elseif ($log->action_data)
                                                {{ json_encode($log->action_data) }}
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
                        <a href="{{ route('admin.ai-players.show', $aiPlayer->id) }}" class="btn_blue">@lang('Back to Player')</a>
                        <a href="{{ route('admin.ai-players.index') }}" class="btn_blue">@lang('Back to AI Players')</a>
                        <button type="button" id="toggleAutoRefresh" class="btn_blue" onclick="toggleAutoRefresh()">@lang('Auto-Refresh: ON')</button>
                        <span id="autoRefreshUpdatedAt" class="textTip" style="margin-left: 10px;">@lang('Updated:') -</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Live tail for this AI player's log entries. --}}
    <script>
        (function () {
            var feedUrl = @json(route('admin.ai-players.logs.json', $aiPlayer->id));
            var intervalSeconds = @json(max(1, (int) $settings->autoupdate_logs_interval_seconds));
            var autoRefreshEnabled = true;
            var autoRefreshTimer = null;
            var lastSeen = new Date().toISOString();

            var tbody = document.getElementById('ai-player-logs-tbody');

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

                return '<tr style="background-color: rgba(255, 255, 0, 0.08);">' +
                    '<td>' + escapeHtml(entry.id) + '</td>' +
                    '<td>' + escapeHtml((entry.created_at || '').replace('T', ' ').replace(/\+.*$/, '').slice(0, 19)) + '</td>' +
                    '<td>' + escapeHtml(entry.action_type) + '</td>' +
                    '<td><span style="color: ' + statusColor(entry.status) + ';">' + escapeHtml(entry.status) + '</span></td>' +
                    '<td style="font-size: 10px; max-width: 300px; word-wrap: break-word;">' + details + '</td>' +
                    '</tr>';
            }

            function refresh() {
                if (tbody === null) return;
                var url = feedUrl + (lastSeen ? ('?since=' + encodeURIComponent(lastSeen)) : '');
                fetch(url, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                    .then(function (resp) { return resp.ok ? resp.json() : null; })
                    .then(function (data) {
                        if (data === null || !data.entries) return;
                        for (var i = data.entries.length - 1; i >= 0; i--) {
                            var entry = data.entries[i];
                            tbody.insertAdjacentHTML('afterbegin', renderEntry(entry));
                            if (entry.created_at && entry.created_at > lastSeen) {
                                lastSeen = entry.created_at;
                            }
                        }
                        var el = document.getElementById('autoRefreshUpdatedAt');
                        if (el) el.textContent = '@lang('Updated:') ' + new Date().toLocaleTimeString();
                    })
                    .catch(function () { /* ignore */ });
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
