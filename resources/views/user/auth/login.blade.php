@extends('user.layouts.layout')

@section('title','ログイン')
@section('right-header-img')
    <img src="{{ asset('user/images/login-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Log in</h4>
                <h1 class="section-sub-title">ログイン</h1>

                <div class="justify-content-center align-items-center d-flex">
                    <form class="form-normal login" action="/login" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-4 col-12">
                                <label class="col-form-label">ID</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <input type="text" maxlength="255" class="form-control" name="email"
                                       value="{{ old('email') }}">
                                @error('email')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-4 col-12">
                                <label class="col-form-label">パスワード</label>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="password-input">
                                    <input type="password" maxlength="32" class="form-control" name="password">
                                    <i class="fas fa-eye password-icon"></i>
                                </div>
                                @error('password')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn-common btn-yellow">ログイン <i class="far fa-arrow-alt-circle-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="text-center mt-4 mb-2">> パスワードを忘れた方は<a href="/password/forgot" class="text-common">こちら</a>
                </div>
                <div class="text-center mb-4">> 初めての方は<a href="/register" class="text-common">こちら</a>から新規会員登録</div>
            </div>
        </div>
        <div class="left-contact-bg">
            <img src="{{ asset('/user/images/left-contact-bg.png') }}">
        </div>
    </div>
    @if(session()->has('error'))
        @include('user.modal.notification_modal',[
      'title' => 'ログイン失敗しました。',
      'body' =>  session()->get('error'),
      'type' => 'error'
  ])
        <input type="hidden" id="notification" value="1">
    @endif
@endsection

