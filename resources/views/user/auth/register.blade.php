<html lang="en" style="height: 100%">
<head>
    <title>会員登録｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）</title>
    @include('user.layouts.meta')
</head>
<body style="min-height: 100%">
<div class="register-page">
    <div class="logo-top">
        <a href="/"><img src="{{ asset('/user/images/logo-white.png') }}"></a>
    </div>
    <div class="register-box section">
        <div class="container signup-container">
            <h4 class="section-title">Sign up</h4>
            <h1 class="section-sub-title">会員登録</h1>
            <div class="align-items-center d-flex justify-content-center">
                <form class="form-normal" method="post" action="/register-confirm?selectType={{$selectType}}">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label required">法人/個人</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="select-input">
                                <select name="type" class="form-control" id="type">
                                    <option selected value="">選択して下さい</option>
                                    @foreach($userType as $key => $type)
                                        <option
                                            {{ old('type', $selectType) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @error('type')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    @if($selectType == 1)
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label required">会社名</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <input type="text" maxlength="255" class="form-control" name="company_name" placeholder="株式会社ボイトラ"
                                       value="{{ old('company_name') }}">
                                @error('company_name')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label required">名前</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="text" maxlength="255" class="form-control" name="name" placeholder="音声　太郎"
                                   value="{{ old('name') }}">
                            @error('name')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label">{{$selectType == 1 ? '会社電話番号' : '電話番号'}}</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="text" maxlength="255" class="form-control" name="phone_number" placeholder="09012345678"
                                   value="{{ old('phone_number') }}">
                            @error('phone_number')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label required">メールアドレス</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="text" maxlength="255" class="form-control" name="email" placeholder="voice@voitra.jp"
                                   value="{{ old('email') }}">
                            @error('email')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12">
                            <label class="col-form-label required">パスワード</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="password-input">
                                <input type="password" maxlength="32" class="form-control" name="password">
                                <i class="fas fa-eye password-icon"></i>
                            </div>
                            @error('password')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group my-form-check mb-0">
                        <div class="regular-checkbox-group">
                            <input class="regular-checkbox" type="checkbox" value="" id="accept">
                            <span class="checkmark"></span>
                        </div>
                        <label class="form-check-label" for="accept">
                            <a class="text-link" href="/home/terms.php " target="_blank">利用規約</a>と<a class="text-link"
                                                                                    href="/home/privacy.php" target="_blank">プライバシーポリシー</a>に同意します。
                        </label>
                    </div>
                    <div class="text-center">
                        <button id="submit" class="btn-common btn-yellow submit" disabled>確認 <i
                                class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </form>
            </div>
            <div class="text-center my-4">> 既に登録済みの方は<a href="/login" class="text-common">こちら</a>からログイン</div>
            <div class="register-link text-center"><a href="/home/terms.php " target="_blank">規約</a>｜<a
                    href="/home/privacy.php" target="_blank">プライバシー</a>
            </div>
        </div>
        <img class="signup-box-layout" src="{{ asset('/user/images/signup-box-layout.png') }}">
    </div>
    <img class="signup-layout-left" src="{{ asset('/user/images/signup-layout-left.png') }}">
    <img class="signup-layout-right" src="{{ asset('/user/images/signup-layout-right.png') }}">
</div>
<script src="{{ asset('/user/js/main.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#type').change(function () {
            if ($(this).val() == 1) {
                window.location.href = '/register?selectType=1'
            } else if($(this).val() == 2) {
                window.location.href = '/register?selectType=2'
            }
        })
        if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
            location.reload();
        }
    })
</script>

</body>
</html>

