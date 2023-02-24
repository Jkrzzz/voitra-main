<html lang="en" style="height: 100%">
<head>
    @if($isSuccess)
        <title>本登録完了｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）</title>
    @else
        <title>登録エラー｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）</title>
    @endif
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
            <h1 class="section-sub-title">{{ $isSuccess ? '本登録完了' : '登録エラー'}}</h1>

            <div class="text-center">
                @if($isSuccess)
                    <img src="{{ asset('/user/images/icon-success.png') }}">
                @else
                    <img src="{{ asset('/user/images/icon-error.png') }}">
                @endif

                <div class="d-flex justify-content-center">
                    <div class="message-text">
                        @if($isSuccess)
                            <p>ご登録いただきありがとうございます。</p>
                            <p>本登録が完了いたしました。</p>
                            <p class="mt-3">下記のリンクよりマイページにお進みください。</p>
                        @else
                            <p>本登録用の確認URLを再発行してください。</p>
                        @endif
                    </div>
                </div>
                @if($isSuccess)
                    <a href="/">
                        <button class="btn-common submit btn-yellow">マイページへ <i
                                class="far fa-arrow-alt-circle-right"></i>
                        </button>
                    </a>
                @else
                    <form method="post" action="/register/resend">
                        @csrf
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <button class="btn-common submit btn-yellow">再発行 <i class="far fa-arrow-alt-circle-right"></i>
                        </button>
                    </form>
                @endif
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

