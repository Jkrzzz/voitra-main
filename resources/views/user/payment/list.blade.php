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
        @if(empty($cards))
        <div class="row info-row mb-0 ">
            <div class="col-md-6 col-12">
                <p class="information-field">カードがまだ登録されていません。</p>
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
                <button class="process-btn btn-sm btn-default show-default" {{ count($cards) == 1 ? 'disabled' : ''}}>
                    デフォルトの設定
                    <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.36221 1.46011e-06C9.59741 1.46011e-06 9.80781 0.146401 9.88701 0.365601L10.4518 1.9312C10.6542 1.9816 10.8278 2.032 10.975 2.0848C11.1358 2.1424 11.343 2.2296 11.599 2.3488L12.9142 1.6528C13.0216 1.59593 13.1445 1.5754 13.2645 1.59429C13.3845 1.61319 13.4951 1.67049 13.5798 1.7576L14.7366 2.9536C14.8902 3.1128 14.9334 3.3456 14.847 3.5488L14.2302 4.9944C14.3326 5.1824 14.4142 5.3432 14.4766 5.4776C14.5438 5.624 14.627 5.8256 14.7262 6.0856L16.1638 6.7016C16.3798 6.7936 16.5134 7.0096 16.499 7.2408L16.3934 8.9008C16.3862 9.00864 16.3475 9.11199 16.2821 9.19803C16.2166 9.28407 16.1274 9.34901 16.0254 9.3848L14.6638 9.8688C14.6246 10.0568 14.5838 10.2176 14.5406 10.3536C14.4709 10.5636 14.3914 10.7703 14.3022 10.9728L14.9862 12.4848C15.0345 12.591 15.0475 12.7099 15.0233 12.8241C14.9991 12.9383 14.939 13.0417 14.8518 13.1192L13.551 14.2808C13.4653 14.357 13.3584 14.4052 13.2446 14.4189C13.1308 14.4326 13.0155 14.4112 12.9142 14.3576L11.5734 13.6472C11.3636 13.7583 11.1472 13.8563 10.9254 13.9408L10.3398 14.16L9.81981 15.6C9.78127 15.7055 9.71176 15.7968 9.62039 15.862C9.52902 15.9273 9.42006 15.9634 9.30781 15.9656L7.78781 16C7.67258 16.003 7.55924 15.9703 7.4634 15.9062C7.36755 15.8422 7.29391 15.75 7.25261 15.6424L6.63981 14.0208C6.43072 13.9493 6.22371 13.872 6.01901 13.7888C5.85158 13.7163 5.68668 13.6382 5.52461 13.5544L4.00461 14.204C3.90445 14.2467 3.79404 14.2594 3.6868 14.2405C3.57956 14.2216 3.48013 14.172 3.40061 14.0976L2.27581 13.0424C2.19206 12.9642 2.13503 12.8616 2.11278 12.7492C2.09053 12.6368 2.10418 12.5202 2.15181 12.416L2.80541 10.992C2.71848 10.8233 2.63789 10.6515 2.56381 10.4768C2.47733 10.263 2.39729 10.0466 2.32381 9.828L0.891806 9.392C0.775406 9.35682 0.673881 9.28419 0.602998 9.18538C0.532114 9.08658 0.495839 8.96714 0.499806 8.8456L0.555806 7.3088C0.559792 7.20853 0.591115 7.11126 0.646388 7.0275C0.701661 6.94375 0.77878 6.8767 0.869406 6.8336L2.37181 6.112C2.44141 5.8568 2.50221 5.6584 2.55581 5.5136C2.63128 5.3202 2.71509 5.13015 2.80701 4.944L2.15581 3.568C2.10639 3.46351 2.09138 3.34603 2.11294 3.23247C2.1345 3.11891 2.19153 3.01511 2.27581 2.936L3.39901 1.8752C3.47774 1.80094 3.57626 1.75101 3.68271 1.73143C3.78915 1.71184 3.89899 1.72343 3.99901 1.7648L5.51741 2.392C5.68541 2.28 5.83741 2.1896 5.97501 2.1168C6.13901 2.0296 6.35821 1.9384 6.63421 1.84L7.16221 0.367201C7.20124 0.259416 7.27259 0.166307 7.36652 0.100586C7.46045 0.0348661 7.57237 -0.000261001 7.68701 1.46011e-06H9.36221ZM8.51901 5.6152C7.18541 5.6152 6.10461 6.6832 6.10461 8.0016C6.10461 9.32 7.18541 10.3888 8.51901 10.3888C9.85181 10.3888 10.9326 9.32 10.9326 8.0016C10.9326 6.6832 9.85261 5.6152 8.51901 5.6152Z" fill="#A0A0A0" />
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
        <div class="row card-item {{ $card['default'] ? 'card-active' : ''}} ">
            <div class="col-md-1 col-3">
                <img src="{{ asset('user/images/'.$card['type'].'.png') }}" />
            </div>
            <div class="col-md-3  col-6">
                <span>{{ $card['card_number'] }}</span>
            </div>
            <div class="col-md-2 default-btn">
                @if($card['default'])
                <button class="custom-label">
                    デフォルト
                </button>
                @endif
            </div>
            <div class="col-md-6 text-right col-3">
                <a href="#" class="remove-card default" data-value="{{ $card['card_id'] }}" data-default="{{ $card['default'] }}">削除</a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@include('user.modal.change_default_modal', ['cards' => $cards])
@include('user.modal.confirm_modal')
@include('user.modal.notify_modal')
<script src="{{ asset('/user/js/card.js')}} "></script>
@endsection