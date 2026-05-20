@extends('ingame.layouts.main')

@section('content')
    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('Universe Gate servers')</h2>
        </div>

        <div id="buttonz">
            <div class="header"><h2>@lang('Registered universes')</h2></div>
            <div class="content">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <p class="box_highlight textCenter no_buddies">@lang('Add or activate mutually registered universes for cross-universe attacks.')</p>

                <form action="{{ route('admin.universe-gates.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="group bborder" style="display: block;">
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Identifier')</label>
                            <div class="thefield"><input class="textInput w200" type="text" maxlength="64" name="universe_identifier" required></div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Name')</label>
                            <div class="thefield"><input class="textInput w200" type="text" maxlength="120" name="name" required></div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Base URL')</label>
                            <div class="thefield"><input class="textInput w200" type="url" maxlength="255" name="base_url" required></div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Shared secret')</label>
                            <div class="thefield">
                                <input class="textInput w200" type="password" maxlength="255" name="shared_secret" required autocomplete="new-password" id="shared_secret_input">
                                <button type="button" onclick="var f=document.getElementById('shared_secret_input');f.type=f.type==='password'?'text':'password';">@lang('Show')</button>
                            </div>
                        </div>
                        <div class="fieldwrapper">
                            <label class="styled textBeefy">@lang('Status')</label>
                            <div class="thefield">
                                <select name="status" class="w130">
                                    <option value="pending">pending</option>
                                    <option value="active">active</option>
                                    <option value="rejected">rejected</option>
                                    <option value="error">error</option>
                                </select>
                            </div>
                        </div>
                        <div class="fieldwrapper">
                            <button class="btn_blue" type="submit">@lang('Save')</button>
                        </div>
                    </div>
                </form>

                <table class="list">
                    <tbody>
                    <tr class="alt">
                        <th>@lang('Name')</th>
                        <th>@lang('Identifier')</th>
                        <th>@lang('Base URL')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Last seen')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                    @foreach ($servers as $server)
                        <tr>
                            <td>{{ $server->name }}</td>
                            <td>{{ $server->universe_identifier }}</td>
                            <td>{{ $server->base_url }}</td>
                            <td>
                                <form action="{{ route('admin.universe-gates.update', $server) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('put') }}
                                    <select name="status" class="w130" onchange="this.form.submit()">
                                        @foreach (['pending', 'active', 'rejected', 'error'] as $status)
                                            <option value="{{ $status }}"{{ $server->status === $status ? ' selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>{{ $server->last_seen_at?->toDateTimeString() ?? '-' }}</td>
                            <td>
                                <form action="{{ route('admin.universe-gates.destroy', $server) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button class="btn_blue" type="submit">@lang('Delete')</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
