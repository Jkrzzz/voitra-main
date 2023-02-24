@extends('admin.layouts.layout')
@section('style')
    <style>
        .doing-note {
            display: none;
        }
        .change-payment-button {
            margin-top: 10px;
        }
        .refund-option {
            color: #FF0000;
        }
        .red {
            color: #FF0000;
        }
        .tabs-vertical .nav-link.has-new {
            background-color: #FCF1EF;
        }
        .tabs-vertical .nav-link.active.has-new {
            background-color: #03749C;
        }
    </style>
@endsection
@php
$notifyClass = config('const.notifyClass');
$notifyTitle = config('const.notifyTitle');
@endphp
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header" style="border-bottom: 2px solid #CED2D8">
                    案件詳細
                </div>
                @csrf
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
                    @endif
                    @if (Session::has('message'))
                        <div class="alert alert-danger" role="alert">{{ Session::get('message') }}</div>
                    @endif
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="id">申し込みID</label>
                                    <input class="form-control" name="id" id="id" type="text" maxlength="255"
                                        value="{{ $order->id }}" disabled>
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
                        @if ($isAdmin)
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
                                <label for="created_at">申し込み時間</label>
                                <input class="form-control" name="created_at" id="created_at" type="text"
                                    value="{{ $order->created_at }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="total_time">{{ $order->plan == 1 ? '合計時間' : '文字数' }}</label>
                                <input class="form-control" name="total_time" id="total_time" type="text" maxlength="255"
                                    value="{{ $order->total_time }}" disabled>
                            </div>
                        </div>
                        @if ($order->plan == 2)
                            @if ($isAdmin)
                                <div class="col-md-4"></div>
                            @endif
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="deadline">納品予定日</label>
                                    @php
                                        $deadlineValue = '';
                                        $today = \Carbon\Carbon::now();
                                        $todayFormat = $today->format('Y-m-d');
                                        if (!$order->deadline) {
                                            if (strtotime($today) > strtotime($order->user_estimate)) {
                                                $deadlineValue = $todayFormat;
                                            } else {
                                                $deadlineValue = $order->user_estimate;
                                            }
                                        } else {
                                            $deadlineValue = $order->deadline;
                                        }
                                    @endphp
                                    @if ($order->user->status != 1 || in_array($order->status, [2, 3, 11, 12, 8, 6]) || !$isEstimateStaff || ($order->status != 4 && !$isAdmin))
                                        <input class="form-control" name="deadline" id="deadline" type="date"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" maxlength="255" disabled
                                            value="{{ $deadlineValue }}">
                                    @else
                                        @if (!$isAdmin && $order->status == 4)
                                            <form action="/admin/orders/{{ $order->id }}/send-admin/estimate"
                                                method="post" id="form-send-admin-estimate">
                                                @csrf
                                                @method('PUT')
                                                <input class="form-control" name="deadline" id="deadline" type="date"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" maxlength="255"
                                                    value="{{ $deadlineValue }}">
                                                @error('deadline')
                                                    <p class="input-error"><i class="fas fa-times-circle"></i>
                                                        {{ $message }}</p>
                                                @enderror
                                                <button type="button" class="btn btn-common mt-2"
                                                    id="send-admin-estimate">納期決定＆管理者に通知
                                                </button>
                                            </form>
                                        @else
                                            <form action="/admin/orders/{{ $order->id }}/send/estimate" method="post"
                                                id="form-send-user-estimate">
                                                @csrf
                                                @method('PUT')
                                                <input class="form-control" name="deadline" id="deadline" type="date"
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" maxlength="255"
                                                    value="{{ $deadlineValue }}">
                                                @error('deadline')
                                                    <p class="input-error"><i class="fas fa-times-circle"></i>
                                                        {{ $message }}</p>
                                                @enderror
                                                <button type="button" class="btn btn-common mt-2"
                                                    id="send-user-estimate">{{ $order->status == 7 ? '再度納期を見積もり' : '納期決定＆ユーザーに通知' }}
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>納品希望日</label>
                                    <input class="form-control" name="user_estimate" id="user_estimate" type="date"
                                        maxlength="255"
                                        value="{{ $order->user_estimate ? date('Y-m-d', strtotime($order->user_estimate)) : $order->user_estimate }}"
                                        disabled>
                                </div>
                            </div>
                            @if ($isAdmin)
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <form action="/admin/orders/{{ $order->id }}/assign/estimate" method="post" id="form-assign-estimate">
                                            @csrf
                                            @method('PUT')
                                            <label >納期確認スタッフ</label>
                                            <select class="form-control" name="estimate_staff"
                                                    id="estimate_staff" {{ in_array($order->status, [2, 3, 7, 11, 12, 8, 6]) || $order->user->status != 1 ? 'disabled' : ''}}>
                                                <option value="">選択してください。</option>
                                                @foreach ($staffs as $staff)
                                                    <option {{ $staff->id == $order->estimate_staff ? 'selected' : '' }}
                                                        value="{{ $staff->id }}">{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('estimate_staff')
                                                <p class="input-error"><i class="fas fa-times-circle"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            @if (!in_array($order->status, [2, 3, 7, 11, 12, 8, 6]) && $order->user->status == 1)
                                                <button type="button" class="btn btn-common mt-2" id="assign-estimate">
                                                    納期確認スタッフをアサイン
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <form action="/admin/orders/{{ $order->id }}/assign/edit" method="post"
                                            id="form-assign-edit">
                                            @csrf
                                            @method('PUT')
                                            <label >編集スタッフ</label>
                                            <select class="form-control" name="edit_staff"
                                                    id="edit_staff" {{ in_array($order->status, [1, 4, 5, 2, 7, 6, 8]) || $order->user->status != 1 ? 'disabled' : ''}}>
                                                <option value="">選択してください。</option>
                                                @foreach ($staffs as $staff)
                                                    <option {{ $staff->id == $order->edit_staff ? 'selected' : '' }}
                                                        value="{{ $staff->id }}">{{ $staff->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('edit_staff')
                                                <p class="input-error"><i class="fas fa-times-circle"></i>
                                                    {{ $message }}
                                                </p>
                                            @enderror
                                            @if (!in_array($order->status, [1, 4, 5, 2, 7, 6, 8]) && $order->user->status == 1)
                                                <button type="button" class="btn btn-common mt-2" id="assign-edit">
                                                    編集スタッフをアサイン
                                                </button>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-4 status-input plan-2">
                                <div class="form-group">
                                    <label >ステータス</label>
                                    <select class="form-control" id="status" name="status" disabled>
                                        @foreach($statusConst as $key => $item)
                                            <option
                                                value="{{ $key }}" {{$key == $order->status ? 'selected' : ''}}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-md-4 status-input plan-1">
                                <div class="form-group">
                                    <label >ステータス</label>
                                    <select class="form-control" id="status" name="status" disabled>
                                        @foreach($audioStatusConst as $key => $item)
                                            <option
                                                value="{{ $key }}" {{ $key == $order->status ? 'selected' : ''}}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                    @if ($isAdmin)
                        <div class="payment-info">
                            <p class="info-title">決済情報</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label >決済方法</label>
                                            <input class="form-control" name="payment_type" id="payment_type"
                                                   type="text"
                                                   value="{{$order->payment_type ? $paymentTypeConst[$order->payment_type] : '---'}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <form action="/admin/orders/{{$order->id}}/payment/edit" method="post" id="form-payment-edit">
                                        @csrf
                                        @method('PUT')
                                        <div class="row align-items-center">
                                            @if($order->payment_status == PAYMENT_REFUND or $order->payment_status == PAYMENT_DONE or $order->payment_status == PAYMENT_VERIFIED)
                                                <div class="col-md-6">
                                                    <label for="id">決済状況</label>
                                                    <div class="input-group mb-3">
                                                        @if ($order->payment_status == PAYMENT_REFUND)
                                                            <select class="form-control red" name="payment_status" id="payment_status" disabled>
                                                                @if ($order->payment_type == PAYMENT_CREDIT)
                                                                    <option selected value="{{ PAYMENT_REFUND }}" class="refund-option">{{@$paymentStatusConst[PAYMENT_REFUND]}}</option>
                                                                    <option value="{{ PAYMENT_DONE }}" class="text-dark">{{@$paymentStatusConst[PAYMENT_DONE]}}</option>
                                                                @elseif ($order->payment_type == PAYMENT_POSTPAID)
                                                                    <option selected value="{{ PAYMENT_REFUND }}" class="refund-option">{{@$paymentStatusConst[PAYMENT_REFUND]}}</option>
                                                                    <option value="{{ PAYMENT_VERIFIED }}" class="text-dark">{{@$paymentStatusConst[PAYMENT_VERIFIED]}}</option>
                                                                @endif
                                                            </select>
                                                        @elseif ($order->payment_status == PAYMENT_DONE)
                                                            <select class="form-control" name="payment_status" id="payment_status" disabled>
                                                                <option selected value="{{ PAYMENT_DONE }}">{{@$paymentStatusConst[PAYMENT_DONE]}}</option>
                                                                <option value="{{ PAYMENT_REFUND }}" class="refund-option">{{@$paymentStatusConst[PAYMENT_REFUND]}}</option>
                                                            </select>
                                                        @elseif ($order->payment_status == PAYMENT_VERIFIED)
                                                            <select class="form-control" name="payment_status" id="payment_status" disabled>
                                                                <option selected value="{{ PAYMENT_VERIFIED }}">{{@$paymentStatusConst[PAYMENT_VERIFIED]}}</option>
                                                                <option value="{{ PAYMENT_REFUND }}" class="refund-option">{{@$paymentStatusConst[PAYMENT_REFUND]}}</option>
                                                            </select>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="change-payment-button">
                                                    <div class="input-group-append" id="change-payment-type">
                                                        <button type="button" class="btn btn-common">変更</button>
                                                    </div>
                                                    <div class="input-group-append" id="save-payment-section">
                                                        <button type="button" class="btn btn-common-outline mr-3" id="cancel-change-payment">キャンセル</button>
                                                        <button type="button" class="btn btn-common" id="save-change-payment">保存</button>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <label for="id">決済状況</label>
                                                    <input class="form-control" name="payment_status" id="payment_status"
                                                    type="text"
                                                    value="{{$order->payment_status ? @$paymentStatusConst[$order->payment_status] : '---'}}" disabled>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal fade info-modal" id="confirm_modal_payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <div id="close-payment-status-modal" class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                                                            <i class="fas fa-times-circle "></i>
                                                        </div>
                                                        @if(isset($icon) && $icon == 'lock')
                                                            <img src="{{ asset('/user/images/icon-lock.png') }}">
                                                        @else
                                                        <img src="{{ asset('/user/images/info.png') }}">
                                                        @endif
                                                        <h4 class="notification-title">更新してもよろしいですか？</h4>
                                                        <div class="text-center">
                                                            <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                                                                <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>いいえ</span>
                                                            </button>
                                                            <button type="submit" id="confirmed_payment" form-id="" class="btn-primary-info group">
                                                                <span id='text'>はい </span><i class="far fa-arrow-alt-circle-right"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label >ファイル処理料金（税込）</label>
                                            <input class="form-control" name="total_price" id="total_price" type="text"
                                                value="@money($order->total_price)円" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($order->coupon)
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label >クーポン適用後ファイル処理料金（税込）<br>
                                                （税抜金額 ー クーポン割引金額）＋消費税　＊決済料金と話者分離は割引対象外</label>
                                            <input class="form-control" name="total_price" id="total_price" type="text"
                                                   value="@money($order->discountedMoneyTotal)円" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label >クーポンコード</label>
                                            <input class="form-control" name="coupon_code" id="coupon_code" type="text"
                                                   value="{{$order->coupon->code}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label >売上値引額（税抜）</label>
                                            <input class="form-control" name="coupon_discount_amount" id="coupon_discount_amount" type="text"
                                            value="@money($order->all_price ? $order->coupon->discount_amount : ceil($order->total_price / 1.1))円" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($order->payment_type == 2)
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>決済料金（税込）</label>
                                                <input class="form-control" name="settlement_fee" id="settlement_fee"
                                                    type="text" value="@money(350)円" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($service)
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>話者分離（税込）</label>
                                                <input class="form-control" name="speaker_separation_option"
                                                       id="speaker_separation_option" type="text"
                                                       value="@money($service->price)円" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group special">
                                        <label>お支払い金額合計（決済金額税込）</label>
                                        <input class="form-control" name="all_price" id="all_price" type="text"
                                            value="@money($order->all_price)円" disabled>
                                    </div>
                                </div>
                            </div>
                            @if($order->payment_type == 2 && $userAddress)
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>決請求先情報</label>
                                            <div class="form-group-box disabled">
                                                {{ @$userTypeConst[$userAddress->type] }}<br>
                                                {{ $userAddress->full_name }}<br>
                                                {{ $userAddress->tel }}<br>
                                                {{ $userAddress->mobile }}<br>
                                                {{ $userAddress->email }}<br>
                                                〒{{ $userAddress->zipcode }}{{ $userAddress->address1 }}{{ $userAddress->address2 }}{{ $userAddress->address3 }}
                                                @if ($userAddress->type == 1)
                                                    <br>{{ $userAddress->company_name }}
                                                    <br>{{ $userAddress->department_name }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="/admin/orders/{{ $order->id }}/memo">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="user_estimate">メモ</label>
                                        <textarea class="form-control" name="memo" id="memo" disabled type="text">{{ $order->memo }}</textarea>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="button" class="btn btn-common" id="note">メモ追加</button>
                                    <div class="doing-note">
                                        <button type="button" class="btn btn-common-outline" id="cancel-note">キャンセル
                                        </button>
                                        <button type="submit" class="btn btn-common" id="save-note">メモ保存</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive" style="max-height: 200px">
                        <table class="table table-responsive-sm mt-5">
                            <thead>
                                <tr>
                                    <th>ファイルID</th>
                                    <th>ファイル名</th>
                                    <th class="text-center">音声</th>
                                    <th class="text-center">既読</th>
                                    <th class="text-center">ステータス</th>
                                    <th class="text-center">話者分離</th>
                                    <th class="text-center">話者数</th>
                                    <th>発注時間</th>
                                    <th>見込処理時間</th>
                                    <th>実際処理時間</th>
                                    <th class="text-center">詳細</th>
                                </tr>
                            </thead>
                            <tbody id="audio-list">
                                @foreach ($audios as $audio)
                                    <tr>
                                        <td>{{ $audio->id }}</td>
                                        <td>{{ \Str::limit($audio->name, 15, ' ...') }}</td>
                                        <td>
                                            @if ($audio->url)
                                                <audio style="height: 20px" controls>
                                                    <source src="{{ $audio->url }}" type="audio/mpeg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            @endif
                                        </td>
                                        @if (($order->plan == 2 && in_array($order->status, [6, 7, 8])) || ($order->plan == 1 && $audio->audioStatus == 2))
                                            <td
                                                class="text-center {{ $audio->isSeen ? 'color-info' : 'color-danger' }}">
                                                {{ $audio->isSeen ? '既読' : '未読' }}</td>
                                        @else
                                            <td class="text-center ">---</td>
                                        @endif
                                        @if ($audio->status == 3)
                                            <td class="text-center" style="color:#BABABA;">
                                                {{ $audioStatusConst[$audio->audioStatus] }}</td>
                                        @else
                                            <td
                                                class="text-center {{ $audio->audioStatus === 2? 'color-success': ($audio->audioStatus === 0 || $audio->audioStatus === 4 || $audio->audioStatus === 3? 'color-danger': 'color-warning') }}">
                                                {{ $audioStatusConst[$audio->audioStatus] }}</td>
                                        @endif
                                        <td class="text-center">
                                            {{ !$audio->diarization || $audio->diarization != 1 ? 'なし' : 'あり' }}</td>
                                        <td class="text-center">{{ $audio->num_speaker }}</td>
                                        <td>{{ $audio->created_at }}</td>
                                        <td>{{ $audio->estimated_processing_time ? gmdate('H:i:s', $audio->estimated_processing_time) : '---' }}
                                        </td>
                                        <td>{{ $audio->actual_processing_time ? gmdate('H:i:s', $audio->actual_processing_time) : '---' }}
                                        </td>
                                        <td class="text-center action-td">
                                            @if ($audio->audioStatus != 4)
                                                <a href="/admin/orders/{{ $order->id }}/audio/{{ $audio->id }}"><i
                                                        class="fas fa-eye px-1 color-primary audio-result"></i></a>
                                                @if ($order->plan == 2 && ((in_array($order->status, [3, 11, 12, 6]) && $isEditStaff && $isAdmin) || (in_array($order->status, [11]) && !$isAdmin && $isEditStaff)))
                                                    <a
                                                        href="/admin/orders/{{ $order->id }}/audio/{{ $audio->id }}/edit"><i
                                                            class="fas fa-edit px-1 color-primary audio-result"></i></a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    @if ($order->user->status == 1 && $isEditStaff && in_array($order->status, [3, 11, 12, 6]) && $isAdmin)
                        <form action="/admin/orders/{{ $order->id }}/send/edit" method="post" id="form-send-user-edit">
                            @csrf
                            @method('PUT')
                            <a href="/admin/orders">
                                <button type="button" class="btn  btn-common-outline">戻る</button>
                            </a>
                            <button type="button" class="btn btn-common"
                                id="send-user-edit">{{ $order->status == 6 ? '納品後修正をユーザーに報告' : 'ブラッシュアップ 完了報告＆ユーザーに通知' }}
                            </button>
                        </form>
                    @elseif($order->user->status == 1 && in_array($order->status, [11]) && !$isAdmin && $isEditStaff)
                        <form action="/admin/orders/{{ $order->id }}/send-admin/edit" method="post"
                            id="form-send-admin-edit">
                            @csrf
                            @method('PUT')
                            <a href="/admin/orders">
                                <button type="button" class="btn  btn-common-outline">戻る</button>
                            </a>
                            <button type="button" class="btn btn-common" id="send-admin-edit">ブラッシュアップ 完了報告＆Admin通知
                            </button>
                        </form>
                    @else
                        <a href="/admin/orders">
                            <button type="button" class="btn  btn-common-outline">戻る</button>
                        </a>
                    @endif
                </div>
            </div>
            @if($logged_in_admin->role == 1 && count($notifications) > 0)
            <div class="card">
                <div class="card-header" style="border-bottom: 2px solid #CED2D8">
                    <div class="row">
                        <div class="col-md-6">
                            アサイン履歴
                        </div>
                    </div>
                </div>
                <div class="card-body list-body">
                    <div class="table-responsive" style="max-height: 250px; overflow: auto">
                        @if(count($notifications) == 0)
                            <div class="text-center">履歴はありません。</div>
                        @else
                            <table class="table notify-table">
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr class="ntf {{ $notification['status_class'] }}" data-url="{{ $notification['reference_url'] }}" data-nid="{{ $notification['id'] }}">
                                            <td class="id">{{ $notification['reference_id'] }}</td>
                                            <td>{{ $notification['data'] }}</td>
                                            <td><div class="tag  {{ $notification['label_class'] }}">{{ $notification['label_title'] }}</div></td>
                                            <td>{{ $notification['created_at'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @if (\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 2 || count($users) > 0)
            <div class="card">
                <div class="card-header" style="border-bottom: 2px solid #CED2D8">
                    <div class="row">
                        <div class="col-md-6">
                            メッセージ
                        </div>
                    </div>
                </div>
                <div class="card-body chat-tabs">
                    <ul class="nav nav-tabs tabs-vertical" id="myTab" role="tablist">
                        <div class="text-center chat-status-title">
                            案件ステータス
                        </div>
                        <div class="d-flex justify-content-center mb-4">
                            @foreach($statusConst as $key => $item)
                                @if ($key == $order->status)
                                    <span class="form-control chat-status-sub-title d-flex justify-content-center align-items-center border-0">{{$item}}</span>
                                @endif
                            @endforeach
                        </div>
                        @if ($isAdmin)
                            <input type="hidden" name="user_id" value="{{ key($users) }}">
                        @endif
                        @foreach ($users as $key => $user)
                        <li class="nav-item" role="presentation">
                            <a id="chat-tab-{{ $key }}" class="nav-link {{ $key === array_key_first($users) ? 'active' : '' }}" href="#chat-container-{{ $key }}" aria-controls="chat-container-{{ $key }}" role="tab" data-toggle="tab" data-value="{{ $key }}">
                                <img src="{{ asset('admin/assets/img/avatar.png') }}" alt="avatar" width="50px" height="50px" class="mr-2">
                                <strong>{{ $user }}</strong>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @foreach ($users as $key => $user)
                        <div class="tab-pane fade show {{ $key === array_key_first($users) ? 'active' : '' }}" id="chat-container-{{ $key }}" aria-labelledby="home-tab-{{ $key }}" role="tabpanel" style="margin-right: 30px;">
                            <div class="chat-area">
                                @foreach ($messages[$key] as $mess)
                                    @if (($isAdmin && $mess->sender_id == 0) || (\Illuminate\Support\Facades\Auth::guard('admin')->user()->id == $mess->sender_id))
                                    <div class="message mess-right">
                                        <div class="mess-area">
                                            <div class="mess-text">
                                                <div style="text-align: left; word-break: break-all; max-width: 400px;">{{ $mess->content }}</div>
                                                <div style="font-size: 10px;">{{ $mess->created_at }}</div>
                                            </div>
                                        </div>
                                        <div class="prof"></div>
                                    </div>
                                    @else
                                    <div class="message">
                                        <div class="prof"></div>
                                        <div class="mess-area">
                                            <div class="mess-text">
                                                <div style="text-align: left; word-break: break-all; max-width: 400px;">{{ $mess->content }}</div>
                                                <div style="font-size: 10px;">{{ $mess->created_at }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        <div class="message-box">
                            <textarea class="form-control" id="message" name="message" rows="2" placeholder="入力してください " maxlength="999999999"></textarea>
                            <button id="send" class="button-s1" tooltip="Send">
                                <svg id="disabled-send" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.0703 5.50965L6.51026 1.22965C0.760264 -1.65035 -1.59974 0.709646 1.28026 6.45965L2.15026 8.19965C2.40026 8.70965 2.40026 9.29965 2.15026 9.80965L1.28026 11.5396C-1.59974 17.2896 0.750264 19.6496 6.51026 16.7696L15.0703 12.4896C18.9103 10.5696 18.9103 7.42965 15.0703 5.50965ZM11.8403 9.74965H6.44026C6.03026 9.74965 5.69026 9.40965 5.69026 8.99965C5.69026 8.58965 6.03026 8.24965 6.44026 8.24965H11.8403C12.2503 8.24965 12.5903 8.58965 12.5903 8.99965C12.5903 9.40965 12.2503 9.74965 11.8403 9.74965Z" fill="#B0B0B0"/>
                                </svg>
                                <svg id="able-send" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15.0703 5.50965L6.51026 1.22965C0.760264 -1.65035 -1.59974 0.709646 1.28026 6.45965L2.15026 8.19965C2.40026 8.70965 2.40026 9.29965 2.15026 9.80965L1.28026 11.5396C-1.59974 17.2896 0.750264 19.6496 6.51026 16.7696L15.0703 12.4896C18.9103 10.5696 18.9103 7.42965 15.0703 5.50965ZM11.8403 9.74965H6.44026C6.03026 9.74965 5.69026 9.40965 5.69026 8.99965C5.69026 8.58965 6.03026 8.24965 6.44026 8.24965H11.8403C12.2503 8.24965 12.5903 8.58965 12.5903 8.99965C12.5903 9.40965 12.2503 9.74965 11.8403 9.74965Z" fill="url(#paint0_linear_3514_49465)"/>
                                    <defs>
                                    <linearGradient id="paint0_linear_3514_49465" x1="0.0498047" y1="0.000976562" x2="17.9503" y2="0.000976562" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FF8301"/>
                                    <stop offset="1" stop-color="#FFAA01"/>
                                    </linearGradient>
                                    </defs>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    </div>
    @include('admin.modal.confirm', ['title' => '更新してもよろしいですか？', 'content' => ''])
    <div class="modal fade info-modal" id="error_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                        <i class="fas fa-times-circle "></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <p class="notification-body"></p>
                    <div class="text-center">
                        <button type="button" class="btn-primary-info group mr-3" data-dismiss="modal">
                            <span id='text-prev'>OK</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input id="isEditComplete" name="isEditComplete" hidden value="{{ $isEditComplete }}">
    <input name="last_memo" hidden value="{{ $order->memo }}">
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#confirmed').attr('type', 'button')
            $('#note').click(function() {
                $('#memo').attr('disabled', false)
                $('.doing-note').show()
                $(this).hide()
            })
            $('#cancel-note').click(function() {
                $('#memo').attr('disabled', true).val($('input[name=last_memo]').val())
                $('.doing-note').hide()
                $('#note').show()
            })

            // let select = $('select').selectize();
            $('#assign-estimate').click(function () {
                if ($('#estimate_staff').val() && $('#estimate_staff').val() != 'blank') {
                    $('#confirm_modal').find('.notification-body').text('スタッフにメールで通知します。')
                    $('#confirmed').attr('form-id', 'assign-estimate')
                    $('#confirm_modal').modal('show')
                } else {
                    $('#error_modal').find('.notification-body').text('納期確認スタッフ項目は空きです。')
                    $('#error_modal').modal('show')
                }

            })
            $('#assign-edit').click(function() {
                if ($('#edit_staff').val() && $('#edit_staff').val() != 'blank') {
                    $('#confirm_modal').find('.notification-body').text('スタッフにメールで通知します。')
                    $('#confirmed').attr('form-id', 'assign-edit')
                    $('#confirm_modal').modal('show')
                } else {
                    $('#error_modal').find('.notification-body').text('編集スタッフ項目は空きです。')
                    $('#error_modal').modal('show')
                }
            })
            $('#send-user-estimate').click(function() {
                if ($('#deadline').val()) {
                    const now = new Date();
                    now.setHours(0, 0, 0, 0);
                    const deadline = new Date($('#deadline').val())
                    deadline.setHours(0, 0, 0, 0)
                    if (deadline.getTime() < now.getTime()) {
                        $('#error_modal').find('.notification-body').text('入力した日付は過去の日付です。')
                        $('#error_modal').modal('show')
                        return
                    }
                    $('#confirm_modal').find('.notification-body').text('お客様にお知らせのメールが送信されます。')
                    $('#confirmed').attr('form-id', 'send-user-estimate')
                    $('#confirm_modal').modal('show')
                } else {
                    $('#error_modal').find('.notification-body').text('納期予定日項目は空きです。')
                    $('#error_modal').modal('show')
                }
            })
            $('#send-user-edit').click(function() {
                if ($('#isEditComplete').val()) {
                    $('#confirm_modal').find('.notification-body').text('お客様にお知らせのメールが送信されます。')
                    $('#confirmed').attr('form-id', 'send-user-edit')
                    $('#confirm_modal').modal('show')
                } else {
                    $('#error_modal').find('.notification-body').text('ブラッシュアップ結果は空きです。')
                    $('#error_modal').modal('show')
                }
            })
            $('#send-admin-estimate').click(function() {
                if ($('#deadline').val()) {
                    const now = new Date();
                    now.setHours(0, 0, 0, 0);
                    const deadline = new Date($('#deadline').val())
                    deadline.setHours(0, 0, 0, 0)
                    if (deadline < now) {
                        $('#error_modal').find('.notification-body').text('入力した日付は過去の日付です。')
                        $('#error_modal').modal('show')
                        return
                    }
                    $('#confirm_modal').find('.notification-body').text('管理者にお知らせのメールが送信されます。')
                    $('#confirmed').attr('form-id', 'send-admin-estimate')
                    $('#confirm_modal').modal('show')
                } else {
                    $('#error_modal').find('.notification-body').text('納期予定日項目は空きです。')
                    $('#error_modal').modal('show')
                }
            })
            $('#send-admin-edit').click(function() {
                if ($('#isEditComplete').val()) {
                    $('#confirm_modal').find('.notification-body').text('管理者にお知らせのメールが送信されます。')
                    $('#confirmed').attr('form-id', 'send-admin-edit')
                    $('#confirm_modal').modal('show')
                } else {
                    $('#error_modal').find('.notification-body').text('ブラッシュアップ結果は空きです。')
                    $('#error_modal').modal('show')
                }
            })
            $('#confirmed').click(function() {
                const form = $(this).attr('form-id')
                $('#form-' + form).submit()
            })

            var defaultStatus = $('#payment_status').val();

            $('#change-payment-type').show();
            $('#save-payment-section').hide();
            $('#change-payment-type').click(function () {
                $('#payment_status').prop("disabled", false);
                $('#payment_status').removeClass("disabled");
                $('#change-payment-type').hide();
                $('#save-payment-section').show();
            })

            $('#payment_status').change(function (e) {
                if (e.target.value === '6') $('#payment_status').addClass('red');
                else $('#payment_status').removeClass('red');
            });

            $('#cancel-change-payment').click( function() {
                $('#change-payment-type').show();
                $('#save-payment-section').hide();
                if (defaultStatus === '6') $('#payment_status').addClass('red');
                else $('#payment_status').removeClass('red');
                $('#payment_status').val(defaultStatus);
                $("#payment_status").prop( "disabled", true );
            })
            $('#save-change-payment').click(function() {
                $('#confirm_modal_payment').modal('show')
            })
            $('#confirmed_payment').click(function() {
                $('#confirm_modal_payment').modal('hide')
            })
            $('#close-payment-status-modal').click(function() {
                $('#confirm_modal_payment').modal('hide')
            })
            $('#disabled-send').show()
            $('#able-send').hide()
            $("#message").on("input", function() {
                if ($(this).val()) {
                    $('#disabled-send').hide()
                    $('#able-send').show()
                } else {
                    $('#disabled-send').show()
                    $('#able-send').hide()
                }
            }).focus(function() {
                @if ($isAdmin)
                    let sender_id = $('input[name=user_id]').val();
                @else
                    let sender_id = 0;
                @endif
                let csrf_token  = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "/admin/messages/ajax-mark-all-as-read",
                    type: "POST",
                    data: {
                        sender_id: sender_id,
                        receiver_id: {{ $logged_in_admin->id }},
                        _token: csrf_token
                    },
                    success: function(response) {
                        $('#chat-tab-'+sender_id).removeClass('has-new');
                    },
                    error: function(error) {
                        // console.log(error);
                    }
                });
            });
            var sendMess = function(mess) {
                let receiver = $('input[name=user_id]').val();
                if (mess) {
                    $.ajax({
                        url: "/admin/messages/send",
                        type: "POST",
                        data: {
                            room_id: `{{ $order->id }}`,
                            content: mess,
                            receiver_id: receiver,
                            _token:  $('input[name="_token"]').attr("value")
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                let data = response.message;
                                let html = `<div class="message mess-right"><div class="mess-area"><div class="mess-text"><div style="text-align: left; word-break: break-all; max-width: 400px;">${data.content}</div><div style="font-size: 10px;">${data.created_at}</div></div></div><div class="prof"></div></div>`
                                $(`.active .chat-area`).append(html);
                                $(".chat-area").animate({
                                    scrollTop: $('.chat-area')[0].scrollHeight - $('.chat-area')[0].clientHeight
                                }, 200);
                                document.getE.scroll({ top: element.scrollHeight, behavior: 'smooth' });
                            } else {
                                $('#error_modal').find('.notification-body').text(response.message)
                                $('#error_modal').modal('show')
                            }
                        },
                        error: function(error) {
                            // console.log(error);
                        }
                    });
                }
            }
            $('.nav-link').click(function() {
                let user_id = $(this).attr('data-value');
                $('input[name=user_id]').val(user_id);
            })
            $("#send").click(function() {
                let mess = $("#message").val();
                $("#message").val('')
                sendMess(mess);
            });
            if ($('.chat-area').length > 0) {
                $(".chat-area").animate({
                    scrollTop: $('.chat-area')[0].scrollHeight - $('.chat-area')[0].clientHeight
                }, 200);
            }
            $("#message").keyup(function(e) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13') {
                    let mess = $("#message").val();
                    $("#message").val('')
                    sendMess(mess);
                }
            });
            $(".notify-table tr").click(function (e) {
                let is_new = $(this).hasClass('new');

                if (is_new) {
                    let csrf_token = $('meta[name="csrf-token"]').attr('content');
                    let notice_id  = $(this).attr('data-nid');

                    $.ajax({
                        url: "/admin/notifications/ajax-mark-as-read",
                        type: "POST",
                        data: {
                            id: notice_id,
                            _token: csrf_token
                        },
                        success: function(response) {
                            let tr_dom = e.currentTarget;
                            $(tr_dom).removeClass('new').addClass('read');
                            $('#notification-list-items #'+notice_id).remove();

                            // let counter = parseInt($('#notifications .notify-count').text()) || 0;
                            let counter = response.unread_left;
                            if (0 >= counter) {
                                counter = 0;
                            }
                            else if (0 < counter && counter < 101) {
                                counter = counter - 1;
                            }
                            else {
                                counter = '99+';
                            }
                            $('#notifications .notify-count').text(counter);
                            $('.sidebar-notify-number').text(counter);
                        },
                        error: function(error) {
                        }
                    });
                }
            });
        });
    </script>
    <script>
        Echo.join(`room.{{ $order->id }}`)
            .listen('Backend.Messages.MessagePosted', (e) => {
                let data = e.message;
                let html = '';
                if (({{$isAdmin ? 1 : 0}} && data.sender_id == 0) || data.sender_id == {{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->id }}) {
                    html = `<div class="message mess-right"><div class="mess-area"><div class="mess-text"><div style="text-align: left; word-break: break-all; max-width: 400px;">${data.content}</div><div style="font-size: 10px;">${data.created_at}</div></div></div><div class="prof"></div></div>`
                } else {
                    html = `<div class="message"><div class="prof"></div><div class="mess-area"><div class="mess-text"><div style="text-align: left; word-break: break-all; max-width: 400px;">${data.content}</div><div style="font-size: 10px;">${data.created_at}</div></div></div></div>`
                }
                if ({{ $isAdmin ? 1 : 0 }}) {
                    $(`#chat-container-${data.sender_id} .chat-area`).append(html);
                    $(`#chat-tab-${data.sender_id}`).addClass('has-new');
                } else {
                    if (data.receiver_id == {{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->id }}) {
                        $(`#chat-container-0 .chat-area`).append(html);
                        $(`#chat-tab-0`).addClass('has-new');
                    } else {
                        window.location.reload();
                    }
                }

                $(".chat-area").animate({
                    scrollTop: $('.chat-area')[0].scrollHeight - $('.chat-area')[0].clientHeight
                }, 200);
            })
    </script>
@endsection
