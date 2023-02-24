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
    </style>
@endsection
@section('content')
    <div class="main-content confirm-page">
        <div class="d-title">
            <span class="page-title">@yield('title')</span>
        </div>
        <div class="upload-container card-management">
            <form id="form-order" action="/upload/payment" method="POST">
                {{ csrf_field() }}
                <input type="text" id="account_id" name="account_id" value="{{ $account_id }}" hidden>
                <input type="text" id="order_id" name="order_id" value="{{ $order_id }}" hidden>
                <input type="text" id="card_no" name="card_number" value="{{ $card_number }}" hidden>
                <input type="text" id="card_expire" name="card_expire" value="{{ $card_expire }}" hidden>
                <input type="text" id="card_id" name="card_id" value="" hidden>
                <input type="text" name="coupon_id" value="{{ @$coupon->id }}" hidden>

                <div class="block">
                    <div class="block-content-sm pb-5">
                        <span class="block-title" style="color: black">支払いカードを選択してください</span>
                        <hr>
                        <div class="box-content pr-0">
                            @foreach ($cards as $card)
                                <div class="d-flex card-item {{ $card['default'] ? 'card-active' : ''}} ">
                                    <input class="mr-4" type="radio" name="card"
                                           data-number="{{ $card['card_number'] }}"
                                           data-expire="{{ $card['card_expire'] }}"
                                           value="{{ $card['card_id'] }}" {{ $card['default'] ? 'checked' : ''}} />
                                    <img class="mr-4" src="{{ asset('user/images/'.$card['type'].'.png') }}"/>
                                    <span class="mr-4">{{ $card['card_number'] }} @if($card['default'])<span class="default-item">「デフォルト」</span>@endif</span>
                                    @if($card['default'])
                                        <button class="custom-label">
                                            デフォルト
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                            <button class="btn btn-primary-outline" id="add-card">
                                カードを追加
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M0.5 8C0.5 3.584 4.084 0 8.5 0C12.916 0 16.5 3.584 16.5 8C16.5 12.416 12.916 16 8.5 16C4.084 16 0.5 12.416 0.5 8ZM9.3 8.8H12.5V7.2H9.3V4H7.7V7.2H4.5V8.8H7.7V12H9.3V8.8Z"
                                          fill="#03749C"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <span id="token_api_url" hidden>{{ $api_url }}</span>
                <span id="token_api_key" hidden>{{ $api_token }}</span>
            </form>
            <div class="upload-button m-4 destop">
                <button class="btn custom-btn btn-default back">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black"/>
                        <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z"
                              stroke="black" stroke-width="2"/>
                    </svg>
                    戻る
                </button>
                <button id="change-pay-card" type="submit" class="btn custom-btn btn-primary">
                    確認画面へ進む
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.5" cy="12" r="11.5" stroke="black"/>
                        <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z"
                              stroke="black" stroke-width="2"/>
                    </svg>
                </button>
            </div>
            <div class="upload-button m-4 mobile">
                <button id="change-pay-card" type="submit" class="btn custom-btn btn-primary">
                    確認画面へ進む
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.5" cy="12" r="11.5" stroke="black"/>
                        <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z"
                              stroke="black" stroke-width="2"/>
                    </svg>
                </button>
                <button class="btn custom-btn btn-default back">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black"/>
                        <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z"
                              stroke="black" stroke-width="2"/>
                    </svg>
                    戻る
                </button>
            </div>
        </div>
    </div>
    @include('user.modal.add_new_card')
    @include('user.modal.success')
    @include('user.modal.notify_modal')
    <script src="{{ asset('/user/js/card.js')}} "></script>
@endsection
