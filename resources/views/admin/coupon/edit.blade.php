@extends('admin.layouts.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    クーポン編集
                </div>
                <form method="post" action="/admin/coupons/{{$coupon->id}}">
                    @csrf
                    @method('put')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">クーポン名*</label>
                                    <textarea rows="1" class="form-control" name="name" id="name" disabled>{{$coupon->name}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">開始日*</label>
                                    <input class="form-control" name="start_at" id="start_at" type="date"
                                           value="{{$coupon->start_at}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">終了日*</label>
                                    <input class="form-control" name="end_at" id="end_at" type="date"
                                           value="{{$coupon->end_at}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">クーポンコード*</label>
                                    <input class="form-control" name="code" id="code" type="text"
                                           value="{{$coupon->code}}"
                                           maxlength="255" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">発行枚数</label>
                                    <input class="form-control" name="quantity" id="quantity" type="text"
                                           value="{{ $coupon->quantity ?: '---' }}" maxlength="11" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">割引金額*</label>
                                    <div class="input-money">
                                        <input class="form-control" name="discount_amount" id="discount_amount"
                                               type="text"
                                               maxlength="11" value="{{ $coupon->discount_amount  }}" disabled>
                                        <span class="disabled">円</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">ステータス</label>
                                    @if($coupon->status !=0)
                                        <select class="form-control" name="status" id="status">
                                            @foreach($couponStatusConst as $key => $status)
                                                @if($key > 0)
                                                    <option
                                                        value="{{$key}}" {{$key == $coupon->status ? 'selected' : ''}}>{{$status}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @else
                                        <input class="form-control" name="status" id="status" type="text"
                                               value="{{ @$couponStatusConst[$coupon->status]  }}" disabled>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">発行残枚数</label>
                                    <input class="form-control" name="remaining_quantity" id="remaining_quantity" type="text"
                                           value="{{ $coupon->remaining_quantity }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label coupon-check-label"
                                           for="is_limited">１アカウントにつき１回限定</label>
                                    <input class="form-check-input" name="is_limited" type="checkbox" disabled
                                           {{ $coupon->is_limited ? 'checked' : '' }} id="is_limited">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label coupon-check-label" for="is_private">プライベート</label>
                                    <input class="form-check-input" name="is_private" disabled
                                           {{ $coupon->is_private ? 'checked' : '' }} type="checkbox" id="is_private">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="javascript:history.back()">
                            <button type="button" class="btn  btn-common-outline">戻る</button>
                        </a>
                        @if($coupon->status != 0)
                            <button type="button" class="btn btn-common" id="submit">保存</button>
                        @endif
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
                                    <p class="notification-body text-left" style="padding: 0 15%">
                                    </p>
                                    <div class="text-center">
                                        <button type="button" class="btn-secondary-info group mr-3"
                                                data-dismiss="modal">
                                            <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>いいえ</span>
                                        </button>
                                        <button type="submit" id="confirmed" form-id="" class="btn-primary-info group">
                                            <span id='text'>はい </span><i class="far fa-arrow-alt-circle-right"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/admin/js/coupon.js') }}"></script>
    <script>
        $(document).ready(function () {
            const status = $('#status').val()
            const is_private = $('#is_private').is(':checked')

            if (status == 1) {
                $('#confirm_modal .notification-title').html('クーポン公開')
                $('#confirm_modal .notification-body').html('クーポンを公開します。<br>' +
                    '・　グローバルクーポンはユーザーのアカウントに表示されます。<br>' +
                    '・　クーポンが利用できるようになります。<br>' +
                    'よろしいでしょうか？')
            } else {
                $('#confirm_modal .notification-title').html('クーポン停止')
                $('#confirm_modal .notification-body').html('クーポンを停止します。<br>' +
                    '・　グローバルクーポンはユーザーのアカウントから非表示します。<br>' +
                    '・　クーポンが利用できなくなります。<br>' +
                    'よろしいでしょうか？')
            }
            $('#status').change(function () {
                const status = $(this).val()
                if (status == 1) {
                    $('#confirm_modal .notification-title').html('クーポン公開')
                    $('#confirm_modal .notification-body').html('クーポンを公開します。<br>' +
                        '・　グローバルクーポンはユーザーのアカウントに表示されます。<br>' +
                        '・　クーポンが利用できるようになります。<br>' +
                        'よろしいでしょうか？')
                } else {
                    $('#confirm_modal .notification-title').html('クーポン停止')
                    $('#confirm_modal .notification-body').html('クーポンを停止します。<br>' +
                        '・　グローバルクーポンはユーザーのアカウントから非表示します。<br>' +
                        '・　クーポンが利用できなくなります。<br>' +
                        'よろしいでしょうか？')
                }
            })
        })
    </script>
@endsection
