<html lang="en" style="height: 100%">
<head>
    <title>会員登録確認｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）</title>
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
            <h1 class="section-sub-title">会員登録</h1>
            <div class="align-items-center d-flex justify-content-center">
                <form class="form-normal" method="post" action="/register">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label">法人/個人</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <label class="col-form-label confirm">{{ $userType[$user->userType] }}</label>
                            <input type="hidden" name="userType" value="{{ $user->userType }}">
                        </div>
                    </div>
                    @if($user->company_name)
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">会社名</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <label class="col-form-label confirm">{{ $user->company_name }}</label>
                                <input type="hidden" name="company_name" value="{{ $user->company_name }}">
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label">名前</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <label class="col-form-label confirm">{{ $user->name }}</label>
                            <input type="hidden" name="name" value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label">{{$user->userType == 1 ? '会社電話番号' : '電話番号'}}</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <label class="col-form-label confirm">{{ $user->phone_number }}</label>
                            <input type="hidden" name="phone_number" value="{{ $user->phone_number }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label">メールアドレス</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <label class="col-form-label confirm">{{ $user->email }}</label>
                            <input type="hidden" name="email" value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label">パスワード</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <label class="col-form-label confirm">{{ $user->confirmPassword }}</label>
                            <input type="hidden" name="password" value="{{ $user->password }}">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" id="back" class="btn-common btn-white group"><i
                                class="far fa-arrow-alt-circle-left back"></i> 戻る
                        </button>
                        <button id="submit" class="btn-common btn-yellow group">登録 <i
                                class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <img class="signup-box-layout" src="{{ asset('/user/images/signup-box-layout.png') }}">
    </div>
    <img class="signup-layout-left" src="{{ asset('/user/images/signup-layout-left.png') }}">
    <img class="signup-layout-right" src="{{ asset('/user/images/signup-layout-right.png') }}">
</div>
@include('user.modal.confirm_back_modal',[
    'title' => '会員登録キャンセル',
    'body' => '会員登録をキャンセルします。よろしいでしょうか？',
    'link' => '/register'
])
<script src="{{ asset('/user/js/main.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#back').click(function () {
            $('#confirm_back_modal').modal('show')
        })
    })
</script>
</body>
</html>

