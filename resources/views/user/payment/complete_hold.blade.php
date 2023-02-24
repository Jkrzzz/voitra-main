@extends('user.layouts.upload_layout')
@section('title','決済完了')
@section('content')
<div class="main-content">
    <div class="upload-container complete">
        <div class="block">
            <div class="block-content">
                <div class="text-center">
                    <img src="{{ asset('/user/images/holding.png') }}" alt="" width="300px">
                    <h4 class="mt-4">
                        後払い情報を審査しています。
                    </h4>
                    <p class="mt-4">
                        審査結果はご登録のメールアドレスに通知致します。
                    </p>
                    <p class="text-bold text-danger">
                        <b>審査は翌営業日の12時まで時間がかかる場合があります。</b>
                    </p>
                    <p>
                        急ぎの場合はクレジットカード払いにご変更ください。
                    </p>
                </div>
            </div>
            <form method="post" action="/request/cancel" id="form-redirect">
                {{ csrf_field() }}
                <input id="order-id" type="text" name="order_id" value="{{@$order->id}}" hidden>
                <input id="method" type="text" name="method" value="1" hidden>
                <input id="type" type="text" name="type" value="{{@$type}}" hidden>

                <div class="upload-button">
                    <a class="btn custom-btn btn-primary" style="width: 350px;" href="/audio">
                        ファイル一覧
                        <svg width="25" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                            <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
                        </svg>
                    </a>
                    <button id="redirect" data-link="{{ route('repay', ['type' => $type, 'order_id' => @$order->id]) }}" class="btn custom-btn btn-outline-info" style="width: 350px;">
                        クレジットカード払いに変更
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12" cy="12" r="11.5" stroke="#03749C" />
                            <path d="M11.8658 6.85938L16.8314 12.0022L11.8658 17.1451M5.79688 12.0022H16.8314H5.79688Z" stroke="#03749C" stroke-width="2" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('user.modal.error_modal')
@include('user.modal.modal_cancel_postpaid')
<script>
    var url = null;
    $("#redirect").click(function(e) {
        e.preventDefault();
        url = $(e.target).attr("data-link");
        $("#modal-cancel-postpaid").modal('show');
    });
    $(document).on('click', '#cancel-action', function(e) {
        window.location.replace(url);
    });
</script>
@endsection
