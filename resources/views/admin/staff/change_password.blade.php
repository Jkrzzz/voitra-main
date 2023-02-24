@php
    $isAdmin = \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1;
@endphp
@extends('admin.layouts.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    スタッフパスワード変更
                </div>
                <form class="form" method="post"
                      action="{{ $isAdmin ? '/admin/staffs/' . $staff->id . '/change-password' : '/admin/information/change-password'}}">
                    @csrf
                    <div class="card-body">
                        @if(!$isAdmin && session()->has('error'))
                        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
                        @endif
                        <div class="row">
                            @if(!$isAdmin)
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="current_password">現在パスワード</label>
                                        <input class="form-control" name="current_password" id="current_password"
                                               type="password"
                                               maxlength="255" value="">
                                        @error('current_password')
                                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="password">新パスワード</label>
                                        <input class="form-control" name="password" id="password" type="password"
                                               maxlength="255" value="">
                                        @error('password')
                                        <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                @if(!$isAdmin)
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="confirm_password">新パスワード（確認用）</label>
                                            <input class="form-control" name="confirm_password" id="confirm_password"
                                                   type="password"
                                                   maxlength="255" value="">
                                            @error('confirm_password')
                                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    条件<br>
                                    ・8文字以上<br>
                                    ・数字・大文字・小文字・記号それぞれ1つ以上<br>
                                    ・入力可能な記号：@$!%*#?&^._
                                </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ $isAdmin ? '/admin/staffs/' . $staff->id . '/edit' : '/admin/information'}}">
                            <button type="button" class="btn btn-common-outline">戻る</button>
                        </a>
                        <button type="button" class="btn btn-common" id="submit">保存</button>
                    </div>
                    @include('admin.modal.confirm',[
    'title' => 'パスワードを変更する？',
    'content' => 'パスワードを変更してもよろしいでしょうか。',
    'icon' => 'lock'
])

                </form>
            </div>
        </div>
    </div>
@endsection
