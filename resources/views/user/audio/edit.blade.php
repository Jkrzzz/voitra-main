@inject('provider', 'App\Http\Controllers\ServiceProvider')
@php
$orderStatus = config('const.userOrderStatus');
$status = config('const.audioStatus');
$paymentType = config('const.paymentType');
$paymentStatus = config('const.paymentStatus');
@endphp
@extends('user.layouts.user_layout')
@section('title','認識結果編集')
@section('content')
    <div class="main-content">
        <span class="page-title">ファイル一覧  >  ファイル詳細 > 結果編集</span>
        <div class="audio-container">
            <div class="header-row row">
                {{ csrf_field() }}
                <input id="audio-id" type="text" name="audio_id" value="{{$data->id}}" hidden>
                <input id="type" type="text" name="type" value="{{$type}}" hidden>
                <input id="option" type="text" name="type" value="{{$isOption}}" hidden>
                <div class="col-md-5 col-12 d-flex align-items-center">
                    <div class="audio-name" style="max-width: 300px;">
                        <h2 id="name">{{ $data->name }}</h2>
                    </div>
                    <input id="audio-name" class="form-control" type="text" name="audio_name" value="{{$data->name}}"
                           style="display: none;" maxlength="100">
                    <h2 class="btn ml-3 edit-btn" id="edit-name">
                        <i class="fas fa-pen edit-icon"></i>
                        <i class="fas fa-save save-icon"></i>
                    </h2>
                </div>
                <div class="col-md-7 col-12 text-right mt-3">
                    <button id="cancel" class="process-btn btn-primary btn-md mb-2" data-id="{{$data->id}}">
                        キャンセル
                        <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.2498 12.6873C11.44 12.6874 11.623 12.7506 11.7619 12.8641C11.9008 12.9776 11.9853 13.133 11.9983 13.2989C12.0112 13.4648 11.9517 13.6289 11.8317 13.7579C11.7117 13.8869 11.5402 13.9712 11.3519 13.9939L11.2498 14H0.750175C0.560049 13.9999 0.377033 13.9368 0.238108 13.8233C0.0991822 13.7097 0.0147053 13.5543 0.00174632 13.3884C-0.0112126 13.2225 0.0483127 13.0585 0.168295 12.9295C0.288276 12.8005 0.459768 12.7161 0.64812 12.6935L0.750175 12.6873H11.2498ZM6.007 0.00087515C6.18817 0.00109312 6.36312 0.0586262 6.49958 0.162854C6.63603 0.267081 6.72476 0.410966 6.7494 0.567946L6.75641 0.657207V9.5772L9.724 6.97812C9.85093 6.86684 10.0193 6.79909 10.1985 6.78721C10.3777 6.77532 10.5559 6.82009 10.7005 6.91336L10.7856 6.97637C10.9129 7.08755 10.9904 7.23505 11.0038 7.39199C11.0172 7.54893 10.9657 7.70486 10.8586 7.83135L10.7866 7.90486L6.54129 11.6241L6.47125 11.6792L6.3792 11.7308L6.34318 11.7492L6.25213 11.7825L6.13207 11.8087L6.06203 11.8157L6.002 11.8175C5.95122 11.8174 5.90059 11.8127 5.85092 11.8035L5.77088 11.7833C5.67578 11.7566 5.58794 11.7131 5.51274 11.6556L1.22043 7.90574C1.08582 7.78877 1.00686 7.63155 0.999463 7.46572C0.992062 7.29989 1.05676 7.13776 1.18054 7.01197C1.30432 6.88619 1.47798 6.80608 1.66657 6.78779C1.85516 6.76949 2.04467 6.81436 2.19695 6.91336L2.281 6.97725L5.2556 9.5737V0.656332C5.2556 0.482262 5.33466 0.315321 5.47539 0.192235C5.61611 0.0691491 5.80698 0 6.006 0L6.007 0.00087515Z"
                                fill="#3D3D3D"/>
                        </svg>
                    </button>
                    <button id="save" class="process-btn btn-primary btn-md">
                        一時保存
                        <svg width="12" height="18" viewBox="0 0 12 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.2498 12.6873C11.44 12.6874 11.623 12.7506 11.7619 12.8641C11.9008 12.9776 11.9853 13.133 11.9983 13.2989C12.0112 13.4648 11.9517 13.6289 11.8317 13.7579C11.7117 13.8869 11.5402 13.9712 11.3519 13.9939L11.2498 14H0.750175C0.560049 13.9999 0.377033 13.9368 0.238108 13.8233C0.0991822 13.7097 0.0147053 13.5543 0.00174632 13.3884C-0.0112126 13.2225 0.0483127 13.0585 0.168295 12.9295C0.288276 12.8005 0.459768 12.7161 0.64812 12.6935L0.750175 12.6873H11.2498ZM6.007 0.00087515C6.18817 0.00109312 6.36312 0.0586262 6.49958 0.162854C6.63603 0.267081 6.72476 0.410966 6.7494 0.567946L6.75641 0.657207V9.5772L9.724 6.97812C9.85093 6.86684 10.0193 6.79909 10.1985 6.78721C10.3777 6.77532 10.5559 6.82009 10.7005 6.91336L10.7856 6.97637C10.9129 7.08755 10.9904 7.23505 11.0038 7.39199C11.0172 7.54893 10.9657 7.70486 10.8586 7.83135L10.7866 7.90486L6.54129 11.6241L6.47125 11.6792L6.3792 11.7308L6.34318 11.7492L6.25213 11.7825L6.13207 11.8087L6.06203 11.8157L6.002 11.8175C5.95122 11.8174 5.90059 11.8127 5.85092 11.8035L5.77088 11.7833C5.67578 11.7566 5.58794 11.7131 5.51274 11.6556L1.22043 7.90574C1.08582 7.78877 1.00686 7.63155 0.999463 7.46572C0.992062 7.29989 1.05676 7.13776 1.18054 7.01197C1.30432 6.88619 1.47798 6.80608 1.66657 6.78779C1.85516 6.76949 2.04467 6.81436 2.19695 6.91336L2.281 6.97725L5.2556 9.5737V0.656332C5.2556 0.482262 5.33466 0.315321 5.47539 0.192235C5.61611 0.0691491 5.80698 0 6.006 0L6.007 0.00087515Z"
                                fill="#3D3D3D"/>
                        </svg>
                    </button>
                    <button id="save-quit" class="process-btn btn-primary btn-md">
                        編集完了
                        <svg width="12" height="10" viewBox="0 0 12 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M3.99993 7.80007L1.19993 5.00006L0.266602 5.9334L3.99993 9.66673L11.9999 1.66673L11.0666 0.733398L3.99993 7.80007Z"
                                fill="#3D3D3D"/>
                        </svg>

                    </button>
                </div>
            </div>
            <div class="audio-box">
                <audio>
                    <source src="{{ $data->url }}" type="audio/mp3">
                </audio>
            </div>
            <div class="box-edit">
                <div class="header-row row">
                    <div class="col-md-6 col-12 d-flex align-items-center">
                        <h2 class="table-title text-left">結果編集
                            @if($isOption)
                            <span style="font-size: 14px; font-weight: normal">(ドラックで会話の順番を移動できます。)</span>
                            @endif
                        </h2>
                    </div>
                    <div class="col-md-6 col-12 d-flex align-items-center text-right">
                        最終更新日: {{ $data->updated_at }}
                    </div>
                </div>
                <hr>
                @if($isOption)
                    <div class="option-box">
                        @if($type == 1)
                            @if($data->edited_result)
                                @php $spks = $provider::spk2id(json_decode($data->edited_result)) @endphp
                                @foreach(json_decode($data->edited_result) as $edited_result)
                                    @if(trim($edited_result->text) != '')
                                        <div class="edit-item">
                                            <div class="top-edit">
                                                <select class="speaker-edit">
                                                    @for($i = 1; $i <=15; $i++)
                                                        <option
                                                            value="{{$i}}" {{$spks[$edited_result->speaker] == $i ? 'selected' : ''}}>
                                                            スピーカー {{$i}}</option>
                                                    @endfor
                                                </select>
                                                <div class="d-flex align-items-center time-edit-group">
                                                    <p class="mr-2">開始</p>
                                                    <input type="text" name="start"
                                                           class="time-edit mr-3 html-duration-picker"
                                                           value="{{gmdate("H:i:s", $edited_result->start)}}">
                                                    <p class="mr-2">終了</p>
                                                    <input type="text" name="stop"
                                                           class="time-edit mr-2 html-duration-picker"
                                                           value="{{gmdate("H:i:s", $edited_result->stop)}}">
                                                </div>
                                            </div>
                                            <p contenteditable="true" class="edit-content">
                                                {{$edited_result->text}}
                                            </p>
                                            {{-- <input type="hidden" name="path" value="{{$edited_result->path}}"> --}}
                                            <i class="far fa-times-circle edit-close"></i>
                                            <div class="edit-drop-area"></div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @elseif($type == 2)
                            @if($data->result)
                                @php $spks = $provider::spk2id(json_decode($data->result)) @endphp
                                @foreach(json_decode($data->result) as $result)
                                    @if(trim($result->text) != '')
                                        <div class="edit-item">
                                            <div class="top-edit">
                                                <select class="speaker-edit">
                                                    @for($i = 1; $i <=15; $i++)
                                                        <option
                                                            value="{{$i}}" {{$spks[$result->speaker] == $i ? 'selected' : ''}}>
                                                            スピーカー {{$i}}</option>
                                                    @endfor
                                                </select>
                                                <div class="d-flex align-items-center time-edit-group">
                                                    <p class="mr-2">開始</p>
                                                    <input type="text" name="start"
                                                           class="time-edit mr-3 html-duration-picker"
                                                           value="{{gmdate("H:i:s", $result->start)}}">
                                                    <p class="mr-2">終了</p>
                                                    <input type="text" name="stop"
                                                           class="time-edit mr-2 html-duration-picker"
                                                           value="{{gmdate("H:i:s", $result->stop)}}">
                                                </div>
                                            </div>
                                            <p contenteditable="true" class="edit-content">
                                                {{$result->text}}
                                            </p>
                                            <input type="hidden" name="path" value="{{$result->path}}">
                                            <i class="far fa-times-circle edit-close"></i>
                                            <div class="edit-drop-area"></div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @else
                            @if($data->api_result)
                                @php $spks = $provider::spk2id(json_decode($data->api_result)) @endphp
                                @foreach(json_decode($data->api_result) as $api_result)
                                    @if(trim($api_result->text) != '')
                                        <div class="edit-item">
                                            <div class="top-edit">
                                                <select class="speaker-edit">
                                                    @for($i = 1; $i <=15; $i++)
                                                        <option
                                                            value="{{$i}}" {{$spks[$api_result->speaker] == $i ? 'selected' : ''}}>
                                                            スピーカー {{$i}}</option>
                                                    @endfor
                                                </select>
                                                <div class="d-flex align-items-center time-edit-group">
                                                    <p class="mr-2">開始</p>
                                                    <input type="text" name="start"
                                                           class="time-edit mr-3 html-duration-picker"
                                                           value="{{gmdate("H:i:s", $api_result->start)}}">
                                                    <p class="mr-2">終了</p>
                                                    <input type="text" name="stop"
                                                           class="time-edit mr-2 html-duration-picker"
                                                           value="{{gmdate("H:i:s", $api_result->stop)}}">
                                                </div>
                                            </div>
                                            <p contenteditable="true" class="edit-content">
                                                {{$api_result->text}}
                                            </p>
                                            <input type="hidden" name="path" value="{{$api_result->path}}">
                                            <i class="far fa-times-circle edit-close"></i>
                                            <div class="edit-drop-area"></div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    </div>
                    <div class="text-right mt-5">
                        <button class="btn-info-custom" id="add-edit-item">追加 <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                @else
                    <div class="option-box">
                        <textarea class="form-control p-0"
                                  id="content">{{ $type == 1 ? $data->edited_result : ($type == 2 ? $data->result : $data->api_result) }}</textarea>
                    </div>
                @endif
            </div>
            <div class="upload-container">
                @if ($order_p1)
                    <div class="block">
                        <div class="block-header row">
                            <div class="col-md-5 col-12">
                                <img src="{{ asset('user/images/block-header.png') }}">
                                <h2>AI文字起こしプラン</h2>
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
                                <p class="font-weight-bold">{{ $order_p1->payment_type ? $paymentType[$order_p1->payment_type] : '' }}</p>
                            </div>
                            <div class="col-lg-2 col-md-4 col-12 order-item-view mb-0">
                                <p class="mb-2">決済状況</p>
                                <p class="font-weight-bold">{{ @$paymentStatus[$order_p1->payment_status] }}</p>
                            </div>
                        </div>
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
                                <p class="font-weight-bold">{{ $order_p2->payment_type ? $paymentType[$order_p2->payment_type] : '' }}</p>
                            </div>
                            <div class="col-lg-2 col-md-2 col-12 order-item-view">
                                <p class="mb-2">決済状況</p>
                                <p class="font-weight-bold">{{ $order_p2->payment_status || $order_p2->payment_status === 0 ?  @$paymentStatus[$order_p2->payment_status] : (($order_p2['order_status'] >= 3) ? '支払済み' : '未決済') }}</p>
                            </div>
                        </div>
                        <form id="payment" action="/audio/brushup-confirm" method="post">
                            {{ csrf_field() }}
                            <input hidden type="text" name="order_id" value="{{$order_p2->id}}">
                        </form>
                        <!-- @if ($order_p2->status == 2)
                        <div class="upload-button">
                            <a class="btn custom-btn btn-primary" href="{{ route('audio.confirmRequest', $order_p2->id) }}">
                                見積り確認
                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12.5" cy="12" r="11.5" stroke="black" />
                                    <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2" />
                                </svg>
                            </a>
                        </div>
                        @endif -->
                    </div>
                @endif
            </div>
        </div>
    </div>
    <input type="hidden" id="num_speaker" value="{{$numSpeaker}}">
    <div class="modal fade info-modal" id="delete-edit-item" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body px-3">
                    <div class="btn-close-modal" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <h4 class="notification-title">ダイアログ削除</h4>
                    <p class="notification-body" style="font-size: 18px">
                        「<span class="delete-text-content"></span>」の内容を削除してもよろしいでしょうか？
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                            <i class="far fa-arrow-alt-circle-left"></i> いいえ
                        </button>
                        <button type="submit" id="delete-item" class="btn-primary-info group">はい <i
                                class="far fa-arrow-alt-circle-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade info-modal" id="delete-edit-item-success" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <img src="{{ asset('/user/images/icon-success.png') }}">
                    <h4 class="notification-title">ダイアログを削除しました</h4>
                    <div class="text-center">
                        <button type="button" class="btn-primary-info btn-ok" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade info-modal" id="save-fail" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="btn-close-modal" data-dismiss="modal">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <img src="{{ asset('/user/images/info.png') }}">
                    <h4 class="notification-title">未入力項目があります。</h4>
                    <p class="notification-body">
                        入力してください。
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn-primary-info btn-ok" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('user.modal.confirm_modal')
    <script id="rendered-js">
        const player = new Plyr('audio', {});
        window.player = player;
    </script>
    <script src="{{asset('/user/js/html-duration-picker.min.js')}}"></script>

    <script src="{{ asset('/user/js/edit.js')}} "></script>

@endsection
