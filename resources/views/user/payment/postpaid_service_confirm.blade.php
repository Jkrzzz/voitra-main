@extends('user.layouts.upload_layout')
@section('title','会員メニュートップ')
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
    <div class="process-bar">
        <div id="steps">
            <div class="stepper done" data-desc="Listing information">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.864 18.84C19.8494 18.8213 19.8308 18.8062 19.8095 18.7958C19.7882 18.7854 19.7648 18.78 19.7411 18.78C19.7174 18.78 19.6941 18.7854 19.6728 18.7958C19.6515 18.8062 19.6328 18.8213 19.6182 18.84L17.4331 21.6076C17.4151 21.6306 17.4039 21.6582 17.4009 21.6873C17.3978 21.7164 17.403 21.7458 17.4158 21.772C17.4286 21.7983 17.4486 21.8205 17.4734 21.8359C17.4982 21.8514 17.5268 21.8596 17.556 21.8595H18.9978V26.5939C18.9978 26.6798 19.068 26.7501 19.1539 26.7501H20.3245C20.4103 26.7501 20.4806 26.6798 20.4806 26.5939V21.8615H21.9262C22.0569 21.8615 22.1291 21.7111 22.0491 21.6095L19.864 18.84Z" fill="#B0B0B0" />
                    <path d="M25.5816 17.0371C24.688 14.6777 22.4112 13 19.7443 13C17.0773 13 14.8005 14.6758 13.9069 17.0352C12.235 17.4746 11 19 11 20.8125C11 22.9707 12.7461 24.7188 14.9 24.7188H15.6823C15.7682 24.7188 15.8384 24.6484 15.8384 24.5625V23.3906C15.8384 23.3047 15.7682 23.2344 15.6823 23.2344H14.9C14.2425 23.2344 13.6241 22.9727 13.1636 22.498C12.7051 22.0254 12.4613 21.3887 12.4827 20.7285C12.5003 20.2129 12.6759 19.7285 12.9939 19.3203C13.3197 18.9043 13.7762 18.6016 14.2835 18.4668L15.0229 18.2734L15.2941 17.5586C15.4619 17.1133 15.696 16.6973 15.9906 16.3203C16.2814 15.9467 16.6259 15.6183 17.0129 15.3457C17.8147 14.7813 18.759 14.4824 19.7443 14.4824C20.7295 14.4824 21.6738 14.7813 22.4756 15.3457C22.8639 15.6191 23.2072 15.9473 23.4979 16.3203C23.7925 16.6973 24.0266 17.1152 24.1944 17.5586L24.4636 18.2715L25.2011 18.4668C26.2585 18.752 26.998 19.7148 26.998 20.8125C26.998 21.459 26.7463 22.0684 26.2898 22.5254C26.0659 22.7508 25.7995 22.9296 25.5062 23.0513C25.2128 23.173 24.8983 23.2352 24.5807 23.2344H23.7984C23.7125 23.2344 23.6423 23.3047 23.6423 23.3906V24.5625C23.6423 24.6484 23.7125 24.7188 23.7984 24.7188H24.5807C26.7346 24.7188 28.4807 22.9707 28.4807 20.8125C28.4807 19.002 27.2496 17.4785 25.5816 17.0371Z" fill="#B0B0B0" />
                    <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0" stroke-width="2.5" />
                </svg>
                <p class="stepper-title">アップ</p>
            </div>
            <div class="stepper done" data-desc="Photos & Details">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0" stroke-width="2.5" />
                    <path d="M28 13H12C10.897 13 10 13.897 10 15V27C10 28.103 10.897 29 12 29H28C29.103 29 30 28.103 30 27V15C30 13.897 29.103 13 28 13ZM12 15H28V17H12V15ZM12 27V21H28.001L28.002 27H12Z" fill="#B0B0B0" />
                    <path d="M14 23H21V25H14V23Z" fill="#B0B0B0" />
                </svg>
                <p class="stepper-title">決済情報入力</p>
            </div>
            <div class="stepper">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0" stroke-width="2.5" />
                    <path d="M13 26.7143H29V29H13V26.7143Z" fill="#B0B0B0" />
                    <path d="M26.2457 13L18.7143 20.5314L15.7543 17.5829L14.1429 19.1943L18.7143 23.7657L27.8571 14.6229L26.2457 13Z" fill="#B0B0B0" />
                </svg>
                <p class="stepper-title">完了</p>
            </div>
        </div>
    </div>
    <div class="upload-container confirm">
        <div class="block">
            <div class="block-content-sm pb-5">
                <span class="block-title" style="color: black">決済確認</span>
                <hr>
                <div class="box-content">
                    <div class="block-header mb-3 row div-nav">
                        <div class="col-md-5">
                            <span class="page-title text-primary">Options</span>
                        </div>
                        <div class="col-md-5 mb-1 lang-res header-title text-center">
                            期間
                        </div>
                        <div class="col-md-2 text-right lang-res header-title">
                            料金 (税込)
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-5">
                            <span>{{$service->name}}（翌月以降は自動更新）</span>
                        </div>
                        <div class="col-12 lang-res-mb text-center-mb-left">
                            時間
                        </div>
                        <div class="col-md-5 mb-1 order-item-detail text-center-mb-left">
                            <span>{{ $date_from . '~' . $date_to }}</span>
                        </div>
                        <div class="col-12 lang-res-mb">
                            話者分離
                        </div>
                        <div class="col-12 lang-res-mb">
                            料金（税込）
                        </div>
                        <div class="col-md-2 order-item-detail">
                            <span>@money($service->price)円</span>
                        </div>
                    </div>
                    <div class="order-item">
                        <hr>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-5">
                            <span class="page-title">合計</span>
                        </div>
                        <div class="col-md-3 order-item-detail text-center">
                        </div>
                        <div class="col-md-2 order-item-detail">
                        </div>
                        <div class="col-md-2 order-item-detail">
                            <span class="page-title text-summary">@money($service->price)円</span>
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-5">
                            <span class="page-title">決済手数料</span>
                        </div>
                        <div class="col-md-3 order-item-detail text-center">
                        </div>
                        <div class="col-md-2 order-item-detail">
                        </div>
                        <div class="col-md-2 order-item-detail">
                            <span class="page-title text-summary">350円</span>
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-5">
                            <span class="page-title">決済金額</span>
                        </div>
                        <div class="col-md-3 order-item-detail text-center">
                        </div>
                        <div class="col-md-2 order-item-detail">
                        </div>
                        <div class="col-md-2 order-item-detail">
                            <span class="page-title text-summary">@money($service->price + 350)円</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block-content-sm pt-0 pb-3">
                <div class="box-content">
                    <div class="block-header mb-3 d-flex">
                            <span class="text-primary bg-primary mr-4">請求先情報</span>
                            <a href="{{ route('changeAddress', ['type' => 3, 'address_id' => $address->id]) }}" class="text-link">
                                変更
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.9333 2.89519L9.10662 1.06852C8.86821 0.844589 8.55581 0.716098 8.22884 0.707493C7.90187 0.698889 7.58314 0.810771 7.33329 1.02186L1.33329 7.02186C1.1178 7.23917 0.983623 7.52399 0.953287 7.82852L0.66662 10.6085C0.65764 10.7062 0.67031 10.8046 0.703728 10.8968C0.737146 10.989 0.790488 11.0726 0.859954 11.1419C0.922247 11.2036 0.996124 11.2525 1.07735 11.2857C1.15857 11.3189 1.24555 11.3357 1.33329 11.3352H1.39329L4.17329 11.0819C4.47782 11.0515 4.76264 10.9173 4.97995 10.7019L10.98 4.70186C11.2128 4.45584 11.3387 4.12753 11.3299 3.78888C11.3212 3.45023 11.1786 3.12886 10.9333 2.89519ZM4.05329 9.74852L2.05329 9.93519L2.23329 7.93519L5.99995 4.21519L7.79995 6.01519L4.05329 9.74852ZM8.66662 5.12186L6.87995 3.33519L8.17995 2.00186L9.99995 3.82186L8.66662 5.12186Z" fill="#03749C" />
                                </svg>
                            </a>

                    </div>
                    <div class="order-item row">
                        <div class="col-md-6" style="text-align: left">
                            <span class="page-title ">法人/個人</span>
                        </div>
                        <div class="col-md-6 order-item-detail">
                            <span class="page-title">{{ $user_type[$address->type] }}</span>
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-6" style="text-align: left">
                            <span class="page-title ">名前</span>
                        </div>
                        <div class="col-md-6 order-item-detail">
                            <span class="page-title">{{ $address->full_name }}</span>
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-6" style="text-align: left">
                            <span class="page-title ">電話番号</span>
                        </div>
                        <div class="col-md-6 order-item-detail">
                            <span class="page-title">{{ $address->tel }}</span>
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-6">
                            <span class="page-title">携帯電話番号</span>
                        </div>
                        <div class="col-md-6 order-item-detail">
                            <span class="page-title ">{{ $address->mobile }}</span>
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-6">
                            <span class="page-title">メールアドレス</span> 
                        </div>
                        <div class="col-md-6 order-item-detail">
                            <span class="page-title">{{ $address->email }}</span>
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-6">
                            <span class="page-title">住所</span>
                        </div>
                        <div class="col-md-6 order-item-detail">
                            <span class="page-title">{{ '〒'.$address->zipcode.$address->address1 . $address->address2 . $address->address3 }}</span>
                        </div>
                    </div>
                    @if($address->type == 1)
                    <div class="order-item row">
                        <div class="col-md-6">
                            <span class="page-title">会社名</span>
                        </div>
                        <div class="col-md-6 order-item-detail">
                            <span class="page-title">{{ $address->company_name }}</span>
                        </div>
                    </div>
                    <div class="order-item row">
                        <div class="col-md-6">
                            <span class="page-title">部署名</span>
                        </div>
                        <div class="col-md-6 order-item-detail">
                            <span class="page-title">{{ $address->department_name }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <form id="form-order" method="post" action="/service/register">
            {{ csrf_field() }}
            <input type="text" id="account_id" name="account_id" value="{{ $account_id }}" hidden>
            <input type="text" id="address" name="address_id" value="{{ $address->id }}" hidden>
            <input type="text" id="method" name="method" value="2" hidden>
            <input type="text" id="fix" name="fix" value="{{ @$fix }}" hidden>
            
            <div class="form-group my-form-check mb-0">
                <div class="regular-checkbox-group">
                    <input class="regular-checkbox" type="checkbox" value="" id="accept">
                    <span class="checkmark"></span>
                </div>
                <label class="form-check-label order-page" for="accept">
                    <a class="text-link">上記内容が間違いなく、発注と同時に、決済されることに同意</a>
                </label>
            </div>
            <div class="upload-button m-4">
                <button class="btn custom-btn btn-default back">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black" />
                        <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z" stroke="black" stroke-width="2" />
                    </svg>
                    戻る
                </button>
                <button id="complete" class="btn custom-btn btn-primary" disabled style="width: 300px;">
                    申し込む
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.5" cy="12" r="11.5" stroke="black" />
                        <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@if (isset($error) && $error)
@include('user.modal.error_modal')
<script>
    $("#modal-error .notification-title").html(
        "後払いの登録が失敗しました。"
    );
    $("#modal-error .notification-body").html(
        "請求先情報をご確認・ご修正の上、再度送信お願いします。"
    );
    $('#modal-error').modal('show');
</script>
@endif
<script src="{{ asset('/user/js/service.js')}} "></script>
@endsection
