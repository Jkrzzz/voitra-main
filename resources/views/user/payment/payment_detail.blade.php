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
            <div class="col-md-6 col-12">
                <h4 class="information-sub-title">請求の詳細</h4>
            </div>
            <div class="col-md-6 col-12 text-right">
                <a href="/payment-history/{{ $paymentHistory->id }}/invoice">
                    <button id="download-history" class="process-btn btn-primary btn-md">
                        ダウンロード
                        <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.2498 12.6873C11.44 12.6874 11.623 12.7506 11.7619 12.8641C11.9008 12.9776 11.9853 13.133 11.9983 13.2989C12.0112 13.4648 11.9517 13.6289 11.8317 13.7579C11.7117 13.8869 11.5402 13.9712 11.3519 13.9939L11.2498 14H0.750175C0.560049 13.9999 0.377033 13.9368 0.238108 13.8233C0.0991822 13.7097 0.0147053 13.5543 0.00174632 13.3884C-0.0112126 13.2225 0.0483127 13.0585 0.168295 12.9295C0.288276 12.8005 0.459768 12.7161 0.64812 12.6935L0.750175 12.6873H11.2498ZM6.007 0.00087515C6.18817 0.00109312 6.36312 0.0586262 6.49958 0.162854C6.63603 0.267081 6.72476 0.410966 6.7494 0.567946L6.75641 0.657207V9.5772L9.724 6.97812C9.85093 6.86684 10.0193 6.79909 10.1985 6.78721C10.3777 6.77532 10.5559 6.82009 10.7005 6.91336L10.7856 6.97637C10.9129 7.08755 10.9904 7.23505 11.0038 7.39199C11.0172 7.54893 10.9657 7.70486 10.8586 7.83135L10.7866 7.90486L6.54129 11.6241L6.47125 11.6792L6.3792 11.7308L6.34318 11.7492L6.25213 11.7825L6.13207 11.8087L6.06203 11.8157L6.002 11.8175C5.95122 11.8174 5.90059 11.8127 5.85092 11.8035L5.77088 11.7833C5.67578 11.7566 5.58794 11.7131 5.51274 11.6556L1.22043 7.90574C1.08582 7.78877 1.00686 7.63155 0.999463 7.46572C0.992062 7.29989 1.05676 7.13776 1.18054 7.01197C1.30432 6.88619 1.47798 6.80608 1.66657 6.78779C1.85516 6.76949 2.04467 6.81436 2.19695 6.91336L2.281 6.97725L5.2556 9.5737V0.656332C5.2556 0.482262 5.33466 0.315321 5.47539 0.192235C5.61611 0.0691491 5.80698 0 6.006 0L6.007 0.00087515Z" fill="#3D3D3D" />
                        </svg>
                    </button>
                </a>
            </div>
        </div>
        <div class="history-detail-box">
            <div class="row">
                <div class="col-md-6 col-12">
                    <img src="{{asset('/user/images/logo-history.png')}}" />
                </div>
                <div class="col-md-6 col-12">
                    <p class="history-detail-branch">アップセルテクノロジィーズ株式会社</p>
                </div>
            </div>
            <div class="history-detail-info mt-4">
                <p class="history-detail-label">請求番号</p>
                <p class="history-detail-value">{{ $paymentHistory->id }}</p>
            </div>
            <div class="history-detail-info mt-2">
                <p class="history-detail-label">ID</p>
                <p class="history-detail-value">{{ $user->email }}</p>
            </div>
            <div class="history-detail-content" style="background: #F9F9F9; border: 1px solid #CBCCCE;">
                @if($paymentHistory->type == 2)
                <table id="history-detail" class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-left">日付</th>
                            <th scope="col" class="text-left">項目</th>
                            <th scope="col" class="text-center">期間</th>
                            <th scope="col" class="text-right">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listItems as $item)
                        <tr data-id="{{$item->id}}" class="history-service">
                            <td class="align-middle text-left" data-label="日付">
                                {{ date('Y年m月d日', strtotime($item->created_at)) }}
                            </td>
                            <td class="align-middle text-left history-title" data-label="項目">{{ $item->title }}</td>
                            <td class="align-middle text-center" data-label="期間">{{ date('Y/m/d', strtotime($paymentHistory->created_at)) }}
                                - {{ date('Y/m/d', strtotime($paymentHistory->end_date)) }}</td>
                            <td class="align-middle text-right " data-label="金額">@money(300)円
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if($paymentHistory->payment_type == 2)
                            <tr>
                                <th scope="col" colspan="3" class="text-left">決済手数料</th>
                                <td class="text-right font-weight-bold" data-label="決済手数料">@money(350)円</td>
                            </tr>
                        @else
                        <tr>
                            <th scope="col" colspan="3" class="text-left">決済金額</th>
                            <td class="text-right font-weight-bold" data-label="決済金額">@money($paymentHistory->total_price)円</td>
                        </tr>
                        @endif
                    </tfoot>
                </table>
                @else
                <table id="history-detail" class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="text-left">日付</th>
                            <th scope="col" class="text-center">項目</th>
                            <th scope="col" class="text-center">プラン</th>
                            <th scope="col" class="text-center">{{$order->plan == 1 ? '時間' : '文字数'}} </th>
                            <th scope="col" class="text-right">金額</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listItems as $item)
                        <tr data-id="{{$paymentHistory->id}}">
                            <td class="align-middle text-left" data-label="日付">
                                {{ date('Y年m月d日', strtotime($paymentHistory->created_at)) }}
                            </td>
                            <td class="align-middle text-center history-title" data-label="項目">{{ $item['name'] }}</td>
                            <td class="align-middle text-center" data-label="プラン">{{ $item['plan'] == 1 ? 'AI文字起こし' : 'ブラッシュアップ' }}</td>
                            @if($order->plan == 1)
                            <td class="align-middle text-center " data-label="{{$order->plan == 1 ? '時間' : '文字数'}}">{{gmdate('H:i:s', $item['duration'])}}</td>
                            @else
                            <td class="align-middle text-center" data-label="文字数">{{$item['length']}}文字</td>
                            @endif
                            <td class="align-middle text-right " data-label="金額">@money($item['price'])円</td>
                        </tr>
                        @endforeach
                        @if($paymentHistory->service_id)
                        <tr>
                            <td class="align-middle text-left" data-label="日付">
                                {{ date('Y年m月d日', strtotime($paymentHistory->created_at)) }}
                            </td>
                            <td class="align-middle text-center" data-label="項目">話者分離オプション</td>
                            <td class="dis-desktop"></td>
                            <td class="align-middle text-center" data-label="期間">{{ date('Y/m/d', strtotime($paymentHistory->created_at)) }}
                                - {{ date('Y/m/d', strtotime($paymentHistory->end_date)) }}</td>
                            <td class="align-middle text-right " data-label="金額">@money(300)円
                            </td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                    @if($coupon)
                        <tr>
                            <th scope="col" colspan="4" class="text-left">クーポン割引金額<span style="font-weight: normal;font-size: 13px;color: #000000;"> （本体価格からの割引となります。）</span></th>
                            <td class="text-right font-weight-bold" data-label="クーポン割引">-@money($coupon->discount_amount)円</td>
                        </tr>
                    @endif
                    @if($paymentHistory->payment_type == 2)
                        <tr>
                            <th scope="col" colspan="4" class="text-left">決済手数料</th>
                            <td class="text-right font-weight-bold" data-label="決済手数料">@money(350)円</td>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="{{$paymentHistory->service_id ? 4 : 3}}" class="text-left">決済金額</th>
                        @if(!$paymentHistory->service_id)
                        @if($order->plan == 2)
                            <td class="text-center" data-label="文字数">{{$totalLength}}文字
                        @else
                            <td class="text-center" data-label="時間">{{gmdate('H:i:s',$totalDuration)}}
                        @endif
                        @endif
                        <td class="text-right font-weight-bold" data-label="決済金額">@money($paymentHistory->total_price)円</td>
                    </tr>
                    </tfoot>
                </table>
                @endif
                <div class="payment-postpaid-address">
                    <div class="history-detail-info mt-4">
                        <p class="history-detail-label font-weight-bold">お支払い方法</p>
                        <p class="history-detail-value">{{ $paymentHistory->payment_type ? $paymentTypeConst[$paymentHistory->payment_type] : '---'}}</p>
                    </div>
                    @if($paymentHistory->payment_type == 2 && $paymentInfo)
                    <div class="history-detail-info mt-4">
                        <p class="history-detail-label font-weight-bold">請求先情報</p>
                    </div>
                    <div class="history-detail-info mt-2">
                        <p class="history-detail-label">法人/個人</p>
                        <p class="history-detail-value">{{ @$userType[$paymentInfo->type] }}</p>
                    </div>
                    <div class="history-detail-info mt-2">
                        <p class="history-detail-label">名前</p>
                        <p class="history-detail-value">{{ $paymentInfo->full_name }}</p>
                    </div>
                    <div class="history-detail-info mt-2">
                        <p class="history-detail-label">電話番号</p>
                        <p class="history-detail-value">{{ $paymentInfo->tel }}</p>
                    </div>
                    <div class="history-detail-info mt-2">
                        <p class="history-detail-label">携帯電話番号</p>
                        <p class="history-detail-value">{{ $paymentInfo->mobile }}</p>
                    </div>
                    <div class="history-detail-info mt-2">
                        <p class="history-detail-label">メールアドレス</p>
                        <p class="history-detail-value">{{ $paymentInfo->email }}</p>
                    </div>
                    <div class="history-detail-info mt-2">
                        <p class="history-detail-label">住所</p>
                        <p class="history-detail-value">{{ '〒'.$paymentInfo->zipcode . $paymentInfo->address1 . $paymentInfo->address2 . $paymentInfo->address3 }}</p>
                    </div>
                    @if($paymentInfo->type == 1)
                    <div class="history-detail-info mt-2">
                        <p class="history-detail-label">会社名</p>
                        <p class="history-detail-value">{{ $paymentInfo->company_name }}</p>
                    </div>
                    <div class="history-detail-info mt-2">
                        <p class="history-detail-label">部署名</p>
                        <p class="history-detail-value">{{ $paymentInfo->department_name }}</p>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('/user/js/history.js')}} "></script>

@endsection
