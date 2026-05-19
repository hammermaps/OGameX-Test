@extends('ingame.layouts.main')

@section('content')

    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('AI Daemon Monitor')</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('AI Daemon Monitor')</h2>
            </div>
            <div class="content">
                <div class="buddylistContent" style="margin-bottom: 60px;">

                    {{-- ===== DAEMON STATUS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Daemon Status')</p>
                    <div class="group bborder" style="display: block;" id="daemon-status">
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Status:')</label>
                            <div class="thefield" id="ai-daemon-status">
                                @if ($daemonStatus->isRunning())
                                    <span style="color: #00cc00; font-weight: bold;">● @lang('Running')</span>
                                @else
                                    <span style="color: #cc0000; font-weight: bold;">● {{ ucfirst($daemonStatus->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('PID:')</label>
                            <div class="thefield" id="ai-daemon-pid">{{ $daemonStatus->pid ?? '-' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Started At:')</label>
                            <div class="thefield">{{ $daemonStatus->started_at?->format('Y-m-d H:i:s') ?? '-' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Uptime:')</label>
                            <div class="thefield" id="ai-daemon-uptime">{{ $daemonStatus->getUptime() }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Last Heartbeat:')</label>
                            <div class="thefield" id="ai-daemon-heartbeat">{{ $daemonStatus->last_heartbeat_at?->diffForHumans() ?? '-' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Memory Usage:')</label>
                            <div class="thefield" id="ai-daemon-memory">{{ $daemonStatus->getFormattedMemoryUsage() }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Players Processed (last cycle):')</label>
                            <div class="thefield" id="ai-daemon-players-processed">{{ $daemonStatus->players_processed }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Total Actions Executed:')</label>
                            <div class="thefield" id="ai-daemon-actions">{{ number_format($daemonStatus->total_actions_executed) }}</div>
                        </div>
                    </div>

                    {{-- ===== DAEMON INSTRUCTIONS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Daemon Control')</p>
                    <div class="group bborder" style="display: block;">
                        <p style="padding: 10px; font-size: 12px;">
                            @lang('The AI daemon is managed via Artisan commands or Docker. Use the following commands:')
                        </p>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Start Daemon:')</label>
                            <div class="thefield"><code>php artisan ogamex:ai:daemon</code></div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Start (Debug):')</label>
                            <div class="thefield"><code>php artisan ogamex:ai:daemon --debug</code></div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Check Status:')</label>
                            <div class="thefield"><code>php artisan ogamex:ai:status</code></div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Create Player:')</label>
                            <div class="thefield"><code>php artisan ogamex:ai:create {profile}</code></div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('List Players:')</label>
                            <div class="thefield"><code>php artisan ogamex:ai:list</code></div>
                        </div>
                    </div>

                    {{-- ===== AI PLAYERS OVERVIEW ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('AI Players Overview')</p>
                    <div class="group bborder" style="display: block;">
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Total AI Players:')</label>
                            <div class="thefield" id="ai-daemon-total-players">{{ $totalCount }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Active Players:')</label>
                            <div class="thefield" id="ai-daemon-active-players">{{ $activeCount }}</div>
                        </div>
                    </div>

                    {{-- ===== DAEMON STATISTICS CHARTS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Daemon Statistics')</p>
                    <div class="group bborder" style="display: block; padding: 10px;">
                        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: space-around;">
                            <div style="flex: 1; min-width: 280px; max-width: 520px;">
                                <p style="text-align: center; font-weight: bold; margin-bottom: 6px; font-size: 12px;">@lang('Memory Usage (MB)')</p>
                                <canvas id="chart-memory" height="120"></canvas>
                            </div>
                            <div style="flex: 1; min-width: 280px; max-width: 520px;">
                                <p style="text-align: center; font-weight: bold; margin-bottom: 6px; font-size: 12px;">@lang('Players Processed (last cycle)')</p>
                                <canvas id="chart-players" height="120"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- ===== LAST ERROR ===== --}}
                    @if ($daemonStatus->error_log)
                        <p class="box_highlight textCenter no_buddies">@lang('Last Daemon Error')</p>
                        <div class="group bborder" style="display: block;">
                            <div style="padding: 10px; color: #cc0000; font-size: 11px; word-wrap: break-word;">
                                {{ $daemonStatus->error_log }}
                            </div>
                        </div>
                    @endif

                    {{-- ===== RECENT ERRORS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Recent Failed Actions')</p>
                    @if ($recentErrors->isEmpty())
                        <div class="group bborder" style="display: block;">
                            <p style="text-align: center; padding: 10px;">@lang('No recent errors.')</p>
                        </div>
                    @else
                        <table class="table569" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('Time')</th>
                                    <th>@lang('AI Player')</th>
                                    <th>@lang('Action')</th>
                                    <th>@lang('Error')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentErrors as $error)
                                    <tr>
                                        <td>{{ $error->created_at?->format('Y-m-d H:i:s') ?? '-' }}</td>
                                        <td>#{{ $error->ai_player_id }}</td>
                                        <td>{{ $error->action_type }}</td>
                                        <td style="font-size: 10px; color: #cc0000;">{{ $error->error_message }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div class="group bborder" style="display: block; text-align: center; padding: 10px;">
                        <a href="{{ route('admin.ai-players.index') }}" class="btn_blue">@lang('Back to AI Players')</a>
                        <a href="{{ route('admin.ai-players.activity-log') }}" class="btn_blue">@lang('Activity Log')</a>
                        <a href="{{ route('admin.ai-players.settings') }}" class="btn_blue">@lang('AI Settings')</a>
                        <button type="button" id="toggleAutoRefresh" class="btn_blue" onclick="toggleAutoRefresh()">@lang('Auto-Refresh: ON')</button>
                        <span id="autoRefreshUpdatedAt" class="textTip" style="margin-left: 10px;">@lang('Updated:') -</span>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js for daemon statistics --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.9/dist/chart.umd.min.js" integrity="sha256-3t7SgRSMFGlQe9DVRaMX6eFm8KxJSuBmRQSrPrVXkco=" crossorigin="anonymous"></script>

    {{-- Live auto-update of the daemon status via JSON. Default: ON, interval from global settings. --}}
    <script>
        (function () {
            var statusUrl = @json(route('admin.ai-players.daemon.json'));
            var intervalSeconds = @json(max(1, (int) $settings->autoupdate_daemon_interval_seconds));
            var autoRefreshEnabled = true;
            var autoRefreshTimer = null;

            // Rolling chart data (max 30 data points)
            var MAX_POINTS = 30;
            var chartLabels = [];
            var memoryData = [];
            var playersData = [];

            // Chart.js colour constants
            var COLOR_MEMORY  = 'rgba(0, 153, 255, 0.85)';
            var COLOR_MEMORY_BORDER  = 'rgba(0, 153, 255, 1)';
            var COLOR_PLAYERS = 'rgba(0, 204, 102, 0.85)';
            var COLOR_PLAYERS_BORDER = 'rgba(0, 204, 102, 1)';

            // Conversion constants
            var BYTES_TO_MB = 1024 * 1024;
            var MB_DECIMAL_FACTOR = 100; // round to 2 decimal places

            function makeChart(canvasId, labels, dataArray, borderColor, bgColor, stepped) {
                return new Chart(document.getElementById(canvasId), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: dataArray,
                            borderColor: borderColor,
                            backgroundColor: bgColor,
                            borderWidth: 2,
                            pointRadius: 3,
                            fill: true,
                            tension: 0.3,
                            stepped: stepped || false
                        }]
                    },
                    options: {
                        animation: false,
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            x: {
                                ticks: { color: '#aaa', font: { size: 10 }, maxTicksLimit: 6 },
                                grid: { color: 'rgba(255,255,255,0.05)' }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { color: '#aaa', font: { size: 10 }, maxTicksLimit: 6 },
                                grid: { color: 'rgba(255,255,255,0.08)' }
                            }
                        }
                    }
                });
            }

            var memoryChart = makeChart('chart-memory', chartLabels, memoryData, COLOR_MEMORY_BORDER, COLOR_MEMORY, false);
            var playersChart = makeChart('chart-players', chartLabels, playersData, COLOR_PLAYERS_BORDER, COLOR_PLAYERS, true);

            function pushChartPoint(label, memBytes, players) {
                chartLabels.push(label);
                memoryData.push(memBytes > 0 ? Math.round(memBytes / BYTES_TO_MB * MB_DECIMAL_FACTOR) / MB_DECIMAL_FACTOR : 0);
                playersData.push(players);
                if (chartLabels.length > MAX_POINTS) {
                    chartLabels.shift();
                    memoryData.shift();
                    playersData.shift();
                }
                memoryChart.update();
                playersChart.update();
            }

            function setText(id, value) {
                var el = document.getElementById(id);
                if (el !== null) {
                    el.textContent = value;
                }
            }

            function refresh() {
                fetch(statusUrl, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                    .then(function (resp) { return resp.ok ? resp.json() : null; })
                    .then(function (data) {
                        if (data === null) {
                            return;
                        }
                        var d = data.daemon || {};
                        setText('ai-daemon-status', d.is_running ? '@lang('Running')' : (d.status || '-'));
                        setText('ai-daemon-pid', d.pid !== null && d.pid !== undefined ? d.pid : '-');
                        setText('ai-daemon-uptime', d.uptime || '-');
                        setText('ai-daemon-memory', d.memory || '-');
                        setText('ai-daemon-heartbeat', d.last_heartbeat_human || '-');
                        setText('ai-daemon-actions', new Intl.NumberFormat().format(d.total_actions_executed || 0));
                        setText('ai-daemon-players-processed', d.players_processed != null ? d.players_processed : '-');
                        var c = data.counts || {};
                        setText('ai-daemon-total-players', c.total_players != null ? c.total_players : '-');
                        setText('ai-daemon-active-players', c.active_players != null ? c.active_players : '-');
                        var ts = new Date().toLocaleTimeString();
                        setText('autoRefreshUpdatedAt', '@lang('Updated:') ' + ts);

                        // Update charts with new data point
                        pushChartPoint(ts, d.memory_usage_bytes || 0, d.players_processed != null ? d.players_processed : 0);
                    })
                    .catch(function () { /* ignore transient network errors */ });
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
                    if (btn) { btn.textContent = '@lang('Auto-Refresh: ON')'; }
                    refresh();
                    start();
                } else {
                    if (btn) { btn.textContent = '@lang('Auto-Refresh: OFF')'; }
                    stop();
                }
            };

            // Kick off immediately on load.
            refresh();
            start();
        })();
    </script>

@endsection
