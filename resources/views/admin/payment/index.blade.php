@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-filter"></i>案件検索フィルター</div>
                <form method="get" action="/admin/payments">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="type">決済項目</label>
                                    <select class="form-control" name="serviceType">
                                        <option value=""></option>
                                        @foreach($serviceTypeConst as $key => $type)
                                            <option
                                                {{ $serviceType == $key ? 'selected' : '' }} value="{{$key}}">{{$type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-common" type="submit"> 検索</button>
                        <a href="/admin/payments">
                            <button class="btn btn-common-outline" id="reset" type="button">リセット</button>
                        </a>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-align-justify"></i> 案件一覧
                        </div>
                        <div class="col-md-6 text-right">
                            <button class="btn btn-common" type="button" id="download" url="{{ $downloadUrl }}">
                                ダウンロード
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body list-body">
                    <table class="table table-responsive-sm table-striped">
                        <thead>
                        <tr>
                            <th>決済ID</th>
                            <th>申し込みID</th>
                            <th>顧客名</th>
                            <th>決済金額</th>
                            <th>決済項目</th>
                            <th class="text-center">決済時間</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paymentHistories as $paymentHistory)
                            <tr>
                                <td>{{ $paymentHistory->id }}</td>
                                <td>{{ $paymentHistory->type == 1 ? $paymentHistory->payment_id : ''}}</td>
                                <td>{{ @$paymentHistory->user->name }}</td>
                                <td>{{ $paymentHistory->total_price }}</td>
                                <td>{{ @$serviceTypeConst[$paymentHistory->service_type] }}</td>
                                <td>{{ $paymentHistory->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="float-right">
                        {{ $paymentHistories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade info-modal" id="confirm_download_modal" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/download-icon.png') }}">
                    <h4 class="notification-title">このファイルをダウンロードしてもよろしいでしょうか。</h4>
                    <p class="notification-body"></p>
                    <div class="text-center">
                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                            <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>キャンセル</span>
                        </button>
                        <button type="submit" id="confirm_download" class="btn-primary-info group">
                            <span id='text'>ダウンロード</span><i class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#download').click(function () {
                $('#confirm_download_modal').modal('show')
            })
            $("#confirm_download").click(async function (event) {
                $('#confirm_download_modal').modal('hide')
                event.preventDefault();
                const url = $('#download').attr('url')
                await fetch(url, {
                    method: 'GET',
                })
                    .then(r => r.json().then(data => data))
                    .then(response => {
                        if (response.success) {
                            var link = document.createElement("a");
                            link.setAttribute('download', response.filename);
                            link.href = response.url;
                            document.body.appendChild(link);
                            link.click();
                            link.remove();
                        }
                    })
                    .catch((error) => {
                        console.log(error)
                    });
            })
        });
    </script>
@endsection
