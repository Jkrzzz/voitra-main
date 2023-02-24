@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-filter"></i>ユーザ検索</div>
                <form method="get" action="/admin/users">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">名前</label>
                                    <input class="form-control" id="name" name="name" type="text"
                                           placeholder="キーワードで検索..." value="{{ $name }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="userType">種別</label>
                                    <select class="form-control" id="userType" name="userType">
                                        <option value="">すべて</option>
                                        @foreach($userTypeConst as $key => $type)
                                            <option
                                                {{$key == $userType ? 'selected' : ''}} value="{{ $key }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">ステータス</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">すべて</option>
                                        @foreach($statusConst as $key => $item)
                                            @if($key != 3)
                                            <option {{isset($status) && $key == $status ? 'selected' : ''}} value="{{ $key }}">{{ $item }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-common" type="submit"> 検索</button>
                        <a href="/admin/users"><button class="btn btn-common-outline" id="reset" type="button">リセット</button></a>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-align-justify"></i> ユーザー一覧
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1)
                            <div class="col-md-6 text-right">
                                <button class="btn btn-common" type="button" id="download" url="{{ $downloadUrl }}">
                                    ダウンロード
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="card-body list-body">
                    <div class="table-responsive">
                        @if(session()->has('success'))
                            <div class="alert alert-success" role="alert">{{  session()->get('success') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                        @endif
                        <table class="table table-responsive-sm table-striped" style="width: 1500px">
                            <thead>
                            <tr>
                                <th>名前</th>
                                <th>会社名</th>
                                <th>メールアドレス</th>
                                <th>電話番号</th>
                                <th>会社電話番号</th>
                                <th class="text-center">種別</th>
                                <th class="text-center">ステータス</th>
                                <th>登録時間</th>
                                <th>最新のログイン</th>
                                {{-- <th>メモ</th> --}}
                                <th class="text-center">詳細</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr row-id="{{ $user->id }}">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->company_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone_number }}</td>
                                    <td>{{ $user->company_phone_number }}</td>
                                    <td class="text-center">{{ $userTypeConst[$user->type] }}</td>
                                    <td class="text-center {{ $user->status == 1 ? 'color-success' : 'color-danger'}}">{{ @$statusConst[$user->status] }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td>{{ $user->last_login_at }}</td>
                                    {{-- <td>{{  \Str::limit($user->memo, 50, ' ...') }}</td> --}}
                                    <td class="text-center action-td">
                                        <a href="/admin/users/{{$user->id}}"><i class="fas fa-eye px-1 color-primary detail"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="float-right">
                        {{ $users->links() }}
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
                    <div class="btn-close-modal cancel-download-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/download-icon.png') }}">
                    <h4 class="notification-title">ユーザーリストダウンロード</h4>
                    <p class="notification-body">現在のユーザー結果がダウンロードされます。よろしいでしょうか？</p>
                    <div class="text-center">
                        <button type="button" class="btn-secondary-info group mr-3 cancel-download-modal" data-dismiss="modal">
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
        });
        $("#confirm_download").click(function (event) {
            event.preventDefault();
            $('#confirm_download_modal').modal('hide')
            const url = $('#download').attr('url')
            fetch(url, {
                methods: 'GET',
                headers: {
                    "X-CSRF-Token": "{{  csrf_token() }}"
                },
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
        $('.cancel-download-modal').click(function() {
            $('#confirm_download_modal').modal('hide')
        })
    </script>
@endsection
