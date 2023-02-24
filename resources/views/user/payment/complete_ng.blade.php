@extends('user.layouts.upload_layout')
@section('title','決済完了')
@section('content')
<div class="main-content">
    <div class="upload-container">
        <div class="block">
            <div class="block-content">
                <div class="text-center">
                    <img src="{{ asset('/user/images/failed.png') }}" alt="" width="300px">
                    <h4 class="mt-4">
                        後払いの審査に通りませんでした。
                    </h4>
                    <p class="mt-4">
                        クレジットカードで再度ご決済お願いします。
                    </p>
                </div>
            </div>
            <form method="post" action="/request/cancel" id="form-redirect">
                {{ csrf_field() }}
                <input id="order-id" type="text" name="order_id" value="{{@$order->id}}" hidden>
                <input id="method" type="text" name="method" value="1" hidden>
                <input id="type" type="text" name="type" value="{{@$type}}" hidden>

                <div class="upload-button">
                    <button id="redirect" data-link="{{ route('repay', ['type' => $type, 'order_id' => @$order->id]) }}" class="btn custom-btn btn-primary" style="width: 350px;">
                        クレジットカードで再決済
                        <svg width="25" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                            <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
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
        // window.location.replace(url);
    });
    $(document).on('click', '#cancel-action', function(e) {
        window.location.replace(url);
    });
</script>
@endsection
