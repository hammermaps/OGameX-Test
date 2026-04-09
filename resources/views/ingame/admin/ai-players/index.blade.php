@extends('ingame.layouts.main')

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#ai-players-table').DataTable({
                pageLength: 25,
                order: [[0, 'asc']],
                language: {
                    emptyTable: '{{ __('No AI players created yet.') }}'
                }
            });
        });
    </script>
@endpush

@section('content')

    @if (session('status'))
        <script>fadeBox('{{ session('status') }}', false);</script>
    @endif

    @if (session('error'))
        <script>fadeBox('{{ session('error') }}', true);</script>
    @endif

    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('AI Players Management')</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('AI Players Management')</h2>
            </div>
            <div class="content">
                <div class="buddylistContent" style="margin-bottom: 60px;">

                    {{-- ===== DAEMON STATUS WIDGET ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Daemon Status')</p>
                    <div class="group bborder" style="display: block;">
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
                            <label class="styled textBeefy">@lang('Uptime:')</label>
                            <div class="thefield">{{ $daemonStatus->getUptime() }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Memory:')</label>
                            <div class="thefield">{{ $daemonStatus->getFormattedMemoryUsage() }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Last Heartbeat:')</label>
                            <div class="thefield">{{ $daemonStatus->last_heartbeat_at?->diffForHumans() ?? '-' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Total Actions:')</label>
                            <div class="thefield">{{ number_format($daemonStatus->total_actions_executed) }}</div>
                        </div>
                        <div class="fieldwrapper" style="text-align: center; margin-top: 10px;">
                            <a href="{{ route('admin.ai-players.daemon') }}" class="btn_blue">@lang('Daemon Monitor')</a>
                        </div>
                    </div>

                    {{-- ===== STATISTICS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Statistics')</p>
                    <div class="group bborder" style="display: block;">
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Total AI Players:')</label>
                            <div class="thefield">{{ $totalCount }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Active Players:')</label>
                            <div class="thefield">{{ $activeCount }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Actions Today:')</label>
                            <div class="thefield">{{ number_format($totalActionsToday) }}</div>
                        </div>
                    </div>

                    {{-- ===== ACTION BUTTONS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Actions')</p>
                    <div class="group bborder" style="display: block; text-align: center; padding: 10px;">
                        <a href="{{ route('admin.ai-players.create') }}" class="btn_blue" style="margin: 5px;">@lang('Create AI Player')</a>
                        <a href="{{ route('admin.ai-players.activity-log') }}" class="btn_blue" style="margin: 5px;">@lang('Activity Log')</a>
                    </div>

                    {{-- ===== AI PLAYERS TABLE ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('AI Players')</p>
                    <div class="group bborder" style="display: block; padding: 10px;">
                        <table id="ai-players-table" class="table table-striped table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Profile')</th>
                                    <th>@lang('Difficulty')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Last Action')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aiPlayers as $aiPlayer)
                                    <tr>
                                        <td>{{ $aiPlayer->user?->username ?? 'N/A' }}</td>
                                        <td>{{ ucfirst($aiPlayer->profile) }}</td>
                                        <td>{{ $aiPlayer->difficulty_level }}/5</td>
                                        <td>
                                            @if ($aiPlayer->is_active)
                                                <span style="color: #00cc00;">@lang('Active')</span>
                                            @else
                                                <span style="color: #cc0000;">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>{{ $aiPlayer->last_action_at?->diffForHumans() ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('admin.ai-players.toggle', $aiPlayer->id) }}" method="post" style="display: inline;">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn_blue" style="font-size: 10px; padding: 2px 6px;">
                                                    {{ $aiPlayer->is_active ? __('Deactivate') : __('Activate') }}
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.ai-players.show', $aiPlayer->id) }}" class="btn_blue" style="font-size: 10px; padding: 2px 6px;">@lang('Edit')</a>
                                            <form action="{{ route('admin.ai-players.impersonate', $aiPlayer->id) }}" method="post" style="display: inline;">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn_blue" style="font-size: 10px; padding: 2px 6px;">@lang('Observe')</button>
                                            </form>
                                            <a href="{{ route('admin.ai-players.logs', $aiPlayer->id) }}" class="btn_blue" style="font-size: 10px; padding: 2px 6px;">@lang('Logs')</a>
                                            <form action="{{ route('admin.ai-players.destroy', $aiPlayer->id) }}" method="post" style="display: inline;" onsubmit="return confirm('@lang('Are you sure you want to delete this AI player?')');">
                                                {{ csrf_field() }}
                                                @method('DELETE')
                                                <button type="submit" class="btn_blue" style="font-size: 10px; padding: 2px 6px; background: #660000;">@lang('Delete')</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
