@extends('user.layouts.user_layout')
@section('title','マイページ')
@section('content')
@php
$languages = config('const.language');
$user = Auth::user();
$isRegisterOption = DB::table('user_services')->where('user_id',$user->id)->where('status', 1)->first();
@endphp
<div class="main-content">
    <span class="page-title">@yield('title')</span>
    <div class="process-bar">
        <div id="steps">
            <div class="stepper done" data-desc="Listing information">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19.864 18.84C19.8494 18.8213 19.8308 18.8062 19.8095 18.7958C19.7882 18.7854 19.7648 18.78 19.7411 18.78C19.7174 18.78 19.6941 18.7854 19.6728 18.7958C19.6515 18.8062 19.6328 18.8213 19.6182 18.84L17.4331 21.6076C17.4151 21.6306 17.4039 21.6582 17.4009 21.6873C17.3978 21.7164 17.403 21.7458 17.4158 21.772C17.4286 21.7983 17.4486 21.8205 17.4734 21.8359C17.4982 21.8514 17.5268 21.8596 17.556 21.8595H18.9978V26.5939C18.9978 26.6798 19.068 26.7501 19.1539 26.7501H20.3245C20.4103 26.7501 20.4806 26.6798 20.4806 26.5939V21.8615H21.9262C22.0569 21.8615 22.1291 21.7111 22.0491 21.6095L19.864 18.84Z" fill="#B0B0B0" />
                    <path d="M25.5816 17.0371C24.688 14.6777 22.4112 13 19.7443 13C17.0773 13 14.8005 14.6758 13.9069 17.0352C12.235 17.4746 11 19 11 20.8125C11 22.9707 12.7461 24.7188 14.9 24.7188H15.6823C15.7682 24.7188 15.8384 24.6484 15.8384 24.5625V23.3906C15.8384 23.3047 15.7682 23.2344 15.6823 23.2344H14.9C14.2425 23.2344 13.6241 22.9727 13.1636 22.498C12.7051 22.0254 12.4613 21.3887 12.4827 20.7285C12.5003 20.2129 12.6759 19.7285 12.9939 19.3203C13.3197 18.9043 13.7762 18.6016 14.2835 18.4668L15.0229 18.2734L15.2941 17.5586C15.4619 17.1133 15.696 16.6973 15.9906 16.3203C16.2814 15.9467 16.6259 15.6183 17.0129 15.3457C17.8147 14.7813 18.759 14.4824 19.7443 14.4824C20.7295 14.4824 21.6738 14.7813 22.4756 15.3457C22.8639 15.6191 23.2072 15.9473 23.4979 16.3203C23.7925 16.6973 24.0266 17.1152 24.1944 17.5586L24.4636 18.2715L25.2011 18.4668C26.2585 18.752 26.998 19.7148 26.998 20.8125C26.998 21.459 26.7463 22.0684 26.2898 22.5254C26.0659 22.7508 25.7995 22.9296 25.5062 23.0513C25.2128 23.173 24.8983 23.2352 24.5807 23.2344H23.7984C23.7125 23.2344 23.6423 23.3047 23.6423 23.3906V24.5625C23.6423 24.6484 23.7125 24.7188 23.7984 24.7188H24.5807C26.7346 24.7188 28.4807 22.9707 28.4807 20.8125C28.4807 19.002 27.2496 17.4785 25.5816 17.0371Z" fill="#B0B0B0" />
                    <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0" stroke-width="2.5" />
                </svg>
                <p class="stepper-title">アップ</p>
            </div>
            <div class="stepper" data-desc="Photos & Details">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0" stroke-width="2.5" />
                    <path d="M28 13H12C10.897 13 10 13.897 10 15V27C10 28.103 10.897 29 12 29H28C29.103 29 30 28.103 30 27V15C30 13.897 29.103 13 28 13ZM12 15H28V17H12V15ZM12 27V21H28.001L28.002 27H12Z" fill="#B0B0B0" />
                    <path d="M14 23H21V25H14V23Z" fill="#B0B0B0" />
                </svg>
                <p class="stepper-title">決済情報入力</p>
            </div>
            <div class="stepper" data-desc="Review & Post">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0" stroke-width="2.5" />
                    <path d="M25.6485 15.35C24.1976 13.9 22.2064 13 19.995 13C15.5722 13 12 16.58 12 21C12 25.42 15.5722 29 19.995 29C23.7273 29 26.8393 26.45 27.7298 23H25.6485C24.828 25.33 22.6066 27 19.995 27C16.6829 27 13.9912 24.31 13.9912 21C13.9912 17.69 16.6829 15 19.995 15C21.656 15 23.137 15.69 24.2176 16.78L20.9956 20H28V13L25.6485 15.35Z" fill="#B0B0B0" />
                </svg>
                <p class="stepper-title">確認</p>
            </div>
            <div class="stepper" data-desc="Your order">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0" stroke-width="2.5" />
                    <path d="M13 26.7143H29V29H13V26.7143Z" fill="#B0B0B0" />
                    <path d="M26.2457 13L18.7143 20.5314L15.7543 17.5829L14.1429 19.1943L18.7143 23.7657L27.8571 14.6229L26.2457 13Z" fill="#B0B0B0" />
                </svg>
                <p class="stepper-title">完了</p>
            </div>
        </div>
    </div>
    <div class="upload-container">
        <p class="text-center mb-4">音声・動画ファイルをアップロードしてください。ドラックアンドドロップでも追加できます。</p>
        <div class="block">
            <div class="block-header row">
                <div class="col-xl-8 col-lg-5 col-sm-6">
                    <img src="{{ asset('user/images/block-header.png') }}">
                    <h2>AI文字起こしプラン</h2>
                </div>
                <div class="col-xl-4 col-lg-7 col-sm-6">
                    <div class="form-group" style="padding: 15px 20px; text-align: right">
                        <label for="language" class="d-inline-block form-label mr-4">言語選択</label>
                        <div class="d-inline-block" style="width: 150px">
                            <select class="form-control" id="language">
                                @foreach ($languages as $key => $value)
                                <option value="{{ $key }}" {{ ('ja-JP' == $key ? 'selected' : '') }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" id="file-upload-form" action="/upload" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input id="file-upload" type="file" name="files[]" accept=".m4a,.aac,.wma,.avi,.wmv,audio/wav,audio/mp3,video/mp4,video/mpeg" multiple>
                <input id="lang" type="text" name="language" hidden>
                <label for="file-upload" id="file-drag">
                    <p class="upload-title">
                        ここにファイルをドロップ</br>
                        または、ファイルを選択してください。
                    </p>
                    <p class="upload-note mt-3 mb-3">
                        <span class="note">動画：.mp4 / .avi / .mpeg / .wmv</span></br>
                        <span class="note">音声：.m4a / .aac / .wav / .mp3 / .wma</span>
                    </p>
                    <div class="upload-button">
                        <button id="file-upload-btn" class="btn custom-btn btn-primary">
                            音声アップロード
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.1486 10.758C12.131 10.7356 12.1086 10.7174 12.083 10.705C12.0574 10.6925 12.0294 10.686 12.0009 10.686C11.9724 10.686 11.9444 10.6925 11.9188 10.705C11.8932 10.7174 11.8708 10.7356 11.8532 10.758L9.22825 14.0791C9.20661 14.1067 9.19319 14.1399 9.18951 14.1748C9.18583 14.2097 9.19205 14.2449 9.20745 14.2765C9.22285 14.308 9.24682 14.3346 9.27661 14.3531C9.3064 14.3717 9.34081 14.3815 9.37591 14.3814H11.1079V20.0627C11.1079 20.1658 11.1923 20.2502 11.2954 20.2502H12.7017C12.8048 20.2502 12.8892 20.1658 12.8892 20.0627V14.3838H14.6259C14.7829 14.3838 14.8696 14.2033 14.7735 14.0814L12.1486 10.758Z" fill="black" />
                                <path d="M19.0182 8.59453C17.9447 5.76328 15.2096 3.75 12.0057 3.75C8.80176 3.75 6.0666 5.76094 4.99316 8.59219C2.98457 9.11953 1.50098 10.95 1.50098 13.125C1.50098 15.7148 3.59863 17.8125 6.18613 17.8125H7.12598C7.2291 17.8125 7.31348 17.7281 7.31348 17.625V16.2188C7.31348 16.1156 7.2291 16.0312 7.12598 16.0312H6.18613C5.39629 16.0312 4.65332 15.7172 4.1002 15.1477C3.54941 14.5805 3.25645 13.8164 3.28223 13.0242C3.30332 12.4055 3.51426 11.8242 3.89629 11.3344C4.2877 10.8352 4.83613 10.4719 5.44551 10.3102L6.33379 10.0781L6.65957 9.22031C6.86113 8.68594 7.14238 8.18672 7.49629 7.73438C7.84568 7.28603 8.25954 6.89191 8.72441 6.56484C9.6877 5.8875 10.8221 5.52891 12.0057 5.52891C13.1893 5.52891 14.3236 5.8875 15.2869 6.56484C15.7533 6.89297 16.1658 7.28672 16.515 7.73438C16.8689 8.18672 17.1502 8.68828 17.3518 9.22031L17.6752 10.0758L18.5611 10.3102C19.8314 10.6523 20.7197 11.8078 20.7197 13.125C20.7197 13.9008 20.4174 14.632 19.8689 15.1805C19.6 15.451 19.28 15.6655 18.9276 15.8115C18.5752 15.9576 18.1973 16.0323 17.8158 16.0312H16.876C16.7729 16.0312 16.6885 16.1156 16.6885 16.2188V17.625C16.6885 17.7281 16.7729 17.8125 16.876 17.8125H17.8158C20.4033 17.8125 22.501 15.7148 22.501 13.125C22.501 10.9523 21.0221 9.12422 19.0182 8.59453Z" fill="black" />
                            </svg>
                        </button>
                    </div>
                    <p class="file-size-note">※ファイル数は5個まで。合計256Mbまでアップロード可能です。</p>
                </label>
            </form>
        </div>
        <div class="block">
            <div class="block-header row">
                <div class="col-xl-8 col-lg-5 col-sm-6">
                    <img src="{{ asset('user/images/block-header.png') }}">
                    <h2>サンプル</h2>
                </div>
            </div>
            <div class="block-content">
                <span class="page-title">サンプル</span>
                <div class="box-content m-3">
                    今回はボイトラについて説明しますこちらは簡単に様々な種類の音声がテキスト化できるサービスで大文字起こしプランはいっぷんさんじゅーえんで即日納品さらにブラッシュアッププランはいち文字いちえんで人の手で文字を起こしてくれます是非ご利用してみてください
                </div>
                <span class="page-title">AI自動文字起こしの精度</span>
                <div class="block-list">
                    <ul>
                        <li>句読点が入らない場合や、数字が「ひらがな」になることがあります。</li>
                        <li>音声の品質（周りの雑音等）により、単純な誤認識が生じる場合があります。</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="block campaign">
            <div class="block-header row">
                <div class="col-xl-9 col-lg-5 col-sm-6">
                    <img src="{{ asset('user/images/block-header.png') }}">
                    <h2>話者分離オプション</h2>
                </div>
                @if ($user->services->count() > 0 && $trail->value == 1)
                <div class="col-xl-3 col-lg-5 col-sm-6">
                    <div class="service-status">
                        <span>無料期間中</span>
                    </div>
                </div>
                @endif
            </div>
            <div class="block-content" id="campaign">
                {{ csrf_field() }}
                @if($trail->value)
                @if(is_null($isRegisterOption))
                <div class="col-xl-5 col-lg-5 col-sm-6">
                    <img class="campaign-img" src="{{ asset('user/images/campaign.png') }}">
                    <div style="text-align: center"><span>※{{ date('Y年m月d日', strtotime($trail->expired_date)) }}まで</span></div>
                </div>
                @endif
                @endif
                <div class="row container">
                    <div class="col-xl-7 col-lg-5 col-sm-12">
                        <div class="block-list">
                            <ul>
                                <li>
                                    <img src="{{ asset('user/images/speaker_icon.png') }}">
                                    <span>最大５人までの同時発話を自動認識</span>
                                </li>
                                <li>
                                    <img src="{{ asset('user/images/speaker_icon.png') }}">
                                    <span>月額300円（税込）で何回でも利用可能</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-5 col-sm-12">
                        <div class="block-list">
                            <img class="campaign-img" src="{{ asset('user/images/campaign_content.png') }}">
                        </div>
                    </div>
                </div>
                @if($trail->value)
                @if(is_null($isRegisterOption))
                <div class="upload-button">
                    <button id="register-trail" class="btn custom-btn btn-primary">
                        無料トライアル
                        <i class="far fa-arrow-alt-circle-right"></i>
                    </button>
                </div>
                @else
                <div class="upload-button">
                    <button class="btn custom-btn btn-default" disabled>
                        無料トライアル
                        <i class="far fa-arrow-alt-circle-right"></i>
                    </button>
                </div>
                @endif
                @else
                @if(is_null($isRegisterOption))
                <div class="upload-button">
                    <a class="btn custom-btn btn-primary" href="/service/register">
                    申し込む
                        <i class="far fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
                @else
                <div class="upload-button">
                    <button class="btn custom-btn btn-default" disabled>
                    申し込む
                        <i class="far fa-arrow-alt-circle-right"></i>
                    </button>
                </div>
                @endif
                @endif
            </div>
        </div>
        @if(config('ishome.is_home'))
            <div class="block campaign">
                <div class="block-header row">
                    <div class="col-xl-9 col-lg-5 col-sm-6">
                        <img class="text-bg" src="{{ asset('user/images/block-header.png')}}">
                        <h2 class="text-s">企業のテキストマイニングオプション</h2>
                    </div>
                </div>

                <div class="block-content">
                    <div class="row container">
                        <div class="col-xl-7 col-lg-5 col-sm-12 d-flex align-items-center">
                            <div class="block-list">
                                <ul>
                                    <li>
                                        <img width="40px" src="{{ asset('user/images/text-icon.png') }}">
                                        <span>テキストを分析して機能を調査する</span>
                                    </li>
                                    <li>
                                        <img width="40px" src="{{ asset('user/images/text-icon-2.png') }}">
                                        <span>テキストを分析して対象顧客を調査する</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-sm-12">
                            <div>
                                <img class="campaign-img"  src="{{ asset('user/images/Mining-upload.png') }}">
                            </div>
                        </div>
                    </div>
                    <div class="upload-button">
                        <a href="{{route('textmining')}}" class="btn custom-btn btn-primary">
                            無料トライアル
                            <i class="far fa-arrow-alt-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@include('user.modal.notify_modal')
@include('user.modal.error_modal')
@if($trail->value)
@if ($user->services->count() <= 0 || $user->services[0]->pivot->status != 1)
@include('user.modal.modal_register_trail')
@include('user.modal.modal_show_campaign')
<script>
    $(document).ready(function() {
        if (sessionStorage.getItem('#modal_show_campaign') !== 'true') {
            $('#modal_show_campaign').modal('show');
            sessionStorage.setItem('#modal_show_campaign', 'true');
        }
    })
</script>
@endif
@endif
@if (isset($error) && $error)
<script>
    $(document).ready(function() {
        $('#modal-error').modal('show')

    })
</script>
@endif
<script>
    $(document).ready(function() {
        sessionStorage.setItem('filesize', 0);
    })
</script>
<script src="{{ asset('/user/js/upload.js')}} "></script>
@endsection
