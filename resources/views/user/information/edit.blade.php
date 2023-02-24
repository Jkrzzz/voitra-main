@extends('user.layouts.user_layout')
@section('title','ユーザー情報編集')
@section('style')
    <link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
@endsection
@section('content')
    <div class="main-content">
        <p class="breadcrumb-common">ユーザー情報 <span>></span> 情報編集</p>
        <h4 class="information-title">ユーザー情報</h4>

        <div class="information-box">
            <div class="row information-sub-header">
                <div class="col-md-6 col-6">
                    <h4 class="information-sub-title">ログイン情報</h4>
                </div>
            </div>
            <div class="row info-row top">
                <div class="col-md-2 col-12">
                    <p class="information-field">メールアドレス</p>
                </div>
                <div class="col-md-10 col-12">
                    <p class="information-content">{{ $user->email ? : '-' }}</p>
                </div>
            </div>
            <div class="row info-row mb-0 ">
                <div class="col-md-2 col-12">
                    <p class="information-field">パスワード</p>
                </div>
                <div class="col-md-5 col-12">
                    <div class="information-content password">
                        <img src="{{ asset('/user/images/password-dot.svg') }}">
                    </div>
                </div>
                <div class="col-md-5 col-12 col-change-password">
                    <a href="/info/change-password">
                        <button class="btn-change-password">パスワード変更 <img
                                src="{{ asset('/user/images/icon-lock.svg') }}">
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <form action="/info/edit" method="post">
            <div class="information-box edit">

                @csrf
                <div class="row information-sub-header">
                    <div class="col-md-6 col-12">
                        <h4 class="information-sub-title">個人情報</h4>
                    </div>
                    <div class="col-md-6 col-12 text-right group-btn-info">
                        <button type="button" class="btn-secondary-info mr-3" id="back">キャンセル <img
                                src="{{ asset('/user/images/icon-enter.png') }}">
                        </button>
                        <button type="submit" class="btn-primary-info">保存 <img
                                src="{{ asset('/user/images/icon-done.png') }}">
                        </button>
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">名前</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <input type="text" maxlength="255" name="name" class="form-control"
                               value="{{ old('name', $user->name) }}">
                        @error('name')
                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">フリガナ</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <input type="text" maxlength="255" name="furigana_name" class="form-control"
                               value="{{ old('furigana_name', $user->furigana_name) }}">
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">電話番号</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <input type="text" maxlength="255" name="phone_number" class="form-control"
                               value="{{ old('phone_number', $user->phone_number) }}">
                        @error('phone_number')
                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">利用言語</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <div class="select-input">
                            <select class="form-control" name="language">
                                <option value=""></option>
                                @foreach($languageConst as $key => $language)
                                    <option
                                        {{ old('language',$user->language) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $language }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">性別</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <div class="select-input">
                            <select class="form-control" name="gender">
                                <option value=""></option>
                                @foreach($genderConst as $key => $gender)
                                    <option
                                        {{ old('gender',$user->gender) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $gender }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row info-row mb-0">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">生年月日</p>
                    </div>
                    <div class="col-md-10 col-12">
                        @if(!old('date_of_birth', $user->date_of_birth))
                            <div class="date-input">
                                <input type="date" name="date_of_birth" class="form-control"
                                       value="">
                            </div>
                        @else
                            <div class="date-input">
                                <input type="date" name="date_of_birth" class="form-control"
                                       value="{{ date('Y-m-d', strtotime($user->date_of_birth)) }}">
                            </div>
                        @endif

                        @error('date_of_birth')
                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="information-box edit">
                @csrf
                <div class="row information-sub-header">
                    <div class="col-md-6 col-12">
                        <h4 class="information-sub-title">法人情報</h4>
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">会社名</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <input type="text" maxlength="255" name="company_name" class="form-control"
                               value="{{ old('company_name', $user->company_name) }}">
                        @error('company_name')
                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">業種</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <div class="select-input">
                            <select class="form-control" name="industry">
                                <option value=""></option>
                                @foreach($industryConst as $key => $industry)
                                    <option
                                        {{ old('industry',$user->industry) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $industry }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">会社住所</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <input type="text" maxlength="255" name="address" class="form-control"
                               value="{{ old('address', $user->address) }}">
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">会社電話番号</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <input type="text" maxlength="255" name="company_phone_number" class="form-control"
                               value="{{ old('company_phone_number', $user->company_phone_number) }}">
                        @error('company_phone_number')
                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="row info-row">
                    <div class="col-md-2 col-12">
                        <p class="information-field edit">担当部署</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <input type="text" maxlength="255" name="department" class="form-control"
                               value="{{ old('department', $user->department) }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('user.modal.confirm_back_modal',[
    'title' => 'ユーザー情報編集',
    'body' => 'ユーザー情報の編集をキャンセルします。よろしいでしょうか？',
    'link' => '/info'
])

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#back').click(function () {
                $('#confirm_back_modal').modal('show')
            })
        })
    </script>
@endsection
