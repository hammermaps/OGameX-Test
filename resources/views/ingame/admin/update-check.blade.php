@extends('ingame.layouts.main')

@section('content')

    <div id="resourcesettingscomponent" class="maincontent">
        <div id="planet" class="shortHeader">
            <h2>@lang('Update Check')</h2>
        </div>

        <div id="buttonz">
            <div class="header">
                <h2>@lang('Update Check')</h2>
            </div>
            <div class="content">
                <div class="buddylistContent" style="margin-bottom: 60px;">
                    <p class="box_highlight textCenter no_buddies">@lang('Check for the latest OGameX release')</p>

                    <div id="updateCheckPanel" style="padding: 10px 20px; font-size: 12px; color: #c0c0c0;">

                        <div class="group bborder" style="display: block; padding: 10px 0;">
                            <div class="fieldwrapper">
                                <label class="styled textBeefy">@lang('Installed Version:')</label>
                                <div class="thefield">
                                    <span style="color: #fff; font-weight: bold;">{{ $currentVersion }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="group bborder" style="display: block; padding: 10px 0;">
                            <div class="fieldwrapper" style="text-align: center; margin-top: 10px;">
                                <button id="checkUpdateBtn" class="btn_blue" type="button">
                                    @lang('Check for Updates')
                                </button>
                            </div>
                        </div>

                        <div id="updateResult" style="display: none; margin-top: 16px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('checkUpdateBtn').addEventListener('click', function () {
            const btn    = this;
            const result = document.getElementById('updateResult');

            btn.disabled    = true;
            btn.textContent = '{{ __('Checking...') }}';
            result.style.display = 'none';
            result.innerHTML     = '';

            fetch('{{ route('admin.update-check.fetch') }}', {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
            })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                btn.disabled    = false;
                btn.textContent = '{{ __('Check for Updates') }}';

                if (data.error) {
                    result.innerHTML = '<p style="color:#e44;">' + data.error + '</p>';
                    result.style.display = 'block';
                    return;
                }

                let html = '<div class="group bborder" style="display:block;padding:10px 0;">';

                if (data.update_available) {
                    html += '<p style="color:#4c4;font-weight:bold;text-align:center;padding:6px 0;">'
                          + '&#x2B06; {{ __('A new version is available!') }}'
                          + '</p>';
                } else {
                    html += '<p style="color:#8bc;font-weight:bold;text-align:center;padding:6px 0;">'
                          + '&#x2714; {{ __('You are running the latest version.') }}'
                          + '</p>';
                }

                html += '<div class="fieldwrapper"><label class="styled textBeefy">{{ __('Latest Version:') }}</label>'
                      + '<div class="thefield"><span style="color:#fff;font-weight:bold;">' + data.latest_version + '</span></div></div>';

                html += '<div class="fieldwrapper"><label class="styled textBeefy">{{ __('Release Date:') }}</label>'
                      + '<div class="thefield"><span>' + data.release_date + '</span></div></div>';

                html += '<div class="fieldwrapper"><label class="styled textBeefy">{{ __('Description:') }}</label>'
                      + '<div class="thefield"><span>' + data.description + '</span></div></div>';

                if (data.update_available && data.download_url) {
                    html += '<div class="fieldwrapper" style="text-align:center;margin-top:10px;">'
                          + '<a href="' + data.download_url + '" target="_blank" rel="noopener" class="btn_blue">'
                          + '{{ __('Download Release') }}</a>';

                    if (data.changelog_url) {
                        html += '&nbsp;<a href="' + data.changelog_url + '" target="_blank" rel="noopener" class="btn_blue">'
                              + '{{ __('View Changelog') }}</a>';
                    }

                    html += '</div>';
                }

                html += '</div>';
                result.innerHTML     = html;
                result.style.display = 'block';
            })
            .catch(function (err) {
                btn.disabled    = false;
                btn.textContent = '{{ __('Check for Updates') }}';
                result.innerHTML = '<p style="color:#e44;">{{ __('Request failed.') }} ' + err + '</p>';
                result.style.display = 'block';
            });
        });
    </script>

@endsection
