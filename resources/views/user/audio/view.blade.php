@inject('provider', 'App\Http\Controllers\ServiceProvider')
@php
$orderStatus = config('const.userOrderStatus');
$status = config('const.audioStatus');
$paymentStatus = config('const.paymentStatus');
$paymentType = config('const.paymentType');
@endphp
@extends('user.layouts.user_layout')
@section('title','ファイル詳細')
@section('style')
<link rel="stylesheet" href="{{ asset('/user/css/boostrap-rating.css') }}">
<style>
    .rating-symbol .far {
        margin-left: 0;
    }

    .rating-symbol .fas {
        color: #FFC100;
    }

    .rating-symbol .fas.empty {
        color: #8F8F8F;
        cursor: default;
    }

    .rating-symbol .fa-star {
        font-size: 20px;
        cursor: pointer;
    }

    .rating-symbol .fa-star.rated {
        font-size: 20px;
        cursor: default;
    }

    .rating-symbol {
        margin: 0 3px;
    }

    @media only screen and (max-width: 810px) {
        .right-content {
            padding: 30px 10px;
        }
    }
</style>
@endsection
@section('content')
<div class="main-content">
    <span class="page-title">ファイル一覧 > ファイル詳細</span>
    <div class="audio-container">
        <div class="header-row row">
            {{ csrf_field() }}
            <input id="audio-id" type="text" name="audio_id" value="{{$data->id}}" hidden>
            <input id="audio-name" type="text" name="audio_name" value="{{$data->name}}" hidden>
            <div class="col-md-5 col-12 d-flex align-items-center">
                <div class="audio-name" style="max-width: 300px;">
                    <h2 id="name" data-toggle="tooltip" title="{{ $data->name }}">{{ $data->name }}</h2>
                </div>
            </div>
            @if(!$isDeleted)
            <div class="col-md-7 col-12" style="text-align: right">
                <button id="download" class="process-btn btn-primary btn-md">
                    ダウンロード
                    <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.2498 12.6873C11.44 12.6874 11.623 12.7506 11.7619 12.8641C11.9008 12.9776 11.9853 13.133 11.9983 13.2989C12.0112 13.4648 11.9517 13.6289 11.8317 13.7579C11.7117 13.8869 11.5402 13.9712 11.3519 13.9939L11.2498 14H0.750175C0.560049 13.9999 0.377033 13.9368 0.238108 13.8233C0.0991822 13.7097 0.0147053 13.5543 0.00174632 13.3884C-0.0112126 13.2225 0.0483127 13.0585 0.168295 12.9295C0.288276 12.8005 0.459768 12.7161 0.64812 12.6935L0.750175 12.6873H11.2498ZM6.007 0.00087515C6.18817 0.00109312 6.36312 0.0586262 6.49958 0.162854C6.63603 0.267081 6.72476 0.410966 6.7494 0.567946L6.75641 0.657207V9.5772L9.724 6.97812C9.85093 6.86684 10.0193 6.79909 10.1985 6.78721C10.3777 6.77532 10.5559 6.82009 10.7005 6.91336L10.7856 6.97637C10.9129 7.08755 10.9904 7.23505 11.0038 7.39199C11.0172 7.54893 10.9657 7.70486 10.8586 7.83135L10.7866 7.90486L6.54129 11.6241L6.47125 11.6792L6.3792 11.7308L6.34318 11.7492L6.25213 11.7825L6.13207 11.8087L6.06203 11.8157L6.002 11.8175C5.95122 11.8174 5.90059 11.8127 5.85092 11.8035L5.77088 11.7833C5.67578 11.7566 5.58794 11.7131 5.51274 11.6556L1.22043 7.90574C1.08582 7.78877 1.00686 7.63155 0.999463 7.46572C0.992062 7.29989 1.05676 7.13776 1.18054 7.01197C1.30432 6.88619 1.47798 6.80608 1.66657 6.78779C1.85516 6.76949 2.04467 6.81436 2.19695 6.91336L2.281 6.97725L5.2556 9.5737V0.656332C5.2556 0.482262 5.33466 0.315321 5.47539 0.192235C5.61611 0.0691491 5.80698 0 6.006 0L6.007 0.00087515Z" fill="#3D3D3D" />
                    </svg>
                </button>
                @if ($order_p2 && ($order_p2->status == 6 || $order_p2->status == 1))

                @else
                @if (!$order_p2)
                <button id="brush-up" class="process-btn btn-primary btn-lg">
                    ブラッシュアップ依頼
                    <svg width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.8574 4.57143L13.5287 3.0019L15 2.28571L13.5287 1.56952L12.8574 0L12.186 1.56952L10.7148 2.28571L12.186 3.0019L12.8574 4.57143ZM4.64406 4.57143L5.31541 3.0019L6.78667 2.28571L5.31541 1.56952L4.64406 0L3.97271 1.56952L2.50145 2.28571L3.97271 3.0019L4.64406 4.57143ZM12.8574 8.7619L12.186 10.3314L10.7148 11.0476L12.186 11.7638L12.8574 13.3333L13.5287 11.7638L15 11.0476L13.5287 10.3314L12.8574 8.7619ZM11.2219 6.18667L9.20068 4.03048C9.05784 3.88571 8.87928 3.80952 8.69359 3.80952C8.5079 3.80952 8.32935 3.88571 8.18651 4.03048L0.208864 12.541C0.142655 12.6114 0.0901273 12.6952 0.0542876 12.7873C0.0184478 12.8795 0 12.9783 0 13.0781C0 13.1779 0.0184478 13.2767 0.0542876 13.3689C0.0901273 13.461 0.142655 13.5448 0.208864 13.6152L2.23006 15.7714C2.3729 15.9238 2.55145 16 2.73714 16C2.92283 16 3.10139 15.9238 3.24423 15.779L11.2219 7.26857C11.5004 6.97143 11.5004 6.48381 11.2219 6.18667V6.18667ZM8.69359 5.65333L9.70062 6.72762L8.865 7.61905L7.85797 6.54476L8.69359 5.65333V5.65333ZM2.73714 14.1638L1.73012 13.0895L6.85095 7.61905L7.85797 8.69333L2.73714 14.1638Z" fill="#3D3D3D" />
                    </svg>
                </button>
                @else
                <button id="cancel-brushup" class="process-btn btn-primary btn-lg">
                    ブラッシュアップ再依頼
                    <svg width="16" height="22" viewBox="0 0 16 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 5V8L12 4L8 0V3C3.58 3 0 6.58 0 11C0 12.57 0.46 14.03 1.24 15.26L2.7 13.8C2.25 12.97 2 12.01 2 11C2 7.69 4.69 5 8 5ZM14.76 6.74L13.3 8.2C13.74 9.04 14 9.99 14 11C14 14.31 11.31 17 8 17V14L4 18L8 22V19C12.42 19 16 15.42 16 11C16 9.43 15.54 7.97 14.76 6.74Z" fill="white" />
                    </svg>
                </button>
                @endif
                @endif
            </div>
            @endif
        </div>

        @if($isDeleted)
        <div class="deleted-audio-box">
            <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.88889 0H5.33333C4.35289 0 3.55556 0.797333 3.55556 1.77778V2.66667H0V4.44444H1.77778V14.2222C1.77778 15.2027 2.57511 16 3.55556 16H10.6667C11.6471 16 12.4444 15.2027 12.4444 14.2222V4.44444H14.2222V2.66667H10.6667V1.77778C10.6667 0.797333 9.86933 0 8.88889 0ZM5.33333 1.77778H8.88889V2.66667H5.33333V1.77778ZM10.6667 14.2222H3.55556V4.44444H10.6667V14.2222Z" fill="#888E8E" />
            </svg>
            VOITRAの利用規約により、{{ date('Y年m月d日 H:i:s', strtotime($date)) }}に自動削除されました。
        </div>
        @else
        <div class="audio-box">
            <audio controls>
                <source src="{{ $data->url }}" type="audio/flac">
            </audio>
        </div>
        @endif
        <div class="box-edit {{$isDeleted ? 'deleted' : ''}}">
            <div class="header-row row">
                <div class="col-md-6 col-12 text-left edit-title">
                    <h2 class="table-title mb-1">認識結果</h2>
                </div>
                @if($order_p1 && $order_p1->pivot->status == 2 && !$isDeleted)
                <div class="col-md-6 col-12 edit-button">
                    <a href="/audio/edit/{{$data['id']}}?type=0">
                        <button id="edit-data" class="process-btn btn-primary btn-lg mb-2" data-id="{{$data['id']}}">
                            編集
                            <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.4335 2.89324L8.60686 1.06657C8.36846 0.842636 8.05606 0.714144 7.72908 0.70554C7.40211 0.696935 7.08338 0.808818 6.83353 1.01991L0.833531 7.0199C0.618042 7.23721 0.483867 7.52204 0.453531 7.82657L0.166864 10.6066C0.157884 10.7042 0.170554 10.8026 0.203972 10.8948C0.23739 10.987 0.290733 11.0707 0.360198 11.1399C0.422491 11.2017 0.496369 11.2506 0.577594 11.2838C0.658819 11.3169 0.745793 11.3337 0.833531 11.3332H0.893531L3.67353 11.0799C3.97806 11.0496 4.26289 10.9154 4.4802 10.6999L10.4802 4.6999C10.7131 4.45388 10.8389 4.12558 10.8302 3.78693C10.8214 3.44828 10.6788 3.12691 10.4335 2.89324ZM3.55353 9.74657L1.55353 9.93324L1.73353 7.93324L5.5002 4.21324L7.3002 6.01324L3.55353 9.74657ZM8.16686 5.1199L6.3802 3.33324L7.6802 1.9999L9.5002 3.8199L8.16686 5.1199Z" fill="#4F4F4F" />
                            </svg>
                        </button>
                    </a>
                </div>
                @endif
            </div>
            <hr>
            <div class="option-box">
                @if($isDeleted)
                <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.88889 0H5.33333C4.35289 0 3.55556 0.797333 3.55556 1.77778V2.66667H0V4.44444H1.77778V14.2222C1.77778 15.2027 2.57511 16 3.55556 16H10.6667C11.6471 16 12.4444 15.2027 12.4444 14.2222V4.44444H14.2222V2.66667H10.6667V1.77778C10.6667 0.797333 9.86933 0 8.88889 0ZM5.33333 1.77778H8.88889V2.66667H5.33333V1.77778ZM10.6667 14.2222H3.55556V4.44444H10.6667V14.2222Z" fill="#888E8E" />
                </svg>
                VOITRAの利用規約により、{{ date('Y年m月d日 H:i:s', strtotime($date)) }}に自動削除されました。
                @else
                @if($isOption)
                @if($data->api_result)
                @php $spks = $provider::spk2id(json_decode($data->api_result)) @endphp
                @foreach(json_decode($data->api_result) as $api_result)
                @if(trim($api_result->text) != '')
                <div class="row mb-2">
                    <div class="col-md-2 col-12">
                        <p class="option-speaker speaker-{{$spks[$api_result->speaker] <= 4 ? $spks[$api_result->speaker] : $spks[$api_result->speaker] % 5}}">
                            スピーカー{{$spks[$api_result->speaker]}}</p>
                        <p class="option-time">{{gmdate("H:i:s", $api_result->start)}}</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <p class="option-result speaker-{{$spks[$api_result->speaker] <= 4 ? $spks[$api_result->speaker] : $spks[$api_result->speaker] % 5}}">{{$api_result->text}}</p>
                    </div>
                </div>
                @endif
                @endforeach
                @endif
                @else
                <textarea class="form-control p-0" disabled>{{ $data->api_result }}</textarea>
                @endif
                @endif
            </div>
        </div>
        @if($order_p2 && ((!is_null($data->edited_result) && $order_p2->status == 6) || $isDeleted))
        <div class="box-edit box-edited-brushup {{$isDeleted ? 'deleted' : ''}}">
            <div class="header-row row">
                <div class="col-md-6 col-12 text-left">
                    <h2 class="table-title mb-1">ブラッシュアップ結果</h2>
                </div>
                @if(!$isDeleted && $order_p2->pivot->status == 2)
                <div class="col-md-6 col-12 edit-button">
                    <a href="/audio/edit/{{$data['id']}}?type=1">
                        <button id="edit-data" class="process-btn btn-primary btn-lg mb-2" data-id="{{$data['id']}}">
                            編集
                            <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.4335 2.89324L8.60686 1.06657C8.36846 0.842636 8.05606 0.714144 7.72908 0.70554C7.40211 0.696935 7.08338 0.808818 6.83353 1.01991L0.833531 7.0199C0.618042 7.23721 0.483867 7.52204 0.453531 7.82657L0.166864 10.6066C0.157884 10.7042 0.170554 10.8026 0.203972 10.8948C0.23739 10.987 0.290733 11.0707 0.360198 11.1399C0.422491 11.2017 0.496369 11.2506 0.577594 11.2838C0.658819 11.3169 0.745793 11.3337 0.833531 11.3332H0.893531L3.67353 11.0799C3.97806 11.0496 4.26289 10.9154 4.4802 10.6999L10.4802 4.6999C10.7131 4.45388 10.8389 4.12558 10.8302 3.78693C10.8214 3.44828 10.6788 3.12691 10.4335 2.89324ZM3.55353 9.74657L1.55353 9.93324L1.73353 7.93324L5.5002 4.21324L7.3002 6.01324L3.55353 9.74657ZM8.16686 5.1199L6.3802 3.33324L7.6802 1.9999L9.5002 3.8199L8.16686 5.1199Z" fill="#4F4F4F" />
                            </svg>
                        </button>
                    </a>
                </div>
                @endif
            </div>
            <hr>
            <div class="option-box">
                @if($isDeleted)
                <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.88889 0H5.33333C4.35289 0 3.55556 0.797333 3.55556 1.77778V2.66667H0V4.44444H1.77778V14.2222C1.77778 15.2027 2.57511 16 3.55556 16H10.6667C11.6471 16 12.4444 15.2027 12.4444 14.2222V4.44444H14.2222V2.66667H10.6667V1.77778C10.6667 0.797333 9.86933 0 8.88889 0ZM5.33333 1.77778H8.88889V2.66667H5.33333V1.77778ZM10.6667 14.2222H3.55556V4.44444H10.6667V14.2222Z" fill="#888E8E" />
                </svg>
                VOITRAの利用規約により、{{ date('Y年m月d日 H:i:s', strtotime($date)) }}に自動削除されました。
                @else
                @if($isOption)
                @php $spks = $provider::spk2id(json_decode($data->edited_result)) @endphp
                @foreach(json_decode($data->edited_result) as $edited_result)
                @if(trim($edited_result->text) != '')
                <div class="row mb-2">
                    <div class="col-md-2 col-12">
                        <p class="option-speaker speaker-{{$spks[$edited_result->speaker] <= 4 ? $spks[$edited_result->speaker] : $spks[$edited_result->speaker] % 5}}">
                            スピーカー{{$spks[$edited_result->speaker]}}</p>
                        <p class="option-time">{{gmdate("H:i:s", $edited_result->start)}}</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <p class="option-result speaker-{{$spks[$edited_result->speaker] <= 4 ? $spks[$edited_result->speaker] : $spks[$edited_result->speaker] % 5}}">{{$edited_result->text}}</p>
                    </div>
                </div>
                @endif
                @endforeach
                @else
                <div>
                    <textarea class="form-control p-0" disabled>{{ $data->edited_result }}</textarea>
                </div>
                @endif
                @endif
            </div>
        </div>
        @endif
        @if(!is_null($data->result))
        <div class="box-edit box-edited {{$isDeleted ? 'deleted' : ''}}">
            <div class="header-row row">
                <div class="col-md-6 col-12 text-left">
                    <h2 class="table-title mb-1">認識結果（編集済み）</h2>
                </div>
                @if($order_p1->pivot->status == 2 && !$isDeleted)
                <div class="col-md-6 col-12 edit-button">
                    <a href="/audio/edit/{{$data['id']}}?type=2">
                        <button id="edit-data" class="process-btn btn-primary btn-lg mb-2" data-id="{{$data['id']}}">
                            編集
                            <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.4335 2.89324L8.60686 1.06657C8.36846 0.842636 8.05606 0.714144 7.72908 0.70554C7.40211 0.696935 7.08338 0.808818 6.83353 1.01991L0.833531 7.0199C0.618042 7.23721 0.483867 7.52204 0.453531 7.82657L0.166864 10.6066C0.157884 10.7042 0.170554 10.8026 0.203972 10.8948C0.23739 10.987 0.290733 11.0707 0.360198 11.1399C0.422491 11.2017 0.496369 11.2506 0.577594 11.2838C0.658819 11.3169 0.745793 11.3337 0.833531 11.3332H0.893531L3.67353 11.0799C3.97806 11.0496 4.26289 10.9154 4.4802 10.6999L10.4802 4.6999C10.7131 4.45388 10.8389 4.12558 10.8302 3.78693C10.8214 3.44828 10.6788 3.12691 10.4335 2.89324ZM3.55353 9.74657L1.55353 9.93324L1.73353 7.93324L5.5002 4.21324L7.3002 6.01324L3.55353 9.74657ZM8.16686 5.1199L6.3802 3.33324L7.6802 1.9999L9.5002 3.8199L8.16686 5.1199Z" fill="#4F4F4F" />
                            </svg>
                        </button>
                    </a>
                </div>
                @endif
            </div>
            <hr>
            <div class="option-box">
                @if($isDeleted)
                <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.88889 0H5.33333C4.35289 0 3.55556 0.797333 3.55556 1.77778V2.66667H0V4.44444H1.77778V14.2222C1.77778 15.2027 2.57511 16 3.55556 16H10.6667C11.6471 16 12.4444 15.2027 12.4444 14.2222V4.44444H14.2222V2.66667H10.6667V1.77778C10.6667 0.797333 9.86933 0 8.88889 0ZM5.33333 1.77778H8.88889V2.66667H5.33333V1.77778ZM10.6667 14.2222H3.55556V4.44444H10.6667V14.2222Z" fill="#888E8E" />
                </svg>
                VOITRAの利用規約により、{{ date('Y年m月d日 H:i:s', strtotime($date)) }}に自動削除されました。
                @else
                @if($isOption)
                @php $spks = $provider::spk2id(json_decode($data->result)) @endphp
                @foreach(json_decode($data->result) as $result)
                @if(trim($result->text) != '')
                <div class="row mb-2">
                    <div class="col-md-2 col-12">
                        <p class="option-speaker speaker-{{$spks[$result->speaker] <= 4 ? $spks[$result->speaker] : $spks[$result->speaker] % 5}}">
                            スピーカー{{$spks[$result->speaker]}}</p>
                        <p class="option-time">{{gmdate("H:i:s", $result->start)}}</p>
                    </div>
                    <div class="col-md-10 col-12">
                        <p class="option-result speaker-{{$spks[$result->speaker] <= 4 ? $spks[$result->speaker] : $spks[$result->speaker] % 5}}">{{$result->text}}</p>
                    </div>
                </div>
                @endif
                @endforeach
                @else
                <div>
                    <textarea class="form-control p-0" disabled>{{ $data->result }}</textarea>
                </div>
                @endif
                @endif
            </div>
        </div>
        @endif
        @if(!$isDeleted)
        <div class="policy-delete">
            <i class="fas fa-info-circle"></i>
            VOITRAの利用規約により、音声ファイルと認識結果は{{ date('Y年m月d日 H:i:s', strtotime($date)) }}まで表示され、その後自動削除されます。<br>
            @if(!$order_p2)
            それに伴いブラッシュアッププラン申し込みも出来なくなりますので、ご了承ください。
            @endif
        </div>
        @endif
        <div class="upload-container">
            @if ($order_p1)
            <div class="block">
                <div class="block-header row">
                    <div class="col-md-5 col-12">
                        <img src="{{ asset('user/images/block-header.png') }}">
                        <h2>AI文字起こしプラン </h2>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <div class="cs-label">
                                <p>{{@$status[$order_p1->audios->find($data->id)->pivot->status]}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-item row mt-4 ml-0 mr-0">
                    <div class="col-lg-2 col-md-4 col-12 order-item-view">
                        <p class="mb-2">アップロード日</p>
                        <p class="font-weight-bold">{{ date('Y-m-d',strtotime($data->created_at)) }}</p>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 order-item-view">
                        <p class="mb-2"> 時間</p>
                        <p class="font-weight-bold">{{ gmdate('H時間i分s秒', $data->duration) }}</p>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 order-item-view">
                        <p class="mb-2">金額（税込）</p>
                        <p class="font-weight-bold">{{ $data->price . '円' }}</p>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 order-item-view">
                        <p class="mb-2"> 決済日</p>
                        <p class="font-weight-bold">{{ date_format($data->updated_at, "Y-m-d")}}</p>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 order-item-view mb-0">
                        <p class="mb-2">決済方法</p>
                        <p class="font-weight-bold"> {{ @$paymentType[$order_p1->payment_type]}}</p>
                    </div>
                    <div class="col-lg-2 col-md-4 col-12 order-item-view mb-0">
                        <p class="mb-2">決済状況</p>
                        <p class="font-weight-bold"> {{ @$paymentStatus[$order_p1->payment_status] }}</p>
                    </div>
                </div>
                @if($order_p1->payment_type == 2)
                <div class="" style="padding: 10px">
                    @if($order_p1->payment_status == 1 || $order_p1->payment_status == 0)
                    <div class="policy-delete mt-3" style="margin-left: 5px;">
                        <i class="fas fa-info-circle"></i>
                        <p>{{ $order_p1->payment_status == 1 ? 'コンビニ後払の審査に通りませんでした。クレジットカードで再決済お願いします。': 'コンビニ後払をキャンセルしましたが、クレジットカードの決済は完了しておりません。再度、決済画面にお進みください。'}}</p>
                    </div>
                    <button id="repay" class="process-btn btn-primary btn-md mt-3" data-type="{{ $order_p1->payment_status }}" data-link="{{ route('repay', ['type' => 1, 'order_id' => $order_p1->id]) }}">
                        {{$order_p1->payment_status == 1 ? 'クレジットカードで再決済' : 'クレジットカード決済へ進む'}}
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="8" cy="8" r="7.5" stroke="#4F4F4F" />
                            <path d="M7.90926 4.57031L11.2196 7.99888L7.90926 11.4275M3.86328 7.99888H11.2196H3.86328Z" stroke="#4F4F4F" stroke-width="2" />
                        </svg>
                    </button>
                    @elseif($order_p1->payment_status == 2)
                    <div class="policy-delete mt-3" style="margin-left: 5px;">
                        <i class="fas fa-info-circle"></i>
                        <p>後払いの与信を審査しております。審査は翌営業日の12時まで時間がかかる場合がありますので、お急ぎの場合は以下の「クレジットカード払いに変更」ボタンにてコンビニ後払いをキャンセルしてクレジットカード払いにご変更ください。</p>
                    </div>
                    <div class="mt-3">
                        <button id="repay" class="process-btn btn-outline-repay btn-md" data-type="{{ $order_p1->payment_status }}" data-link="{{ route('repay', ['type' => 1, 'order_id' => $order_p1->id]) }}">
                            クレジットカード払いに変更
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="10.5" stroke="#03749C" />
                                <path d="M10.8769 6.28777L15.4287 11.0021L10.8769 15.7163M5.31372 11.0021H15.4287H5.31372Z" stroke="#03749C" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                    @elseif($order_p1->payment_status == 5)
                    <div class="policy-delete mt-3" style="margin-left: 5px;">
                        <i class="fas fa-info-circle"></i>
                        <p class="text-danger">後払の審査が保留になりました。請求先の情報を修正が必要になりますので、修正してください。</p>
                        <p>修正していただいた後、後払いの与信をかけなおします。審査は翌営業日の12時まで時間がかかる場合がありますので、お急ぎの場合は以下の<span class="font-weight-bold">「クレジットカード払いに変更」</span>ボタンにてコンビニ後払いをキャンセルしてクレジットカード払いにご変更ください。</p>
                    </div>
                    <div class="mt-3">
                        <a class="process-btn btn-primary btn-md btn-fix" href="{{ route('fixAddress', ['type' => 1, 'order_id' => $order_p1->id]) }}">
                            請求先情報を修正
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8" cy="8" r="7.5" stroke="#4F4F4F" />
                                <path d="M7.90926 4.57031L11.2196 7.99888L7.90926 11.4275M3.86328 7.99888H11.2196H3.86328Z" stroke="#4F4F4F" stroke-width="2" />
                            </svg>
                        </a>
                    </div>
                    <div class="mt-4">
                        <button id="repay" class="process-btn btn-outline-repay btn-md" data-type="{{ $order_p1->payment_status }}" data-link="{{ route('repay', ['type' => 1, 'order_id' => $order_p1->id]) }}">
                            クレジットカード払いに変更
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="10.5" stroke="#03749C" />
                                <path d="M10.8769 6.28777L15.4287 11.0021L10.8769 15.7163M5.31372 11.0021H15.4287H5.31372Z" stroke="#03749C" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
                @endif
                @if($order_p1->pivot->status == 2)
                <div class="feedback-box" data-plan="1">
                    <div class="feedback-header">
                        レビュー
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12 feedback-title">
                            AI文字起こしプランの満足度
                        </div>
                        <div class="col-lg-6 col-md-4 col-8">
                            <input type="hidden" name="rate-plan-1" class="rating {{ $order_p1->pivot->rate || $isDeleted ? 'rated' : ''}}" data-filled="fas fa-star {{ $order_p1->pivot->rate || $isDeleted ? 'rated' : '' }}" data-empty="{{ $order_p1->pivot->rate || $isDeleted ? 'fas fa-star empty' : 'far fa-star' }}" value="{{$order_p1->pivot->rate}}" {{ $order_p1->pivot->rate || $isDeleted ? 'disabled' : ''}} />
                        </div>
                        @if($order_p1->pivot->rate)
                        <div class="col-lg-3 col-md-4 col-4">
                            <p class="feedback-date">{{date('Y/m/d',strtotime($order_p1->pivot->rate_at))}}</p>
                        </div>
                        @endif
                    </div>
                    <div class="comment-box">
                        <div class="row">
                            <div class="col-md-8 col-8">
                                <p class="mb-3 feedback-title">レビュー</p>
                            </div>
                            @if($order_p1->pivot->comment)
                            <div class="col-md-4 col-4">
                                <p class="feedback-date">{{date('Y/m/d',strtotime($order_p1->pivot->comment_at))}}</p>
                            </div>
                            @endif
                        </div>
                        @if($order_p1->pivot->comment)
                        <div class="px-2 commented">{{$order_p1->pivot->comment}}</div>
                        @else
                        <textarea class="form-control" name="comment-plan-1" {{ $isDeleted ? 'disabled' : ''}} placeholder="{{ $isDeleted ? '音声ファイルが削除されたため、フィードバックができなくなりました。' : 'ご意見・ご要望がございましたら、コメントをお願いします。（最大255文字まで）'}}" maxlength="255"></textarea>
                        <p class="count-char"><span>0</span>/255</p>
                        @endif
                    </div>
                    @if(!$isDeleted && !$order_p1->pivot->comment)
                    <div class="text-right mt-3">
                        <button disabled type="button" class="btn-primary-info submit-feedback">
                            送信<i class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                    @endif
                </div>
                @endif
            </div>
            @endif
            @if ($order_p2)
            <div class="block">
                <div class="block-header row">
                    <div class="col-md-5 col-12">
                        <img src="{{ asset('user/images/block-header.png') }}">
                        <h2>ブラッシュアッププラン</h2>
                    </div>
                    <div class="col-md-7 col-12">
                        <div class="form-group">
                            <div class="cs-label">
                                <p>{{@$orderStatus[$order_p2->status]}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-item row mt-4 ml-0 mr-0">
                    <div class="col-lg-2 col-md-2 col-12 order-item-view">
                        <p class="mb-2">文字数</p>
                        <p class="font-weight-bold">{{ $order_p2['total_time'] . '文字' }}</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12 order-item-view">
                        <p class="mb-2">金額（税込）</p>
                        <p class="font-weight-bold">{{ $order_p2->total_price . '円' }}</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12 order-item-view">
                        <p class="mb-2">希望納品日</p>
                        <p class="font-weight-bold">{{ $order_p2->audios->find($data->id)->pivot->user_estimate }}</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12 order-item-view">
                        <p class="mb-2">納品予定日</p>
                        <p class="font-weight-bold">{{ $order_p2->deadline }}</p>
                    </div>
                </div>
                <div class="order-item row mt-4 ml-0 mr-0">
                    <div class="col-lg-2 col-md-2 col-12 order-item-view">
                        <p class="mb-2">決済日</p>
                        <p class="font-weight-bold">{{ $order_p2->payment_type ? date_format($data->updated_at, "Y-m-d") : '' }}</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12 order-item-view mb-0">
                        <p class="mb-2">決済方法</p>
                        <p class="font-weight-bold">{{ @$paymentType[$order_p2->payment_type]}}</p>
                    </div>
                    <div class="col-lg-2 col-md-2 col-12 order-item-view">
                        <p class="mb-2">決済状況</p>
                        <p class="font-weight-bold">{{ $order_p2->payment_status || $order_p2->payment_status === 0 ?  @$paymentStatus[$order_p2->payment_status] : (($order_p2['order_status'] >= 3) ? '支払済み' : '未決済') }}</p>
                    </div>
                </div>
                @if($order_p2->status == 6)
                <div class="feedback-box" data-plan="2">
                    <div class="feedback-header">
                        レビュー
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-12 feedback-title">
                            ブラッシュアッププランの満足度
                        </div>
                        <div class="col-lg-6 col-md-4 col-8">
                            <input type="hidden" name="rate-plan-2" class="rating" data-filled="fas fa-star" data-empty="{{ $order_p2->pivot->rate || $isDeleted ? 'fas fa-star empty' : 'far fa-star' }}" value="{{$order_p2->pivot->rate}}" {{ $order_p2->pivot->rate || $isDeleted ? 'disabled' : ''}} />
                        </div>
                        <div class="col-lg-3 col-md-4 col-4">
                            @if($order_p2->pivot->rate)
                            <p class="feedback-date">{{date('Y/m/d',strtotime($order_p2->pivot->rate_at))}}</p>
                            @endif
                        </div>
                    </div>
                    <div class="comment-box">
                        <div class="row">
                            <div class="col-md-8 col-8">
                                <p class="mb-3 feedback-title">レビュー</p>
                            </div>
                            @if($order_p2->pivot->comment)
                            <div class="col-md-4 col-4">
                                <p class="feedback-date">{{date('Y/m/d',strtotime($order_p2->pivot->comment_at))}}</p>
                            </div>
                            @endif
                        </div>
                        @if($order_p2->pivot->comment)
                        <div class="px-2 commented">{{$order_p2->pivot->comment}}</div>
                        @else
                        <textarea class="form-control" name="comment-plan-2" {{ $isDeleted ? 'disabled' : ''}} placeholder="{{ $isDeleted ? '音声ファイルが削除されたため、フィードバックができなくなりました。' : 'ご意見・ご要望がございましたら、コメントをお願いします。（最大255文字まで）'}}" maxlength="255"></textarea>
                        <p class="count-char"><span>0</span>/255</p>
                        @endif
                    </div>
                    @if(!$isDeleted && !$order_p2->pivot->comment)
                    <div class="text-right mt-3">
                        <button disabled type="button" class="btn-primary-info submit-feedback">
                            送信<i class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                    @endif
                </div>
                @endif
                <form id="payment" action="/audio/brushup-confirm" method="post">
                    {{ csrf_field() }}
                    <input hidden type="text" name="order_id" value="{{$order_p2->id}}">
                </form>
                @if($order_p2->payment_type == 2)
                <div class="" style="padding: 10px">
                    @if($order_p2->payment_status == 1 || $order_p2->payment_status == 0)
                    <div class="policy-delete mt-3" style="margin-left: 5px;">
                        <i class="fas fa-info-circle"></i>
                        <p>{{ $order_p2->payment_status == 1 ? 'コンビニ後払の審査に通りませんでした。クレジットカードで再決済お願いします。': 'コンビニ後払をキャンセルしましたが、クレジットカードの決済は完了しておりません。再度、決済画面にお進みください。'}}</p>
                    </div>
                    <button id="repay" class="process-btn btn-primary btn-md mt-3" data-type="{{ $order_p2->payment_status }}" data-link="{{ route('repay', ['type' => 2, 'order_id' => $order_p2->id]) }}">
                        {{$order_p2->payment_status == 1 ? 'クレジットカードで再決済' : 'クレジットカード決済へ進む'}}
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="8" cy="8" r="7.5" stroke="#4F4F4F" />
                            <path d="M7.90926 4.57031L11.2196 7.99888L7.90926 11.4275M3.86328 7.99888H11.2196H3.86328Z" stroke="#4F4F4F" stroke-width="2" />
                        </svg>
                    </button>
                    @elseif($order_p2->payment_status == 2)
                    <div class="policy-delete mt-3" style="margin-left: 5px;">
                        <i class="fas fa-info-circle"></i>
                        <p>後払いの与信を審査しております。審査は翌営業日の12時まで時間がかかる場合がありますので、お急ぎの場合は以下の「クレジットカード払いに変更」ボタンにてコンビニ後払いをキャンセルしてクレジットカード払いにご変更ください。</p>
                    </div>
                    <div class="mt-3">
                        <button id="repay" class="process-btn btn-outline-repay btn-md" data-type="{{ $order_p2->payment_status }}" data-link="{{ route('repay', ['type' => 2, 'order_id' => $order_p2->id]) }}">
                            クレジットカード払いに変更
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="10.5" stroke="#03749C" />
                                <path d="M10.8769 6.28777L15.4287 11.0021L10.8769 15.7163M5.31372 11.0021H15.4287H5.31372Z" stroke="#03749C" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                    @elseif($order_p2->payment_status == 5)
                    <div class="policy-delete mt-3" style="margin-left: 5px;">
                        <i class="fas fa-info-circle"></i>
                        <p class="text-danger">後払の審査が保留になりました。請求先の情報を修正が必要になりますので、修正してください。</p>
                        <p>後払いの与信を審査しております。審査は翌営業日の12時まで時間がかかる場合がありますので、お急ぎの場合は以下の「クレジットカード払いに変更」ボタンにてコンビニ後払いをキャンセルしてクレジットカード払いにご変更ください。</p>
                    </div>
                    <div class="mt-3">
                        <a class="process-btn btn-primary btn-md btn-fix" href="{{ route('fixAddress', ['type' => 2, 'order_id' => $order_p2->id]) }}">
                            請求先情報を修正
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="8" cy="8" r="7.5" stroke="#4F4F4F" />
                                <path d="M7.90926 4.57031L11.2196 7.99888L7.90926 11.4275M3.86328 7.99888H11.2196H3.86328Z" stroke="#4F4F4F" stroke-width="2" />
                            </svg>
                        </a>
                    </div>
                    <div class="mt-4">
                        <button id="repay" class="process-btn btn-outline-repay btn-md" data-type="{{ $order_p2->payment_status }}" data-link="{{ route('repay', ['type' => 2, 'order_id' => $order_p2->id]) }}">
                            クレジットカード払いに変更
                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="11" cy="11" r="10.5" stroke="#03749C" />
                                <path d="M10.8769 6.28777L15.4287 11.0021L10.8769 15.7163M5.31372 11.0021H15.4287H5.31372Z" stroke="#03749C" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                    @endif
                </div>
                @endif
                @if ($order_p2->status == 2)
                    @if($order_p2->payment_status !== 2 && $order_p2->payment_status !== 5 && $order_p2->payment_status !== 1)
                    <div class="upload-button">
                        <a class="btn custom-btn btn-primary" href="{{ route('audio.confirmRequest', $order_p2->id) }}">
                            見積り確認
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12.5" cy="12" r="11.5" stroke="black" />
                                <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2" />
                            </svg>
                        </a>
                    </div>
                    @endif
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@include('user.modal.confirm_modal')
@include('user.modal.error_modal')
@include('user.modal.success_modal')
@include('user.modal.modal_cancel_postpaid')
<input name="feedbackPlan" value="{{$feedbackPlan}}" type="hidden">
@if($feedbackPlan)
@include('user.modal.feedback_modal',[
'plan' => $feedbackPlan
])
@endif
@include('user.modal.feedback_confirm_modal')
<script id="rendered-js">
    const player = new Plyr('audio', {});
    window.player = player;
</script>
<script src="{{ asset('/user/js/boostrap-rating.min.js')}} "></script>
<script src="{{ asset('/user/js/edit.js')}} "></script>
<script>
    $('body').on('click', function(e) {
        const feedbackPlan = $('input[name=feedbackPlan]').val()
        if (feedbackPlan != 0) {
            var target, href;
            target = $(e.target);
            if (target.attr('download') != undefined) {
                return
            }
            if (e.target.tagName === 'A' || target.parents('a').length > 0) {
                e.preventDefault();
                $('#feedback_modal .rating').rating('rate', 0)
                $('#feedback_modal textarea').val('')
                $('#feedback_modal').modal('show')
                $('#not-feedback').click(function() {
                    if (e.target.tagName === 'A') {
                        href = target.attr('href');
                    } else {
                        href = target.parents('a').first().attr('href');
                    }
                    window.location.href = href;
                })
            }
        }
    });
    var url = null;
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
</script>
@endsection
