@extends('user.layouts.user_layout')
@section('title','ユーザー情報')
@section('style')
    <link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
    <style>
        .tooltip-inner{
            padding: 0.25rem 0.5rem!important;
        }
        .tooltip .arrow{
            display: block!important;
        }
        .bs-tooltip-auto[x-placement^=right] .arrow::before, .bs-tooltip-right .arrow::before{
            border-right-color: #fff9e5;
        }
    </style>
@endsection
@section('content')
    <div class="main-content">
        <p class="breadcrumb-common">クーポン</p>
        <div class="information-box">
            <div class="row information-sub-header">
                <div class="col-md-6 col-6">
                    <h4 class="information-sub-title">クーポン一覧</h4>
                </div>
            </div>
            <div class="coupon-list">
                @if(count($coupons) > 0)
                    <div class="row">
                        @foreach ($coupons as $coupon)
                            <div class="col-md-6 col-12">
                                <div class="coupon-box">
                                    <div class="coupon-info">
                                        <div class="row mb-2">
                                            <div class="col-md-3 col-3">
                                                <p class="coupon-info-label">コード</p>
                                            </div>
                                            <div class="col-md-9 col-9">
                                                <p class="coupon-info-content">{{$coupon->code}}
                                                    <i class="far fa-copy copy-coupon-code" data-copy="{{$coupon->code}}" data-toggle="tooltip" data-placement="right" title="コピーしました"></i>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3 col-3">
                                                <p class="coupon-info-label">利用回数</p>
                                            </div>
                                            <div class="col-md-9 col-9">
                                                <p class="coupon-info-content coupon-quantity">
                                                    @if ($coupon->is_limited)
                                                        @if($coupon->quantity)
                                                            先着{{$coupon->quantity}}名までご利用いただけます。<br>
                                                            お一人様１回限りご利用いただけます。
                                                        @else
                                                            お一人様１回限りご利用いただけます。
                                                        @endif
                                                    @else
                                                        @if($coupon->quantity)
                                                            先着{{$coupon->quantity}}回までご利用いただけます。<br>
                                                            回数制限に達するまで、何度でもご利用いただけます。
                                                        @else
                                                            期間中使い放題
                                                        @endif
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 col-3">
                                                <p class="coupon-info-label">有効時間</p>
                                            </div>
                                            <div class="col-md-9 col-9">
                                                <p class="coupon-info-content">{{date('Y/m/d',strtotime($coupon->start_at))}} - {{date('Y/m/d', strtotime($coupon->end_at))}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="coupon-amount">@money($coupon->discount_amount)円</p>
                                    <p class="coupon-note">※決済手数料と話者分離月額料金には適用できません。<br>
                                        ※他のクーポンと併用できません。</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="empty-coupons">クーポンはありません。</p>
                @endif
                    <div class="coupon-bottom">
                        <p>注意事項</p>
                        <p>・クーポンによってご利用いただけるサービス／有効期限が異なります。<br>
                            ・クーポンは1回のご注文につき1つのみご利用いただけます。他のクーポンとの併用はできません。<br>
                            ・キャンペーンは予告なく変更または中止する場合があります。<br>
                            ・クーポンは、決済手数料と話者分離月額料金には適用できません。</p>
                    </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/user/js/coupon.js') }}"></script>
@endsection
