@extends('ingame.layouts.main')

@section('content')

    @if (session('error'))
        <script>fadeBox('{{ session('error') }}', true);</script>
    @endif

    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('Create AI Player')</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('Create AI Player')</h2>
            </div>
            <form action="{{ route('admin.ai-players.store') }}" name="form" method="post">
                {{ csrf_field() }}
                <div class="content">
                    <div class="buddylistContent">

                        {{-- ===== BASIC SETTINGS ===== --}}
                        <p class="box_highlight textCenter no_buddies">@lang('Basic Settings')</p>
                        <div class="group bborder" style="display: block;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Profile:')</label>
                                <div class="thefield">
                                    <select name="profile" class="w200">
                                        @foreach ($profiles as $profile)
                                            <option value="{{ $profile->value }}">{{ $profile->getName() }} - {{ $profile->getDescription() }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Number of Players:')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="1" min="1" max="50" name="count">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Difficulty (1-5):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="3" min="1" max="5" name="difficulty_level">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Activate immediately:')</label>
                                <div class="thefield">
                                    <input type="checkbox" name="is_active" value="1">
                                </div>
                            </div>
                        </div>

                        {{-- ===== TIMING SETTINGS ===== --}}
                        <p class="box_highlight textCenter no_buddies">@lang('Timing Settings')</p>
                        <div class="group bborder" style="display: block;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Action Interval Min (sec):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w80 textCenter textBeefy" value="60" min="10" name="action_interval_min">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Action Interval Max (sec):')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w80 textCenter textBeefy" value="300" min="10" name="action_interval_max">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Sleep Start (HH:MM):')</label>
                                <div class="thefield">
                                    <input type="time" class="textInput w100 textCenter textBeefy" value="01:00" name="sleep_start">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Sleep End (HH:MM):')</label>
                                <div class="thefield">
                                    <input type="time" class="textInput w100 textCenter textBeefy" value="07:00" name="sleep_end">
                                </div>
                            </div>
                        </div>

                        {{-- ===== PRIORITY SETTINGS ===== --}}
                        <p class="box_highlight textCenter no_buddies">@lang('Priority Weights (1-10)')</p>
                        <div class="group bborder" style="display: block;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Building Priority:')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="5" min="1" max="10" name="priority_building">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Research Priority:')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="5" min="1" max="10" name="priority_research">
                                </div>
                            </div>
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Fleet Priority:')</label>
                                <div class="thefield">
                                    <input type="number" class="textInput w50 textCenter textBeefy" value="5" min="1" max="10" name="priority_fleet">
                                </div>
                            </div>
                        </div>

                        {{-- ===== SUBMIT ===== --}}
                        <div class="group bborder" style="display: block; text-align: center; padding: 10px;">
                            <input type="submit" class="btn_blue" value="@lang('Create AI Player(s)')">
                            <a href="{{ route('admin.ai-players.index') }}" class="btn_blue" style="margin-left: 10px;">@lang('Cancel')</a>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
