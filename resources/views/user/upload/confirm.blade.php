@extends('user.layouts.upload_layout')
@section('title','決済確認')
@section('style')
    <style>
        .checkmark {
            top: 1px;
            left: -2px;
        }

        @media only screen and (max-width: 600px) {
            .checkmark {
                top: -2px;
                left: -2px;
            }
        }
        .box-content {
            padding: 10px;
        }
        @media only screen and (max-width: 810px){
            .block-content-sm {
                padding: 15px;
            }
            .no-menu .right-content{
                padding: 30px 10px;
            }
        }
    </style>
@endsection
@php
    $languages = config('const.language');
    $audios = $data->audios;
@endphp
@section('content')
    <div class="main-content confirm-page">
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
                <div class="stepper done" data-desc="Photos & Details">
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
                <div class="stepper done" data-desc="Review & Post">
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
                <div class="block-content-sm pb-5">
                    <span class="block-title" style="color: black">決済確認</span>
                    <hr>
                    <div class="box-content">
                        <div class="block-header mb-3 confirm-label-mb">
                            <button class="custom-label-mb text-primary bg-primary">
                                依頼ファイル詳細
                            </button>
                        </div>
                        <div class="block-header mb-3 row confirm-label-des">
                            <div class="col-md-3">
                                <button class="custom-label text-primary bg-primary">
                                    依頼ファイル詳細
                                </button>
                            </div>
                            <div class="col-md-3 mb-1 lang-res header-title">
                                時間
                            </div>
                            <div class="col-md-2 lang-res header-title">
                                話者分離
                            </div>
                            <div class="col-md-2 lang-res header-title">
                                見込処理時間
                            </div>
                            <div class="col-md-2 lang-res header-title">
                                料金（税込）
                            </div>
                        </div>
                        @foreach ($audios as $audio)
                            <div class="order-item row">
                                <div class="col-md-3">
                                    <span class="audio-name">{{$audio->name}}</span>
                                </div>
                                <div class="col-12 lang-res-mb">
                                    時間
                                </div>
                                <div class="col-md-3 mb-1 order-item-detail text-left">
                                    <span> {{ gmdate('H時間i分s秒', $audio->duration) }}</span>
                                </div>
                                <div class="col-12 lang-res-mb">
                                    話者分離
                                </div>
                                <div class="col-md-2 order-item-detail num_speaker">
                                    @if($audio->pivot->diarization)
                                        @if($audio->pivot->num_speaker > 0)
                                            <span>{{ $audio->pivot->num_speaker }}人</span>
                                        @else
                                            <span value="">指定なし</span>
                                        @endif
                                    @else
                                        <span>利用しない</span>
                                    @endif
                                </div>
                                <div class="col-12 lang-res-mb">
                                    見込処理時間
                                </div>
                                <div class="col-md-2 mb-1 order-item-detail text-left">
                                    <span> {{ gmdate("H時間i分s秒", $audio->pivot->estimated_processing_time) }}</span>
                                </div>
                                <div class="col-12 lang-res-mb">
                                    料金（税込）
                                </div>
                                <div class="col-md-2 order-item-detail text-left">
                                    <span>@money($audio->price)円</span>
                                </div>
                            </div>
                        @endforeach
                        <div class="order-item">
                            <hr>
                        </div>
                        <div class="order-item row">
                            <div class="col-md-3">
                                <span class="page-title">ファイル処理料金</span>
                            </div>
                            <div class="col-md-3 order-item-detail text-left">
                                <span class="page-title text-summary">{{ gmdate('H時間i分s秒', $data->total_time) }}</span>
                            </div>
                            <div class="col-md-2 order-item-detail">
                            </div>
                            <div class="col-md-2 order-item-detail">
                            </div>
                            <div class="col-md-2 order-item-detail text-left">
                                <span>@money($data->total_price)円</span>
                            </div>
                        </div>
                        @if($coupon)
                        <div class="order-item row">
                            <div class="col-md-10">
                                <span class="page-title">クーポン割引金額<span class="item-coupon-note d-inline">（本体価格からの割引となります。）</span></span>
                            </div>
                            <div class="col-md-2 order-item-detail text-left">
                                <span>-@money($coupon->discount_amount)円</span>
                            </div>
                        </div>
                        <div class="order-item">
                            <hr>
                        </div>
                        <div class="order-item row">
                            <div class="col-md-10">
                                <span class="page-title">決済金額</span>
                            </div>
                            <div class="col-md-2 order-item-detail text-left">
                                <span class="page-title text-summary">@money($discountedMoneyTotal)円</span>
                            </div>
                        </div>
                            @endif
                    </div>
                </div>
                @if($discountedMoneyTotal)
                <div class="block-content-sm pt-0 pb-3">
                    <div class="box-content">
                        <div class="block-header mb-3 confirm-label-mb">
                            <button class="custom-label-mb text-primary bg-primary">
                                決済カード情報
                            </button>
                        </div>
                        <div class="block-header mb-3 row">
                            <div class="col-md-5">
                                <button class="custom-label text-primary bg-primary">
                                    決済カード情報
                                </button>
                            </div>
                        </div>
                        <div class="order-item row">
                            <div class="col-md-6" style="text-align: left">
                                <span class="page-title ">カード名義</span>
                            </div>
                            <div class="col-md-6 order-item-detail">
                                <span>{{ $username }}</span>
                            </div>
                        </div>
                        <div class="order-item row">
                            <div class="col-md-6">
                                <span class="page-title">クレジットカード</span>
                            </div>
                            <div class="col-md-6 order-item-detail">
                                <span>{{ $req_card_number }}</span>
                            </div>
                        </div>
                        <div class="order-item row">
                            <div class="col-md-6">
                                <span class="page-title">有効期間</span>
                            </div>
                            <div class="col-md-6 order-item-detail">
                                <span >{{ $expdate }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                    @endif
            </div>
            <form id="form-order" method="post" action="/upload/complete">
                {{ csrf_field() }}
                <input type="text" name="token" value="{{ $token }}" hidden>
                <input type="text" name="username" value="{{ $username }}" hidden>
                <input type="text" name="expdate" value="{{ $expdate }}" hidden>
                <input type="text" name="payment_amount" value="{{ $data->total_price }}" hidden>
                <input type="text" name="coupon_id" value="{{ @$coupon->id }}" hidden>
                <input type="text" name="payment_id" value="{{ $payment_id }}" hidden>
                <input type="text" name="order_id" value="{{ $data->id }}" hidden>
                <input type="text" name="discountedMoneyTotal" value="{{ $discountedMoneyTotal }}" hidden>

                <div class="form-group my-form-check mb-0">
                    <div class="regular-checkbox-group">
                        <input class="regular-checkbox" type="checkbox" value="" id="accept" autocomplete="off">
                        <span class="checkmark"></span>
                    </div>
                    <label class="form-check-label order-page" for="accept">
                        <a class="text-link">上記内容で、発注と決済が行われることに同意</a>
                    </label>
                </div>
            </form>
            <div class="upload-button m-4">
                <button class="btn custom-btn btn-default back">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black"/>
                        <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z"
                              stroke="black" stroke-width="2"/>
                    </svg>
                    戻る
                </button>
                <button id="complete" class="btn custom-btn btn-primary" disabled style="width: 300px;">
                決済してテキスト化を実行
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.5" cy="12" r="11.5" stroke="black"/>
                        <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z"
                              stroke="black" stroke-width="2"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <script src="{{ asset('/user/js/upload_detail.js')}} "></script>
@endsection
