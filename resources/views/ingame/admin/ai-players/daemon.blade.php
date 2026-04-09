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
                            <div class="thefield">
                                @if ($daemonStatus->isRunning())
                                    <span style="color: #00cc00; font-weight: bold;">● @lang('Running')</span>
                                @else
                                    <span style="color: #cc0000; font-weight: bold;">● {{ ucfirst($daemonStatus->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('PID:')</label>
                            <div class="thefield">{{ $daemonStatus->pid ?? '-' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Started At:')</label>
                            <div class="thefield">{{ $daemonStatus->started_at?->format('Y-m-d H:i:s') ?? '-' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Uptime:')</label>
                            <div class="thefield">{{ $daemonStatus->getUptime() }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Last Heartbeat:')</label>
                            <div class="thefield">{{ $daemonStatus->last_heartbeat_at?->diffForHumans() ?? '-' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Memory Usage:')</label>
                            <div class="thefield">{{ $daemonStatus->getFormattedMemoryUsage() }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Players Processed (last cycle):')</label>
                            <div class="thefield">{{ $daemonStatus->players_processed }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Total Actions Executed:')</label>
                            <div class="thefield">{{ number_format($daemonStatus->total_actions_executed) }}</div>
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
                            <div class="thefield">{{ $totalCount }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Active Players:')</label>
                            <div class="thefield">{{ $activeCount }}</div>
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
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Auto-refresh every 10 seconds --}}
    <script>
        setTimeout(function() {
            location.reload();
        }, 10000);
    </script>

@endsection
