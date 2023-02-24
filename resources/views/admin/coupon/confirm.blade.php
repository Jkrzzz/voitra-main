@extends('admin.layouts.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    新規クーポン作成確認
                </div>
                <form class="form" method="post" action="/admin/coupons">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">クーポン名*</label>
                                    <textarea class="form-control" name="name" id="name" disabled>{{$coupon->name}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">開始日*</label>
                                    <input class="form-control" name="start_at" id="start_at" type="date" value="{{$coupon->start_at}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">終了日*</label>
                                    <input class="form-control" name="end_at" id="end_at" type="date" value="{{$coupon->end_at}}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">クーポンコード*</label>
                                    <input class="form-control" name="code" id="code" type="text" value="{{$coupon->code}}" maxlength="255" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">発行枚数</label>
                                    <input class="form-control" name="quantity" id="quantity" type="text" value="{{$coupon->quantity}}" maxlength="11" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">割引金額*</label>
                                    <div class="input-money">
                                        <input class="form-control" name="discount_amount" id="discount_amount" type="text"
                                               maxlength="11" value="{{ $coupon->discount_amount  }}" disabled>
                                        <span class="disabled">円</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label coupon-check-label" for="is_limited">１アカウントにつき１回限定</label>
                                    <input class="form-check-input" name="is_limited" type="checkbox" disabled {{ $coupon->is_limited ? 'checked' : '' }} id="is_limited">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label coupon-check-label" for="is_private">プライベート</label>
                                    <input class="form-check-input" name="is_private" disabled {{ $coupon->is_private ? 'checked' : '' }} type="checkbox" id="is_private">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="javascript:history.back()" >
                            <button type="button" class="btn  btn-common-outline">戻る</button>
                        </a>
                        <button type="button" class="btn btn-common" id="submit">作成</button>
                    </div>
                    <input type="hidden" name="name_confirmed" value="{{ $coupon->name }}">
                    <input type="hidden" name="start_at_confirmed" value="{{ $coupon->start_at }}">
                    <input type="hidden" name="end_at_confirmed" value="{{ $coupon->end_at }}">
                    <input type="hidden" name="code_confirmed" value="{{ $coupon->code }}">
                    <input type="hidden" name="quantity_confirmed" value="{{ $coupon->quantity }}">
                    <input type="hidden" name="quantity_confirmed" value="{{ $coupon->quantity }}">
                    <input type="hidden" name="discount_amount_confirmed" value="{{ $coupon->discount_amount }}">
                    <input type="hidden" name="is_limited_confirmed" value="{{ $coupon->is_limited ? 1 : 0 }}">
                    <input type="hidden" name="is_private_confirmed" value="{{ $coupon->is_private ? 1 : 0 }}">
                    @include('admin.modal.confirm',[
'title' => '新規クーポン作成',
'content' => 'ユーザーのアカウントに表示されます。よろしいでしょうか？'
])
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/admin/js/coupon.js') }}"></script>
    <script>
        $(document).ready(function () {
            if($('input[name=is_private_confirmed]').val() == 1) {
                $('#confirm_modal .notification-body').html('プライベートクーポンを発行します。<br>' +
                    'ユーザーのアカウントに表示されませんが、利用できます。<br>' +
                    'よろしいでしょうか？')
                $('#confirm_modal .notification-body').addClass('text-left')
                $('#confirm_modal .notification-body').addClass('d-flex')
                $('#confirm_modal .notification-body').addClass('justify-content-center')
            }
        })
    </script>
@endsection
