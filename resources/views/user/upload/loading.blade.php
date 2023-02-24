@extends('user.layouts.upload_layout')
@section('title','決済・依頼中')
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
        <div class="block loading">
            <div class="block-content">
                <svg width="150" height="100" viewBox="0 0 140 92" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="120" y="23" width="16" height="45" rx="8" fill="#F7931E">
                        <animate attributeName="height" attributeType="XML" values="30;90;30" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>
                        <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>
                    </rect>
                    <rect x="90" y="23" width="16" height="45" rx="8" fill="#FAAA20">
                        <animate attributeName="height" attributeType="XML" values="30;90;30" begin="-0.15s" dur="0.6s" repeatCount="indefinite"></animate>
                        <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="-0.15s" dur="0.6s" repeatCount="indefinite"></animate>
                    </rect>
                    <rect x="60" y="23" width="15" height="45" rx="7.5" fill="#FFC924">
                        <animate attributeName="height" attributeType="XML" values="30;90;30" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>
                        <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="0.3s" dur="0.6s" repeatCount="indefinite"></animate>
                    </rect>
                    <rect x="30" y="23" width="16" height="45" rx="8" fill="#FFD34C">
                        <animate attributeName="height" attributeType="XML" values="30;90;30" begin="-0.15s" dur="0.6s" repeatCount="indefinite"></animate>
                        <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="-0.15s" dur="0.6s" repeatCount="indefinite"></animate>
                    </rect>
                    <rect x="0" y="23" width="16" height="45" rx="8" fill="#FFDD76">
                        <animate attributeName="height" attributeType="XML" values="30;90;30" begin="0s" dur="0.6s" repeatCount="indefinite"></animate>
                        <animate attributeName="y" attributeType="XML" values="23; 0; 23" begin="0s" dur="0.6s" repeatCount="indefinite"></animate>
                    </rect>
                </svg>
            </div>
            <div class="block-content">
                <span class="title">少しお待ちしてください...</span>
            </div>
        </div>
    </div>
</div>

@endsection
