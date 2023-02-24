@extends('admin.layouts.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    案件詳細
                </div>
                <form method="post" action="/admin/staffs">
                    @csrf
                    <div class="card-body">
                        <form id="form" action="" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="id">申し込みID</label>
                                            <input class="form-control" name="id" id="id" type="text" maxlength="255"
                                                   value="{{$order->id}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="user_name">顧客名</label>
                                            <input class="form-control" name="user_name" id="user_name" type="text"
                                                   value="{{ @$order->user->name }}" maxlength="255" disabled>
                                        </div>
                                    </div>
                                </div>
                                @if($isAdmin)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="plan">プラン</label>
                                                <input class="form-control" name="plan" id="plan" type="text"
                                                       value="{{ $order->plan }}" maxlength="255" disabled>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_price">決済金額</label>
                                        <input class="form-control" name="total_price" id="total_price" type="text"
                                               maxlength="255" value="{{ $order->total_price }}" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="total_time">{{$order->plan == 1 ? '合計時間' : '文字数'}}</label>
                                        <input class="form-control" name="total_time" id="total_time" type="text"
                                               maxlength="255" value="{{ $order->total_time }}" disabled>
                                    </div>
                                </div>
                                @if($order->plan == 2)
                                    @if($isAdmin)
                                        <div class="col-md-4"></div>
                                    @endif
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="deadline">納品予定日</label>
                                            <input class="form-control" name="deadline" id="deadline" type="date"
                                                   maxlength="255"
                                                   value="{{ $order->deadline ? date('Y-m-d', strtotime($order->deadline)) : $order->deadline }}"
                                                   disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="user_estimate">納品希望日</label>
                                            <input class="form-control" name="user_estimate" id="user_estimate"
                                                   type="date" maxlength="255"
                                                   value="{{ $order->user_estimate ? date('Y-m-d', strtotime($order->user_estimate)) : $order->user_estimate }}"
                                                   disabled>
                                        </div>
                                    </div>
                                    @if($isAdmin)
                                        <div class="col-md-4"></div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="estimate_staff">納期確認スタッフ</label>
                                                <input class="form-control" name="estimate_staff" id="estimate_staff"
                                                       type="text" maxlength="255"
                                                       value="{{$order->estimate_staff_name}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="edit_staff">編集スタッフ</label>
                                                <input class="form-control" name="edit_staff" id="edit_staff"
                                                       type="text" maxlength="255" value="{{$order->edit_staff_name}}"
                                                       disabled>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if($order->plan == 2)
                                    <div class="col-md-4 status-input plan-2">
                                        <div class="form-group">
                                            <label for="status">ステータス</label>
                                            <select class="form-control" id="status" name="status" disabled>
                                                @foreach($statusConst as $key => $item)
                                                    <option
                                                        value="{{ $key }}" {{ $key == $order->status ? 'selected' : ''}}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-md-4 status-input plan-1">
                                        <div class="form-group">
                                            <label for="status">ステータス</label>
                                            <select class="form-control" id="status" name="status" disabled>
                                                @foreach($audioStatusConst as $key => $item)
                                                    <option
                                                        value="{{ $key }}" {{ $key == $order->status ? 'selected' : ''}}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="user_estimate">メモ</label>
                                            <textarea class="form-control" name="memo" id="memo" type="text"
                                                      disabled>{{$order->memo}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive" style="max-height: 200px">
                                <table class="table table-responsive-sm mt-5">
                                    <thead>
                                    <tr>
                                        <th>ファイルID</th>
                                        <th>ファイル名</th>
                                        <th class="text-center">音声</th>
                                        <th class="text-center">ステータス</th>
                                        <th class="text-center">話者分離</th>
                                        <th class="text-center">話者数</th>
                                        <th>発注時間</th>
                                        <th class="text-center">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="audio-list">
                                    @foreach($audios as $audio)
                                        <tr>
                                            <td>{{ $audio->id }}</td>
                                            <td>{{\Str::limit($audio->name, 15, ' ...')  }}</td>
                                            <td>
                                                @if($audio->url)
                                                    <audio style="height: 20px" controls>
                                                        <source src="{{ $audio->url }}" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @endif
                                            </td>
                                            <td class="text-center {{ $audio->status === 2 ? 'color-success' : ($audio->audioStatus === 0 || $audio->audioStatus === 4 || $audio->audioStatus === 3 ? 'color-danger' : 'color-warning')}}">{{ $audioStatusConst[$audio->audioStatus]}}</td>
                                            <td class="text-center">{{$audio->diarization ? ($audio->diarization == 1 ? 'Yes' : 'No' ) : ''}}</td>
                                            <td class="text-center">{{$audio->num_speaker}}</td>
                                            <td>{{$audio->created_at}}</td>
                                            <td class="text-center action-td">
                                                @if($audio->audioStatus != 4)
                                                    <a href="/admin/orders/{{$order->id}}/audio/{{$audio->id}}}"><i
                                                            class="fas fa-eye px-1 color-primary audio-result"></i></a>
                                                    @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-right">
                        <a href="/admin/orders">
                            <button type="button" class="btn  btn-common-outline">閉じる</button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
