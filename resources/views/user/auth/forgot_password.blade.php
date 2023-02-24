@extends('user.layouts.layout')

@section('title','パスワード再発行')
@section('right-header-img')
    <img src="{{ asset('/user/images/reset-password-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Reset Password</h4>
                <h1 class="section-sub-title">パスワードの再発行</h1>

                <p class="reset-password-guild">登録されたメールアドレスを入力後、<br>
                    「パスワードを再発行」ボタンを押してください。</p>
                <div class="justify-content-center align-items-center d-flex">
                    <form class="form-normal login" action="/password/forgot" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4 col-12">
                                <label class="col-form-label">メールアドレス</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" maxlength="255" class="form-control" name="email"
                                       value="{{ old('email') }}">
                                @error('email')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn-common btn-yellow">パスワードの再発行 <i class="far fa-arrow-alt-circle-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="left-contact-bg">
            <img src="{{ asset('/user/images/left-contact-bg.png') }}">
        </div>
    </div>
    @if(session()->has('error'))
        @include('user.modal.notification_modal',[
    'title' => 'パスワード再発行エラー',
    'body' =>  session()->get('error'),
    'type' => 'password'
   ])
        <input type="hidden" id="notification" value="1">
    @endif
@endsection
