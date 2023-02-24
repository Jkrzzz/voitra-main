@extends('user.layouts.user_layout')
@section('title','ユーザー情報')
@section('style')
<link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
@endsection
@section('content')
<div class="main-content">
    <p class="breadcrumb-common">支払明細</p>
    <div class="information-box">
        <div class="row information-sub-header">
            <div class="col-md-6 col-6">
                <h4 class="information-sub-title">決済履歴</h4>
            </div>
        </div>
        @if(count($services) > 0)
        <div class="payment-section">
            <h4 class="payment-section-title">有料オプション一覧</h4>
            <div class="payment-option">
                @foreach($services as $service)
                @if($trail->value)
                <div class="payment-option-item">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <p class="payment-option-name">{{ $service->name }}</p>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="payment-option-wrap">
                                <p class="payment-option-price">無料トライアル適用中</p>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <p class="payment-option-date">無料期間終了予定<br>
                                <span>{{ date('Y年m月d日', strtotime($trail->expired_date)) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @else
                <h4 class="payment-option-name">{{ $service->name }}</h4>
                <div class="payment-option-item">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12 order-item-view">
                            <p class="mb-2">決済方法</p>
                            <p class="font-weight-bold">{{ @$paymentTypeConst[$service->pivot->payment_type] }}</p>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12 order-item-view">
                            <p class="mb-2">決済状況</p>
                            <p class="font-weight-bold">{{ @$paymentStatus[$service->pivot->payment_status] }}</p>
                        </div>
                        <div class="col-lg-2 col-md-3 col-12 order-item-view">
                            <p class="mb-2">申込状況</p>
                            <p class="font-weight-bold">{{ @$servicePaymentStatus[$service->pivot->status] }}</p>
                        </div>
                        @if($service->pivot->status == 1)
                        <div class="col-lg-2 col-md-3 col-12 order-item-view">
                            <p class="mb-2">次の更新日</p>
                            <p class="font-weight-bold" style="color: #03749C">{{ @date('Y-m-d', strtotime($service->pivot->updated_at. ' + 1 months')) }}</p>
                        </div>
                        @endif
                    </div>
                    @if($service->pivot->payment_status == 0 || $service->pivot->payment_status == 1)
                    <div class="policy-delete mt-3">
                        <i class="fas fa-info-circle"></i>
                        @if($service->pivot->payment_status == 0)
                        コンビニ後払をキャンセルしましたが、クレジットカードの決済は完了しておりません。再度、決済画面にお進みください。
                        @elseif($service->pivot->payment_status == 1)
                        コンビニ後払の審査に通りませんでした。クレジットカードで再決済お願いします。
                        @endif
                    </div>
                    <div class="">
                        <div class="mt-3">
                            <button id="repay" class="process-btn btn-primary btn-md" data-type="{{ $service->pivot->payment_status }}" data-link="{{ route('repay', ['type' => 3]) }}">
                                {{$service->pivot->payment_status == 1 ?  'クレジットカードで再決済' : 'クレジットカード決済へ進む'}}
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="8" cy="8" r="7.5" stroke="#4F4F4F" />
                                    <path d="M7.90926 4.57031L11.2196 7.99888L7.90926 11.4275M3.86328 7.99888H11.2196H3.86328Z" stroke="#4F4F4F" stroke-width="2" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @elseif($service->pivot->payment_status == 2 || $service->pivot->payment_status == 5)
                    <div class="policy-delete mt-3">
                        <i class="fas fa-info-circle"></i>
                        @if($service->pivot->payment_status == 2)
                        後払いの与信を審査しております。審査は翌営業日の12時まで時間がかかる場合がありますので、お急ぎの場合は以下の<span style="font-weight:bold">「クレジットカード払いに変更」</span>ボタンにてコンビニ後払いをキャンセルしてクレジットカード払いにご変更ください。
                        @elseif($service->pivot->payment_status == 5)
                        <p class="text-danger">後払の審査が保留になりました。請求先の情報を修正が必要になりますので、修正してください。</p>
                        修正していただいた後、後払いの与信をかけなおします。審査は翌営業日の12時まで時間がかかる場合がありますので、お急ぎの場合は以下の<span style="font-weight:bold">「クレジットカード払いに変更」</span>ボタンにてコンビニ後払いをキャンセルしてクレジットカード払いにご変更ください。
                        @endif
                    </div>
                    <div class="">
                        @if($service->pivot->payment_status == 2)
                        <div class="mt-3">
                            <button id="repay" class="process-btn btn-outline-repay btn-md" data-type="{{ $service->pivot->payment_status }}" data-link="{{ route('repay', ['type' => 3]) }}">
                                クレジットカード払いに変更
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="9.5" stroke="#03749C" />
                                    <path d="M9.88828 5.71614L14.0262 10.0019L9.88828 14.2876M4.83081 10.0019H14.0262H4.83081Z" stroke="#03749C" stroke-width="2" />
                                </svg>
                            </button>
                        </div>
                        @elseif($service->pivot->payment_status == 5)
                        <div class="mt-3">
                            <a class="process-btn btn-primary btn-md  btn-fix" href="{{ route('fixAddress', ['type' => $service->pivot->order_id ? 4 : 3, 'order_id' => $service->pivot->order_id]) }}">
                                請求先情報を修正
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="8" cy="8" r="7.5" stroke="#4F4F4F" />
                                    <path d="M7.90926 4.57031L11.2196 7.99888L7.90926 11.4275M3.86328 7.99888H11.2196H3.86328Z" stroke="#4F4F4F" stroke-width="2" />
                                </svg>
                            </a>
                        </div>
                        <div class="mt-4">
                            <button id="repay" class="process-btn btn-outline-repay btn-md" data-type="{{ $service->pivot->payment_status }}" data-link="{{ route('repay', ['type' => 3]) }}">
                                クレジットカード払いに変更
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="10" cy="10" r="9.5" stroke="#03749C" />
                                    <path d="M9.88828 5.71614L14.0262 10.0019L9.88828 14.2876M4.83081 10.0019H14.0262H4.83081Z" stroke="#03749C" stroke-width="2" />
                                </svg>
                            </button>
                        </div>
                        @endif
                    </div>
                    @endif
                @endif
                @endforeach
                </div>
            </div>
        </div>
        @endif

            <div class="payment-section mt-5">
                <h4 class="payment-section-title">決済履歴</h4>
                <div class="table-content history">
                    <table id="history-table" class="table">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-left">日付</th>
                            <th scope="col" class="text-left">項目</th>
                            <th scope="col" class="text-left">決済方法</th>
                            <th scope="col" class="text-left">金額</th>
                            <th scope="col" class="text-left"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($paymentHistories as $paymentHistory)
                            <tr data-id="{{$paymentHistory->id}}">
                                <td class="align-middle text-left" data-label="日付">
                                    {{ date('Y/m/d', strtotime($paymentHistory->created_at)) }}
                                </td>
                                <td class="align-middle text-left" data-label="項目">{{ $paymentHistory->title }}</td>
                                <td class="align-middle text-left" data-label="決済方法">{{ $paymentHistory->payment_type ? $paymentTypeConst[$paymentHistory->payment_type] : '---'}}</td>
                                <td class="align-middle text-left" data-label="金額">@money($paymentHistory->total_price)円</td>
                                <td class="align-middle text-center" data-label=""><a href="/payment-history/{{$paymentHistory->id}}">
                                        <button class="btn-primary-info">詳細</button>
                                    </a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
@include('user.modal.modal_cancel_postpaid')
<script src="{{ asset('/user/js/history.js')}} "></script>
<script>
    $(document).ready(function() {
        $("#repay").click(function(e) {
            e.preventDefault();
            url = $(e.target).attr("data-link");
            type = $(e.target).attr("data-type");
            if (type == 0) {
                window.location.replace(url);
            } else {
                $("#modal-cancel-postpaid").modal('show');
            }
        });
        $(document).on('click', '#cancel-action', function(e) {
            // $("#form-repay-p1").submit();
            window.location.replace(url);
        });
    })
</script>
@endsection
