@extends('user.layouts.upload_layout')
@section('title','請求先情報')
@section('style')
<link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
@endsection
@section('content')
<div class="main-content">
    <p class="breadcrumb-common text-center"><h3>請求先情報</h3></p>
    <div class="card-management">

        <form method="post" action="{{$type == 3 ? '/service/payment' : ($type == 2 ? '/audio/brushup-confirm' : ($type == 4 ? '/upload/payment_service' : '/upload/payment')) }}" id="form-order">
            {{ csrf_field() }}
            <input type="text" id="account_id" name="account_id" value="{{ $account_id ?? '' }}" hidden>
            <input type="text" id="order_id" name="order_id" value="{{ $order_id ?? '' }}" hidden>
            <input id="method" type="text" name="method" value="2" hidden>
            <input id="address_id" type="text" name="address_id" value="" hidden>
            <input type="text" name="coupon_id" value="{{ @$coupon->id }}" hidden>
        </form>

        <div class="row">
            @foreach ($addresses as $address)
            <div class="col-md-6">
                <div class="address-item {{ $address['default'] ? 'card-active' : ''}}">
                    <div>
                        <div><b>{{ $userType[$address['type']] }}</b></div>
                        <div><b>{{ $address['full_name'] }}</b></div>
                        <div>{{ $address['tel'] }}</div>
                        <div>{{ $address['mobile'] }}</div>
                        <div>{{ $address['email'] }}</div>
                        <div>{{ '〒' . $address['zipcode'] . $address['address1'] . $address['address2'] . $address['address3'] }}</div>
                        @if ($address['type'] == 1)
                        <div>{{ $address['company_name'] }}</div>
                        <div>{{ $address['department_name'] }}</div>
                        @endif
                    </div>
                    <div class="row mt-3 mb-2 action">
                        <div class="col-md-12">
                            @if ($current_address == $address['id'])
                            <a disabled class="process-btn btn-primary btn-md disabled" style="padding: 10px 50px; text-align: center; margin-left: 0" data-value="{{ $address->id }}">
                                選択中
                            </a>
                            @else
                            <a class="process-btn btn-primary btn-md select-item" style="padding: 10px 50px; text-align: center; margin-left: 0" data-value="{{ $address->id }}">
                                選択
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="col-md-12 mt-5">
            <a class="process-btn btn-primary btn-md" href="{{ route('registerAddressPayment', ['type' => $type, 'order_id' => $order_id, 'coupon_id' => $coupon]) }}" style="width: 200px !important; padding: 10px 50px; text-align: center; margin-left: 0">
                請求先を追加
                <svg width="25" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                    <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
                </svg>
            </a>
        </div>
        <div class="col-md-12 mt-5">
            <button class="process-btn btn-primary btn-lg btn-edit select-item" data-value="{{ $current_address }}" style="width: 225px !important; margin-left: 0; color: white; border: none; background: linear-gradient(360deg, #256c83 0%, rgba(63, 140, 171, 0.62) 100%) !important;">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="white" />
                    <path d="M12.2404 6.85718L7.20039 12L12.2404 17.1429M18.4004 12H7.20039H18.4004Z" stroke="white" stroke-width="2" />
                </svg>
                戻る
            </button>
        </div>
    </div>
</div>
@include('user.modal.confirm_modal')
@include('user.modal.notify_modal')
<script src="{{ asset('/user/js/address.js')}} "></script>
@endsection
