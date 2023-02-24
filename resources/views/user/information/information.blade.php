@extends('user.layouts.user_layout')
@section('title','ユーザー情報')
@section('style')
    <link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
@endsection
@section('content')
    <div class="main-content">
        <p class="breadcrumb-common">ユーザー情報</p>
        <h4 class="information-title">ユーザー情報</h4>

        <div class="information-box">
            <div class="row information-sub-header">
                <div class="col-md-6 col-6">
                    <h4 class="information-sub-title">ログイン情報</h4>
                </div>
            </div>
            <div class="row info-row top">
                <div class="col-md-2 col-12">
                    <p class="information-field">メールアドレス</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->email ? : '-' }}</p>
                </div>
            </div>
            <div class="row info-row mb-0 ">
                <div class="col-md-2 col-12">
                    <p class="information-field">パスワード</p>
                </div>
                <div class="col-md-5 col-12">
                    <div class="information-content password">
                        <img src="{{ asset('/user/images/password-dot.svg') }}">
                    </div>
                </div>
                <div class="col-md-5 col-12 col-change-password">
                    <a href="/info/change-password">
                        <button class="btn-change-password">パスワード変更 <img
                                src="{{ asset('/user/images/icon-lock.svg') }}">
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="information-box">
            <div class="row information-sub-header">
                <div class="col-md-6 col-6">
                    <h4 class="information-sub-title">個人情報</h4>
                </div>
                <div class="col-md-6 col-6 text-right">
                    <a href="/info/edit">
                        <button class="btn-primary-info">編集 <img src="{{ asset('/user/images/icon-edit.png') }}">
                        </button>
                    </a>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">名前</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{$user->name ? : '-'}}</p>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">フリガナ</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->furigana_name ? : '-' }}</p>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">電話番号</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{$user->phone_number ? : '-' }}</p>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">利用言語</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->language ?  $languageConst[$user->language] : '-' }}</p>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">性別</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->gender ? $genderConst[$user->gender] : '-' }}</p>
                </div>
            </div>
            <div class="row info-row mb-0">
                <div class="col-md-2 col-12">
                    <p class="information-field">生年月日</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->date_of_birth ? date('Y-m-d', strtotime(old('date_of_birth',$user->date_of_birth))) : '-' }}</p>
                </div>
            </div>
        </div>

        <div class="information-box">
            <div class="row information-sub-header">
                <div class="col-md-6 col-6">
                    <h4 class="information-sub-title">法人情報</h4>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">会社名</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->company_name? : '-'}}</p>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">業種</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->industry ? $industryConst[$user->industry]  : '-' }}</p>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">会社住所</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->address ? : '-' }}</p>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">会社電話番号</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{$user->company_phone_number ? : '-' }}</p>
                </div>
            </div>
            <div class="row info-row">
                <div class="col-md-2 col-12">
                    <p class="information-field">担当部署</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->department ? : '-' }}</p>
                </div>
            </div>
        </div>
        <div class="information-box remove-link">
            @if($isRegisterService)
                <a href="/remove-service" class="text-right"><p class="text-link-info mb-1">オプション解除</p></a>
            @endif
            <a href="/remove-member" class="text-right"><p class="text-link-info">Voitra 退会</p></a>
        </div>
    </div>
@endsection

