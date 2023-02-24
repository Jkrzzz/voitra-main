@extends('user.layouts.upload_layout')
@section('title','依頼内容確認')
@section('style')
    <style>
        .checkmark {
            top: 0;
        }

        /*.no-menu .right-content{*/
        /*    width: 100%;*/
        /*    padding: 30px 40px 60px 40px;*/
        /*}*/
        @media only screen and (max-width: 991px) {
            .item-header {
                margin-bottom: 20px;
            }

            .header-title {
                text-align: left !important;
                display: block;
            }

            .order-header {
                margin-top: 10px;
            }
        }

        .no-menu .right-content {
            padding: 30px 0 60px 0;
        }
    </style>
@endsection
@php
    $languages = config('const.language');
    $audios = $data->audios;
@endphp
@section('content')
    <div class="main-content">
        <div class="d-title">
            <span class="page-title">@yield('title')</span>
        </div>
        <div class="process-bar">
            <div id="steps">
                <div class="stepper done" data-desc="Listing information">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.864 18.84C19.8494 18.8213 19.8308 18.8062 19.8095 18.7958C19.7882 18.7854 19.7648 18.78 19.7411 18.78C19.7174 18.78 19.6941 18.7854 19.6728 18.7958C19.6515 18.8062 19.6328 18.8213 19.6182 18.84L17.4331 21.6076C17.4151 21.6306 17.4039 21.6582 17.4009 21.6873C17.3978 21.7164 17.403 21.7458 17.4158 21.772C17.4286 21.7983 17.4486 21.8205 17.4734 21.8359C17.4982 21.8514 17.5268 21.8596 17.556 21.8595H18.9978V26.5939C18.9978 26.6798 19.068 26.7501 19.1539 26.7501H20.3245C20.4103 26.7501 20.4806 26.6798 20.4806 26.5939V21.8615H21.9262C22.0569 21.8615 22.1291 21.7111 22.0491 21.6095L19.864 18.84Z"
                            fill="#B0B0B0"/>
                        <path
                            d="M25.5816 17.0371C24.688 14.6777 22.4112 13 19.7443 13C17.0773 13 14.8005 14.6758 13.9069 17.0352C12.235 17.4746 11 19 11 20.8125C11 22.9707 12.7461 24.7188 14.9 24.7188H15.6823C15.7682 24.7188 15.8384 24.6484 15.8384 24.5625V23.3906C15.8384 23.3047 15.7682 23.2344 15.6823 23.2344H14.9C14.2425 23.2344 13.6241 22.9727 13.1636 22.498C12.7051 22.0254 12.4613 21.3887 12.4827 20.7285C12.5003 20.2129 12.6759 19.7285 12.9939 19.3203C13.3197 18.9043 13.7762 18.6016 14.2835 18.4668L15.0229 18.2734L15.2941 17.5586C15.4619 17.1133 15.696 16.6973 15.9906 16.3203C16.2814 15.9467 16.6259 15.6183 17.0129 15.3457C17.8147 14.7813 18.759 14.4824 19.7443 14.4824C20.7295 14.4824 21.6738 14.7813 22.4756 15.3457C22.8639 15.6191 23.2072 15.9473 23.4979 16.3203C23.7925 16.6973 24.0266 17.1152 24.1944 17.5586L24.4636 18.2715L25.2011 18.4668C26.2585 18.752 26.998 19.7148 26.998 20.8125C26.998 21.459 26.7463 22.0684 26.2898 22.5254C26.0659 22.7508 25.7995 22.9296 25.5062 23.0513C25.2128 23.173 24.8983 23.2352 24.5807 23.2344H23.7984C23.7125 23.2344 23.6423 23.3047 23.6423 23.3906V24.5625C23.6423 24.6484 23.7125 24.7188 23.7984 24.7188H24.5807C26.7346 24.7188 28.4807 22.9707 28.4807 20.8125C28.4807 19.002 27.2496 17.4785 25.5816 17.0371Z"
                            fill="#B0B0B0"/>
                        <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0"
                                stroke-width="2.5"/>
                    </svg>
                    <p class="stepper-title">アップ</p>
                </div>
                <div class="stepper" data-desc="Photos & Details">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0"
                                stroke-width="2.5"/>
                        <path
                            d="M28 13H12C10.897 13 10 13.897 10 15V27C10 28.103 10.897 29 12 29H28C29.103 29 30 28.103 30 27V15C30 13.897 29.103 13 28 13ZM12 15H28V17H12V15ZM12 27V21H28.001L28.002 27H12Z"
                            fill="#B0B0B0"/>
                        <path d="M14 23H21V25H14V23Z" fill="#B0B0B0"/>
                    </svg>
                    <p class="stepper-title">決済情報入力</p>
                </div>
                <div class="stepper" data-desc="Review & Post">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0"
                                stroke-width="2.5"/>
                        <path
                            d="M25.6485 15.35C24.1976 13.9 22.2064 13 19.995 13C15.5722 13 12 16.58 12 21C12 25.42 15.5722 29 19.995 29C23.7273 29 26.8393 26.45 27.7298 23H25.6485C24.828 25.33 22.6066 27 19.995 27C16.6829 27 13.9912 24.31 13.9912 21C13.9912 17.69 16.6829 15 19.995 15C21.656 15 23.137 15.69 24.2176 16.78L20.9956 20H28V13L25.6485 15.35Z"
                            fill="#B0B0B0"/>
                    </svg>
                    <p class="stepper-title">確認</p>
                </div>
                <div class="stepper" data-desc="Your order">
                    <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0"
                                stroke-width="2.5"/>
                        <path d="M13 26.7143H29V29H13V26.7143Z" fill="#B0B0B0"/>
                        <path
                            d="M26.2457 13L18.7143 20.5314L15.7543 17.5829L14.1429 19.1943L18.7143 23.7657L27.8571 14.6229L26.2457 13Z"
                            fill="#B0B0B0"/>
                    </svg>
                    <p class="stepper-title">完了</p>
                </div>
            </div>
        </div>
        <div class="upload-container">
            <div class="block">
                <div class="block-header row mb-3">
                    <div class="col-xl-8 col-lg-5 col-sm-6">
                        <img src="{{ asset('user/images/block-header.png') }}">
                        <h2>AI文字起こしプラン</h2>
                    </div>
                </div>
                <div class="block-content">
                    @foreach ($audios as $audio)
                        <div class="audio-item">
                            <div class="item-header row">
                                <div class="col-lg-4 col-md-12 col-12 order">
                                    <div class="order-header">
                                        <p class="header-title audio-name font-weight-bold" data-toggle="tooltip"
                                           data-placement="top" title="{{ $audio['name'] }}">{{ $audio->name }}</p>
                                        <p class="order-lang">{{ !is_null($audio->language) ? $languages[$audio->language] : '' }}</p>
                                    </div>
                                    <audio class="audio-player">
                                        <source src="{{ $audio->url }}" type="audio/flac">
                                    </audio>
                                </div>
                                <div class="col-lg-2 col-md-12 col-12">
                                    <div class="order-header">
                                        <p class="header-title font-weight-bold">話者分離</p>
                                    </div>
                                    @if($audio->pivot->diarization)
                                        @if($audio->pivot->num_speaker > 0)
                                            <input value="{{ $audio->pivot->num_speaker }}" class="form-control"
                                                   disabled>
                                        @else
                                            <input value="指定なし" class="form-control" disabled>
                                        @endif
                                    @else
                                        <input value="利用しない" class="form-control" disabled>
                                    @endif
                                </div>
                                <div class="col-lg-2 col-md-12 col-12">
                                    <div class="order-header">
                                        <p class="header-title font-weight-bold">時間</p>
                                    </div>
                                    <input value="{{ gmdate('H時間i分s秒', $audio->duration) }}" class="form-control"
                                           disabled>
                                </div>
                                <div class="col-lg-2 col-md-12 col-12">
                                    <div class="order-header">
                                        <p class="header-title font-weight-bold">見込処理時間</p>
                                    </div>
                                    <input value="{{ gmdate("H時間i分s秒", $audio->pivot->estimated_processing_time) }}"
                                           class="form-control" disabled>
                                </div>
                                <div class="col-lg-2 col-md-12 col-12">
                                    <div class="order-header">
                                        <p class="header-title font-weight-bold">料金（税込）</p>
                                        <p class="small-text order-price">※ 30円/1分</p>
                                    </div>
                                    <input value="@money($audio->pivot->price)円" class="form-control" disabled>

                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="coupon">
                        <div class="audio-item">
                            <div class="item-header row">
                                <div class="col-lg-6 col-md-12">
                                    <p class="header-title font-weight-bold use-coupon-title">クーポン利用</p>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    @if($isUseCoupon && $coupon)
                                        <div class="used-coupon">
                                            {{$coupon->code}}
                                            <i class="far fa-times-circle" id="remove-coupon"></i>
                                        </div>
                                    @else
                                        <input id="coupon_code" value="" class="form-control" placeholder="ABCDE">
                                    @endif
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <button id="use_coupon" class="btn btn-cs" disabled>適用</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="line">
                    </div>
                    <div class="audio-item">
                        <div class="item-header row">
                            <div class="col-lg-6 col-md-12">
                                <p class="header-title font-weight-bold total-order-title"
                                   style="font-size: 20px;color: #4B4B4B">ファイル処理料金</p>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="order-header">
                                    <p class="header-title text-summary font-weight-bold">時間</p>
                                </div>
                                <input value="{{ gmdate('H時間i分s秒', $data->total_time) }}" class="form-control" disabled>
                            </div>
                            <div class="col-lg-2 col-md-12">
                                <div class="order-header">
                                    <p class="header-title text-summary font-weight-bold">料金（税込）</p>
                                </div>
                                <input value="@money($data->total_price)円" class="form-control" disabled>
                            </div>
                        </div>
                        @if($isUseCoupon && $coupon)
                        <div class="item-header row">
                            <div class="col-lg-10 col-md-12">
                                <p class="header-title font-weight-bold"
                                   style="font-size: 20px;color: #4B4B4B">クーポン割引金額
                                <span class="item-coupon-note">（本体価格からの割引となります。）</span>
                                </p>
                            </div>
                            <div class="col-lg-2 col-md-12">
                                <input value="-@money($coupon->discount_amount)円" class="form-control" disabled>
                            </div>
                        </div>
                            @endif
                    </div>
                </div>
                <div class="block-content">
                    <div class="line">
                    </div>
                    <div class="box-cont mt-3">
                        <div class="block-list">
                            @if($isUseCoupon && $coupon)
                            <div class="item-header row discounted-money" style="align-items: center;">
                                <div class="col-xl-10 col-md-7">
                                    <p class="page-title font-weight-bold mb-3">
                                        クーポン適用後ファイル処理料金
                                        <span class="item-coupon-note">（税抜金額 ー クーポン割引金額）＋消費税</span>
                                    </p>
                                </div>
                                <div class="col-xl-2 col-md-5">
                                    <div class="discounted-money-total">@money($discountedMoneyTotal)円（税込）</div>
                                </div>
                            </div>
                            @endif
                            <div class="item-header row" style="align-items: center;">
                                <div class="col-xl-7 col-lg-5 col-sm-6">
                                    <p class="page-title font-weight-bold mb-3" style="font-size: 20px;color: #4B4B4B">
                                        決済方法</p>
                                </div>
                                @if(!$isUseCoupon || $discountedMoneyTotal > 0)
                                <div class="col-xl-5 col-lg-7 col-sm-6">
                                    <div style="text-align: right">
                                        <select class="form-control" id="payment-method">
                                            <option value="1">クレジットカード</option>
                                            <option value="2">コンビニ後払い（ベリトランス後払い）</option>
                                        </select>
                                    </div>
                                </div>
                                @else
                                    <div class="col-xl-12 col-lg-12 col-sm-12">
                                        <div class="used-coupon" style="color: #74787D">
                                            決済金額が0になったため決済なしで注文いただきます。
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div id="postpaid-noty" class="block-list"
                         style="display: none; background-color: #FFF; border-radius: 10px; padding: 15px 20px; height: 120px; overflow-y: scroll">
                        <p>•後払い手数料：350円（税込）</p>
                        <p>•利用限度額：55,000円（税込）</p>
                        <p>•請求書はサービス提供後に株式会社SCOREより郵送されます。発行から14日以内にコンビニでお支払いください。</p>
                        <p style="padding: 15px 0px">
                            •お客様に対する代金債権とそれに付帯する個人情報（定義は、個人情報の保護に関する法律第2条第1項に従います。）は、包括的な決済サービスを提供する株式会社DGフィナンシャルテクノロジーに譲渡・提供されたうえで、さらに同社から後払い決済サービスを提供する
                            株式会社SCOREに対し、再譲渡・提供されますので、 当該第三者への譲渡・提供に同意の上、お申込みください。<br></p>
                        <p>【提供先の個人情報の利用目的】
                            <br>以下URL（個人情報の取扱いについて）よりご確認ください。
                        <ul>
                            <li>株式会社DGフィナンシャルテクノロジー<br><a target="_blank"
                                                          href="https://www.veritrans.co.jp/privacy/operation.html">https://www.veritrans.co.jp/privacy/operation.html</a>
                            </li>
                            <li>株式会社SCORE ：<br><a target="_blank" href="https://corp.scoring.jp/privacypolicy/">https://corp.scoring.jp/privacypolicy/</a>
                            </li>
                        </ul>
                        </p>
                        <p style="padding: 15px 0px">【提供する個人情報】
                            <br>氏名、電話番号、住所、Eメールアドレス
                            <br>※その他、個人情報には該当しない、購入商品や取引金額等の決済データも専用システムにて提供されます。
                        </p>
                        <p>•株式会社SCOREが行う与信審査の結果により、後払い決済をご利用頂けない場合がございます。</p>
                        <p>•株式会社DGフィナンシャルテクノロジー、株式会社SCOREの詳細は以下URLよりご確認ください。
                        <ul>
                            <li>株式会社DGフィナンシャルテクノロジーについて<br><a target="_blank" href="https://www.veritrans.co.jp/">https://www.veritrans.co.jp/</a>
                            </li>
                            <li>株式会社SCOREについて<br><a target="_blank" href="https://www.scoring.jp/consumer/">https://www.scoring.jp/consumer/</a>
                            </li>
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
                        <span class="page-title-2">注意事項</span>
                        <ul style="margin-top: 10px;">
                            <li>雑音などが含まれている場合や、認識が困難な専門用語や固有名詞などが含まれる場合は、正確にテキスト化できない可能性がございます。</li>
                            <li>AI音声認識によりテキスト化となるため、音声ファイルでは騒音やノイズが多い場合など精度が低くなる可能性があります。</li>
                            <li>価格は、税込価格となります。</li>
                            <li>納品予定日の通知から24時間以上経過しますと、納期にも遅れが生じますので、お申込みいただくことができなくなります。予めご了承下さい。</li>
                        </ul>
                    </div>
                </div>
                <form method="post" action="/upload/payment" id="form-order">
                    {{ csrf_field() }}
                    <input id="order-id" type="text" name="order_id" value="{{$data->id}}" hidden>
                    <input id="paynow_option" type="hidden" name="paynow_option" value="{{$paynowOption}}">
                    <input id="method" type="text" name="method" value="1" hidden>
                    <input id="coupon_id" type="hidden" name="coupon_id" value="{{@$coupon->id}}">
                    <div class="form-group my-form-check mb-0">
                        <div class="regular-checkbox-group">
                            <input class="regular-checkbox" type="checkbox" value="" id="accept" autocomplete="off">
                            <span class="checkmark"></span>
                        </div>
                        <label class="form-check-label order-page" for="accept">
                            <a class="text-link" href="/home/terms.php" target="_blank">利用規約</a>
                            / <a class="text-link" target="_blank" href="/home/privacy.php">プライバシーポリシー</a>
                            / 注意事項に同意。
                        </label>
                    </div>

                    <div class="upload-button">
                        <a class="btn custom-btn btn-default"
                        href="{{ route('upload.detail', ['order_id' => $data->id]) }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black"/>
                                <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z"
                                    stroke="black" stroke-width="2"/>
                            </svg>
                            戻る
                        </a>
                        <button class="btn custom-btn btn-primary">
                            確認画面へ進む
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12.5" cy="12" r="11.5" stroke="black"/>
                                <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z"
                                    stroke="black" stroke-width="2"/>
                            </svg>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" name="coupon" value="{{json_encode($coupon)}}">
    <input type="hidden" name="is_use_coupon" value="{{$isUseCoupon}}">
    @include('user.modal.modal_postpaid_privacy')
    @include('user.modal.error_modal')
    <script id="rendered-js">
        let audio = document.querySelectorAll('.audio-player');
        audio.forEach(function (e) {
            let p = new Plyr(e);
            window.player = p;
        })
    </script>
    <script src="{{ asset('/user/js/upload_detail.js')}} "></script>
@endsection
