@extends('user.layouts.layout')

@section('title','新パスワード入力')
@section('right-header-img')
    <img src="{{ asset('user/images/reset-password-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Reset Password</h4>
                <h1 class="section-sub-title">パスワードの再発行</h1>

                <p class="reset-password-guild">新しいパスワードを設定してください。<br>
                    <span>英数字混合の8文字以上で登録してください。</span></p>
                <div class="justify-content-center align-items-center d-flex">
                    <form class="form-normal reset-password" action="/password/reset" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">新しいパスワード</label>
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
                        <div class="form-group row mb-0">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">新しいパスワード（確認）</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <div class="password-input">
                                    <input type="password" maxlength="32" class="form-control" name="password_confirm">
                                    <i class="fas fa-eye password-icon"></i>
                                </div>
                                @error('password_confirm')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn-common btn-yellow">パスワードの再発行 <i
                                    class="far fa-arrow-alt-circle-right"></i>
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



