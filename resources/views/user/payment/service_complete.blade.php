@extends('user.layouts.upload_layout')
@section('title','決済完了')
@section('content')
<div class="main-content">
    <div class="d-title">
        <span class="page-title">@yield('title')</span>
    </div>
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
            <div class="stepper done" data-desc="Photos & Details">
                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="20" cy="20" r="18.75" transform="rotate(-180 20 20)" stroke="#B0B0B0" stroke-width="2.5" />
                    <path d="M28 13H12C10.897 13 10 13.897 10 15V27C10 28.103 10.897 29 12 29H28C29.103 29 30 28.103 30 27V15C30 13.897 29.103 13 28 13ZM12 15H28V17H12V15ZM12 27V21H28.001L28.002 27H12Z" fill="#B0B0B0" />
                    <path d="M14 23H21V25H14V23Z" fill="#B0B0B0" />
                </svg>
                <p class="stepper-title">決済情報入力</p>
            </div>
            <div class="stepper done">
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
        <div class="block">
            <div class="block-content">
                <div class="box-header">
                    <span class="title">話者分離の申し込みが完了いたしました。</span>
                </div>
                <div class="text-center">
                    <div class="success-icon">
                        @if($success)
                        <svg width="24" height="21" viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.2279 1.60267C20.6389 1.18786 21.1973 0.952603 21.7812 0.948302C22.3651 0.944001 22.927 1.17101 23.344 1.57972C23.761 1.98843 23.9993 2.5456 24.0068 3.12947C24.0143 3.71334 23.7903 4.27642 23.3839 4.69567L11.6239 19.3972C11.4219 19.6147 11.1781 19.7893 10.9071 19.9105C10.6361 20.0317 10.3434 20.097 10.0466 20.1026C9.74982 20.1082 9.45492 20.054 9.17955 19.9431C8.90417 19.8322 8.65397 19.6669 8.44389 19.4572L0.646886 11.6632C0.232551 11.2486 -0.000140589 10.6865 6.37267e-08 10.1004C0.000140716 9.51429 0.233102 8.95226 0.647636 8.53792C1.06217 8.12359 1.62432 7.89089 2.21042 7.89104C2.79651 7.89118 3.35855 8.12414 3.77289 8.53867L9.93939 14.7067L20.1694 1.67167C20.188 1.64795 20.208 1.62541 20.2294 1.60417L20.2279 1.60267Z" fill="url(#paint0_linear)" />
                            <defs>
                                <linearGradient id="paint0_linear" x1="18.2614" y1="7.02139" x2="3.13094" y2="15.3692" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FED450" />
                                    <stop offset="0.635417" stop-color="#FFB305" />
                                    <stop offset="1" stop-color="#FF7A1B" />
                                </linearGradient>
                            </defs>
                        </svg>
                        @else
                        <svg width="24" height="21" viewBox="0 0 24 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.2279 1.60267C20.6389 1.18786 21.1973 0.952603 21.7812 0.948302C22.3651 0.944001 22.927 1.17101 23.344 1.57972C23.761 1.98843 23.9993 2.5456 24.0068 3.12947C24.0143 3.71334 23.7903 4.27642 23.3839 4.69567L11.6239 19.3972C11.4219 19.6147 11.1781 19.7893 10.9071 19.9105C10.6361 20.0317 10.3434 20.097 10.0466 20.1026C9.74982 20.1082 9.45492 20.054 9.17955 19.9431C8.90417 19.8322 8.65397 19.6669 8.44389 19.4572L0.646886 11.6632C0.232551 11.2486 -0.000140589 10.6865 6.37267e-08 10.1004C0.000140716 9.51429 0.233102 8.95226 0.647636 8.53792C1.06217 8.12359 1.62432 7.89089 2.21042 7.89104C2.79651 7.89118 3.35855 8.12414 3.77289 8.53867L9.93939 14.7067L20.1694 1.67167C20.188 1.64795 20.208 1.62541 20.2294 1.60417L20.2279 1.60267Z" fill="url(#paint0_linear)" />
                            <defs>
                                <linearGradient id="paint0_linear" x1="18.2614" y1="7.02139" x2="3.13094" y2="15.3692" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#FED450" />
                                    <stop offset="0.635417" stop-color="#FFB305" />
                                    <stop offset="1" stop-color="#FF7A1B" />
                                </linearGradient>
                            </defs>
                        </svg>
                        @endif
                    </div>
                </div>
                <div class="text-center">
                    <p>
                        ファイルアップロード画面に戻ります。少々お待ちください...
                    </p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('user/images/complete2.png') }}" />
                </div>
                <input id="order_id" name="order_id" value="{{ $order_id }}" hidden>
            </div>
        </div>
    </div>
</div>
@include('user.modal.error_modal')

@if(isset($order_id) && $order_id)
<script>
    function sleep(time) {
        return new Promise((resolve) => setTimeout(resolve, time));
    }
    sleep(3000).then(() => {
        let order_id = $('#order_id').val();
        window.location.replace('/upload/detail?order_id=' + order_id)
    });
</script>
@else
<script>
    function sleep(time) {
        return new Promise((resolve) => setTimeout(resolve, time));
    }
    sleep(3000).then(() => {
        window.location.replace('/upload')
    });
</script>
@endif
<script src="{{ asset('/user/js/brushup.js')}} "></script>
@endsection