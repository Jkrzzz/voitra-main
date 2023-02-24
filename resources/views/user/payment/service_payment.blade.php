@extends('user.layouts.upload_layout')
@section('title','会員メニュートップ')
@section('content')
<style>
    .no-menu .right-content {
        padding: 30px 0 60px 0;
    }
</style>
<div class="main-content">
    <div class="d-title">
        <span class="page-title">@yield('title')</span>
    </div>
    <div class="upload-container service-payment">
        <div class="block">
            <div class="block-header row">
                <div class="col-xl-8 col-lg-5 col-sm-6">
                    <img src="{{ asset('user/images/block-header.png') }}">
                    <h2>話者分離オプション</h2>
                </div>
                <div class="col-xl-4 col-lg-7 col-sm-6">
                </div>
            </div>
            <div class="block-content campaign row">
                <div class="col-xl-7 col-lg-7">
                    <div class="block-list">
                        <ul>
                            <li>
                                <img src="{{ asset('user/images/speaker_icon.png') }}">
                                <span>最大５人までの同時発話を自動認識</span>
                            </li>
                            <li>
                                <img src="{{ asset('user/images/speaker_icon.png') }}">
                                <span>月額300円（税込）で何回でも利用可能</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <div class="block-list">
                        <img class="campaign-img" src="{{ asset('user/images/campaign_content.png') }}">
                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="audio-item">
                    <div class="item-header row">
                        <div class="cold-lg-8 col-md-6">
                            <span class="header-title font-weight-bold total-order-title">期間 <span class="text-sm">（自動更新）</span></span>
                        </div>
                        <div class="cold-lg-4 col-md-6">
                            <input value="{{$date_from . '~' . $date_to}}" class="form-control text-right" disabled="">
                        </div>
                    </div>
                    <div class="item-header row">
                        <div class="cold-lg-10 col-md-9">
                            <span class="header-title font-weight-bold total-order-title">合計 <span class="text-sm">（税込）</span></span>
                        </div>
                        <div class="cold-lg-2 col-md-3">
                            <input value="@money($service->price)円" class="form-control text-right" disabled="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content">
                <div class="line">
                </div>
                <div class="box-cont mt-3">
                    <div class="block-list">
                        <div class="item-header row" style="align-items: center;">
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
                                <p class="page-title font-weight-bold mb-3" style="font-size: 20px;color: #4B4B4B"> 決済方法</p>
                            </div>
                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7">
                                <div style="text-align: right">
                                    <select class="form-control" id="payment-method">
                                        <option value="1">クレジットカード</option>
                                        <option value="2">コンビニ後払い（ベリトランス後払い）</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>
                <div id="postpaid-noty" class="block-list" style="display: none; background-color: #FFF; border-radius: 10px; padding: 15px 20px; height: 120px; overflow-y: scroll">
                    <p>•後払い手数料：350円（税込）</p>
                    <p>•利用限度額：55,000円（税込）</p>
                    <p>•請求書はサービス提供後に株式会社SCOREより郵送されます。発行から14日以内にコンビニでお支払いください。</p>
                    <p style="padding: 15px 0px">•お客様に対する代金債権とそれに付帯する個人情報（定義は、個人情報の保護に関する法律第2条第1項に従います。）は、包括的な決済サービスを提供する株式会社DGフィナンシャルテクノロジーに譲渡・提供されたうえで、さらに同社から後払い決済サービスを提供する 株式会社SCOREに対し、再譲渡・提供されますので、 当該第三者への譲渡・提供に同意の上、お申込みください。<br></p>
                    <p>【提供先の個人情報の利用目的】
                        <br>以下URL（個人情報の取扱いについて）よりご確認ください。
                    <ul>
                        <li>株式会社DGフィナンシャルテクノロジー<br><a target="_blank" href="https://www.veritrans.co.jp/privacy/operation.html">https://www.veritrans.co.jp/privacy/operation.html</a></li>
                        <li>株式会社SCORE ：<br><a target="_blank" href="https://corp.scoring.jp/privacypolicy/">https://corp.scoring.jp/privacypolicy/</a></li>
                    </ul>
                    </p>
                    <p style="padding: 15px 0px">【提供する個人情報】
                        <br>氏名、電話番号、住所、Eメールアドレス
                        <br>※その他、個人情報には該当しない、購入商品や取引金額等の決済データも専用システムにて提供されます。
                    </p>
                    <p>•株式会社SCOREが行う与信審査の結果により、後払い決済をご利用頂けない場合がございます。</p>
                    <p>•株式会社DGフィナンシャルテクノロジー、株式会社SCOREの詳細は以下URLよりご確認ください。
                    <ul>
                        <li>株式会社DGフィナンシャルテクノロジーについて<br><a target="_blank" href="https://www.veritrans.co.jp/">https://www.veritrans.co.jp/</a></li>
                        <li>株式会社SCOREについて<br><a target="_blank" href="https://www.scoring.jp/consumer/">https://www.scoring.jp/consumer/</a></li>
                    </ul>
                    </p>
                    <p style="padding: 15px 0px">個人情報の提供に関する問合せ先：voitra_support@upselltech-group.co.jp</p>
                    <p>•下記スマートフォンアプリからお支払い可能です。
                    <ul>
                        <li>LINEPay請求書支払い</li>
                        <li>楽天銀行コンビニ支払サービス（アプリで払込票支払）</li>
                    </ul>
                    </p>
                </div>
                <div class="block-list" style="background-color: #EFEFEF; border-radius: 10px; padding: 15px 10px">
                    <span class="page-title">注意事項</span>
                    <ul style="margin-top: 10px;">
                        <li>次回以降は自動更新となり手続きが不要となります。</li>
                        <li>更新時期になりましたら、自動更新に関するメールを配信いたします。</li>
                        <li>自動更新の解除は、ユーザー情報からいつでも変更が可能です。</li>
                        <li>価格は、税込価格となります。</li>
                    </ul>
                </div>
            </div>
            <form method="post" action="{{ isset($order_id) ? '/upload/detail?order_id='.$order_id : '/service/payment/' }}" id="form-order">
                {{ csrf_field() }}
                <input id="order-id" type="text" name="order_id" value="{{ $order_id }}" hidden>
                <input id="method" type="text" name="method" value="1" hidden>

                <div class="form-group my-form-check mb-0">
                    <div class="regular-checkbox-group">
                        <input class="regular-checkbox" type="checkbox" value="" id="accept">
                        <span class="checkmark"></span>
                    </div>
                    <label class="form-check-label order-page" for="accept">
                        <a class="text-link" href="/home/terms.php" target="_blank">利用規約</a>
                        / <a class="text-link" target="_blank" href="/home/privacy.php">プライバシーポリシー</a>
                        / 注意事項に同意。
                    </label>
                </div>
                <div class="upload-button">
                    <button id="back" class="btn custom-btn btn-default">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black"></circle>
                            <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z" stroke="black" stroke-width="2"></path>
                        </svg>
                        戻る
                    </button>
                    <button class="btn custom-btn btn-primary" id="confirm" disabled="">
                        決済画面へ進む
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                            <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('user.modal.notify_modal')
@include('user.modal.success')
@include('user.modal.modal_postpaid_privacy')
@if (isset($error) && $error)
@include('user.modal.error_modal')
<script>
    $("#modal-error .notification-title").html(
        "もう一度決済してください。"
    );
    $('#modal-error').modal('show');
</script>
@endif
<script>
    $(document).ready(function() {
        var order_id = $('#order-id').val();
    })
    $("#back").click(function(e) {
        e.preventDefault();
        history.back();
    });
</script>
<script src="{{ asset('/user/js/service.js')}} "></script>
@endsection
