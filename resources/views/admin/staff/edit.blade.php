@php
    $isAdmin = \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1;
@endphp
@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    @if($isAdmin)
                        スタッフ編集
                    @else
                        スタッフの情報
                    @endif
                </div>
                <form id="form" class="form" method="post"
                      action="{{ $isAdmin ? '/admin/staffs/' . $staff->id : '/admin/information' }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff_id">スタッフID</label>
                                    <input class="form-control" name="staff_id" id="staff_id" type="text"
                                           maxlength="255" value="{{ $staff->staff_id }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">スタッフ名</label>
                                    <input class="form-control" id="name" name="name" type="text" maxlength="255"
                                           value="{{ old('name', $staff->name) }}">
                                    @error('name')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">メールアドレス</label>
                                    <input class="form-control" id="email" name="email" type="text" maxlength="255"
                                           value="{{ $staff->email }}" disabled>
                                </div>
                            </div>
                            @if($isAdmin)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">ステータス</label>
                                        <select class="form-control" id="status" name="status">
                                            @foreach($statusConst as $key => $item)
                                                @if ($key == 1 || $key == 4)
                                                    <option {{$key == $staff->status ? 'selected' : ''}} value="{{ $key }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @else
                                <input type="hidden" name="status" id="status" value="{{ $staff->status }}">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="d-flex">
                                            <p class="total-text">合計案件数</p>
                                            <p>{{ $staff->total_order }}</p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="total-text">対応中案件数</p>
                                            <p>{{ $staff->total_order_processing }}</p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="total-text">対応中文字数合計</p>
                                            <p>{{$staff->total_char_processing}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <a href="{{ $isAdmin ? '/admin/staffs/' . $staff->id . '/change-password' : '/admin/information/change-password' }}">パスワード変更</a>
                            </div>
                        </div>
{{--                        <div class="row times">--}}
{{--                            <div class="col-md-12">--}}
{{--                                <p class="mb-0"><strong>登録時間:</strong> {{$staff->created_at}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="card-footer text-right">
                        @if($isAdmin)
                            <a href="/admin/staffs">
                                <button type="button" class="btn btn-common-outline">戻る</button>
                            </a>
                        @else
                            <a href="/admin/orders">
                                <button type="button" class="btn btn-common-outline">戻る</button>
                            </a>
                        @endif
                        <button type="button" class="btn btn-common" id="submit">保存</button>
                    </div>
                    <div class="modal fade info-modal" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                                        <i class="fas fa-times-circle "></i>
                                    </div>
                                    <img src="{{ asset('/user/images/info.png') }}">
                                    <h4 class="notification-title"></h4>
                                    <p class="notification-body">変更した内容を保存します。よろしいでしょうか？</p>
                                    <div class="text-center">
                                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                                            <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>いいえ</span>
                                        </button>
                                        <button type="button" id="confirmed" class="btn-primary-info group">
                                            <span id='text'>はい</span><i class="far fa-arrow-alt-circle-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade info-modal" id="check_staff" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <h4 class="notification-title"> 業務を担当しているスタッフです。</h4>
                    <p class="notification-body">このスタッフはタスクを担当しているため、「非活性」に変更することはできません。タスクを他のスタッフにアサインしてから変更してください。</p>
                    <div class="text-center">
                        <button type="button" class="btn-primary-info group"  data-dismiss="modal">
                            <span id='text'>OK</span><i class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="total_order_processing" value="{{ $staff->total_order_processing }}">
    <input type="hidden" name="last_status" value="{{ $staff->status }}">
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#confirmed').click(function (){
                const total_order_processing = $('input[name=total_order_processing]').val()
                const last_status = $('input[name=last_status]').val()
                if (total_order_processing > 0 && last_status != $('#status').val()){
                    $('#check_staff').modal('show')
                }
                $('#confirm_modal').modal('hide')
            })
            $('#submit').click(function (){
                const total_order_processing = $('input[name=total_order_processing]').val()
                const last_status = $('input[name=last_status]').val()
                if (total_order_processing == 0 || last_status == $('#status').val()){
                    $('#confirmed').attr('type','submit')
                }
            })
        })
    </script>
@endsection
