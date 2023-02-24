@extends('user.layouts.user_layout')
@section('title','クレジット管理')
@section('style')
<link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
@endsection
@section('content')
<div class="main-content">
    <p class="breadcrumb-common">クレジット管理</p>
    <div class="card-management">
        <div class="row information-sub-header">
            <div class="col-md-6 col-6">
                <h4 class="information-sub-title">支払方法</h4>
            </div>
        </div>
        {{ csrf_field() }}
        <input type="text" id="account_id" name="account_id" value="{{ $account_id }}" hidden>
        <input type="text" id="has_monthy_pay" name="has_monthy_pay" value="{{ $has_monthy_pay }}" hidden>
        @if(empty($cards))
            <div class="row info-row mb-0 ">
                <div class="col-md-6 col-12">
                    <p class="information-field" style="color: #212529">カードがまだ登録されていません。</p>
                </div>
                <div class="col-md-6 col-12 text-right card-setting">
                    <a class="process-btn btn-sm btn-primary" href="/card-management/new">
                        カードを追加
                        <svg width="25" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                            <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
                        </svg>
                    </a>
                </div>
            </div>
        @else
            <div class="row info-row mb-0 ">
                <div class="col-md-6 col-12">
                    <p class="information-field">クレジットカード一覧</p>
                </div>
                <div class="col-md-6 col-12 text-right card-setting">
                    <button class="process-btn btn-sm btn-primary-outline show-default" {{ count($cards) == 1 ? 'disabled' : ''}}>
                        デフォルトの設定
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.86221 1.46011e-06C9.09741 1.46011e-06 9.30781 0.146401 9.38701 0.365601L9.95181 1.9312C10.1542 1.9816 10.3278 2.032 10.475 2.0848C10.6358 2.1424 10.843 2.2296 11.099 2.3488L12.4142 1.6528C12.5216 1.59593 12.6445 1.5754 12.7645 1.59429C12.8845 1.61319 12.9951 1.67049 13.0798 1.7576L14.2366 2.9536C14.3902 3.1128 14.4334 3.3456 14.347 3.5488L13.7302 4.9944C13.8326 5.1824 13.9142 5.3432 13.9766 5.4776C14.0438 5.624 14.127 5.8256 14.2262 6.0856L15.6638 6.7016C15.8798 6.7936 16.0134 7.0096 15.999 7.2408L15.8934 8.9008C15.8862 9.00864 15.8475 9.11199 15.7821 9.19803C15.7166 9.28407 15.6274 9.34901 15.5254 9.3848L14.1638 9.8688C14.1246 10.0568 14.0838 10.2176 14.0406 10.3536C13.9709 10.5636 13.8914 10.7703 13.8022 10.9728L14.4862 12.4848C14.5345 12.591 14.5475 12.7099 14.5233 12.8241C14.4991 12.9383 14.439 13.0417 14.3518 13.1192L13.051 14.2808C12.9653 14.357 12.8584 14.4052 12.7446 14.4189C12.6308 14.4326 12.5155 14.4112 12.4142 14.3576L11.0734 13.6472C10.8636 13.7583 10.6472 13.8563 10.4254 13.9408L9.83981 14.16L9.31981 15.6C9.28127 15.7055 9.21176 15.7968 9.12039 15.862C9.02902 15.9273 8.92006 15.9634 8.80781 15.9656L7.28781 16C7.17258 16.003 7.05924 15.9703 6.9634 15.9062C6.86755 15.8422 6.79391 15.75 6.75261 15.6424L6.13981 14.0208C5.93072 13.9493 5.72371 13.872 5.51901 13.7888C5.35158 13.7163 5.18668 13.6382 5.02461 13.5544L3.50461 14.204C3.40445 14.2467 3.29404 14.2594 3.1868 14.2405C3.07956 14.2216 2.98013 14.172 2.90061 14.0976L1.77581 13.0424C1.69206 12.9642 1.63503 12.8616 1.61278 12.7492C1.59053 12.6368 1.60418 12.5202 1.65181 12.416L2.30541 10.992C2.21848 10.8233 2.13789 10.6515 2.06381 10.4768C1.97733 10.263 1.89729 10.0466 1.82381 9.828L0.391806 9.392C0.275406 9.35682 0.173881 9.28419 0.102998 9.18538C0.0321138 9.08658 -0.00416132 8.96714 -0.000194306 8.8456L0.0558057 7.3088C0.0597918 7.20853 0.091115 7.11126 0.146388 7.0275C0.201661 6.94375 0.27878 6.8767 0.369406 6.8336L1.87181 6.112C1.94141 5.8568 2.00221 5.6584 2.05581 5.5136C2.13128 5.3202 2.21509 5.13015 2.30701 4.944L1.65581 3.568C1.60639 3.46351 1.59138 3.34603 1.61294 3.23247C1.6345 3.11891 1.69153 3.01511 1.77581 2.936L2.89901 1.8752C2.97774 1.80094 3.07626 1.75101 3.18271 1.73143C3.28915 1.71184 3.39899 1.72343 3.49901 1.7648L5.01741 2.392C5.18541 2.28 5.33741 2.1896 5.47501 2.1168C5.63901 2.0296 5.85821 1.9384 6.13421 1.84L6.66221 0.367201C6.70124 0.259416 6.77259 0.166307 6.86652 0.100586C6.96045 0.0348661 7.07237 -0.000261001 7.18701 1.46011e-06H8.86221ZM8.01901 5.6152C6.68541 5.6152 5.60461 6.6832 5.60461 8.0016C5.60461 9.32 6.68541 10.3888 8.01901 10.3888C9.35181 10.3888 10.4326 9.32 10.4326 8.0016C10.4326 6.6832 9.35261 5.6152 8.01901 5.6152Z" fill="#03749C" />
                        </svg>
                    </button>
                    <a class="process-btn btn-sm btn-primary" href="/card-management/add">
                        カードを追加
                        <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 8C0.5 3.584 4.084 0 8.5 0C12.916 0 16.5 3.584 16.5 8C16.5 12.416 12.916 16 8.5 16C4.084 16 0.5 12.416 0.5 8ZM9.3 8.8H12.5V7.2H9.3V4H7.7V7.2H4.5V8.8H7.7V12H9.3V8.8Z" fill="#4F4F4F" />
                        </svg>
                    </a>
                </div>
            </div>
            @foreach ($cards as $card)
                <div class="row card-item">
                    <div class="col-md-1 col-2">
                        <img src="{{ asset('user/images/'.$card['type'].'.png') }}" />
                    </div>
                    <div class="col-md-2  col-8">
                        <span>{{ $card['card_number'] }}</span>
                        @if($card['default'])<span class="default-item">「デフォルト」</span>@endif
                    </div>

                    <div class="col-md-2 default-btn">
                        @if($card['default'])
                        <button class="custom-label">
                            デフォルト
                        </button>
                        @endif
                    </div>
                    <div class="col-md-7 text-right col-2">
                        <a href="#" class="remove-card default" data-number="{{ $card['card_number'] }}" data-type="{{ $card['type'] }}" data-value="{{ $card['card_id'] }}" data-default="{{ $card['default'] }}" style="color: #797979">削除</a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@include('user.modal.change_default_modal', ['cards' => $cards])
@include('user.modal.card_confirm_modal')
@include('user.modal.notify_modal')
@include('user.modal.success')
<script src="{{ asset('/user/js/card.js')}} "></script>
@endsection
