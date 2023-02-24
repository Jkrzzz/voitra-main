@extends('admin.layouts.layout')
@section('style')
    <style>
        .day-off:disabled {
            background-color: #fff;
        }
        .form-control{
            -webkit-text-fill-color: #768192;
            opacity: 1;
        }
        .day-off:disabled.disabled {
            background-color: #d8dbe0;
        }
        .input-error{
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">話者分離オプション</div>
                <div class="card-body list-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                    @endif
                    <table class="table table-responsive-sm table-striped">
                        <thead>
                        <tr>
                            <th class="text-center">項目</th>
                            <th class="text-center">設定</th>
                            <th class="text-center">終了時間</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($settings as $setting)
                            @if($setting->key == 'diarization_trail')
                                <tr row-id="{{ $setting->id }}">
                                    <td class="text-center">{{ $setting->name }}</td>
                                    <td class="text-center action-td">
                                        <form class="form-setting">
                                            <input type="hidden" name="setting_id" value="{{ $setting->id }}">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       {{ $setting->value ? 'checked' : '' }} type="radio" name="value"
                                                       value="1">
                                                <label class="form-check-label" style="color: green">ON</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"
                                                       {{ !$setting->value ? 'checked' : '' }} type="radio" name="value"
                                                       value="0">
                                                <label class="form-check-label" style="color: red">OFF</label>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        {{ $setting->expired_date }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $settings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">サーバー上・管理画面上の音声ファイル保存期間設定</div>
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-md-6">
                    <p class="setting-label font-weight-bold">サーバー上・管理画面上の音声ファイル保存期間設定</p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex">
                        <input type="text" style="width: 150px" value="{{$delete_file_time->value}}"
                               class="form-control text-left" min="31" max="186"
                               id="delete_file_time" name="delete_file_time" disabled>
                        <span class="ml-2 d-flex align-items-center">日</span>
                    </div>
                    <p class="input-error"><i class="fas fa-times-circle"></i> <span></span></p>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="button" class="btn btn-common" id="change-setting-delete-file">変更</button>
            <div class="setting" style="display: none">
                <button type="button" class="btn btn-common-outline" id="cancel-setting-delete-file-time">
                    キャンセル
                </button>
                <button type="button" class="btn btn-common save" data-setting="delete_file_time" data-title="サーバー上の音声ファイル保存期間を変更してよろしいでしょうか？">保存</button>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">納期希望日制限設定</div>
        <div class="card-body">
            <form id="form-setting-user-estimate" style="display: none">
                <div class="row">
                    <div class="col-md-6">
                        <p class="setting-label">システムが受注している案件の音声の合計時間</p>
                    </div>
                    <div class="col-md-6">
                        <p class="setting-note" id="total-duration-processing"
                           data-value="{{$totalDurationProcessing}}">{{\App\Helper\Helper::formatDuration($totalDurationProcessing)}}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="setting-label font-weight-bold">終業時間</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <input type="time" style="width: 150px" value="{{$time_end_daily->value}}"
                                   class="form-control text-left"
                                   id="time_end_daily" name="time_end_daily" disabled>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="setting-label font-weight-bold">一日処理可能な音声の合計時間の設定</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <input style="width: 150px" type="text"
                                   value="{{\App\Helper\Helper::secondsToMinutes($time_processing_daily->value)}}"
                                   class="form-control text-left"
                                   id="time_processing_daily"
                                   name="time_processing_daily" disabled>
                            <span class="ml-2 d-flex align-items-center">分</span>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="setting-label font-weight-bold">アップする音声の長さ</p>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex">
                            <input style="width: 150px" type="text"
                                   value="{{\App\Helper\Helper::secondsToMinutes($audio_duration->value)}}"
                                   class="form-control text-left"
                                   id="audio_duration"
                                   name="audio_duration" data-value="{{$audio_duration->value}}"
                                   disabled>
                            <span class="ml-2 d-flex align-items-center">分</span>
                        </div>
                    </div>
                </div>

                <input style="width: 150px" type="hidden" value="{{$day_delay->value}}"
                       class="form-control text-left"
                       id="day_delay" name="day_delay">
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="setting-label font-weight-bold">案件対応不可日付を設定</p>
                    </div>
                    <div class="col-md-6">
                        <div class="list-day-off">
                            @foreach(json_decode($day_off->value, true) as $key => $day)
                                <div class="d-flex mb-2">
                                    <input style="width: 150px" type="text" value="{{$day}}"
                                           class="form-control text-left day-off disabled"
                                           name="day_off[]" disabled>
                                    <button type="button" class="btn btn-common-outline ml-2 remove-day-off"
                                            data-dayoff="{{$day}}" style="display: none">削除
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-common add-day-off" style="display: none">追加</button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p class="setting-label font-weight-bold">ユーザーの表示プレビュー</p>
                    </div>
                    <div class="col-md-6">
                        <div id="datepicker"></div>
                    </div>
                </div>
            </form>
            <div class="text-center" id="loading">
                <div class="spinner-border">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button type="button" class="btn btn-common" id="change-setting">変更</button>
            <div class="setting" style="display: none">
                <button type="button" class="btn btn-common-outline" id="cancel-setting-set-calender">
                    キャンセル
                </button>
                <button type="button" class="btn btn-common save" data-title="保存した後、ユーザー側のカレンダーが更新されます。よろしいでしょうか？">保存</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="turnOnModal" tabindex="-1" role="dialog" aria-labelledby="turnOnModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" onclick="location.reload()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="mt-4 mb-3">無料キャンペーン終了時間</h4>
                    <br>
                    <input id="expired-date" name="expired_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                           value="{{ $setting->expired_date }}" type='date' class="form-control date"/>
                    <br>
                    <p>「開始」をクリックして、話者分離無料キャンペーンが開始されます。
                        終了時間はユーザー画面に反映されますがキャンペーンを終了するには、手動でOFFにしてください。

                        よろしいでしょうか？
                    </p>
                    <div class="text-center mb-4">
                        <button type="button" class="btn btn-secondary-common submit mx-1" onclick="location.reload()">
                            キャンセル
                        </button>
                        <button type="button" class="btn btn-danger-common mx-1 setting-confirm" id="update">開始</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="turnOffModal" tabindex="-1" role="dialog" aria-labelledby="turnOffModalTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" onclick="location.reload()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="mt-4 mb-3">話者分離無料キャンペーン終了</h4>
                    <p>「はい」をクリックした後、話者分離無料キャンペーンをすぐに終了します。
                        宜しいでしょうか？
                    </p>
                    <div class="text-center mb-4">
                        <button type="button" class="btn btn-secondary-common submit mx-1" onclick="location.reload()">
                            いいえ
                        </button>
                        <button type="button" class="btn btn-danger-common mx-1 setting-confirm" id="setting-confirm">
                            はい
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade info-modal" id="confirm_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <h4 class="notification-title"></h4>
                    <p class="notification-body"></p>
                    <div class="text-center">
                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                            <i class="far fa-arrow-alt-circle-left"></i> キャンセル
                        </button>
                        <button type="button" id="confirmed" class="btn-primary-info group" data-key="">保存 <i
                                class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade info-modal" id="add_day_off_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <h4 class="notification-title">対応不可日設定</h4>
                    <div class="notification-body d-flex justify-content-center">
                        <div id="add-day-date-picker"></div>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                            <i class="far fa-arrow-alt-circle-left"></i> キャンセル
                        </button>
                        <button type="button" class="btn-primary-info group" id="add_day_off_success" data-key="day_off"
                                data-label="対応不可日設定" disabled>選択 <i
                                class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="notifyModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <button type="button" class="close" onclick="location.reload()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="mt-4 mb-3 notify-title font-weight-bold"></h4>
                    <p class="notify-body  m-4"></p>
                    <div class="text-center mb-4">
                        <button type="button" class="btn btn-danger-common mx-1"
                                onclick="location.reload()">OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade info-modal" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <p class="notification-body">入力した日付は過去の日付です。</p>
                    <div class="text-center">
                        <button type="button" class="btn-primary-info group mr-3" onclick="window.location.reload()">
                            <span id='text-prev'>OK</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('/user/js/html-duration-picker.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            $.datepicker.regional['ja'] = {
                closeText: '閉じる',
                prevText: '&#x3c;前',
                nextText: '次&#x3e;',
                currentText: '今日',
                monthNames: ['1月', '2月', '3月', '4月', '5月', '6月',
                    '7月', '8月', '9月', '10月', '11月', '12月'],
                monthNamesShort: ['1月', '2月', '3月', '4月', '5月', '6月',
                    '7月', '8月', '9月', '10月', '11月', '12月'],
                dayNames: ['日曜日', '月曜日', '火曜日', '水曜日', '木曜日', '金曜日', '土曜日'],
                dayNamesShort: ['日', '月', '火', '水', '木', '金', '土'],
                dayNamesMin: ['日', '月', '火', '水', '木', '金', '土'],
                weekHeader: '週',
                dateFormat: 'yy/mm/dd',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: true,
                yearSuffix: '年'
            };
            $.datepicker.setDefaults($.datepicker.regional['ja']);
            let setting_data = {}
            let national_days = []
            let disable_days = []
            const totalDurationProcessing = $('#total-duration-processing').attr('data-value')
            fetch('https://holidays-jp.github.io/api/v1/date.json')
                .then(response => response.json())
                .then((data) => {
                    $('#loading').hide()
                    $('#loading').prev().show()
                    national_days = Object.keys(data)
                    disable_days = [...national_days]
                    $('input[name="day_off[]"]').each(function () {
                        disable_days.push($(this).val())
                    })
                    const workEndTime = $('input[name=time_end_daily]').val()
                    const timeProcessingDaily = secondsFromMinutes($('input[name=time_processing_daily]').val())
                    const orderPlusTime = secondsFromMinutes($('input[name=audio_duration]').val())
                    const dayDelay = $('input[name=day_delay]').val()
                    setCalender(workEndTime, totalDurationProcessing, dayDelay, orderPlusTime, timeProcessingDaily, disable_days)
                });

            $('#turnOnModal').on('hidden.bs.modal', function () {
                location.reload();
            })
            $('#turnOffModal').on('hidden.bs.modal', function () {
                location.reload();
            })
            $('.form-setting').change(function () {
                setting_data.value = $(this).find('.form-check-input:checked').val();
                if (setting_data.value && setting_data.value != 0) {
                    $('#turnOnModal').modal('show');
                } else {
                    $('#turnOffModal').modal('show');
                }
            })
            let id = $(this).find('input[name=setting_id]').val()
            $('.setting-confirm').click(function () {
                setting_data._token = '{{ csrf_token() }}'
                setting_data.expired_date = $("#expired-date").val();
                const now = new Date();
                now.setHours(0, 0, 0, 0)
                const expired_date = new Date(setting_data.expired_date)
                expired_date.setHours(0, 0, 0, 0)
                if (expired_date < now && $(this).attr('id') == 'update') {
                    $('#turnOnModal').modal('hide')
                    $('#error_modal').modal('show')
                    return
                }
                $.ajax({
                    url: `/admin/settings/${id}`,
                    method: "put",
                    data: setting_data,
                    success: function (response) {
                        $('#turnOnModal').modal('hide')
                        $('#turnOffModal').modal('hide')
                        if (setting_data.value && setting_data.value != 0) {
                            $('#notifyModal .notify-title').html('無料キャンペーンが開始されました。')
                            $('#notifyModal .notify-body').html(`ユーザーに反映する終了時間は${setting_data.expired_date}です。キャンペーンを終了するには手動で行う必要があります。ご注意ください。`)
                            $('#notifyModal').modal('show')
                        } else {
                            $('#notifyModal .notify-title').html('無料キャンペーンが終了されました。')
                            $('#notifyModal .notify-body').html('')
                            $('#notifyModal').modal('show')
                        }
                    },
                    error: function (e) {
                        $('#turnOnModal').modal('hide')
                        $('#turnOffModal').modal('hide')
                        $('.list-body').prepend(`<div class="alert alert-danger" role="alert">${e.responseJSON.message}</div>`)
                        setTimeout(function () {
                            $('.alert').remove()
                            window.location.reload()
                        }, 3000);
                    },
                });
            })
            $('#change-setting').click(function () {
                $('#time_end_daily').removeAttr('disabled')
                $('#time_processing_daily').removeAttr('disabled')
                $('#audio_duration').removeAttr('disabled')
                $('.remove-day-off').show()
                $('.add-day-off').show()
                $('.day-off').removeClass('disabled')
                $(this).hide()
                $(this).next().show()
            })

            $('#change-setting-delete-file').click(function (){
                $('#delete_file_time').removeAttr('disabled')
                $(this).hide()
                $(this).next().show()
            })
            $('#confirmed').click(function () {
                let day_off = [];
                $('input[name="day_off[]"]').each(function () {
                    day_off.push($(this).val())
                })
                let data = {
                    time_end_daily: $('input[name=time_end_daily]').val(),
                    time_processing_daily: secondsFromMinutes($('input[name=time_processing_daily]').val()),
                    audio_duration: secondsFromMinutes($('input[name=audio_duration]').val()),
                    day_delay: $('input[name=day_delay]').val(),
                    day_off: JSON.stringify(day_off),
                    delete_file_time: $('input[name=delete_file_time]').val(),
                    _token: '{{ csrf_token() }}'
                }
                console.log(data)
                $.ajax({
                    url: `/admin/change-setting`,
                    method: "put",
                    data: data,
                    success: function (response) {
                        $('#notifyModal .notify-title').html('')
                        $('#notifyModal .notify-body').html(response.message)
                        $('#confirm_modal').modal('hide')
                        $('#notifyModal').modal('show')
                    },
                    error: function (e) {
                        $('#confirm_modal').modal('hide')
                        console.log(e)
                    },
                });
            })
            $('body').on('click', '.add-day-off', function () {
                $('#add-day-date-picker').datepicker({
                    minDate: 0,
                    dateFormat: "yy/mm/dd",
                    beforeShowDay: noDisableDaysOrHolidays,
                    onSelect: function () {
                        if ($(this).datepicker('getDate')) {
                            $('#add_day_off_success').removeAttr('disabled')
                        } else {
                            $('#add_day_off_success').attr('disabled', true)
                        }
                    }
                }).datepicker('setDate', null)
                $('#add_day_off_modal').modal('show')
                $('#confirm_modal').modal('hide')
            })

            function disableDays(date) {
                const string = $.datepicker.formatDate('yy-mm-dd', date);
                return [disable_days.indexOf(string) == -1]
            }

            function noDisableDaysOrHolidays(date) {
                const noWeekend = $.datepicker.noWeekends(date);
                if (noWeekend[0]) {
                    return disableDays(date);
                } else {
                    return noWeekend;
                }
            }

            $('body').on('click', '.remove-day-off', function () {
                disable_days.remove($(this).parent().find('input').val())
                $(this).parent().remove()
                const workEndTime = $('input[name=time_end_daily]').val()
                const timeProcessingDaily = secondsFromMinutes($('input[name=time_processing_daily]').val())
                const orderPlusTime = secondsFromMinutes($('input[name=audio_duration]').val())
                const dayDelay = $('input[name=day_delay]').val()
                setCalender(workEndTime, totalDurationProcessing, dayDelay, orderPlusTime, timeProcessingDaily, disable_days)
            })

            $('#add_day_off_success').click(function () {
                const add_day = formatDate($('#add-day-date-picker').datepicker('getDate'))
                disable_days.push(add_day)
                $('.list-day-off').append(`<div class="d-flex mb-2">
                                    <input style="width: 150px" type="text" value="${add_day}"
                                           class="form-control text-left day-off"
                                           name="day_off[]" disabled>
                                    <button type="submit" class="btn btn-common-outline ml-2 remove-day-off"
                                            data-dayoff="${add_day}" >削除
                                    </button>
                                </div>`)
                const workEndTime = $('input[name=time_end_daily]').val()
                const timeProcessingDaily = secondsFromMinutes($('input[name=time_processing_daily]').val())
                const orderPlusTime = secondsFromMinutes($('input[name=audio_duration]').val())
                const dayDelay = $('input[name=day_delay]').val()
                setCalender(workEndTime, totalDurationProcessing, dayDelay, orderPlusTime, timeProcessingDaily, disable_days)
                $('#add_day_off_modal').modal('hide')
                $(this).attr('disabled', true)
            })
            $('#form-setting-user-estimate').change(function () {
                const workEndTime = $('input[name=time_end_daily]').val()
                let timeProcessingDaily
                if ($('input[name=time_processing_daily]').val() < 1) {
                    timeProcessingDaily = 60;
                    $('input[name=time_processing_daily]').val(1)
                } else {
                    timeProcessingDaily = secondsFromMinutes($('input[name=time_processing_daily]').val())
                }
                let orderPlusTime
                if ($('input[name=audio_duration]').val() < 1) {
                    orderPlusTime = 60;
                    $('input[name=audio_duration]').val(1)
                } else {
                    orderPlusTime = secondsFromMinutes($('input[name=audio_duration]').val())
                }
                const dayDelay = $('input[name=day_delay]').val()
                setCalender(workEndTime, totalDurationProcessing, dayDelay, orderPlusTime, timeProcessingDaily, disable_days)
            })

            function setCalender(workEndTime, totalDurationProcessing, dayDelay, orderPlusTime, timeProcessingDaily, disableDays) {
                const todayNow = new Date()
                const todayEnd = new Date()
                todayEnd.setHours(workEndTime.split(':')[0])
                todayEnd.setMinutes(workEndTime.split(':')[1])
                todayEnd.setSeconds(0)
                let nearestDate
                if (todayNow < todayEnd) {
                    nearestDate = addDays(todayNow, parseFloat(dayDelay))
                } else {
                    nearestDate = addDays(todayNow, parseFloat(dayDelay) + 1)
                }
                const datePlus = Math.ceil((parseFloat(totalDurationProcessing) + parseFloat(orderPlusTime)) / parseFloat(timeProcessingDaily))
                nearestDate = addDays(nearestDate, datePlus)
                let workDayArray = getDates(todayNow, nearestDate)
                for (let i = 0; i < workDayArray.length; i++) {
                    const day = workDayArray[i]
                    if (day.getDay() == 6 || day.getDay() == 0 || disableDays.includes(formatDate(day))) {
                        workDayArray.push(addDays(workDayArray[workDayArray.length - 1], 1))
                        workDayArray.splice(i, 1);
                        i--
                    }
                }
                nearestDate = workDayArray[workDayArray.length - 1]
                let defaultWorkDayArray = [nearestDate, addDays(nearestDate, 1)]
                for (let i = 0; i < defaultWorkDayArray.length; i++) {
                    const day = defaultWorkDayArray[i]
                    if (day.getDay() == 6 || day.getDay() == 0 || disableDays.includes(formatDate(day))) {
                        defaultWorkDayArray.push(addDays(defaultWorkDayArray[defaultWorkDayArray.length - 1], 1))
                        defaultWorkDayArray.splice(i, 1);
                        i--
                    }
                }
                const defaultDate = defaultWorkDayArray[defaultWorkDayArray.length - 1]
                $('#datepicker').datepicker("destroy")
                $('#datepicker').datepicker({
                    dateFormat: "yy/mm/dd",
                    minDate: nearestDate,
                    beforeShowDay: noDisableDaysOrHolidays
                }).datepicker('setDate', defaultDate);
            }

            $('.save').click(function () {
                if ($(this).attr('data-setting') == 'delete_file_time' && ($('#delete_file_time').val() < 31 || $('#delete_file_time').val() > 186)) {
                    $('#delete_file_time').parent().parent().find('.input-error').show()
                    $('#delete_file_time').parent().parent().find('.input-error span').text('31から186までの間の整数を半角で入力してください。')
                    return;
                } else {
                    $('#delete_file_time').parent().parent().find('.input-error').hide()
                }
                $('#confirm_modal .notification-body').text($(this).attr('data-title'))
                $('#confirm_modal').modal('show')
            })
            $('#delete_file_time').inputFilter(function(value) {
                return /^\d*$/.test(value); });
            $('#time_processing_daily').inputFilter(function(value) {
                return /^\d*$/.test(value)&& (value === "" || parseInt(value) <= 4800000); });
            $('#audio_duration').inputFilter(function(value) {
                return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 300); });
            const workEndTimeCurrent = $('input[name=time_end_daily]').val()
            const timeProcessingDailyCurrent = $('input[name=time_processing_daily]').val()
            const orderPlusTimeCurrent = $('input[name=audio_duration]').val()
            const dayDelayCurrent = $('input[name=day_delay]').val()
            let dayOffCurrent = [];
            $('input[name="day_off[]"]').each(function () {
                dayOffCurrent.push($(this).val())
            })
            const deleteFileTimeCurrent = $('input[name=delete_file_time]').val()
            $('#cancel-setting-delete-file-time').click(function (){
                $(this).parent().hide()
                $(this).parent().prev().show()
                $('#delete_file_time').val(deleteFileTimeCurrent)
                $('#delete_file_time').attr('disabled',true)
                $(this).parent().parent().parent().find('.input-error').hide()
            })

            $('#cancel-setting-set-calender').click(function (){
                $(this).parent().hide()
                $(this).parent().prev().show()
                $('#time_end_daily').val(workEndTimeCurrent)
                $('#time_end_daily').attr('disabled',true)
                $('#time_processing_daily').val(timeProcessingDailyCurrent)
                $('#time_processing_daily').attr('disabled',true)
                $('#audio_duration').val(orderPlusTimeCurrent)
                $('#audio_duration').attr('disabled',true)
                disable_days = [...national_days]
                let html = ''
                for (let i = 0; i < dayOffCurrent.length; i++) {
                    disable_days.push(dayOffCurrent[i])
                    html += `<div class="d-flex mb-2">
                                    <input style="width: 150px" type="text" value="${dayOffCurrent[i]}" class="form-control text-left day-off disabled" name="day_off[]" disabled="">
                                    <button type="button" class="btn btn-common-outline ml-2 remove-day-off" data-dayoff="${dayOffCurrent[i]}" style="display: none">削除
                                    </button>
                                </div>`
                }
                $('.add-day-off').hide()
                $('.list-day-off').html(html)
                setCalender(workEndTimeCurrent, totalDurationProcessing, dayDelayCurrent, orderPlusTimeCurrent, timeProcessingDailyCurrent, disable_days)
            })
        });
    </script>
@endsection
