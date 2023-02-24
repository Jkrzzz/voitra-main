@extends('user.layouts.user_layout')
@section('title','パスワード変更')
@section('style')
    <link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
@endsection
@section('content')
    <div class="main-content">
        <p class="breadcrumb-common">ユーザー情報 <span>></span> パスワード変更</p>
        <h4 class="information-title">パスワード変更</h4>


        <div class="information-box edit">
            <form id="form" action="/info/change-password" method="post">
                @csrf
                <div class="row information-sub-header">
                    <div class="col-md-6 col-12">
                        <h4 class="information-sub-title">個人情報</h4>
                    </div>
                    <div class="col-md-6 col-12 text-right group-btn-info">
                        <a href="/info">
                            <button type="button" class="btn-secondary-info mr-3">キャンセル <img
                                    src="{{ asset('/user/images/icon-enter.png') }}">
                            </button>
                        </a>
                        <button id="submit" type="button" class="btn-primary-info">保存 <img
                                src="{{ asset('/user/images/icon-done.png') }}">
                        </button>
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-3 col-12">
                        <p class="information-field edit">現在パスワード</p>
                    </div>
                    <div class="col-md-9 col-12">
                        <div class="password-input information">
                            <input type="password" maxlength="32" name="current_password" class="form-control"
                                   value="{{ old('current_password') }}">
                            <i class="fas fa-eye password-icon"></i>
                        </div>
                        @error('current_password')
                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-3 col-12">
                        <p class="information-field edit">新パスワード</p>
                    </div>
                    <div class="col-md-9 col-12">
                        <div class="password-input information">
                            <input type="password" maxlength="32" name="new_password" class="form-control"
                                   value="{{ old('new_password') }}">
                            <i class="fas fa-eye password-icon"></i>
                        </div>
                        @error('new_password')
                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-3 col-12">
                        <p class="information-field edit">新パスワード（確認用）</p>
                    </div>
                    <div class="col-md-9 col-12">
                        <div class="password-input information">
                            <input type="password" maxlength="32" name="confirm_password" class="form-control"
                                   value="{{ old('confirm_password') }}">
                            <i class="fas fa-eye password-icon"></i>
                        </div>
                        @error('confirm_password')
                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                @include('user.modal.confirm_change_password_modal')
            </form>
        </div>

    </div>

    @if(session()->has('error'))
        @include('user.modal.change_password_error',[
   'title' => 'パスワード変更エラー',
   'body' =>  session()->get('error')
  ])
        <input type="hidden" id="error" value="1">
    @endif
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#submit').click(function () {
                $('#confirm_change_password_modal').modal('show')
            });
            if ($('#error').val() !== undefined) {
                $('#change_password_error').modal('show')
            }
            $('.password-input .password-icon').click(function (){
                if ( $(this).prev().attr('type') === 'password'){
                    $(this).prev().attr('type','text')
                    $(this).attr('class', 'fas fa-eye-slash password-icon')
                } else {
                    $(this).prev().attr('type','password')
                    $(this).attr('class', 'fas fa-eye password-icon')
                }
            })
        })
    </script>
@endsection
