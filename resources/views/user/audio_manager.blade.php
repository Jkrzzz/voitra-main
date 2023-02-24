@extends('user.layouts.user_layout')
@section('title','ファイル一覧')
@php
$orderStatus = config('const.userOrderStatus');
$status = config('const.audioStatus');
$paymentStatus = config('const.paymentStatus');
@endphp
@section('style')
<style>
    .checkmark {
        top: 1px;
        left: -2px;
    }

    .regular-checkbox-group {
        margin: 0 10px;
    }

    @media only screen and (max-width: 600px) {
        .checkmark {
            top: -2px;
            left: -2px;
        }
    }

    .is-deleted {
        background-color: rgba(196, 196, 196, 0.3) !important;
        opacity: 0.7;
    }

    .is-deleted .custom-checkbox+label {
        background-color: rgba(196, 196, 196, 0.3);
    }
</style>
@endsection
@section('content')
<div class="main-content">
    <span class="page-title">@yield('title')</span>
    <div class="audio-container audio-manager">
        {{ csrf_field() }}
        <div class="header-row row">
            <div class="col-md-4 col-12" style="display: flex; align-items: center;">
                <h2 class="table-title">AI文字起こしプラン</h2>
            </div>
            <div class="col-md-8 col-12" style="text-align: right">
                <button id="download-p1" class="process-btn btn-primary btn-md mb-2">
                    ダウンロード
                    <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.2498 12.6873C11.44 12.6874 11.623 12.7506 11.7619 12.8641C11.9008 12.9776 11.9853 13.133 11.9983 13.2989C12.0112 13.4648 11.9517 13.6289 11.8317 13.7579C11.7117 13.8869 11.5402 13.9712 11.3519 13.9939L11.2498 14H0.750175C0.560049 13.9999 0.377033 13.9368 0.238108 13.8233C0.0991822 13.7097 0.0147053 13.5543 0.00174632 13.3884C-0.0112126 13.2225 0.0483127 13.0585 0.168295 12.9295C0.288276 12.8005 0.459768 12.7161 0.64812 12.6935L0.750175 12.6873H11.2498ZM6.007 0.00087515C6.18817 0.00109312 6.36312 0.0586262 6.49958 0.162854C6.63603 0.267081 6.72476 0.410966 6.7494 0.567946L6.75641 0.657207V9.5772L9.724 6.97812C9.85093 6.86684 10.0193 6.79909 10.1985 6.78721C10.3777 6.77532 10.5559 6.82009 10.7005 6.91336L10.7856 6.97637C10.9129 7.08755 10.9904 7.23505 11.0038 7.39199C11.0172 7.54893 10.9657 7.70486 10.8586 7.83135L10.7866 7.90486L6.54129 11.6241L6.47125 11.6792L6.3792 11.7308L6.34318 11.7492L6.25213 11.7825L6.13207 11.8087L6.06203 11.8157L6.002 11.8175C5.95122 11.8174 5.90059 11.8127 5.85092 11.8035L5.77088 11.7833C5.67578 11.7566 5.58794 11.7131 5.51274 11.6556L1.22043 7.90574C1.08582 7.78877 1.00686 7.63155 0.999463 7.46572C0.992062 7.29989 1.05676 7.13776 1.18054 7.01197C1.30432 6.88619 1.47798 6.80608 1.66657 6.78779C1.85516 6.76949 2.04467 6.81436 2.19695 6.91336L2.281 6.97725L5.2556 9.5737V0.656332C5.2556 0.482262 5.33466 0.315321 5.47539 0.192235C5.61611 0.0691491 5.80698 0 6.006 0L6.007 0.00087515Z" fill="#3D3D3D" />
                    </svg>
                </button>
                <button id="brush-up" class="process-btn btn-primary btn-lg">
                    ブラッシュアップ依頼
                    <svg width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.8574 4.57143L13.5287 3.0019L15 2.28571L13.5287 1.56952L12.8574 0L12.186 1.56952L10.7148 2.28571L12.186 3.0019L12.8574 4.57143ZM4.64406 4.57143L5.31541 3.0019L6.78667 2.28571L5.31541 1.56952L4.64406 0L3.97271 1.56952L2.50145 2.28571L3.97271 3.0019L4.64406 4.57143ZM12.8574 8.7619L12.186 10.3314L10.7148 11.0476L12.186 11.7638L12.8574 13.3333L13.5287 11.7638L15 11.0476L13.5287 10.3314L12.8574 8.7619ZM11.2219 6.18667L9.20068 4.03048C9.05784 3.88571 8.87928 3.80952 8.69359 3.80952C8.5079 3.80952 8.32935 3.88571 8.18651 4.03048L0.208864 12.541C0.142655 12.6114 0.0901273 12.6952 0.0542876 12.7873C0.0184478 12.8795 0 12.9783 0 13.0781C0 13.1779 0.0184478 13.2767 0.0542876 13.3689C0.0901273 13.461 0.142655 13.5448 0.208864 13.6152L2.23006 15.7714C2.3729 15.9238 2.55145 16 2.73714 16C2.92283 16 3.10139 15.9238 3.24423 15.779L11.2219 7.26857C11.5004 6.97143 11.5004 6.48381 11.2219 6.18667V6.18667ZM8.69359 5.65333L9.70062 6.72762L8.865 7.61905L7.85797 6.54476L8.69359 5.65333V5.65333ZM2.73714 14.1638L1.73012 13.0895L6.85095 7.61905L7.85797 8.69333L2.73714 14.1638Z" fill="#3D3D3D" />
                    </svg>
                </button>
                <button id="delete-p1" class="process-btn btn-default btn-sm">
                    削除
                    <svg width="16" height="18" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.77756 0H6.222C5.24156 0 4.44423 0.797333 4.44423 1.77778V2.66667H0.888672V4.44444H2.66645V14.2222C2.66645 15.2027 3.46378 16 4.44423 16H11.5553C12.5358 16 13.3331 15.2027 13.3331 14.2222V4.44444H15.1109V2.66667H11.5553V1.77778C11.5553 0.797333 10.758 0 9.77756 0ZM6.222 1.77778H9.77756V2.66667H6.222V1.77778ZM11.5553 14.2222H4.44423V4.44444H11.5553V14.2222Z" fill="#3D3D3D" />
                    </svg>
                </button>
            </div>
        </div>
        <hr>
        <div class="table-content">
            <table id="order-p1" class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="checkbox-cell">
                            <div class="checkbox-cell">
                                <input id="select-order-p1" class="custom-checkbox select-order-p1" type="checkbox" value="">
                                <label class="custom-control-label" for="select-order-p1"></label>
                            </div>
                        </th>
                        <th scope="col" class="index">ファイルID</th>
                        <th scope="col">ファイル名</th>
                        <th scope="col">時間</th>
                        <th scope="col">発注日</th>
                        <th scope="col">見込処理時間</th>
                        <th scope="col">決済状況</th>
                        <th scope="col">ステータス</th>
                        <th scope="col" class="text-center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['audio_p1'] as $audio)
                    <tr data-id="{{$audio['id']}}" class="{{ $audio['is_deleted'] ? 'is-deleted' : '' }}">
                        <td class="align-middle" scope="row">
                            <div class="checkbox-cell">
                                <input id="checkbox-p1-{{$audio['id']}}" class="custom-checkbox checkbox-p1" type="checkbox" value="" {{$audio->is_deleted ? 'disabled' : ''}}>
                                <label class="custom-control-label" for="checkbox-p1-{{$audio['id']}}"></label>
                            </div>
                        </td>
                        <td class="align-middle index" data-label="ID">{{ $audio['id'] }}</td>
                        <td class="align-middle" data-label="ファイル名">
                            <p class="audio-name-cell" data-toggle="tooltip" data-placement="top" title="{{ $audio['name'] }}">{{ $audio['name'] }}</p>
                        </td>
                        <td class="align-middle" data-label="時間">{{ gmdate('H時間i分s秒', $audio->duration) }}</td>
                        <td class="align-middle" data-label="発注日">{{ $audio['created_at'] }}</td>
                        <td class="align-middle" data-label="見込処理時間">{{$audio['estimated_processing_time'] ? gmdate("H時間i分s秒", $audio['estimated_processing_time']) : ''}}</td>
                        <td class="align-middle" data-label="決済状況">
                            {{ @$paymentStatus[$audio['payment_status']] }}
                            @if(!is_null($audio['payment_status']))
                            @if($audio['payment_status'] == 1)
                            <i class="cust-icon fas fa-info-circle danger" data-toggle="tooltip" data-placement="top" data-html="true" title="後払い審査に通りませんでした。詳細ページから、クレジットカードで再決済することが可能です。"></i>
                            @elseif($audio['payment_status'] == 0)
                            <i class="cust-icon fas fa-info-circle danger" data-toggle="tooltip" data-placement="top" data-html="true" title="後払いがキャンセルされました。決済が確定されておりませんので、詳細ページからクレジットカード決済を行ってください。"></i>
                            @elseif($audio['payment_status'] == 2)
                            <i class="cust-icon fas fa-info-circle warning" data-toggle="tooltip" data-placement="top" data-html="true" title="審査は翌営業日の12時まで時間がかかる場合がありますので、急ぎの場合は、詳細から、クレジットカード払いにご変更頂くことも可能です。"></i>
                            @elseif($audio['payment_status'] == 5)
                            <i class="cust-icon fas fa-info-circle warning" data-toggle="tooltip" data-placement="top" data-html="true" title="後払の審査が保留になりました。詳細ページから、修正画面に遷移して修正内容をご確認ください。内容を確認し、修正をお願いいたします。修正していただいた後、後払いの与信をかけなおします。"></i>
                            @endif
                            @endif
                        </td>
                        <td class="align-middle {{ ($audio['status'] == 2) ? 'text-success' : (($audio['payment_status'] == 1 || $audio['payment_status'] === 0) ? 'text-danger' : 'text-primary') }}" data-label="ステータス" style="font-size: 16px;font-weight: normal">{{ @$status[$audio->status] }}</td>
                        <td class="action-cell" data-label="操作">
                            <a href="{{ route('audio.view', $audio['id']) }}">
                                <button class="table-btn btn-view">
                                    詳細
                                    <svg width="15" height="20" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.5 0.137695C4.09091 0.137695 1.17955 2.21103 0 5.1377C1.17955 8.06436 4.09091 10.1377 7.5 10.1377C10.9091 10.1377 13.8205 8.06436 15 5.1377C13.8205 2.21103 10.9091 0.137695 7.5 0.137695ZM7.5 8.47103C5.61818 8.47103 4.09091 6.9777 4.09091 5.1377C4.09091 3.2977 5.61818 1.80436 7.5 1.80436C9.38182 1.80436 10.9091 3.2977 10.9091 5.1377C10.9091 6.9777 9.38182 8.47103 7.5 8.47103ZM7.5 3.1377C6.36818 3.1377 5.45455 4.03103 5.45455 5.1377C5.45455 6.24436 6.36818 7.1377 7.5 7.1377C8.63182 7.1377 9.54545 6.24436 9.54545 5.1377C9.54545 4.03103 8.63182 3.1377 7.5 3.1377Z" fill="#256c83" />
                                    </svg>
                                </button>
                            </a>
                            @if($audio->pivot->status == 2 && !$audio->is_deleted)
                            <a href="{{ route('audio.edit', $audio['id']) }}">
                                <button class="table-btn btn-edit">
                                    編集
                                    <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.9335 2.48992L9.10686 0.663251C8.86846 0.439315 8.55606 0.310824 8.22908 0.30222C7.90211 0.293615 7.58338 0.405498 7.33353 0.616585L1.33353 6.61658C1.11804 6.83389 0.983867 7.11872 0.953531 7.42325L0.666864 10.2032C0.657884 10.3009 0.670554 10.3993 0.703972 10.4915C0.73739 10.5837 0.790733 10.6674 0.860198 10.7366C0.922491 10.7984 0.996369 10.8473 1.07759 10.8804C1.15882 10.9136 1.24579 10.9304 1.33353 10.9299H1.39353L4.17353 10.6766C4.47806 10.6462 4.76289 10.5121 4.9802 10.2966L10.9802 4.29658C11.2131 4.05056 11.3389 3.72226 11.3302 3.38361C11.3214 3.04496 11.1788 2.72359 10.9335 2.48992ZM4.05353 9.34325L2.05353 9.52992L2.23353 7.52992L6.0002 3.80992L7.8002 5.60992L4.05353 9.34325ZM8.66686 4.71658L6.8802 2.92992L8.1802 1.59658L10.0002 3.41658L8.66686 4.71658Z" fill="white" />
                                    </svg>
                                </button>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="audio-container audio-manager">
        <div class="audio-container  audio-manager">
            <div class="header-row row">
                <div class="col-md-4" style="display: flex; align-items: center;">
                    <h2 class="table-title">ブラッシュアッププラン</h2>
                </div>
                <div class="col-md-8" style="text-align: right">
                    <button id="download-p2" class="process-btn btn-primary btn-md mb-2">
                        ダウンロード
                        <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.2498 12.6873C11.44 12.6874 11.623 12.7506 11.7619 12.8641C11.9008 12.9776 11.9853 13.133 11.9983 13.2989C12.0112 13.4648 11.9517 13.6289 11.8317 13.7579C11.7117 13.8869 11.5402 13.9712 11.3519 13.9939L11.2498 14H0.750175C0.560049 13.9999 0.377033 13.9368 0.238108 13.8233C0.0991822 13.7097 0.0147053 13.5543 0.00174632 13.3884C-0.0112126 13.2225 0.0483127 13.0585 0.168295 12.9295C0.288276 12.8005 0.459768 12.7161 0.64812 12.6935L0.750175 12.6873H11.2498ZM6.007 0.00087515C6.18817 0.00109312 6.36312 0.0586262 6.49958 0.162854C6.63603 0.267081 6.72476 0.410966 6.7494 0.567946L6.75641 0.657207V9.5772L9.724 6.97812C9.85093 6.86684 10.0193 6.79909 10.1985 6.78721C10.3777 6.77532 10.5559 6.82009 10.7005 6.91336L10.7856 6.97637C10.9129 7.08755 10.9904 7.23505 11.0038 7.39199C11.0172 7.54893 10.9657 7.70486 10.8586 7.83135L10.7866 7.90486L6.54129 11.6241L6.47125 11.6792L6.3792 11.7308L6.34318 11.7492L6.25213 11.7825L6.13207 11.8087L6.06203 11.8157L6.002 11.8175C5.95122 11.8174 5.90059 11.8127 5.85092 11.8035L5.77088 11.7833C5.67578 11.7566 5.58794 11.7131 5.51274 11.6556L1.22043 7.90574C1.08582 7.78877 1.00686 7.63155 0.999463 7.46572C0.992062 7.29989 1.05676 7.13776 1.18054 7.01197C1.30432 6.88619 1.47798 6.80608 1.66657 6.78779C1.85516 6.76949 2.04467 6.81436 2.19695 6.91336L2.281 6.97725L5.2556 9.5737V0.656332C5.2556 0.482262 5.33466 0.315321 5.47539 0.192235C5.61611 0.0691491 5.80698 0 6.006 0L6.007 0.00087515Z" fill="#3D3D3D" />
                        </svg>
                    </button>
                    <button id="cancel-brushup" class="process-btn btn-primary btn-lg btn-edit">
                        ブラッシュアップ再依頼
                        <svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 5V8L12 4L8 0V3C3.58 3 0 6.58 0 11C0 12.57 0.46 14.03 1.24 15.26L2.7 13.8C2.25 12.97 2 12.01 2 11C2 7.69 4.69 5 8 5ZM14.76 6.74L13.3 8.2C13.74 9.04 14 9.99 14 11C14 14.31 11.31 17 8 17V14L4 18L8 22V19C12.42 19 16 15.42 16 11C16 9.43 15.54 7.97 14.76 6.74Z" fill="white" />
                        </svg>
                    </button>
                    <button id="delete-p2" class="process-btn btn-default btn-sm">
                        削除
                        <svg width="16" height="18" viewBox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.77756 0H6.222C5.24156 0 4.44423 0.797333 4.44423 1.77778V2.66667H0.888672V4.44444H2.66645V14.2222C2.66645 15.2027 3.46378 16 4.44423 16H11.5553C12.5358 16 13.3331 15.2027 13.3331 14.2222V4.44444H15.1109V2.66667H11.5553V1.77778C11.5553 0.797333 10.758 0 9.77756 0ZM6.222 1.77778H9.77756V2.66667H6.222V1.77778ZM11.5553 14.2222H4.44423V4.44444H11.5553V14.2222Z" fill="#3D3D3D" />
                        </svg>
                    </button>
                </div>
            </div>
            <hr>
            <div class="table-content">
                <table id="order-p2" class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">
                                <div class="checkbox-cell">
                                    <input id="select-order-p2" class="custom-checkbox select-order-p2" type="checkbox" value="">
                                    <label class="custom-control-label" for="select-order-p2"></label>
                                </div>
                            </th>
                            <th scope="col" class="index">ファイルID</th>
                            <th scope="col">ファイル名</th>
                            <th scope="col">文字数</th>
                            <th scope="col">納品予定日</th>
                            <th scope="col">決済状況</th>
                            <th scope="col">ステータス</th>
                            <th scope="col" class="text-center">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['audio_p2'] as $audio)
                        <tr data-id="{{$audio['id']}}" class="{{ $audio['is_deleted'] ? 'is-deleted' : '' }}">
                            <td class="align-middle" scope="row">
                                <div class="checkbox-cell">
                                    <input id="checkbox-p2-{{$audio['id']}}" class="custom-checkbox checkbox-p2" type="checkbox" value="" {{$audio->is_deleted ? 'disabled' : ''}}>
                                    <label class="custom-control-label" for="checkbox-p2-{{$audio['id']}}"></label>
                                </div>
                            </td>
                            <td class="align-middle index" data-label="ID">{{ $audio['id'] }}</td>
                            <td class="align-middle" data-label="ファイル名">
                                <p class="audio-name-cell" data-toggle="tooltip" data-placement="top" title="{{ $audio['name'] }}">{{ $audio['name'] }}</p>
                            </td>
                            <td class="align-middle" data-label="文字数">{{ $audio['length'] .'文字'}}</td>
                            <td class="align-middle" data-label="納品予定日">{{ @$audio['deadline'] }}</td>
                            <td class="align-middle" data-label="決済状況">
                                {{ $audio['payment_status'] || $audio['payment_status'] === 0 ? @$paymentStatus[$audio['payment_status']] : ((($audio['order_status'] >= 3 && !in_array($audio['order_status'], [4, 5])) ? '支払済み' : '未決済')) }}
                                @if(!is_null($audio['payment_status']))
                                @if($audio['payment_status'] == 1)
                                <i class="cust-icon fas fa-info-circle danger" data-toggle="tooltip" data-placement="top" data-html="true" title="後払い審査に通りませんでした。詳細ページから、クレジットカードで再決済することが可能です。"></i>
                                @elseif($audio['payment_status'] == 0)
                                <i class="cust-icon fas fa-info-circle danger" data-toggle="tooltip" data-placement="top" data-html="true" title="後払いがキャンセルされました。決済が確定されておりませんので、詳細ページからクレジットカード決済を行ってください。"></i>
                                @elseif($audio['payment_status'] == 2)
                                <i class="cust-icon fas fa-info-circle warning" data-toggle="tooltip" data-placement="top" data-html="true" title="審査は翌営業日の12時まで時間がかかる場合がありますので、急ぎの場合は、詳細から、クレジットカード払いにご変更頂くことも可能です。"></i>
                                @elseif($audio['payment_status'] == 5)
                                <i class="cust-icon fas fa-info-circle warning" data-toggle="tooltip" data-placement="top" data-html="true" title="後払の審査が保留になりました。詳細ページから、修正画面に遷移して修正内容をご確認ください。内容を確認し、修正をお願いいたします。修正していただいた後、後払いの与信をかけなおします。"></i>
                                @endif
                                @endif
                            </td>
                            @if($audio['order_status'] == 8)
                                <td class="align-middle text-danger" data-label="ステータス" style="font-size: 16px;font-weight: normal">{{ $orderStatus[$audio['order_status']] }}</td>
                            @else
                                <td class="align-middle {{ (@$audio['order_status'] == 1 || @$audio['order_status'] == 7 || @$audio['order_status'] == 9) ? 'text-warning' : (($audio['order_status'] == 4 || $audio['order_status'] == 2 || $audio['order_status'] == 5) ? 'text-primary' : 'text-success')}}" data-label="ステータス" style="font-size: 16px;font-weight: normal">{{ $orderStatus[$audio['order_status']] }}</td>
                            @endif
                            <td class="action-cell" data-label="操作">
                                <a href="{{ route('audio.view', $audio['id']) }}">
                                    <button class="table-btn btn-view">
                                        詳細
                                        <svg width="15" height="20" viewBox="0 0 15 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7.5 0.137695C4.09091 0.137695 1.17955 2.21103 0 5.1377C1.17955 8.06436 4.09091 10.1377 7.5 10.1377C10.9091 10.1377 13.8205 8.06436 15 5.1377C13.8205 2.21103 10.9091 0.137695 7.5 0.137695ZM7.5 8.47103C5.61818 8.47103 4.09091 6.9777 4.09091 5.1377C4.09091 3.2977 5.61818 1.80436 7.5 1.80436C9.38182 1.80436 10.9091 3.2977 10.9091 5.1377C10.9091 6.9777 9.38182 8.47103 7.5 8.47103ZM7.5 3.1377C6.36818 3.1377 5.45455 4.03103 5.45455 5.1377C5.45455 6.24436 6.36818 7.1377 7.5 7.1377C8.63182 7.1377 9.54545 6.24436 9.54545 5.1377C9.54545 4.03103 8.63182 3.1377 7.5 3.1377Z" fill="#256c83" />
                                        </svg>
                                    </button>
                                </a>
                                @if(!$audio->is_deleted)
                                <a href="{{ route('audio.edit', $audio['id']) }}">
                                    <button class="table-btn btn-edit">
                                        編集
                                        <svg width="12" height="15" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.9335 2.48992L9.10686 0.663251C8.86846 0.439315 8.55606 0.310824 8.22908 0.30222C7.90211 0.293615 7.58338 0.405498 7.33353 0.616585L1.33353 6.61658C1.11804 6.83389 0.983867 7.11872 0.953531 7.42325L0.666864 10.2032C0.657884 10.3009 0.670554 10.3993 0.703972 10.4915C0.73739 10.5837 0.790733 10.6674 0.860198 10.7366C0.922491 10.7984 0.996369 10.8473 1.07759 10.8804C1.15882 10.9136 1.24579 10.9304 1.33353 10.9299H1.39353L4.17353 10.6766C4.47806 10.6462 4.76289 10.5121 4.9802 10.2966L10.9802 4.29658C11.2131 4.05056 11.3389 3.72226 11.3302 3.38361C11.3214 3.04496 11.1788 2.72359 10.9335 2.48992ZM4.05353 9.34325L2.05353 9.52992L2.23353 7.52992L6.0002 3.80992L7.8002 5.60992L4.05353 9.34325ZM8.66686 4.71658L6.8802 2.92992L8.1802 1.59658L10.0002 3.41658L8.66686 4.71658Z" fill="white" />
                                        </svg>
                                    </button>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('user.modal.confirm_modal')
@include('user.modal.notify_modal')
@include('user.modal.error_modal')
<script src="{{ asset('/user/js/order.js')}}?v=12"></script>
<script>
    $(document).ready(function() {
        $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    });
</script>
@endsection
