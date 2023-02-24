@extends('admin.layouts.layout')
@section('style')
    <style>
        .admin-tr {
            background: #fcf1ef !important;
        }

        .limit-text {
            width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fas fa-filter"></i> 案件検索</div>
                <form method="get" action="/admin/orders">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user_id">申し込みID</label>
                                    <input type="number" name="order_id" placeholder="" class="form-control" min="1"
                                           value="{{ request()->get('order_id') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="audio_id">ファイルID</label>
                                    <input type="number" name="audio_id" placeholder="" class="form-control" min="1"
                                           value="{{ request()->get('audio_id') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user_id">顧客名</label>
                                    <select class="form-control user-select" id="user_id" name="user_id">
                                        <option value="">すべて</option>
                                        <option value="all">すべて</option>
                                        @foreach($usersConst as $key => $item)
                                            <option
                                                {{$item->id == $user_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div
                                class="col-md-4" {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 2 ? 'hidden': ''}}>
                                <div class="form-group">
                                    <label for="staff_id">担当スタッフ</label>
                                    <select class="form-control staff-select" id="staff_id"
                                            name="staff_id">
                                        <option value="">すべて</option>
                                        <option value="all">すべて</option>
                                        @foreach($staffsConst as $key => $item)
                                            <option
                                                {{$item->id == $staff_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1 )
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="plan">プラン</label>
                                        <select class="form-control" id="plan" name="plan">
                                            <option value="">すべて</option>
                                            <option value="all">すべて</option>
                                            <option {{ $plan == 1 ? 'selected' : ''}} value="1">AI自動文字起こしプラン</option>
                                            <option {{ $plan == 2 ? 'selected' : ''}} value="2">ブラッシュアッププラン</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">ステータス</label>
                                    @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1 )
                                        @if(request()->plan == 1)
                                            <select class="form-control" id="status" name="status">
                                                <option selected value="">すべて</option>
                                                <option value="all">すべて</option>
                                                @foreach($audioConst as $key => $item)
                                                    @if($key != 0)
                                                        <option
                                                            {{$key == $status ? 'selected' : ''}} value="{{ $key }}">{{ $item }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @elseif(request()->plan == 2)
                                            <select class="form-control" id="status" name="status">
                                                <option selected value="">すべて</option>
                                                <option value="all">すべて</option>
                                                @foreach($statusConst as $key => $item)
                                                    @if($key != 0)
                                                        <option
                                                            {{$key == $status ? 'selected' : ''}} value="{{ $key }}">{{ $item }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        @else
                                            <select class="form-control not-search" id="status" name="status" disabled>
                                                <option selected value="">すべて</option>
                                            </select>
                                        @endif
                                    @else
                                        <select class="form-control" id="status" name="status">
                                            <option selected value="">すべて</option>
                                            <option value="all">すべて</option>
                                            @foreach($statusConst as $key => $item)
                                                @if($key != 0)
                                                    <option
                                                        {{$key == $status ? 'selected' : ''}} value="{{ $key }}">{{ $item }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div
                                class="col-md-4" {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1 ? 'hidden': ''}}>
                                <div class="form-group">
                                    <label for="staffAssign">業務種別</label>
                                    <select class="form-control" id="staffAssign" name="staffAssign">
                                        <option value="">すべて</option>
                                        <option value="all">すべて</option>
                                        @foreach($staffAssignConst as $key => $item)
                                            <option
                                                {{$key == $staffAssign ? 'selected' : ''}} value="{{ $key }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div
                                class="col-md-4 expand-content" {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 2 ? 'hidden': ''}}>
                                <div class="form-group">
                                    <label for="staff_estimate_id">納期確認スタッフ</label>
                                    <select class="form-control staff-select" id="staff_estimate_id"
                                            name="staff_estimate_id">
                                        <option value="">すべて</option>
                                        <option value="all">すべて</option>
                                        @foreach($staffsConst as $key => $item)
                                            <option
                                                {{$item->id == $staff_estimate_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div
                                class="col-md-4 expand-content" {{\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 2 ? 'hidden': ''}}>
                                <div class="form-group">
                                    <label for="staff_edit_id">編集スタッフ</label>
                                    <select class="form-control staff-select" id="staff_edit_id"
                                            name="staff_edit_id">
                                        <option value="">すべて</option>
                                        <option value="all">すべて</option>
                                        @foreach($staffsConst as $key => $item)
                                            <option
                                                {{$item->id == $staff_edit_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1)
                            <p class="expand-text"><span>詳細検索</span> <i class="fas fa-chevron-down"></i></p>
                        @endif
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-common" type="submit"> 検索</button>
                        <a href="/admin/orders">
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
                    @if(session()->has('success'))
                        <div class="alert alert-success" role="alert">{{  session()->get('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
                    @endif
                   <div class="table-responsive">
                       <table class="table" style="width: 2000px">
                           <thead>
                           <tr>
                               <th class="has-order" order-by="id"
                                   order="{{ $order_by == 'id' ? ($order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'}}">申し込みID
                                   <i class="fas fa-long-arrow-alt-down {{ $order == 'DESC' && $order_by == 'id' ? 'active' : ''}}"></i>
                                   <i class="fas fa-long-arrow-alt-up {{ $order == 'ASC' && $order_by == 'id' ? 'active' : ''}}"></i>
                               </th>
                               <th>申込時間</th>
                               <th>顧客名</th>
                               @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1)
                                   <th>プラン</th>
                               @endif
                               <th>ステータス</th>
                               <th>決済方法</th>
                               <th>決済状況</th>
                               <th>決済金額</th>
                               <th>話者分離</th>
                               @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1)
                                   <th class="has-order" order-by="estimate_staff"
                                       order="{{ $order_by == 'estimate_staff' ? ($order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'}}">
                                       納期確認スタッフ
                                       <i class="fas fa-long-arrow-alt-down {{ $order == 'DESC' && $order_by == 'estimate_staff' ? 'active' : ''}}"></i>
                                       <i class="fas fa-long-arrow-alt-up {{ $order == 'ASC' && $order_by == 'estimate_staff' ? 'active' : ''}}"></i>
                                   </th>
                                   <th class="has-order" order-by="edit_staff"
                                       order="{{ $order_by == 'edit_staff' ? ($order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'}}">
                                       編集スタッフ
                                       <i class="fas fa-long-arrow-alt-down {{ $order == 'DESC' && $order_by == 'edit_staff' ? 'active' : ''}}"></i>
                                       <i class="fas fa-long-arrow-alt-up {{ $order == 'ASC' && $order_by == 'edit_staff' ? 'active' : ''}}"></i>
                                   </th>
                               @else
                                   <th>業務種別</th>
                               @endif
                               <th class="has-order" order-by="deadline"
                                   order="{{ $order_by == 'deadline' ? ($order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'}}">
                                   納品予定日
                                   <i class="fas fa-long-arrow-alt-down {{ $order == 'DESC' && $order_by == 'deadline' ? 'active' : ''}}"></i>
                                   <i class="fas fa-long-arrow-alt-up {{ $order == 'ASC' && $order_by == 'deadline' ? 'active' : ''}}"></i>
                               </th>
                               <th class="has-order" order-by="user_estimate"
                                   order="{{ $order_by == 'user_estimate' ? ($order == 'DESC' ? 'ASC' : 'DESC') : 'DESC'}}">
                                   納品希望日
                                   <i class="fas fa-long-arrow-alt-down {{ $order == 'DESC' && $order_by == 'user_estimate' ? 'active' : ''}}"></i>
                                   <i class="fas fa-long-arrow-alt-up {{ $order == 'ASC' && $order_by == 'user_estimate' ? 'active' : ''}}"></i>
                               </th>
                               <th>既読</th>
                               <th>見込処理時間</th>
                               <th>詳細</th>
                           </tr>
                           </thead>
                           <tbody>
                           @foreach($orders as $order)
                               <tr row-id="{{ $order->id }}"
                                   class="order-tr {{ ((in_array($order->status, [1, 5, 3, 12]) && \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1) || (in_array($order->status, [4, 11]) && \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 2)) && $order->plan == 2 ? 'admin-tr' : ''}}">
                                   <td>{{ $order->id }}</td>
                                   <td>{{ $order->created_at }}</td>
                                   <td><a href="/admin/users/{{$order->user_id}}"><p
                                               class="limit-text">{{@$order->user->name}}</p></a></td>
                                   @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1)
                                       <td>{{ $order->plan }}</td>
                                   @endif
                                   <td class="{{ $order->status == 6 ? 'color-success' : ($order->status == 0 ? 'color-danger' : 'color-warning')}}">
                                       @if($order->plan == 1)
                                           {{ @$audioConst[$order->status] }}
                                       @elseif ($order->plan == 2)
                                           {{ @$statusConst[$order->status] }}
                                       @endif
                                   </td>
                                   <td>{{@$paymentTypeConst[$order->payment_type]}}</td>
                                   <td>{{@$paymentStatusConst[$order->payment_status]}}</td>
                                   <td>{{ $order->all_price }}</td>
                                   <td>{{ $order->diarization }}</td>
                                   @if(\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1)
                                       <td>{{ @$staffNameArr[$order->estimate_staff] }}</td>
                                       <td>{{ @$staffNameArr[$order->edit_staff] }}</td>
                                   @else
                                       <td>{{ @$staffAssignConst[$order->staffAssign] }}</td>
                                   @endif
                                   <td>{{ $order->deadline }}</td>
                                   <td>{{ @$order->audios[0]->pivot->user_estimate }}</td>
                                   <td>{{ $order->totalSeenAudio }}/{{ $order->totalAudio }}</td>
                                   <td>{{$order->estimated_processing_time ? gmdate("H:i:s", $order->estimated_processing_time) : '---'}}</td>
                                   <td class="action-td">
                                       <a href="/admin/orders/{{$order->id}}/edit"><i
                                               class="fas fa-eye px-1 color-primary detail"></i></a>
                                   </td>
                               </tr>
                           @endforeach
                           </tbody>
                       </table>
                   </div>
                    <div class="float-right">
                        {{ $orders->links() }}
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
                    <h4 class="notification-title">ファイル一覧ダウンロード</h4>
                    <p class="notification-body">ファイルの一覧をダウンロードします。よろしでしょうか？</p>
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

    <input type="hidden" name="plan-2-status" value="{{json_encode($statusConst)}}">
    <input type="hidden" name="plan-1-status" value="{{json_encode($audioConst)}}">
    <input type="hidden" name="filter-order-id" value="{{request()->get('order_id')}}">
    <input type="hidden" name="filter-audio-id" value="{{request()->get('audio_id')}}">
    <input type="hidden" name="filter-user-id" value="{{$user_id}}">
    <input type="hidden" name="filter-staff-id" value="{{$staff_id}}">
    <input type="hidden" name="filter-status" value="{{$status}}">
    <input type="hidden" name="filter-staff-assign" value="{{$staffAssign}}">
    <input type="hidden" name="filter-plan" value="{{$plan}}">
    <input type="hidden" name="filter-staff-estimate_id" value="{{$staff_estimate_id}}">
    <input type="hidden" name="filter-staff-edit_id" value="{{$staff_edit_id}}">
@endsection
@section('script')
    <script>
        var spk2id = function (data) {
            if (data) {
                let spks = [];
                let res = {};
                for (let x of data) {
                    if (!spks.includes(x['speaker'])) {
                        spks.push(x['speaker'])
                    }
                }
                for (let i = 1; i <= spks.length; i++) {
                    res[spks[i - 1]] = i
                }
                return res
            }
        }
        $(document).ready(function () {
            if (sessionStorage.getItem('expand') == 'true') {
                $('.expand-text').find('i').removeClass('fa-chevron-down')
                $('.expand-text').find('i').addClass('fa-chevron-up')
                $('.expand-content').show()
            } else {
                $('.expand-text').find('i').removeClass('fa-chevron-up')
                $('.expand-text').find('i').addClass('fa-chevron-down')
                $('.expand-content').hide()
            }
            $('.expand-text').click(function () {
                if ($(this).find('i').hasClass('fa-chevron-down')) {
                    $(this).find('i').removeClass('fa-chevron-down')
                    $(this).find('i').addClass('fa-chevron-up')
                    $('.expand-content').show()
                    sessionStorage.setItem('expand', 'true');
                } else {
                    $(this).find('i').removeClass('fa-chevron-up')
                    $(this).find('i').addClass('fa-chevron-down')
                    $('.expand-content').hide()
                    sessionStorage.setItem('expand', 'false');
                }
            })
            let select = $('select').selectize();
            if ($('#filterStatus').val() == '') {
                $('#status').selectize()[0].selectize.setValue(null, false)
            }
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
                            link.download= response.filename;
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
            $('.has-order').click(function () {
                const order_id = $('input[name=filter-order-id]').val()
                const audio_id = $('input[name=filter-audio-id]').val()
                const user_id = $('input[name=filter-user-id]').val()
                const staff_id = $('input[name=filter-staff-id]').val()
                const status = $('input[name=filter-status]').val()
                const staffAssign = $('input[name=filter-staff-assign]').val()
                const plan = $('input[name=filter-plan]').val()
                const staff_estimate_id = $('input[name=filter-staff-estimate_id]').val()
                const staff_edit_id = $('input[name=filter-staff-edit_id]').val()
                const order = $(this).attr('order')
                const order_by = $(this).attr('order-by')
                window.location.href = `/admin/orders?order_id=${order_id}&audio_id=${audio_id}&user_id=${user_id}&staff_id=${staff_id}&status=${status}&staffAssign=${staffAssign}&plan=${plan}&staff_estimate_id=${staff_estimate_id}&staff_edit_id=${staff_edit_id}&order=${order}&order_by=${order_by}`
            })
            const plan_1_status = JSON.parse($('input[name=plan-1-status]').val())
            let plan_1_option = [
                {
                    text: 'すべて',
                    value: null
                },
                {
                    text: 'すべて',
                    value: 'all'
                }
            ]

            for (const i in plan_1_status) {
                if (plan_1_status.hasOwnProperty(i)) {
                    if (i != 0) {
                        plan_1_option.push({
                            text: plan_1_status[i],
                            value: i
                        })
                    }
                }
            }
            const plan_2_status = JSON.parse($('input[name=plan-2-status]').val())
            let plan_2_option = [
                {
                    text: 'すべて',
                    value: null
                },
                {
                    text: 'すべて',
                    value: 'all'
                }
            ]
            for (const i in plan_2_status) {
                if (plan_2_status.hasOwnProperty(i)) {
                    if (i != 0) {
                        plan_2_option.push({
                            text: plan_2_status[i],
                            value: i
                        })
                    }
                }
            }
            $('#plan').change(function () {
                const plan = $(this).val()
                console.log(plan_2_option)
                console.log(plan_1_option)
                if (plan == 1) {
                    $('#status').selectize()[0].selectize.clear()
                    $('#status').selectize()[0].selectize.clearOptions()
                    $('#status').selectize()[0].selectize.addOption(plan_1_option)
                    $('#status').selectize()[0].selectize.enable()
                } else if (plan == 2) {
                    $('#status').selectize()[0].selectize.clear()
                    $('#status').selectize()[0].selectize.clearOptions()
                    $('#status').selectize()[0].selectize.addOption(plan_2_option)
                    $('#status').selectize()[0].selectize.enable()
                } else {
                    $('#status').selectize()[0].selectize.clear()
                    $('#status').selectize()[0].selectize.disable()
                }
            })
            $('.order-tr').dblclick(function (){
                const id = $(this).attr('row-id');
                window.location.href = `/admin/orders/${id}/edit`
            })
        });
    </script>
@endsection
