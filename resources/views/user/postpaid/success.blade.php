@extends('user.layouts.upload_layout')
@section('title','決済完了')
@section('content')
<div class="main-content">
    <div class="upload-container">
        <div class="block">
            <div class="block-content">
                <div class="text-center">
                    <div class="success-icon">
                        <svg width="24" height="21" viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.2279 1.60267C20.6389 1.18786 21.1973 0.952603 21.7812 0.948302C22.3651 0.944001 22.927 1.17101 23.344 1.57972C23.761 1.98843 23.9993 2.5456 24.0068 3.12947C24.0143 3.71334 23.7903 4.27642 23.3839 4.69567L11.6239 19.3972C11.4219 19.6147 11.1781 19.7893 10.9071 19.9105C10.6361 20.0317 10.3434 20.097 10.0466 20.1026C9.74982 20.1082 9.45492 20.054 9.17955 19.9431C8.90417 19.8322 8.65397 19.6669 8.44389 19.4572L0.646886 11.6632C0.232551 11.2486 -0.000140589 10.6865 6.37267e-08 10.1004C0.000140716 9.51429 0.233102 8.95226 0.647636 8.53792C1.06217 8.12359 1.62432 7.89089 2.21042 7.89104C2.79651 7.89118 3.35855 8.12414 3.77289 8.53867L9.93939 14.7067L20.1694 1.67167C20.188 1.64795 20.208 1.62541 20.2294 1.60417L20.2279 1.60267Z" fill="url(#paint0_linear)" />
                            <defs>
                                <linearGradient id="paint0_linear" x1="18.2614" y1="7.02139" x2="3.13094" y2="15.3692" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FED450" />
                                    <stop offset="0.635417" stop-color="#FFB305" />
                                    <stop offset="1" stop-color="#FF7A1B" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <div class="box-header">
                    <span class="title">{{ @$type ? ' 請求先を編集しました。' : '請求先を登録しました。' }}</span>
                </div>
            </div>
        </div>
        <div class="upload-button">
            <a class="btn custom-btn btn-primary" href="/address/management">
                請求先情報画面に戻る
                <svg width="25" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                    <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection
