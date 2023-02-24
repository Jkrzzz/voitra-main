@extends('admin.layouts.layout')
@section('style')
    <style>
        .admin-tr {
            background: #fcf1ef !important;
        }

        .limit-text {
            width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

    </style>
@endsection
@php
$notifyClass = config('const.notifyClass');
$notifyTitle = config('const.notifyTitle');
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12">
            @if ($logged_in_admin->role == 1)
            <div class="card">
                <div class="card-header">
                    集計<span class="small-text">※直近３ヶ月の情報で集計しています。</span></div>
                <div class="card-body">
                    <div class="row" style="justify-content: center;">
                        <div class="notify-summary">
                            <div class="notify-type">
                                <div class="type">オプション解約</div>
                                <div class="count">{{ $serviceCancelCounter }}</div>
                            </div>
                            <div class="notify-icon">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="48" rx="24" fill="url(#paint0_linear_3497_12635)" />
                                    <path d="M20 23.75C19.59 23.75 19.25 23.41 19.25 23V18C19.25 15.38 21.38 13.25 24 13.25C26.62 13.25 28.75 15.38 28.75 18V18.3C28.75 18.71 28.41 19.05 28 19.05C27.59 19.05 27.25 18.71 27.25 18.3V18C27.25 16.21 25.79 14.75 24 14.75C22.21 14.75 20.75 16.21 20.75 18V23C20.75 23.41 20.41 23.75 20 23.75Z" fill="white" />
                                    <path d="M23.9997 28.25C22.6597 28.25 21.3797 27.68 20.4797 26.69C20.1997 26.38 20.2297 25.91 20.5297 25.63C20.8397 25.35 21.3097 25.38 21.5897 25.68C22.1997 26.36 23.0797 26.75 23.9997 26.75C25.7897 26.75 27.2497 25.29 27.2497 23.5V23C27.2497 22.59 27.5897 22.25 27.9997 22.25C28.4097 22.25 28.7497 22.59 28.7497 23V23.5C28.7497 26.12 26.6197 28.25 23.9997 28.25Z" fill="white" />
                                    <path d="M24.0003 31.7504C21.8703 31.7504 19.8303 30.9504 18.2703 29.5004C17.9703 29.2204 17.9503 28.7404 18.2303 28.4404C18.5203 28.1304 19.0003 28.1204 19.3003 28.4004C20.5803 29.5904 22.2503 30.2504 24.0003 30.2504C27.8003 30.2504 30.9003 27.1504 30.9003 23.3504V21.6504C30.9003 21.2404 31.2403 20.9004 31.6503 20.9004C32.0603 20.9004 32.4003 21.2404 32.4003 21.6504V23.3504C32.4003 27.9804 28.6303 31.7504 24.0003 31.7504Z" fill="white" />
                                    <path d="M16.9496 27.0804C16.6596 27.0804 16.3796 26.9104 16.2596 26.6204C15.8196 25.5804 15.5996 24.4904 15.5996 23.3504V21.6504C15.5996 21.2404 15.9396 20.9004 16.3496 20.9004C16.7596 20.9004 17.0996 21.2404 17.0996 21.6504V23.3504C17.0996 24.2804 17.2796 25.1804 17.6396 26.0304C17.7996 26.4104 17.6196 26.8504 17.2396 27.0104C17.1496 27.0604 17.0496 27.0804 16.9496 27.0804Z" fill="white" />
                                    <path d="M15.9204 31.7403C15.7304 31.7403 15.5404 31.6703 15.3904 31.5203C15.1004 31.2303 15.1004 30.7503 15.3904 30.4603L31.5404 14.3103C31.8304 14.0203 32.3104 14.0203 32.6004 14.3103C32.8904 14.6003 32.8904 15.0803 32.6004 15.3703L16.4604 31.5203C16.3104 31.6703 16.1204 31.7403 15.9204 31.7403Z" fill="white" />
                                    <path d="M23 18.75C22.59 18.75 22.25 18.41 22.25 18V15C22.25 14.59 22.59 14.25 23 14.25C23.41 14.25 23.75 14.59 23.75 15V18C23.75 18.41 23.41 18.75 23 18.75Z" fill="white" />
                                    <path d="M24 34.75C23.59 34.75 23.25 34.41 23.25 34V31C23.25 30.59 23.59 30.25 24 30.25C24.41 30.25 24.75 30.59 24.75 31V34C24.75 34.41 24.41 34.75 24 34.75Z" fill="white" />
                                    <defs>
                                        <linearGradient id="paint0_linear_3497_12635" x1="5.36031e-07" y1="27.36"
                                            x2="48.0003" y2="27.8038" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#FF8201" />
                                            <stop offset="1" stop-color="#FFAD01" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                        </div>
                        <div class="notify-summary">
                            <div class="notify-type">
                                <div class="type">退会</div>
                                <div class="count">{{ $withdrawalCounter }}</div>
                            </div>
                            <div class="notify-icon">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="48" rx="24" fill="#FF0000"/>
                                    <path d="M24 24.75C20.83 24.75 18.25 22.17 18.25 19C18.25 15.83 20.83 13.25 24 13.25C27.17 13.25 29.75 15.83 29.75 19C29.75 22.17 27.17 24.75 24 24.75ZM24 14.75C21.66 14.75 19.75 16.66 19.75 19C19.75 21.34 21.66 23.25 24 23.25C26.34 23.25 28.25 21.34 28.25 19C28.25 16.66 26.34 14.75 24 14.75Z" fill="white"/>
                                    <path d="M15.4102 34.75C15.0002 34.75 14.6602 34.41 14.6602 34C14.6602 29.73 18.8502 26.25 24.0002 26.25C25.0102 26.25 26.0002 26.38 26.9602 26.65C27.3602 26.76 27.5902 27.17 27.4802 27.57C27.3702 27.97 26.9602 28.2 26.5602 28.09C25.7402 27.86 24.8802 27.75 24.0002 27.75C19.6802 27.75 16.1602 30.55 16.1602 34C16.1602 34.41 15.8202 34.75 15.4102 34.75Z" fill="white"/>
                                    <path d="M30 34.75C28.82 34.75 27.7 34.31 26.83 33.52C26.48 33.22 26.17 32.85 25.93 32.44C25.49 31.72 25.25 30.87 25.25 30C25.25 28.75 25.73 27.58 26.59 26.69C27.49 25.76 28.7 25.25 30 25.25C31.36 25.25 32.65 25.83 33.53 26.83C34.31 27.7 34.75 28.82 34.75 30C34.75 30.38 34.7 30.76 34.6 31.12C34.5 31.57 34.31 32.04 34.05 32.45C33.22 33.87 31.66 34.75 30 34.75ZM30 26.75C29.11 26.75 28.29 27.1 27.67 27.73C27.08 28.34 26.75 29.14 26.75 30C26.75 30.59 26.91 31.17 27.22 31.67C27.38 31.95 27.59 32.2 27.83 32.41C28.43 32.96 29.2 33.26 30 33.26C31.13 33.26 32.2 32.66 32.78 31.69C32.95 31.41 33.08 31.09 33.15 30.78C33.22 30.52 33.25 30.27 33.25 30.01C33.25 29.21 32.95 28.44 32.41 27.84C31.81 27.14 30.93 26.75 30 26.75Z" fill="white"/>
                                    <path d="M31.4998 30.7305H28.5098C28.0998 30.7305 27.7598 30.3905 27.7598 29.9805C27.7598 29.5705 28.0998 29.2305 28.5098 29.2305H31.4998C31.9098 29.2305 32.2498 29.5705 32.2498 29.9805C32.2498 30.3905 31.9098 30.7305 31.4998 30.7305Z" fill="white"/>
                                </svg>
                            </div>
                        </div>
                        <div class="notify-summary">
                            <div class="notify-type">
                                <div class="type">問い合わせ</div>
                                <div class="count">{{ $contactCounter }}</div>
                            </div>
                            <div class="notify-icon">
                                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="48" rx="24" fill="#28A745"/>
                                    <path d="M24 24.75C20.83 24.75 18.25 22.17 18.25 19C18.25 15.83 20.83 13.25 24 13.25C27.17 13.25 29.75 15.83 29.75 19C29.75 22.17 27.17 24.75 24 24.75ZM24 14.75C21.66 14.75 19.75 16.66 19.75 19C19.75 21.34 21.66 23.25 24 23.25C26.34 23.25 28.25 21.34 28.25 19C28.25 16.66 26.34 14.75 24 14.75Z" fill="white"/>
                                    <path d="M15.4102 34.75C15.0002 34.75 14.6602 34.41 14.6602 34C14.6602 29.73 18.8502 26.25 24.0002 26.25C25.0102 26.25 26.0001 26.38 26.9601 26.65C27.3601 26.76 27.5902 27.17 27.4802 27.57C27.3702 27.97 26.9601 28.2 26.5602 28.09C25.7402 27.86 24.8802 27.75 24.0002 27.75C19.6802 27.75 16.1602 30.55 16.1602 34C16.1602 34.41 15.8202 34.75 15.4102 34.75Z" fill="white"/>
                                    <path d="M30 34.75C28.82 34.75 27.7 34.31 26.83 33.52C26.48 33.22 26.17 32.85 25.93 32.44C25.49 31.72 25.25 30.87 25.25 30C25.25 28.75 25.73 27.58 26.59 26.69C27.49 25.76 28.7 25.25 30 25.25C31.36 25.25 32.65 25.83 33.53 26.83C34.31 27.7 34.75 28.82 34.75 30C34.75 30.38 34.7 30.76 34.6 31.12C34.5 31.57 34.31 32.04 34.05 32.45C33.22 33.87 31.66 34.75 30 34.75ZM30 26.75C29.11 26.75 28.29 27.1 27.67 27.73C27.08 28.34 26.75 29.14 26.75 30C26.75 30.59 26.91 31.17 27.22 31.67C27.38 31.95 27.59 32.2 27.83 32.41C28.43 32.96 29.2 33.26 30 33.26C31.13 33.26 32.2 32.66 32.78 31.69C32.95 31.41 33.08 31.09 33.15 30.78C33.22 30.52 33.25 30.27 33.25 30.01C33.25 29.21 32.95 28.44 32.41 27.84C31.81 27.14 30.93 26.75 30 26.75Z" fill="white"/>
                                    <path d="M31.4998 30.7305H28.5098C28.0998 30.7305 27.7598 30.3905 27.7598 29.9805C27.7598 29.5705 28.0998 29.2305 28.5098 29.2305H31.4998C31.9098 29.2305 32.2498 29.5705 32.2498 29.9805C32.2498 30.3905 31.9098 30.7305 31.4998 30.7305Z" fill="white"/>
                                    <path d="M30 32.2595C29.59 32.2595 29.25 31.9195 29.25 31.5095V28.5195C29.25 28.1095 29.59 27.7695 30 27.7695C30.41 27.7695 30.75 28.1095 30.75 28.5195V31.5095C30.75 31.9295 30.41 32.2595 30 32.2595Z" fill="white"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            通知一覧
                            <span class="small-text">※直近３ヶ月の情報を表示しています。</span>
                        </div>
                    </div>
                </div>
                <div class="card-body list-body">
                    <div class="table-responsive">
                        <table class="table notify-table">
                            <tbody>
                                @foreach ($notifications as $notification)
                                <tr class="ntf {{ $notification['status_class'] }}" data-url="{{ $notification['reference_url'] }}" data-nid="{{ $notification['id'] }}">
                                    <td class="id">{{ $notification['reference_id'] }}</td>
                                    <td>{{ $notification['data'] }}</td>
                                    <td><div class="tag  {{ $notification['label_class'] }}">{{ $notification['label_title'] }}</div></td>
                                    <td>{{ $notification['created_at'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-right table-footer" style="padding-right: unset;">
                        @if ($logged_in_admin->role == 1)
                        <div class="form-inline" style="margin-right: unset">
                            <label>
                                <input class="form-control" name="from" id="from" type="text" readonly style="background-color: #fffddd">
                            </label>
                            <span class="ml-3">から</span>
                        </div>
                        <div class="form-inline">
                            <label>
                                <input class="form-control" name="to" id="to" type="text" readonly style="background-color: #fffddd">
                            </label>
                            <span class="ml-3">まで</span>
                        </div>
                        <button class="btn btn-common" type="button" data-toggle="modal" data-target="#confirm_download_modal">ダウンロード</button>
                        @endif
                    </div>
                    <div class="float-right">
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade info-modal" id="confirm_download_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/download-icon.png') }}">
                    <h4 class="notification-title">通知リストダウンロード</h4>
                    <p class="notification-body">フィルターした結果がダウンロードされます。よろしいでしょうか？</p>
                    <div class="text-center">
                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                            <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>キャンセル</span>
                        </button>
                        <button type="submit" id="confirm_download" class="btn-primary-info group" data-dismiss="modal">
                            <span id='text'>ダウンロード</span><i class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('tr').click(function (e) {
                var url = $(this).attr("data-url");
                let is_new = $(this).hasClass('new');

                if (is_new) {
                    let csrf_token = $('meta[name="csrf-token"]').attr('content');
                    let notice_id  = $(this).attr('data-nid');

                    $.ajax({
                        url: "/admin/notifications/ajax-mark-as-read",
                        type: "POST",
                        data: {
                            id: notice_id,
                            _token: csrf_token
                        },
                        success: function(response) {
                            window.location.href = url;
                        },
                        error: function(error) {
                        }
                    });
                }
                else {
                    window.location.href = url;
                }
            });
            $("#confirm_download").click(async function (event) {
                event.preventDefault();
                await fetch('admin/export/notifications?'+ new URLSearchParams({
                        from: $('#from').val(),
                        to: $('#to').val(),
                    }), {
                        method: 'GET',
                    })
                    .then(r => r.json().then(data => data))
                    .then(response => {
                        if (response.success) {
                            var link = document.createElement("a");
                            link.setAttribute('download', response.filename);
                            link.href = response.url;
                            document.body.appendChild(link);
                            link.click();
                            link.remove();
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    });
            })
        });
        $(function($){
            $.datepicker.regional['ja'] = {
                closeText: '閉じる',
                prevText: '&#x3c;前',
                nextText: '次&#x3e;',
                currentText: '今日',
                monthNames: ['1月','2月','3月','4月','5月','6月',
                '7月','8月','9月','10月','11月','12月'],
                monthNamesShort: ['1月','2月','3月','4月','5月','6月',
                '7月','8月','9月','10月','11月','12月'],
                dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
                dayNamesShort: ['日','月','火','水','木','金','土'],
                dayNamesMin: ['日','月','火','水','木','金','土'],
                weekHeader: '週',
                dateFormat: 'yy/mm/dd',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: true,
                yearSuffix: '年'};
            $.datepicker.setDefaults($.datepicker.regional['ja']);
        });
        $(function() {
            var selectedFromDate = new Date('<?php echo $firstNotification->created_at; ?>');
            var selectedToDate = new Date();
            $( "#from" ).datepicker({
                onSelect: function(){
                    selectedFromDate = $(this).val();
                    $( "#to" ).datepicker( "option", "minDate", selectedFromDate );
                },
                minDate: selectedFromDate,
                maxDate: selectedToDate
            }).datepicker('setDate', selectedFromDate);
            $( "#to" ).datepicker({
                onSelect: function(){
                    selectedToDate = $(this).val();
                    $( "#from" ).datepicker( "option", "maxDate", selectedToDate );
                },
                minDate: selectedFromDate,
                maxDate: selectedToDate
            }).datepicker('setDate', selectedToDate);
        });
    </script>
@endsection
