@extends('user.layouts.layout')

@section('title','パスワード更新完了')
@section('right-header-img')
    <img src="{{ asset('/user/images/reset-password-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Reset Password</h4>
                <h1 class="section-sub-title">新規パスワード登録完了</h1>
                <div class="text-center">
                    <img src="{{ asset('/user/images/icon-success.png') }}">
                    <div class="d-flex justify-content-center">
                        <div class="message-text">
                            <p>新しいパスワードが設定されました。</p>
                            <p>再度ログイン画面よりログインしてください。。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="left-contact-bg">
            <img src="{{ asset('/user/images/left-contact-bg.png') }}">
        </div>
    </div>
@endsection
