@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-align-justify"></i> クーポン一覧
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="/admin/coupons/create">
                                <button class="btn btn-common">新規クーポン作成</button>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body list-body">
                    {{-- @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">{{  session()->get('success') }}</div>
                    @endif --}}
                    {{-- @if($errors->any())
                        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                    @endif --}}
                    <table class="table table-responsive-sm table-striped">
                        <thead>
                        <tr>
                            <th>コード</th>
                            <th>クーポン名</th>
                            <th>金額</th>
                            <th>発行枚数</th>
                            <th>発行残枚数</th>
                            <th>種類</th>
                            <th>ステータス</th>
                            <th>開始日</th>
                            <th>終了日</th>
                            <th class="text-center">詳細</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons as $coupon)
                            <tr row-id="{{ $coupon->id }}">
                                <td>{{ $coupon->code }}</td>
                                <td data-toggle="tooltip" data-placement="top" title="{{$coupon->name}}">{{  \Illuminate\Support\Str::limit($coupon->name, 20, $end='...')}}</td>
                                <td>{{ $coupon->discount_amount }}</td>
                                <td>{{ $coupon->quantity }}</td>
                                <td>{{ $coupon->remaining_quantity }}</td>
                                <td>{{ $coupon->is_private ? 'プライベート' : 'グローバル' }}</td>
                                <td>{{ @$couponStatusConst[$coupon->status] }}</td>
                                <td>{{ $coupon->start_at }}</td>
                                <td>{{ $coupon->end_at }}</td>
                                <td class="text-center action-td">
                                    <a href="/admin/coupons/{{$coupon->id}}"><i class="fas fa-eye px-1 color-primary detail"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $coupons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
