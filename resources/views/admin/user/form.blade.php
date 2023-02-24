@extends('admin.layouts.layout')
@section('style')
<style>
    .memo-form {
        padding-top: 0rem !important;
    }
</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    ユーザ詳細
                </div>
                @if(session()->has('success'))
                    <div class="alert alert-success m-3" role="alert">{{  session()->get('success') }}</div>
                @endif
                <form class="form" method="post" action="/admin/users/{{$user->id}}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">メールアドレス</label>
                                    <input class="form-control" name="email" id="email" type="email" maxlength="255"
                                            value="{{ $user->email }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_name">会社名</label>
                                    <input class="form-control" name="company_name" id="company_name" type="text"
                                            maxlength="255" value="{{ $user->company_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">名前</label>
                                    <input class="form-control" name="name" id="name" type="text" maxlength="255"
                                            value="{{ $user->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="industry">業種</label>
                                    <select class="form-control" id="industry" name="industry" disabled>
                                        <option value=""></option>
                                        @foreach($industryConst as $key => $industry)
                                            <option
                                                {{$key == $user->industry ? 'selected' : ''}} value="{{ $key }}">{{ $industry }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="furigana_name">フリガナ</label>
                                    <input class="form-control" name="furigana_name" id="furigana_name" type="text"
                                            maxlength="255" value="{{ $user->furigana_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">会社住所</label>
                                    <input class="form-control" name="address" id="address" type="text"
                                            maxlength="255" value="{{ $user->address }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_number">電話番号</label>
                                    <input class="form-control" name="phone_number" id="phone_number" type="text"
                                            maxlength="255" value="{{ $user->phone_number }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company_phone_number">会社電話番号</label>
                                    <input class="form-control" name="company_phone_number"
                                            id="company_phone_number" type="text"
                                            maxlength="255" value="{{ $user->company_phone_number }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="language">利用言語</label>
                                    <select class="form-control" id="language" name="language" disabled>
                                        <option value=""></option>
                                        @foreach($languageConst as $key => $lang)
                                            <option
                                                {{$key == $user->language ? 'selected' : ''}} value="{{ $key }}">{{ $lang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">担当部署</label>
                                    <input class="form-control" name="department" id="department" type="text"
                                            value="{{ $user->department }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gender">性別</label>
                                    <select class="form-control" id="gender" name="gender" disabled>
                                        <option value=""></option>
                                        @foreach($genderConst as $key => $gender)
                                            <option
                                                {{$key == $user->gender ? 'selected' : ''}} value="{{ $key }}">{{ $gender }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_of_birth">生年月日</label>
                                    <input class="form-control" name="date_of_birth" id="date_of_birth" type="date"
                                            value="{{$user->date_of_birth ? date('Y-m-d', strtotime($user->date_of_birth)) : ''}}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="userType">法人/個人</label>
                                    <select class="form-control" id="userType" name="userType" disabled>
                                        @foreach($userTypeConst as $key => $type)
                                            <option
                                                {{$key == $user->type ? 'selected' : ''}} value="{{ $key }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">ステータス</label>
                                    @if($user->status == 0 || $user->status == 2)
                                        <select class="form-control" id="status" name="status" disabled>
                                            @foreach($statusConst as $key => $item)
                                                @if($key != 3)
                                                    <option
                                                        {{$key == $user->status ? 'selected' : ''}} {{ $key == 0 ? 'disabled' : ''}} value="{{ $key }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @else
                                        <select class="form-control" id="status" name="status" disabled>
                                            @foreach($statusConst as $key => $item)
                                                @if($key != 0 && $key != 3 && $key != 2)
                                                    <option
                                                        {{$key == $user->status ? 'selected' : ''}} {{ $key == 0 ? 'disabled' : '' }} value="{{ $key }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                @if($logged_in_admin->role == 1)
                                <div class="text-right">
                                    @if($user->status != 0 && $user->status != 2)
                                    <button type="button" class="btn btn-common" id="change-status">変更</button>
                                    <div id="status-btns">
                                        <button type="button" class="btn btn-common-outline" id="cancel-change-status">キャンセル</button>
                                        <button type="button" class="btn btn-common" id="submit">保存</button>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="last_login_at">最新のログイン</label>
                                    <input class="form-control" name="last_login_at" id="last_login_at" type="text"
                                            maxlength="255" value="{{ $user->last_login_at }}" disabled>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="row times">--}}
                        {{--                            <div class="col-md-12">--}}
                        {{--                                <p class="mb-0"><strong>登録時間:</strong> {{$user->created_at}}</p>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                    @include('admin.modal.confirm',[
                        'title' => '',
                        'content' => '変更した内容を保存します。よろしいでしょうか？'
                    ])
                </form>
                <form method="post" action="/admin/users/{{$user->id}}/memo">
                    @csrf
                    @method('PUT')
                    <div class="card-body memo-form">
                        <div class="form-group">
                            <label for="memo">メモ</label>
                            <textarea id="memo-text-area" class="form-control" name="memo" disabled
                                        style="min-height: 100px">{{ $user->memo }}</textarea>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-common" id="change-memo">編集</button>
                            <div id="memo-btns">
                                <button type="button" class="btn  btn-common-outline" id="cancel-change-memo">キャンセル</button>
                                <button type="button" class="btn btn-common" id="submit-memo">保存</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade info-modal" id="confirm_modal_memo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                                        <i class="fas fa-times-circle "></i>
                                    </div>
                                    @if(isset($icon) && $icon == 'lock')
                                        <img src="{{ asset('/user/images/icon-lock.png') }}">
                                    @else
                                    <img src="{{ asset('/user/images/info.png') }}">
                                    @endif
                                    <h4 class="notification-title"></h4>
                                    <p class="notification-body">変更した内容を保存します。よろしいでしょうか？</p>
                                    <div class="text-center">
                                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                                            <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>いいえ</span>
                                        </button>
                                        <button type="submit" id="confirmed" form-id="" class="btn-primary-info group">
                                            <span id='text'>はい </span><i class="far fa-arrow-alt-circle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-footer text-right">
                    <a href="/admin/users">
                        <button type="button" class="btn  btn-common-outline">戻る</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var defaultStatus = $('#status').val();
        var defaultMemo = $('#memo-text-area').val();
        $(document).ready(function () {
            $("#status-btns").hide();
            $("#memo-btns").hide();
        });
        $("#change-status").click(function (){
            $("#change-status").hide();
            $("#status-btns").show();
            $("#status").prop( "disabled", false );
        });
        $("#cancel-change-status").click(function () {
            $("#change-status").show();
            $("#status-btns").hide();
            $('#status').val(defaultStatus);
            $("#status").prop( "disabled", true );
        })
        $("#change-memo").click(function (){
            $("#change-memo").hide();
            $("#memo-btns").show();
            $("#memo-text-area").prop( "disabled", false );
        });
        $("#cancel-change-memo").click(function () {
            $('#memo-text-area').val(defaultMemo);
            $("#change-memo").show();
            $("#memo-btns").hide();
            $("#memo-text-area").prop( "disabled", true );
        })
        $('#submit-memo').click(function (){
            $('#confirm_modal_memo').modal('show')
        })
    </script>
@endsection
