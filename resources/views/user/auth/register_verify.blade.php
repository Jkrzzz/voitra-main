<html lang="en" style="height: 100%">
<head>
    <title>仮会員登録完了｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）</title>
    @include('user.layouts.meta')
</head>
<body style="min-height: 100%">
<div class="register-page">
    <div class="logo-top">
        <a href="/"><img src="{{ asset('/user/images/logo-white.png') }}"></a>
    </div>
    <div class="register-box section">
        <div class="container">
            <h4 class="section-title">Sign up</h4>
            <h1 class="section-sub-title">仮登録完了</h1>

            <div class="text-center">
                <img src="{{ asset('/user/images/icon-mail.png') }}">
                <div class="d-flex justify-content-center">
                    <div class="message-text">
                        <p>まだ会員登録は完了しておりません。<br>
                        <p class="text-common">{{$user->email}}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <div class="sub-message-text">
                        <p>に承認のメールをお送りいたしましたのでご確認ください。</p>
                        <p>ご本人様確認のため、メールに記載のURLより「24時間以内」にアクセスし</p>
                        <p>アカウントの本登録を完了させて下さい。</p>
                    </div>
                </div>
            </div>

        </div>
        <img class="signup-box-layout" src="{{ asset('/user/images/signup-box-layout.png') }}">
    </div>
    <img class="signup-layout-left" src="{{ asset('/user/images/signup-layout-left.png') }}">
    <img class="signup-layout-right" src="{{ asset('/user/images/signup-layout-right.png') }}">
</div>
<script src="{{ asset('/user/js/main.js') }}"></script>
</body>
</html>

