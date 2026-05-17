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
            <h2>@lang('AI Global Settings')</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('AI Global Settings')</h2>
            </div>
            <div class="content">
                <div class="buddylistContent" style="margin-bottom: 60px;">

                    <form action="{{ route('admin.ai-players.settings.update') }}" method="post">
                        {{ csrf_field() }}
                        @method('PUT')

                        <p class="box_highlight textCenter no_buddies">@lang('Daemon')</p>
                        <div class="group bborder" style="display: block;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Daemon enabled:')</label>
                                <div class="thefield">
                                    <input type="hidden" name="daemon_enabled" value="0">
                                    <input type="checkbox" name="daemon_enabled" value="1" {{ $settings->daemon_enabled ? 'checked' : '' }}>
                                    <span class="textTip">@lang('Master switch. When off the daemon idles instead of processing AI players.')</span>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Max players per cycle:')</label>
                                <div class="thefield">
                                    <input type="number" name="max_concurrent_players" min="1" max="10000" value="{{ old('max_concurrent_players', $settings->max_concurrent_players) }}" required>
                                </div>
                            </div>
                        </div>

                        <p class="box_highlight textCenter no_buddies">@lang('Defaults for new AI players')</p>
                        <div class="group bborder" style="display: block;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Action interval min (s):')</label>
                                <div class="thefield">
                                    <input type="number" name="default_action_interval_min" min="10" value="{{ old('default_action_interval_min', $settings->default_action_interval_min) }}" required>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Action interval max (s):')</label>
                                <div class="thefield">
                                    <input type="number" name="default_action_interval_max" min="10" value="{{ old('default_action_interval_max', $settings->default_action_interval_max) }}" required>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Default sleep start:')</label>
                                <div class="thefield">
                                    <input type="time" name="default_sleep_start" value="{{ old('default_sleep_start', $settings->default_sleep_start) }}" required>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Default sleep end:')</label>
                                <div class="thefield">
                                    <input type="time" name="default_sleep_end" value="{{ old('default_sleep_end', $settings->default_sleep_end) }}" required>
                                </div>
                            </div>
                        </div>

                        <p class="box_highlight textCenter no_buddies">@lang('Logging &amp; Auto-Update')</p>
                        <div class="group bborder" style="display: block;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Log retention (days):')</label>
                                <div class="thefield">
                                    <input type="number" name="log_retention_days" min="0" max="3650" value="{{ old('log_retention_days', $settings->log_retention_days) }}" required>
                                    <span class="textTip">@lang('Older AI log entries are deleted by ogamex:ai:prune-logs. 0 disables pruning.')</span>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Daemon auto-update (s):')</label>
                                <div class="thefield">
                                    <input type="number" name="autoupdate_daemon_interval_seconds" min="1" max="3600" value="{{ old('autoupdate_daemon_interval_seconds', $settings->autoupdate_daemon_interval_seconds) }}" required>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Logs auto-update (s):')</label>
                                <div class="thefield">
                                    <input type="number" name="autoupdate_logs_interval_seconds" min="1" max="3600" value="{{ old('autoupdate_logs_interval_seconds', $settings->autoupdate_logs_interval_seconds) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="group bborder" style="display: block; text-align: center; padding: 10px;">
                            <button type="submit" class="btn_blue">@lang('Save Settings')</button>
                            <a href="{{ route('admin.ai-players.index') }}" class="btn_blue">@lang('Back to AI Players')</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
