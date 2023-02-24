@extends('user.layouts.layout')

@section('title','パスワード再発行メール送信')
@section('right-header-img')
    <img src="{{ asset('/user/images/reset-password-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Reset Password</h4>
                <h1 class="section-sub-title">パスワードの再発行</h1>
                <div class="text-center">
                    <img src="{{ asset('/user/images/icon-mail.png') }}">
                    <div class="d-flex justify-content-center">
                        <div class="message-text">
                            <p>登録されたメールアドレスにパスワードの再設定用のURLを<br>送信いたしました。</p>
                            <p>URLにアクセスして新しいパスワードを設定してください。</p>
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
