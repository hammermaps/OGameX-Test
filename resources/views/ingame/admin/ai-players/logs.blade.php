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
                            <tbody>
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
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
