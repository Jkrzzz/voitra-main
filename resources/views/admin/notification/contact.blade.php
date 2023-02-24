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
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            お問い合わせ
                        </div>
                    </div>
                </div>
                <div id="contact" class="card-body list-body">
                    <div class="table-responsive">
                        <table class="table notify-table">
                            <thead>
                                <tr>
                                    <th>法人/個人</th>
                                    <th>名前</th>
                                    <th>メールアドレス</th>
                                    <th>電話番号</th>
                                    <th>お問い合わせの種類</th>
                                    <th>お問い合わせ内容</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts->items() as $contact)
                                    <tr id="{{$contact->id}}" class="content {{ $contact->status_class }}" data-name="{{$contact->name}}" data-email="{{$contact->email}}" data-mobile="{{$contact->phone_number}}" data-type="{{$contactTypeConst[$contact->content_type]}}" data-content="{{$contact->content}}" data-contact-type={{ $contact->type }} data-company="{{ $contact->company_name }}">
                                        <td>{{$userTypeConst[$contact->type]}}</td>
                                        <td>{{$contact->name}}</td>
                                        <td>{{$contact->email}}</td>
                                        <td>{{$contact->phone_number}}</td>
                                        <td>{{$contactTypeConst[$contact->content_type]}}</td>
                                        <td>{{$contact->short_desc}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade info-modal" id="show-detail" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <h4 class="notification-title">お問い合わせ内容</h4>
                    <div class="body" style="padding: 10px 30px">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var currentId = '<?php echo $request->id; ?>';
            $('tr.content').click(function (event) {
                var name = $(this).attr("data-name");
                var email = $(this).attr("data-email");
                var type = $(this).attr("data-type");
                var mobile = $(this).attr("data-mobile");
                var content = $(this).attr("data-content");
                var html = `<div class="text-left">`;
                let contact_type = $(this).attr("data-contact-type");
                if (1 == contact_type) {
                    let company_name = $(this).attr("data-company");
                    html += `<div><label>会社名:</label> ${company_name}</div>`;
                }
                html += `<div><label>名前:</label> ${name}</div>`;
                html += `<div><label>メールアドレス:</label> ${email}</div>`;
                html += `<div><label>電話番号:</label> ${mobile}</div>`;
                html += `<div><label>お問い合わせの種類:</label> ${type}</div>`;
                html += `<div><label>お問い合わせ内容:</label> ${content}</div>`;
                html += `</div>`;
                $('#show-detail .body').html(html);
                $('#show-detail').modal('show');

                event.preventDefault();

                let is_new = $(this).hasClass('new');
                if (is_new) {
                    let csrf_token = $('meta[name="csrf-token"]').attr('content');
                    let contact_id = $(this).attr('id');

                    $.ajax({
                        url: "/admin/notifications/ajax-mark-contact-as-read",
                        type: "POST",
                        data: {
                            id: contact_id,
                            _token: csrf_token
                        },
                        success: function(response) {
                            // console.log(response);
                            let tr_dom = event.currentTarget;
                            $(tr_dom).removeClass('new').addClass('read');

                            let counter = parseInt($('#notifications .notify-count').text()) || 0;
                            if (0 >= counter) {
                                counter = 0;
                            }
                            else if (0 < counter && counter < 101) {
                                counter = counter - 1;
                            }
                            else {
                                counter = '99+';
                            }
                            $('#notifications .notify-count').text(counter);
                            $('.sidebar-notify-number').text(counter);
                        },
                        error: function(error) {
                            // console.log(error);
                        }
                    });
                }
            });
            $('.btn-close-modal').click( function(e) {
                e.preventDefault();
                $('#show-detail').modal('hide');
            })
            setTimeout(() => {
                $('#' + currentId).click();
            }, 800);
        });
    </script>
@endsection
