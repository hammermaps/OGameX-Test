@extends('ingame.layouts.main')

@section('content')

    @if (session('status'))
        <script>fadeBox('{{ session('status') }}', false);</script>
    @endif

    @if (session('error'))
        <script>fadeBox('{{ session('error') }}', true);</script>
    @endif

    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('AI Player Details'): {{ $aiPlayer->user?->username ?? 'N/A' }}</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('AI Player Details')</h2>
            </div>
            <div class="content">
                <div class="buddylistContent" style="margin-bottom: 60px;">

                    {{-- ===== PLAYER INFO ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Player Information')</p>
                    <div class="group bborder" style="display: block;">
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Username:')</label>
                            <div class="thefield">{{ $aiPlayer->user?->username ?? 'N/A' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('User ID:')</label>
                            <div class="thefield">{{ $aiPlayer->user_id }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Status:')</label>
                            <div class="thefield">
                                @if ($aiPlayer->is_active)
                                    <span style="color: #00cc00; font-weight: bold;">@lang('Active')</span>
                                @else
                                    <span style="color: #cc0000; font-weight: bold;">@lang('Inactive')</span>
                                @endif
                            </div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Created:')</label>
                            <div class="thefield">{{ $aiPlayer->created_at?->format('Y-m-d H:i:s') ?? '-' }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Total Actions:')</label>
                            <div class="thefield">{{ number_format($stats['total_actions']) }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Actions Today:')</label>
                            <div class="thefield">{{ number_format($stats['actions_today']) }}</div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Last Action:')</label>
                            <div class="thefield">{{ $aiPlayer->last_action_at?->diffForHumans() ?? 'Never' }}</div>
                        </div>
                    </div>

                    {{-- ===== ACTION BUTTONS ===== --}}
                    <div class="group bborder" style="display: block; text-align: center; padding: 10px;">
                        <form action="{{ route('admin.ai-players.toggle', $aiPlayer->id) }}" method="post" style="display: inline;">
                            {{ csrf_field() }}
                            <button type="submit" class="btn_blue">{{ $aiPlayer->is_active ? __('Deactivate') : __('Activate') }}</button>
                        </form>
                        <form action="{{ route('admin.ai-players.impersonate', $aiPlayer->id) }}" method="post" style="display: inline;">
                            {{ csrf_field() }}
                            <button type="submit" class="btn_blue">@lang('Observe / Impersonate')</button>
                        </form>
                        <a href="{{ route('admin.ai-players.logs', $aiPlayer->id) }}" class="btn_blue">@lang('View Full Logs')</a>
                    </div>

                    {{-- ===== EDIT SETTINGS ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Edit Settings')</p>
                    <form action="{{ route('admin.ai-players.update', $aiPlayer->id) }}" method="post">
                        {{ csrf_field() }}
                        @method('PUT')
                        <div class="group bborder" style="display: block;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Profile:')</label>
                                <div class="thefield">
                                    <select name="profile" class="w200">
                                        @foreach ($profiles as $profile)
                                            <option value="{{ $profile->value }}" {{ $aiPlayer->profile === $profile->value ? 'selected' : '' }}>
                                                {{ $profile->getName() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Difficulty (1-5):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="{{ $aiPlayer->difficulty_level }}" min="1" max="5" name="difficulty_level">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Action Interval Min (sec):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w80 textCenter textBeefy" value="{{ $aiPlayer->action_interval_min }}" min="10" name="action_interval_min">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Action Interval Max (sec):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w80 textCenter textBeefy" value="{{ $aiPlayer->action_interval_max }}" min="10" name="action_interval_max">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Sleep Start:')</label>
                                <div class="thefield">
                                    <input type="time" class="textInput w100 textCenter textBeefy" value="{{ $aiPlayer->sleep_start }}" name="sleep_start">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Sleep End:')</label>
                                <div class="thefield">
                                    <input type="time" class="textInput w100 textCenter textBeefy" value="{{ $aiPlayer->sleep_end }}" name="sleep_end">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Building Priority (1-10):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="{{ $aiPlayer->priority_building }}" min="1" max="10" name="priority_building">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Research Priority (1-10):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="{{ $aiPlayer->priority_research }}" min="1" max="10" name="priority_research">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Fleet Priority (1-10):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="{{ $aiPlayer->priority_fleet }}" min="1" max="10" name="priority_fleet">
                                </div>
                            </div>
                            <div class="fieldwrapper" style="text-align: center; margin-top: 10px;">
                                <input type="submit" class="btn_blue" value="@lang('Save Settings')">
                            </div>
                        </div>
                    </form>

                    {{-- ===== RECENT ACTIVITY LOG ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Recent Activity (last 50)')</p>
                    @if ($recentLogs->isEmpty())
                        <div class="group bborder" style="display: block;">
                            <p style="text-align: center; padding: 10px;">@lang('No actions logged yet.')</p>
                        </div>
                    @else
                        <table class="table569" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>@lang('Time')</th>
                                    <th>@lang('Action')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Details')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recentLogs as $log)
                                    <tr>
                                        <td>{{ $log->created_at?->format('H:i:s') ?? '-' }}</td>
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
                                        <td style="font-size: 10px;">
                                            @if ($log->error_message)
                                                {{ $log->error_message }}
                                            @elseif ($log->action_data)
                                                {{ json_encode($log->action_data) }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    {{-- ===== DELETE ===== --}}
                    <p class="box_highlight textCenter no_buddies">@lang('Danger Zone')</p>
                    <div class="group bborder" style="display: block; text-align: center; padding: 10px;">
                        <form action="{{ route('admin.ai-players.destroy', $aiPlayer->id) }}" method="post" onsubmit="return confirm('@lang('Are you sure? This will permanently delete this AI player and its user account.')');">
                            {{ csrf_field() }}
                            @method('DELETE')
                            <button type="submit" class="btn_blue" style="background: #660000;">@lang('Delete AI Player')</button>
                        </form>
                    </div>

                    <div class="group bborder" style="display: block; text-align: center; padding: 10px;">
                        <a href="{{ route('admin.ai-players.index') }}" class="btn_blue">@lang('Back to AI Players')</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
