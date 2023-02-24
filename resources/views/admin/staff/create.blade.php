@extends('admin.layouts.layout')
@section('style')
    <style>
        @error('password')
        .password-error {
            color: #FF0000;
        }
        @enderror
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    新スタッフ
                </div>
                <form class="form" method="post" action="/admin/staffs">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff_id">スタッフID</label>
                                    <input class="form-control" name="staff_id" id="staff_id" type="text"
                                           maxlength="50" value="{{ old('staff_id') }}">
                                    @error('staff_id')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">スタッフ名</label>
                                    <input class="form-control" id="name" name="name" type="text" maxlength="255" value="{{ old('name') }}">
                                    @error('name')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">メールアドレス</label>
                                    <input class="form-control" id="email" name="email" type="text" maxlength="255" value="{{ old('email') }}">
                                    @error('email')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">パスワード</label>
                                    <input style="background-color: #fff" class="form-control" id="password" name="password" type="password"
                                           maxlength="255" value="{{ old('password') }}" readonly onfocus="this.removeAttribute('readonly');">
                                </div>
                                <div class="form-group">
                                    <div class="password-error">
                                        条件<br>
                                        ・8文字以上<br>
                                        ・数字・大文字・小文字・記号それぞれ1つ以上<br>
                                        ・入力可能な記号：@$!%*#?&^._
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="/admin/staffs">
                            <button type="button" class="btn  btn-common-outline">戻る</button>
                        </a>
                        <button type="button" class="btn btn-common" id="submit">作成</button>
                    </div>
                    @include('admin.modal.confirm',[
    'title' => '新スタッフ作成',
    'content' => '新スタッフのアカウントを作成します。よろしいでしょうか？'
])

                </form>
            </div>
        </div>
    </div>
@endsection
