@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    スタッフ詳細
                </div>
                <form method="post" action="/admin/staffs">
                    @csrf
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
                                    <input class="form-control" id="name" name="name" type="text"
                                           value="{{ $staff->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">メールアドレス</label>
                                    <input class="form-control" id="email" name="email" type="text" maxlength="255"
                                           value="{{ $staff->email }}" disabled>
                                </div>
                            </div>
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
                            <div class="col-md-6">
                                <a href="/admin/orders?staff_id={{$staff->id}}">
                                    <button type="button" class="btn btn-common-outline">スタッフの案件一覧</button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                       <div class="row">
                           <div class="col-md-12 text-right">
                               <a href="/admin/staffs">
                                   <button type="button" class="btn btn-common-outline">戻る</button>
                               </a>
                           </div>
                       </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
