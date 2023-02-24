<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Zen+Old+Mincho&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Zen+Old+Mincho:wght@900&display=swap');
        /*@import url('https://fonts.googleapis.com/css2?family=Kosugi+Maru&display=swap');*/
        body {
            margin: 0;
            /*font-family: 'Kosugi Maru', sans-serif;*/
            font-family: 'Zen Old Mincho', serif;
        }

        p {
            /*font-family: 'Kosugi Maru', sans-serif;*/
            font-family: 'Zen Old Mincho', serif;
            display: block;
            margin: 0;
            padding: 0;
        }

        *, ::after, ::before {
            box-sizing: border-box;
        }

        .main-content {
            position: relative;
            height: auto;
        }

        .history-detail-box {
            padding: 10px;
        }

        * {
            -webkit-box-sizing: border-box;
        }

        .flexrow {
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
        }

        .flexrow > div {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }

        .flexrow > div:last-child {
            margin-right: 0;
        }

        .row > div {
            -webkit-box-flex: 1;
            -webkit-flex: 1;
            flex: 1;
        }

        .row > div:last-child {
            margin-right: 0;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        .history-detail-branch {
            text-align: right;
            font-size: 14px;
            color: #212529;
        }

        .history-detail-label, th {
            font-size: 14px;
            color: #141721;
            font-weight: 900 !important;
        }

        .history-detail-value {
            font-size: 14px;
            color: #141721;
            margin-left: 150px;
            margin-top: 0;
        }

        .history-detail-content {
            margin-top: 10px;
        }

        #history-detail {
            /*background: #F9F9F9;*/
            border: none;
        }

        .table {
            width: 100%;
            border-radius: 10px;
            border-bottom: none !important;
        }

        #history-detail th:first-child {
            padding-left: 40px !important;
        }

        #history-detail th {
            font-weight: normal;
            font-size: 13px;
            color: #141721;
            padding: 15px !important;
        }

        tr:first-child th:first-child {
            border-top-left-radius: 10px;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .text-left {
            text-align: left !important;
        }

        td, th {
            border-top: none !important;
            border-bottom: 1px solid #ddd;
            text-align: center;
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
        }

        tr:first-child th:last-child {
            border-top-right-radius: 10px;
        }

        #history-detail th:last-child {
            padding-right: 40px !important;
        }

        #history-detail tbody tr:first-child td {
            padding-top: 20px !important;
        }

        .history-service td {
            padding-bottom: 60px !important;
        }

        .table td, .table th {
            padding: .75rem;
        }

        .align-middle {
            vertical-align: middle !important;
        }

        .history-service td {
            padding-bottom: 60px !important;
        }

        #history-detail td:last-child {
            padding-right: 40px !important;
        }

        #history-detail tfoot th {
            font-size: 14px;
        }

        #history-detail tfoot td {
            padding: 10px !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .history-title {
            width: 40%;
            word-wrap:break-word;
        }

        /*.font-weight-bold{*/
        /*    font-weight: bold;*/
        /*}*/

    </style>
</head>
<body>
<div class="main-content">
    <div class="history-detail-box" style="border: none">
        <div class="flexrow">
            <div>
                <img src="data:image/png;base64, {{ $image }}"/>
            </div>
            <div>
                <p class="history-detail-branch" style="display: block">アップセルテクノロジィーズ株式会社</p>
            </div>
        </div>
        <div class="flexrow" style="margin-bottom: 0">
            <div>
                <p class="history-detail-label">請求番号</p>
            </div>
            <div>
                <p class="history-detail-value">{{ $paymentHistory->id}}</p>
            </div>
        </div>
        <div class="flexrow">
            <div>
                <p class="history-detail-label">ID</p>
            </div>
            <div>
                <p class="history-detail-value">{{ $user->email }}</p>
            </div>
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
                            <td class="align-middle text-center"
                                data-label="期間">{{ date('Y/m/d', strtotime($paymentHistory->created_at)) }}
                                - {{ date('Y/m/d', strtotime($paymentHistory->end_date)) }}</td>
                            <td class="align-middle text-right " data-label="金額">@money($paymentHistory->total_price)円
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th scope="col" class="text-left">決済金額</th>
                        <td colspan="3" class="text-right" data-label="決済金額">@money($paymentHistory->total_price)円</td>
                    </tr>
                    </tfoot>
                </table>
            @else
                <table id="history-detail" class="table">
                    <thead>
                    <tr>
                        <th scope="col" class="text-left">日付</th>
                        <th scope="col" class="text-left">項目</th>
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
                            <td class="align-middle text-left history-title" data-label="項目">{{ $item['name'] }}</td>
                            <td class="align-middle text-center"
                                data-label="プラン">{{ $item['plan'] == 1 ? 'AI文字起こし' : 'ブラッシュアップ' }}</td>
                            @if($order->plan == 1)
                                <td class="align-middle text-center "
                                    data-label="時間">{{gmdate('H:i:s', $item['duration'])}}</td>
                            @else
                                <td class="align-middle text-center "
                                    data-label="文字数">{{$item['length']}}文字
                                </td>
                            @endif
                            <td class="align-middle text-right " data-label="金額">@money($item['price'])円</td>
                        </tr>
                    @endforeach
                    @if($paymentHistory->service_id)
                        <tr>
                            <td class="align-middle text-left" data-label="日付">
                                {{ date('Y年m月d日', strtotime($paymentHistory->created_at)) }}
                            </td>
                            <td class="align-middle text-left" data-label="項目">話者分離オプション</td>
                            <td></td>
                            <td class="align-middle text-center"
                                data-label="期間">{{ date('Y/m/d', strtotime($paymentHistory->created_at)) }}
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
                            <th class="text-right" data-label="クーポン割引" style="white-space: nowrap;">-@money($coupon->discount_amount)円</th>
                        </tr>
                    @endif
                    @if($paymentHistory->payment_type == 2)
                        <tr>
                            <th scope="col" colspan="4" class="text-left">決済手数料</th>
                            <th class="text-right" data-label="決済金額">@money(350)円</th>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="3" class="text-left">決済金額</th>
                        @if($order->plan == 2)
                            <td class="text-center" data-label="文字数">{{$totalLength}}文字
                        @else
                            <td class="text-center" data-label="文字数">{{gmdate('H:i:s',$totalDuration)}}
                        @endif
                        <th class="text-right" data-label="決済金額">@money($paymentHistory->total_price)円</th>
                    </tr>
                    </tfoot>
                </table>
            @endif
            <div style="padding: 15px">
                <div class="flexrow">
                    <div>
                        <p class="history-detail-label">お支払い方法</p>
                    </div>
                    <div>
                        <p class="history-detail-value">{{ $paymentHistory->payment_type ? $paymentTypeConst[$paymentHistory->payment_type] : '---' }}</p>
                    </div>
                </div>
                @if($paymentHistory->payment_type == 2 && $paymentInfo)
                    <div class="flexrow">
                        <div>
                            <p class="history-detail-label font-weight-bold">請求先情報</p>
                        </div>
                    </div>
                    <div class="flexrow">
                        <div>
                            <p class="history-detail-label">法人/個人</p>
                        </div>
                        <div>
                            <p class="history-detail-value">{{ $userType[$paymentInfo->type] }}</p>
                        </div>
                    </div>
                    <div class="flexrow">
                        <div>
                            <p class="history-detail-label">名前</p>
                        </div>
                        <div>
                            <p class="history-detail-value">{{ $paymentInfo->full_name }}</p>
                        </div>
                    </div>
                    <div class="flexrow">
                        <div>
                            <p class="history-detail-label">電話番号</p>
                        </div>
                        <div>
                            <p class="history-detail-value">{{ $paymentInfo->tel }}</p>
                        </div>
                    </div>
                    <div class="flexrow">
                        <div>
                            <p class="history-detail-label">携帯電話番号</p>
                        </div>
                        <div>
                            <p class="history-detail-value">{{ $paymentInfo->mobile }}</p>
                        </div>
                    </div>
                    <div class="flexrow">
                        <div>
                            <p class="history-detail-label">メールアドレス</p>
                        </div>
                        <div>
                            <p class="history-detail-value">{{ $paymentInfo->email }}</p>
                        </div>
                    </div>
                    <div class="flexrow">
                        <div>
                            <p class="history-detail-label">住所</p>
                        </div>
                        <div>
                            <p class="history-detail-value">{{ '〒'.$paymentInfo->zipcode . $paymentInfo->address1 . $paymentInfo->address2 . $paymentInfo->address3 }}</p>
                        </div>
                    </div>
                    @if($paymentInfo->type == 1)
                        <div class="flexrow">
                            <div>
                                <p class="history-detail-label" style="margin-bottom: 0">会社名</p>
                            </div>
                            <div>
                                <p class="history-detail-value"
                                   style="margin-bottom: 0">{{ $paymentInfo->company_name }}</p>
                            </div>
                        </div>
                        <div class="flexrow">
                            <div>
                                <p class="history-detail-label">部署名</p>
                            </div>
                            <div>
                                <p class="history-detail-value">{{ $paymentInfo->department_name }}</p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
</body>
