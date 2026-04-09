@extends('ingame.layouts.main')

@section('content')

    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('Changelog')</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('Changelog')</h2>
            </div>
            <div class="content">
                <div class="buddylistContent" style="margin-bottom: 60px;">
                    <p class="box_highlight textCenter no_buddies">@lang('Recent changes to OGameX')</p>

                    <div style="padding: 10px 20px; font-size: 12px; line-height: 1.7; color: #c0c0c0;">
                        @php
                            $lines = explode("\n", $changelog);
                            $inList = false;
                        @endphp

                        @foreach ($lines as $line)
                            @php $trimmed = rtrim($line); @endphp

                            @if (preg_match('/^## \[(.+)\] - (.+)$/', $trimmed, $m))
                                @if ($inList)
                                    </ul>
                                    @php $inList = false; @endphp
                                @endif
                                <h3 style="color: #f48406; margin-top: 20px; margin-bottom: 4px; font-size: 13px;">
                                    v{{ $m[1] }} &mdash; {{ $m[2] }}
                                </h3>
                                <hr style="border-color: #444; margin: 4px 0 8px;">
                            @elseif (preg_match('/^### (.+)$/', $trimmed, $m))
                                @if ($inList)
                                    </ul>
                                    @php $inList = false; @endphp
                                @endif
                                <p style="color: #9bc; font-weight: bold; margin: 10px 0 4px;">{{ $m[1] }}</p>
                            @elseif (preg_match('/^- (.+)$/', $trimmed, $m))
                                @if (! $inList)
                                    <ul style="margin: 0 0 6px 16px; padding: 0;">
                                    @php $inList = true; @endphp
                                @endif
                                <li>{{ $m[1] }}</li>
                            @elseif ($trimmed === '' && $inList)
                                </ul>
                                @php $inList = false; @endphp
                            @elseif (preg_match('/^# (.+)$/', $trimmed, $m))
                                {{-- top-level heading: skip --}}
                            @endif
                        @endforeach

                        @if ($inList)
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
