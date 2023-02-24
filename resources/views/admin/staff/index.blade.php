@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <i class="fas fa-filter"></i>スタッフ検索
                    </div>
                </div>
                <form class="form-filter" method="get" action="/admin/staffs">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="staff_name">スタッフ名</label>
                                    <input class="form-control" id="staff_name" name="staff_name" type="text"
                                           placeholder="" value="{{ $staff_name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="staff_id">スタッフID</label>
                                    <input class="form-control" id="staff_id" name="staff_id" type="text"
                                           placeholder="" value="{{ $staff_id }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">ステータス</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">すべて</option>
                                        @foreach($statusConst as $key => $item)
                                            @if($key != 0 && $key != 3)
                                                <option
                                                    {{$key == $status ? 'selected' : ''}} value="{{ $key }}">{{ $item }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-common" type="submit"> 検索</button>
                        <a href="/admin/staffs">
                            <button class="btn btn-common-outline" id="reset" type="button">リセット</button>
                        </a>
                    </div>
                    <input type="hidden" name="order" value="{{$order}}">
                    <input type="hidden" name="order_by" value="{{$order_by}}">
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-align-justify"></i>スタッフ一覧
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="/admin/staffs/create">
                                <button class="btn btn-common">新スタッフ作成</button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body list-body">
                    @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">{{  session()->get('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                    @endif
                    <table class="table table-responsive-sm table-striped">
                        <thead>
                        <tr>
                            <th>スタッフID</th>
                            <th>スタッフ名</th>
                            <th>メールアドレス</th>
                            <th class="text-center has-order" order-by="total_order"
                                order="{{ $order_by == 'total_order' ? ($order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'}}">合計案件数
                                <i class="fas fa-long-arrow-alt-down {{ $order == 'DESC' && $order_by == 'total_order' ? 'active' : ''}}"></i>
                                <i class="fas fa-long-arrow-alt-up {{ $order == 'ASC' && $order_by == 'total_order' ? 'active' : ''}}"></i>
                            </th>
                            <th class="text-center has-order" order-by="total_order_processing"
                                order="{{ $order_by == 'total_order_processing' ? ($order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'}}">対応中案件数
                                <i class="fas fa-long-arrow-alt-down {{ $order == 'DESC' && $order_by == 'total_order_processing' ? 'active' : ''}}"></i>
                                <i class="fas fa-long-arrow-alt-up {{ $order == 'ASC' && $order_by == 'total_order_processing' ? 'active' : ''}}"></i>
                            </th>
                            <th class="text-center has-order" order-by="total_char_processing"
                                order="{{ $order_by == 'total_char_processing' ? ($order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'}}">対応中文字数合計
                                <i class="fas fa-long-arrow-alt-down {{ $order == 'DESC' && $order_by == 'total_char_processing' ? 'active' : ''}}"></i>
                                <i class="fas fa-long-arrow-alt-up {{ $order == 'ASC' && $order_by == 'total_char_processing' ? 'active' : ''}}"></i>
                            </th>
                            <th class="text-center">ステータス</th>
                            <th class="text-center">詳細</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($staffs as $staff)
                            <tr row-id="{{ $staff->id }}">
                                <td data-toggle="tooltip" data-placement="top" title="{{ $staff->staff_id }}">{{\Str::limit($staff->staff_id, 15, ' ...') }}</td>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td class="text-center">{{ $staff->total_order }}</td>
                                <td class="text-center">{{ $staff->total_order_processing }}</td>
                                <td class="text-center">{{ $staff->total_char_processing }}</td>
                                <td class="text-center {{ $staff->status == 1 ? 'color-success' : 'color-danger'}}">{{ @$statusConst[$staff->status] }}</td>
                                <td class="text-center action-td">
                                    <a href="/admin/staffs/{{$staff->id}}"><i
                                            class="fas fa-eye px-1 color-primary detail"></i></a>
                                    <a href="/admin/staffs/{{$staff->id}}/edit"><i
                                            class="fas fa-edit px-1 color-warning edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $staffs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="filter-staff-name" value="{{$staff_name}}">
    <input type="hidden" name="filter-staff-id" value="{{$staff_id}}">
    <input type="hidden" name="filter-status" value="{{$status}}">
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('.has-order').click(function () {
                const staff_name = $('input[name=filter-staff-name]').val()
                const staff_id = $('input[name=filter-staff-id]').val()
                const status = $('input[name=filter-status]').val()
                const order = $(this).attr('order')
                const order_by = $(this).attr('order-by')
                window.location.href = `/admin/staffs?staff_name=${staff_name}&staff_id=${staff_id}&status=${status}&order=${order}&order_by=${order_by}`
            })
        })
    </script>
@endsection
