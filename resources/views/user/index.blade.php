<!DOCTYPE html>
<html lang="ja">
<head>
    <title>AI文字起こし 音声テキスト化｜voitra（ボイトラ）</title>
    <meta charset="utf-8">
    <meta property="og:site_name" content="AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://voitra.jp/">
	<meta name="description" content="AI文字起こし 音声のテキスト化サービスのvoitra（ボイトラ）は、1分30円の低価格で音声をテキスト化できるAI文字起こしサービスです。携帯・PCから音声や動画のファイルをアップするだけで、簡単文字起こし！話者分離も可能で、複数人での会議、youtubeの動画字幕、取材の音声、講義の音声などのテキスト化に適しております。">
	<meta property="og:description" content="AI文字起こし 音声のテキスト化サービスのvoitra（ボイトラ）は、1分30円の低価格で音声をテキスト化できるAI文字起こしサービスです。携帯・PCから音声や動画のファイルをアップするだけで、簡単文字起こし！話者分離も可能で、複数人での会議、youtubeの動画字幕、取材の音声、講義の音声などのテキスト化に適しております。">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('/user/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/user/css/audio.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/user/images/icon.png') }}?v=8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
          integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    @if (Auth::check())
        <link rel="stylesheet" href="{{ asset('/user/css/user.css') }}">
        <link rel="stylesheet" href="{{ asset('/user/css/mobile.css') }}">
    @endif
    <script src="{{ asset('/user/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/user/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('/user/js/popper.min.js') }}"></script>
    <script src="{{ asset('/user/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/user/js/jquery.sticky.js')}} "></script>
    <script src="{{ asset('/user/js/dataTables.min.js')}} "></script>
    <script src="{{ asset('/user/js/audio.js')}} "></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-N6JH4BR');</script>
    <!-- End Google Tag Manager -->
    <style>
        html, body {
            height: 100%;
        }

        .big-header {
            display: none;
        }

        .site-navbar .site-navigation .site-menu > li:not(.logo) > a:hover {
            border-bottom: solid 2px #FFC100;
        }

        .footer {
            padding: 180px 0 20px 0;
        }

        .footer-content {
            padding-top: 50px;
            position: relative;
            z-index: 999;
        }
        .p-200{
            padding-top: 12%;
        }

        @media only screen and (min-width: 769px)  and (max-width: 1400px){
            .banner{
                height: 63vw;
            }
            .p-200{
                padding-top: 7%;
            }
            .banner-video {
                left: -3.6458333333333335vw;
                top: 140px;
                position: absolute;
                z-index: 999;
                right: 0;
                margin-right: 6.770833333333333vw;
                height: auto;

            }

            .brand-name {
                font-weight: bold;
                font-size: 7.708333333333333vw;
                background: linear-gradient(90deg, #FFC100 0%, #FF7A1B 107.43%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 1.0416666666666667vw;
            }

            .brand-quote {
                font-weight: 500;
                font-size: 1.9791666666666667vw;
            }

            .left-shape {
                background: linear-gradient(198.72deg, #FFD557 41.58%, #FFB50A 104.63%);
                mix-blend-mode: normal;
                opacity: 0.9;
                border-radius: 3.4087291666666664vw 0;
                position: absolute;
                width: 11.666666666666666vw;
                height: 9.739583333333334vw;
                left: -8.020833333333334vw;
                bottom: 0.20833333333333334vw;
                transform: matrix(1, 0, 0, -1, 0, 0);
            }

            .banner-video-gif {
                width: 100%;
                height: auto;
                object-fit: fill;
                border-radius: 8.663854166666665vw 0;
            }

            .banner-right-icon {
                position: absolute;
                bottom: -1.0416666666666667vw;
                right: -1.0416666666666667vw;
                width: 7.083333333333333vw;
                height: 7.083333333333333vw;
            }

            .btn-register {
                margin-top: 1.5625vw;
                background: #FFC100;
                border-radius: 37px;
                width: 15.052083333333334vw;
                height: 3.75vw;
                padding: 0.5729166666666666vw 1.6666666666666667vw 0.625vw;
                color: #121D26;
                font-size: 1.0416666666666667vw;
                font-weight: bold;
                border: #FFC100;
                cursor: pointer;
                position: relative;
                z-index: 1;
                overflow: hidden;
                transition: all .2s ease-in-out;
            }

            .btn-register i {
                margin-left: 10px;
                font-size: 1.25vw;
            }

            .section-title {
                font-weight: bold;
                font-size: 0.9375vw;
                line-height: 1.3541666666666667vw;
                text-transform: uppercase;
                color: #FFC100;
                position: relative;
                display: inline-block;
                margin-bottom: 0;
            }

            .section-sub-title {
                font-weight: bold;
                font-size: 1.6666666666666667vw;
                line-height: 2.3958333333333335vw;
                color: #141721;
                margin-bottom: 2.0833333333333335vw;
            }

            .text20 {
                font-size: 1.0416666666666667vw;
            }
            .service-top {
                position: relative;
                padding: 4.947916666666667vw 0 2.6041666666666665vw 0;
                min-height: 37.135416666666664vw;
            }
            .service-header {
                font-size: 2.0833333333333335vw;
                top: -3.6458333333333335vw;
                left: -1.25vw;
            }
            .service-title {
                font-weight: bold;
                font-size: 1.6666666666666667vw;
                line-height: 2.3958333333333335vw;
                color: #FFC100;
                margin-bottom:  0.4166666666666667vw;
            }
            .top-result-header {
                font-size:  0.7291666666666666vw;
                font-weight: bold;
                color: #FFC100;
                padding-bottom: 0.3125vw;
                border-bottom: solid 1px #FFC100;
            }
            .top-result-body {
                margin-top:  0.5208333333333334vw;
                font-size: 0.7291666666666666vw;
                color: #121D26;
            }

            .service-top-ul {
                list-style: none;
                margin-bottom: 1.4583333333333333vw;
                margin-top: 0.78125vw;
                font-size:  0.8333333333333334vw;
                color: #121D26;
                padding: 0;
            }
            .service-box {
                padding: 2.96875vw 4.166666666666667vw 1.5625vw 4.166666666666667vw;
                background: #FFFFFF;
                border-radius:0.5208333333333334vw;
            }
            .service-header.right {
                right: -2.03125vw;
                left: auto;
                top: -1.8229166666666667vw;
            }
            .btn-common:not(.btn-menu) {
                background: #121D26;
                border-radius: 1.3541666666666667vw;
                color: #ffffff;
                font-size:  0.9375vw;
                font-weight: bold;
                border: #121D26;
                cursor: pointer;
                position: relative;
                overflow: hidden;
                z-index: 1;
                transition: all .2s ease-in-out;
                margin-top: 2.0833333333333335vw;
                padding: 0.5208333333333334vw 1.5625vw;
            }
            .btn-common:not(.btn-menu).btn-yellow{
                background-color: #FFC100;
                color: #121D26;
            }
            .btn-common i {
                font-size: 1.25vw;
                margin-left: 0.2604166666666667vw;
            }
            .service-bg.right{
                text-align: right;
            }
            .service-bg img{
                height: 100%;
                width: auto;
            }
            .step {
                padding: 1.0416666666666667vw;
                border-radius: 0.5208333333333334vw;
                transition: transform .2s;
                margin-bottom:  2.0416666666666667vw;
                min-height: 18.645833333333332vw;
            }
            .step-name{
                font-weight: 700;
                font-size:  1.0416666666666667vw;
                border-bottom: 1px solid #000000;
                display: inline-block;
            }
            .step-img img{
                width: 6.770833333333333vw;
                height: 6.770833333333333vw;
            }
            .step-title {
                font-size: 1.0416666666666667vw;
            }
            .section{
                font-size: 0.8333333333333334vw;
            }
            .strength {
                padding-top:  2.6041666666666665vw;
                padding-bottom:  2.6041666666666665vw;
                margin-bottom: 1.0416666666666667vw;
            }
            .strength-point {
                font-size:  0.9375vw;
                font-weight: bold;
                text-transform: uppercase;
                margin-bottom:  0.5208333333333334vw;
            }
            .strength-title {
                font-weight: bold;
                font-size: 1.25vw;
                color: #FFC100;
                border-bottom: 1px solid #000000;
                padding-bottom: 0.5208333333333334vw;
            }
            .strength-sub-title {
                font-size: 0.9375vw;
                text-align: right;
                margin-bottom: 1.0416666666666667vw;
                text-transform: uppercase;
            }
            .strength-list {
                list-style-type: none;
                font-size: 1.0416666666666667vw;
                padding: 0;
            }
            .strength-list li {
                padding: 0.5208333333333334vw 0 0.2604166666666667vw 2.6041666666666665vw;
                position: relative;
                font-weight: 500;
            }
            .strength-list li img{
                width: 3.2291666666666665vw;
                height: 3.2291666666666665vw;
            }
            .strength-body{
                min-height: 23.4375vw;
                padding: 1.5625vw 12% 1.5625vw 1.5625vw;
            }
            .strength-bg img{
                width: auto;
                height: 100%;
            }
            .strength-body.right {
                padding-left: 15%;
                margin-left: 40%;
                width: 60%;
                padding-right: 2.34375vw;
            }
            .price-plan .card{
                height: 100%;
            }
            .price-plan .card-header {
                padding-top: 1.1979166666666667vw;
                padding-left: 1.1979166666666667vw;
                border-radius: 0.625vw 0.625vw 0 0;
            }
            .text22 {
                font-size: 1.1458333333333333vw;
            }
            .price {
                margin-top: 1.0416666666666667vw;
                margin-bottom: 2.0833333333333335vw;
                font-size: 1.25vw;
                padding-bottom:  2.0833333333333335vw;
            }
            .price span {
                font-size:  2.0833333333333335vw;
            }
            .price span p {
                font-size: 1.25vw;
            }
            .price-ul {
                margin-top:  1.0416666666666667vw;
                font-size:  1.0416666666666667vw;
            }
            .price-plan .card-body{
                padding: 1.0416666666666667vw;
                min-height: 21.25vw;
            }
            .price-plan{
                padding: 0 25% 7.03125vw 25%;
            }
            .price-ul li::before{
                position: absolute;
                left: -1.5625vw;
                top: 0.78125vw;
                height: 1.0416666666666667vw;
                width: 1.0416666666666667vw;
                content: "";
                background: url("/user/images/list-style-1.png");
                background-size: 100% 100%;
            }
            .price-plan-big-layout h1{
                font-size: 3.3333333333333335vw;
                bottom: -0.8333333333333334vw;
            }
            .section-title.space::after {
                bottom: 0.3125vw;
                width:  3.6458333333333335vw;
            }
            .question{
                font-size: 1.0416666666666667vw;
            }
            .qa-icon{
                padding-top: 0.5208333333333334vw;
            }
            .qa-icon img{
                width: 2.0833333333333335vw;
                height: 2.0833333333333335vw;
            }
            .qa{
                padding: 0.78125vw;
                margin-bottom: 1.0416666666666667vw;
            }
            .top-contact {
                border-radius: 1.3020833333333333vw;
                padding:2.8645833333333335vw 2.6041666666666665vw;
                min-height:11.71875vw;
                bottom: -7.8125vw;
            }
            .top-contact-title {
                margin-top: 0.5208333333333334vw;
                font-size: 1.6666666666666667vw;
                padding-bottom: 1.0416666666666667vw;
            }
            .top-contact-content{
                font-size: 1.0416666666666667vw;
            }
            .contact-layout{
                font-size: 5.729166666666667vw;
                bottom: -1.3541666666666667vw;
            }
            .btn-contact {
                margin-top: 1.1458333333333333vw !important;
                font-size:  1.3541666666666667vw !important;
                height: 4.166666666666667vw;
                padding:  0.5729166666666666vw 1.6666666666666667vw 0.625vw !important;
                box-shadow: -10px 8px 32px rgb(173 73 8 / 60%);
                border-radius: 1.9270833333333333vw !important;
            }
            .footer {
                padding: 9.375vw 0 1.0416666666666667vw 0;
            }
            .comming-soon{
                margin-top: 3.6458333333333335vw;
                font-size: 2.191838541666667vw;
            }
            .payment-title{
                font-size: 1.6666666666666667vw;
                margin-left: 2.0833333333333335vw;
            }
            .payment-box{
                padding: 1.0416666666666667vw 3.125vw;
                border-radius: 0.5208333333333334vw;
                height: 21vw;
            }
            .payment-sub-title{
                margin-top: 1.4583333333333333vw;
                font-size: 1.0416666666666667vw;
                padding-bottom: 0.3645833333333333vw;
            }
            .payment-sub-title:after {
                left: 6.770833333333333vw;
                right: 6.770833333333333vw;
                border-bottom: solid 0.10416666666666667vw #FFC100;
            }
            .postpaid-method{
                margin-bottom: 0.2604166666666667vw;
            }
            .postpaid-method.first-line{
                margin-top: 0.78125vw;
            }
            .postpaid-method .payment-img{
                margin-right: 0.6770833333333334vw;
            }
            .payment-method {
                margin-top:  1.9791666666666667vw;
            }
            .payment-method .payment-img{
                margin-right: 0.6770833333333334vw;
                width: 3.8541666666666665vw;
            }
            .prepay-content{
                bottom: 1.0416666666666667vw;
                font-size: 1.0416666666666667vw;
                line-height: 1.5104166666666667vw;
            }
            .postpaid-method.convenience-stores .payment-img{
                width: 1.71875vw;
            }
            .postpaid-method.app .payment-img{
                width: 5.208333333333333vw;
            }
            .payment-title-img{
                width: 2.6041666666666665vw;
            }
            .cp_img{ 
                width:100%;max-width:367px;
            }
        }
        @media only screen and (max-width: 768px) {
            .p-200 {
                padding-top: 15%;
            }
            .h-20{
                min-height: 300px;
            }
        }
        @media only screen and (max-width: 468px) {
            .p-200 {
                padding-top: 0%;
            }
            .h-20{
                min-height: 300px;
            }
        }
        
    </style>
</head>
<body>
<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header d-flex mt-3">
        <div class="site-mobile-menu-close">
            <span class="icon-close2 js-menu-toggle"><i class="fas fa-times"></i></span>
        </div>
        <div class="site-logo-mb">
            <a href="/"><img alt="AI文字起こし 音声のテキスト化サービス voitra（ボイトラ）" src="{{ asset('./user/images/logo-white.png') }}"></a>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<header class="site-navbar site-navbar-target" role="banner">
    <div class="container-fluid">
        <div class="row div-nav align-items-center position-relative">
            <div class="col-md-8 text-left">
                <nav class="site-navigation text-left ml-auto d-none d-lg-block" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav ml-auto link-top-page">
                        <li class="div-nav logo"><a href="/"><img alt="AI文字起こし 音声のテキスト化サービス voitra（ボイトラ）" src="{{ asset('./user/images/logo-white.png') }}"></a>
                        </li>
                        <li><a href="/#overview" to="overview" class="nav-link">概要</a></li>
                        <li><a href="/#flow" to="flow" class="nav-link">流れ</a></li>
                        <li><a href="/#strength" to="strength" class="nav-link">強み</a></li>
                        <li><a href="/#fee" to="fee" class="nav-link">料金</a></li>
                        <li><a href="/#faq" to="faq" class="nav-link">FAQ</a></li>
                        <li><a href="/contact" class="nav-link">お問い合わせ</a></li>
                        <li class="div-nav-mb d-flex justify-content-center">
                            <div class="mt-4">
                                @if (Auth::check())
                                    <button class="btn-common-outline my-0 mx-1 btn-bs-white btn-menu"
                                            onclick="window.location.href = '/upload'">マイページ
                                    </button>
                                    <button class="btn-common mx-1 my-0 btn-menu"
                                            onclick="window.location.href = '/logout'">ログアウト
                                    </button>
                                @else
                                    <button class="btn-common-outline my-0 mx-1 btn-bs-white btn-menu"
                                            onclick="window.location.href = '/login'">ログイン
                                    </button>
                                    <button class="btn-common mx-1 my-0 btn-menu"
                                            onclick="window.location.href = '/register'">会員登録
                                    </button>
                                @endif
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            @if (Auth::check())
                <div class="col-md-4 text-right">
                    <a href="/upload">
                        <button class="btn-common-outline mx-2 my-0 btn-menu">マイページ</button>
                    </a>
                    <a href="/logout">
                        <button class="btn-common mx-2 my-0 btn-menu">ログアウト</button>
                    </a>
                </div>
            @else
                <div class="col-md-4 text-right">
                    <a href="/login">
                        <button class="btn-common-outline mx-2 my-0 btn-menu">ログイン</button>
                    </a>
                    <a href="/register">
                        <button class="btn-common mx-2 my-0 btn-menu">会員登録</button>
                    </a>
                </div>
            @endif

        </div>
        <div class="row div-nav-mb align-items-center position-relative">
            <div class="col-6 text-left d-flex">
                <span class="d-inline-block d-lg-none"><a href="#"
                                                          class="site-menu-toggle js-menu-toggle"><i
                            class="fas fa-bars fa-2x"></i></a></span>
                <div class="site-logo ml-4">
                    <a href="/"><img alt="AI文字起こし 音声のテキスト化サービス voitra（ボイトラ）" src="{{ asset('user/images/logo-white.png') }}"></a>
                </div>
            </div>
            <div class="col-6 text-right">
                @if (Auth::check())
                    <a href="/upload">
                        <button class="btn-common-outline mx-1 my-0 btn-menu">マイページ</button>
                    </a>
                @else
                    <a href="/login">
                        <button class="btn-common-outline mx-1 my-0 btn-menu">ログイン</button>
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>
<div class="big-header">
    <div class="left-header">
        <img src="{{ asset('user/images/left-header.png') }}">
        <h1 class="left-header-text">VOICE <br>
            TRANSCRIPTION</h1>
    </div>
    <div class="right-header">
        @yield('right-header-img')
    </div>
</div>
<div class="section banner">
    <img class="main-banner-layout" alt="音声、動画ファイルから自動文字起こしがでできるアプリ" src="{{asset('/user/images/main-banner-layout.png')}}">
    <div class="banner-right">
        <img class="banner-right-layout" alt="音声、動画ファイルから自動テキスト化がでできるアプリ" src="{{asset('/user/images/banner-right-layout.png')}}">
        <div class="banner-video">
            <img class="main-banner-layout-mb" alt="音声、動画ファイルから自動文字起こしがでできるアプリ" src="{{asset('/user/images/main-banner-layout-mb.png')}}">
            <video class="banner-video-gif" src="{{asset('/user/images/banner-video-3.mp4')}}" type="video/mp4"
                   autoplay="autoplay" muted="muted" playsinline="" loop="loop"></video>
            <div class="left-shape"></div>
            <img class="banner-right-icon" alt="音声テキスト化・文字起こし" src="{{asset('/user/images/banner-right-icon.png')}}">
        </div>
    </div>
    <div class="container-fluid-banner">
        <div class="brand">
            <h1 class="brand-name"><img class="logo_key" alt="音声テキスト化・文字起こし・動画字幕のvoitra（ボイトラ）" src="{{asset('/user/images/logo_key.png')}}"></h1>
            <h4 class="brand-quote">音声や動画をアップするだけで<br>
                簡単にテキスト化</h4>
            @if(\Illuminate\Support\Facades\Auth::check())
                <a href="/upload">
                    <button class="btn btn-register">アップロード
                        <i class="far fa-arrow-alt-circle-right"></i>
                    </button>
                </a>
            @else
                <a href="/register">
                    <button class="btn btn-register">今すぐ会員登録
                        <i class="far fa-arrow-alt-circle-right"></i>
                    </button>
                </a>
            @endif

        </div>
    </div>
    <div class="scroll-banner">
        Scroll down
    </div>
</div>
<div class="section responsive-section">
    <div class="container-fluid">
        <h4 class="section-title">USE SCENE</h4>
        <h1 class="section-sub-title">利用シーン</h1>
        <div id="carouselTopPage" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselTopPage" data-slide-to="0" class="active"><i class="fas fa-circle"> <span>Feature 1</span></i>
                </li>
                <li data-target="#carouselTopPage" data-slide-to="1"><i class="fas fa-circle"><span>Feature 2</span></i>
                </li>
                <li data-target="#carouselTopPage" data-slide-to="2"><i class="fas fa-circle">
                        <span>Feature 3</span></i></li>
                <li data-target="#carouselTopPage" data-slide-to="3"><i class="fas fa-circle">
                        <span>Feature 4</span></i></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{ asset('/user/images/spin-slider.png') }}" class="d-block w-100" alt="会議の議事録を簡単に作成可能！音声を録音してアップするだけでテキスト化">
                        </div>
                        <div class="col-md-5">
                            <div class="top-feature">
                                <h4 class="section-sub-title">会議の議事録</h4>
                                <p class="text20">会議や打ち合わせで録音した<br>
                                    音声データをアップしてすぐ<br>
                                    にテキスト化。議事録を作る<br>のも簡単！</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{ asset('/user/images/spin-slider-2.png') }}" class="d-block w-100"
                                 alt="取材音声もアップするだけでテキスト化">
                        </div>
                        <div class="col-md-5">
                            <div class="top-feature">
                                <h4 class="section-sub-title">取材の録音した音声</h4>
                                <p class="text20">取材の録音を簡単にテキスト<br>
                                    化。スマホでもできるので、<br>
                                    取材後の空き時間に音声ファ<br>
                                    イルをアップするだけ！</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{ asset('/user/images/spin-slider-3.png') }}" class="d-block w-100"
                                 alt="youtubeなどの動画の字幕付けもAI音声文字起こしで簡単！">
                        </div>
                        <div class="col-md-5">
                            <div class="top-feature">
                                <h4 class="section-sub-title">動画の字幕付け</h4>
                                <p class="text20">動画（mp4 / .avi / .mpeg / .wmv ）の音声も文字起こしできるので、YouTubeの字幕作成も簡単！</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{ asset('/user/images/spin-slider-4.png') }}" class="d-block w-100"
                                 alt="講義の録音音声も簡単にテキスト化できるのでレポート作成が楽になります！">
                        </div>
                        <div class="col-md-5">
                            <div class="top-feature">
                                <h4 class="section-sub-title">講義の録音</h4>
                                <p class="text20">講義を録音して内容をテキスト化！レポート作成が簡単にでき、講義に集中できます！</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="bg-common">
    <div class="section responsive-section" id="overview">
        <div class="container-fluid">
            <h4 class="section-title">Services</h4>
            <h1 class="section-sub-title">サービス概要</h1>
        </div>
        <div class="service-top">
            <div class="container-fluid">
                <div class="service-box">
                    <h4 class="service-header">Voice<br>
                        Transcription</h4>
                    <h4 class="service-title">AI文字起こしプラン</h4>
                    <p class="text20"><strong>１分30円</strong><span style="font-size: 12px">（税込）</span>でAIが自動でテキスト化
                        音声をアップするだけで簡単すぐにテキスト化
                    </p>
                    <div class="top-audio-result">
                        <p class="top-result-header">テキストサンプル</p>
                        <p class="top-result-body">
                            今回はボイトラについて説明しますこちらは簡単に様々な種類の音声がテキスト化できるサービスで大文字起こしプランはいっぷんさんじゅーえんで即日納品さらにブラッシュアッププランはいち文字いちえんで人の手で文字を起こしてくれます是非ご利用してみてください</p>
                    </div>
                    <ul class="service-top-ul">
                        <li class="pt-0">※句読点が入らない場合や、数字が「ひらがな」になることがあります。</li>
                        <li class="pb-0">※音声の品質（周りの雑音等）により、単純な誤認識が生じる場合があります。</li>
                    </ul>
                    <a href="{{ \Illuminate\Support\Facades\Auth::check() ? '/audio' : '/register' }}">
                        <button class="btn btn-common mt-0">今すぐ発注
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </button>
                    </a>
                </div>
            </div>
            <div class="service-bg">
                <img src="{{ asset('/user/images/service-top-1.png') }}" alt="人の手によるブラッシュアッププランも用意しております！AIが聞き取れなかった音声も人が聞いて書き起こします！">
            </div>
        </div>
        <div class="service-top pb-0">
            <div class="container-fluid">
                <div class="service-box float-right">
                    <h4 class="service-header right">Brush up</h4>
                    <h4 class="service-title">ブラッシュアッププラン</h4>
                    <p class="text20">人の手による文字起こし。<br>
                        ご希望によりフィラーワードの除去も行えます</p>
                    <div class="top-audio-result">
                        <p class="top-result-header">テキストサンプル</p>
                        <p class="top-result-body">
                            今回は、ボイトラについて説明します。こちらは、簡単に様々な種類の音声がテキスト化できるサービスです。AI文字起こしプランは、1分30円で即日納品！更にブラッシュアッププランは、1文字1円で人の手で文字起こしをしてくれます。是非、ご利用してみてください！</p>
                    </div>
                    <ul class="service-top-ul">
                        <li class="pt-0">※句読点、改行を適切に入れます。</li>
                        <li class="pb-0">※フィラーワードの削除を行います。（フィラーワードとは、「あのー」や「えー」「そのー」など、話すときに言葉と言葉を
                            埋める意味のない言葉のことです。）
                        </li>
                    </ul>
                    <a href="{{ \Illuminate\Support\Facades\Auth::check() ? '/audio' : '/register' }}">
                        <button class="btn btn-common mt-0">今すぐ発注
                            <i class="fas fa-arrow-alt-circle-right"></i>
                        </button>
                    </a>
                </div>
            </div>
            <div class="service-bg right">
                <img src="{{ asset('/user/images/service-top-2.png') }}" alt="簡単便利なvoitraは、アップするだけで、音声をテキスト化・文字起こしが可能です！">
            </div>
        </div>
    </div>
        {{-- Text Mining Start --}}
    @if(config('ishome.is_home'))
    <div class="service-top h-20">
        <div class="container-fluid p-200">
            <div class="service-box">
                <h4 class="service-header" style="top:-42px">Corporate Text Mining</h4>
                <h4 class="service-title">テキストマイニング計画</h4>
                <p class="text20 mb-3">テキスト分析を使用すると、新機能を探索し、ターゲット顧客を見つけることができます。</p>
                <a href="/textmining">
                    <button class="btn btn-common mt-0">テキストマイニングを使い始める
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </button>
                </a>
            </div>
        </div>
        <div class="service-bg pr-lg-5">
            <img src="{{ asset('/user/images/mining-home.png') }}">
        </div>
    </div>
    @endif
    {{-- Text Mining End --}}
    <div class="section responsive-section" id="flow">
        <div class="container-fluid">
            <h4 class="section-title">4 Steps</h4>
            <h1 class="section-sub-title">テキスト化の流れ</h1>
            <div class="steps">
                <div class="row">
                    <div class="col-md-3 col-12">
                        <div class="step">
                            <p class="step-name">Step 1</p>
                            <div class="step-img position-relative d-flex justify-content-center my-4">
                                <img src="{{ asset('/user/images/step-1.png') }}" alt="ステップ１携帯やパソコンから音声ファイル動画ファイルをアップするだけ！">
                            </div>
                            <p class="step-title">ファイルアップロード</p>
                            <p>携帯・パソコンなどから音声や動画ファイルをアップロード。</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="step">
                            <p class="step-name">Step 2</p>
                            <div class="step-img position-relative d-flex justify-content-center my-4">
                                <img src="{{ asset('/user/images/step-2.png') }}" alt="音声の時間により計算された金額を確認してお支払い。">
                            </div>
                            <p class="step-title">お支払い</p>
                            <p>音声の時間により計算された金額を確認して、お支払い。</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="step">
                            <p class="step-name">Step 3</p>
                            <div class="step-img position-relative d-flex justify-content-center my-4">
                                <img src="{{ asset('/user/images/step-3.png') }}" alt="AIが自動でテキスト化してくれます。">
                            </div>
                            <p class="step-title">テキスト化完了</p>
                            <p>AIによる文字起こしが実行され音声がテキスト化されます！</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <div class="step">
                            <p class="step-name">Step 4</p>
                            <div class="step-img position-relative d-flex justify-content-center my-4">
                                <img src="{{ asset('/user/images/step-4.png') }}" alt="必要に応じてテキスト化されたものをブラッシュアップ依頼すれば人の手による文字起こしが可能です。">
                            </div>
                            <p class="step-title">ブラッシュアップ依頼</p>
                            <p>必要に応じてテキストのブラッシュアップ依頼が可能です（有料）。</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="step-bg">
            <img src="{{ asset('/user/images/steps-bg.png') }}">
        </div>
    </div>
</div>
<div class="section pt-2 responsive-section" id="strength">
    <div class="container-fluid">
        <h4 class="section-title">Strenghts</h4>
        <h1 class="section-sub-title">Voitra の強み</h1>
        <div class="steps">
            <div class="strength">
                <div class="strength-bg" style="text-align: right">
                    <img src="{{ asset('/user/images/strength1.png') }}" alt="VOITRAの強みは安くて早くて使いやすい音声テキスト化アプリ">
                </div>
                <div class="strength-body">
                    <p class="strength-point">point 1</p>
                    <h3 class="strength-title">安い！早い！使いやすい！</h3>
                    <p class="strength-sub-title">USER FRIENDLY</p>
                    <ul class="strength-list">
                        <li><img src="{{ asset('/user/images/icon-wallet.png') }}" alt="低単価１分30円の業界最安値水準の価格です。"> 低単価　１分30円<span
                                style="font-size: 12px">（税込）</span></li>
                        <li><img src="{{ asset('/user/images/icon-time-history.png') }}" alt="短納期・即日対応"> 短納期　最短即日対応</li>
                        <li><img src="{{ asset('/user/images/icon-share.png') }}" alt="スマホやPCで音声をアップするだけ"> 簡単　スマホやPCで音声をアッ プするだけ！
                        </li>
                    </ul>
                </div>

            </div>
            <div class="strength right">
                <div class="strength-bg right">
                    <img src="{{ asset('/user/images/strength2.png') }}" alt="ポイント２：様々な言語に対応">
                </div>
                <div class="strength-body right">
                    <p class="strength-point">point 2</p>
                    <h3 class="strength-title">さまざまな言語に対応！</h3>
                    <p class="strength-sub-title">MULTILINGUAL SUPPORT</p>
                    <ul class="strength-list">
                        <li><img src="{{ asset('/user/images/icon-global.png') }}" alt="125以上の言語に対応">125以上の言語に対応
                            <p class="help-text">※話者分離機能は9ヶ国語　詳細は<span class="lang-link" data-toggle="modal"
                                                                       data-target="#modal-language">こちら</span></p>
                        </li>
                        <li><img src="{{ asset('/user/images/icon-translate.png') }}" alt="翻訳対応（開発予定）"> 翻訳対応（開発予定）</li>
                    </ul>
                </div>

            </div>
            <div class="strength">
                <div class="strength-bg" style="text-align: right">
                    <img src="{{ asset('/user/images/strength3.png') }}" alt="ポイント３：話者分離機能の付いており複数人の会話でも、テキスト化された文章がわかりやすい！">
                </div>
                <div class="strength-body">
                    <p class="strength-point">point 3</p>
                    <h3 class="strength-title">話者分離機能も利用可能！</h3>
                    <p class="strength-sub-title">SPEAKER SEPARATION</p>
                    <ul class="strength-list">
                        <li><img src="{{ asset('/user/images/icon-mic.png') }}" alt="最大５人までの同時発話を自動認識"> 最大５人までの同時発話を自動認識</li>
                    </ul>
                    <a href="{{\Illuminate\Support\Facades\Auth::check() ? 'javascript:void(0)' : '/register'}}">
                        @if($trail->value)
                            <button class="btn btn-common btn-yellow {{\Illuminate\Support\Facades\Auth::check() ? 'register-option-btn' : ''}}">無料トライアル
                                <i class="far fa-arrow-alt-circle-right"></i>
                            </button>
                        @else
                            @if($isRegisterTrail)
                                <button class="btn btn-common btn-yellow" disabled>申し込み
                                    <i class="far fa-arrow-alt-circle-right"></i>
                                </button>
                            @else
                                <button class="btn btn-common btn-yellow" onclick="window.location.href = '/service/register'">申し込み
                                    <i class="far fa-arrow-alt-circle-right"></i>
                                </button>
                                @endif
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="strength-layout">
        <img src="{{ asset('/user/images/strength-layout.png') }}" alt="音声テキスト化の料金">
    </div>
</div>
<div id="fee" class="section price-plan-bg">
    <div class="responsive-section">
        <div class="container-fluid">
            <h4 class="section-title">Price plans</h4>
            <h1 class="section-sub-title">料金表</h1>
            <div class="row price-plan">
                <div class="col-md-6 col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-black font-weight-bold text22 text-center">
                            AI文字起こしプラン
                        </div>
                        <div class="card-body text-center position-relative">
                            <div class="price">
                                <span>30<p>円</p></span> / 1分（税込）
                            </div>
                            <ul class="price-ul text-left">
                                <li>mp3, wav, ogg, mp4</li>
                                <li>125 以上の言語に対応</li>
                                <li>５人までの話者分離<br>
                                    <span style="font-size: 0.625vw">※話者分離機能は、別途費用がかかります。</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="card mb-4">
                        <div class="card-header bg-black font-weight-bold text22 text-center ">
                            ブラッシュアッププラン
                        </div>
                        <div class="card-body text-center position-relative">
                            <div class="price">
                                <span>1.1<p>円</p></span> / 1文字（税込）
                            </div>
                            <ul class="price-ul text-left">
                                <li>AIでは難しい用語の変換</li>
                                <li>希望によりフィラーワードの除去</li>
                                <li>最短納期で納品</li>
                                <li>日本語のみ対応</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <img class="price-plan-layout" src="{{ asset('/user/images/price-plan-layout.png') }}" alt="音声テキスト化">
    <div class="price-plan-big-layout">
        <h1>VOICE TRANSCRIPTION</h1>
    </div>
</div>
<div class="position-relative">
    <div id="payment" class="section position-relative responsive-section">
        <div class="container-fluid">
            <h4 class="section-title">PAYMENTS</h4>
            <h1 class="section-sub-title">決済方法</h1>
            <div class="row">
                <div class="col-md-6 col-12">
                    <div class="payment-box">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="payment-title-img"><img src="{{ asset('/user/images/payment-1.png') }}" alt="様々な支払い方法を利用可能"></div>
                            <h4 class="payment-title">クレジットカード</h4>
                        </div>
                        <p class="payment-sub-title">多様なブランドに対応</p>
                        <div class="d-flex justify-content-center align-items-center payment-method">
                            <div class="payment-img"><img src="{{ asset('/user/images/visa.png') }}" alt="音声テキスト化のVOITRAはVISAに対応"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/master.png') }}" alt="音声テキスト化のvoitraはMASTERカードに対応"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/jbc.png') }}" alt="文字起こしサービスvoitraはJCBに対応"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/amexpress.png') }}" alt="文字起こしサービスのVOITRAは、AMEXに対応"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/diner.png') }}" alt="音声テキスト化サービスのvoitraは、dinersに対応しております。"></div>
                        </div>
                        <p class="prepay-content mb-5">待ちなしでスムーズ決済</p>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="payment-box mb-0">
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="payment-title-img"><img src="{{ asset('/user/images/payment-2.png') }}" alt="動画の字幕付・会議の議事録作成のvoitraは、コンビニ後払いも可能"></div>
                            <h4 class="payment-title">コンビニ後払い</h4>
                        </div>
                        <p class="payment-sub-title">全国56,000店以上のコンビニでお支払い</p>
                        <div class="d-flex justify-content-center align-items-center postpaid-method first-line convenience-stores">
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-1.png') }}" alt="セブンイレブン"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-2.png') }}" alt="ローソン"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-3.png') }}" alt="ミニストップ"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-4.png') }}" alt="ファミリーマート"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-5.png') }}" alt="ポプラ"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-6.png') }}" alt="くらしハウス"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-7.png') }}" alt="スリーエイト"></div>
                        </div>
                        <div class="d-flex justify-content-center align-items-center postpaid-method convenience-stores ">
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-8.png') }}" alt="生活彩家"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-9.png') }}" alt="MMK設置店"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-10.png') }}" alt="セイコーマート"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/postpaid-11.png') }}" alt="デイリーヤマザキ"></div>
                        </div>
                        <p class="payment-sub-title">アプリで簡単お支払い</p>
                        <div class="d-flex justify-content-center align-items-center postpaid-method first-line app">
                            <div class="payment-img"><img src="{{ asset('/user/images/line-pay.png') }}" alt="LINE請求書払い"></div>
                            <div class="payment-img"><img src="{{ asset('/user/images/rakuten.png') }}" alt="楽天銀行"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="payment-layout">
        <img src="{{ asset('/user/images/payment-layout.png') }}" alt="音声テキスト化サービスvoitraの支払い方法">
    </div>
</div>
<div id="faq" class="section position-relative responsive-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-12">
                <h4 class="section-title space">Frequently Asked<br> Questions</h4>
                <h1 class="section-sub-title">よくある質問</h1>
            </div>
            <div class="col-lg-7 col-md-12 col-12 qa-body">
                <div class="qa">
                    <div class="qa-header">
                        <p class="question">どんなファイルをアップロードできるのですか？</p>
                        <div class="qa-icon">
                            <img src="{{ asset('/user/images/chervon-down-contact.png') }}" alt="音声テキスト化voitraのファイルアップ可能な形式">
                        </div>
                    </div>
                    <div class="answer">
                        <div class="answer-content">
                            はい、音声（.m4a / .aac / .wav / .mp3 / .wma）動画（mp4 / .avi / .mpeg / .wmv）形式であれば可能です。
                        </div>
                    </div>
                </div>
                <div class="qa">
                    <div class="qa-header">
                        <p class="question">テキストはどのような形で出力されるのですか？</p>
                        <div class="qa-icon">
                            <img src="{{ asset('/user/images/chervon-down-contact.png') }}" alt="文字起こしサービスvoitraのテキスト化されたものはCSV形式で出力">
                        </div>
                    </div>
                    <div class="answer">
                        <div class="answer-content">
                            AIによる文字起こしが終わるとテキストファイルのダウンロードリンクが現れます。（CSVファイル） 編集画面でテキストの修正をご自身で行うこともできます。
                        </div>
                    </div>
                </div>
                <div class="qa">
                    <div class="qa-header">
                        <p class="question">料金体系はどうなっていますか？</p>
                        <div class="qa-icon">
                            <img src="{{ asset('/user/images/chervon-down-contact.png') }}" alt="料金体系は、１分３０円">
                        </div>
                    </div>
                    <div class="answer">
                        <div class="answer-content">
                            AI自動文字起こしプランは、ファイルの時間に応じた従量課金になります。無音部分も課金対象となりますのでご了承ください。
                            ブラッシュアッププランは、テキストの文字数に応じた従量課金になります。AI自動文字起こしプランで出力された文字数が基準となります。
                        </div>
                    </div>
                </div>
                <div class="qa">
                    <div class="qa-header">
                        <p class="question">どんな録音状態でも認識できますか？</p>
                        <div class="qa-icon">
                            <img src="{{ asset('/user/images/chervon-down-contact.png') }}" alt="どんな録音状態でも認識できますか？雑音などが含まれると認識できない場合があります。">
                        </div>
                    </div>
                    <div class="answer">
                        <div class="answer-content">
                            雑音などが含まれている場合や、専門用語・認識できない固有名詞などが含まれる場合は、正確にテキストできない可能性がございます。
                        </div>
                    </div>
                </div>
                <div class="qa">
                    <div class="qa-header">
                        <p class="question">支払い方法を教えて下さい。</p>
                        <div class="qa-icon">
                            <img src="{{ asset('/user/images/chervon-down-contact.png') }}" alt="支払い方法は、クレジットカードやコンビニ後払いが使えます。">
                        </div>
                    </div>
                    <div class="answer">
                        <div class="answer-content">
                            クレジットカード(VISA / MASTER / JCB / AMEX / DINERS)・コンビニ後払い(ベリトランス後払い)になります。
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="top-contact">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12 top-contact-right">
                    <h4 class="top-contact-title">新規会員登録</h4>
                    <p class="top-contact-content">
                        無料登録しておけば<br>
                        いざという時、手軽にテキスト化できます！
                    </p>
                </div>
                <div class="col-lg-6 col-md-6 col-12 text-center">
                    <a href="/register">
                        <button class="btn-common btn-contact">今すぐ無料会員登録 ! <i
                                class="fas fa-arrow-alt-circle-right"></i>
                        </button>
                    </a>
                </div>
            </div>
            <h1 class="contact-layout">MEMBERSHIP</h1>
        </div>
    </div>
    <div class="qa-bg">
        <img src="{{ asset('/user/images/qa-bg.png') }}" alt="音声テキスト化voitraに無料会員登録">
    </div>
</div>
<div class="modal fade" id="modal-language" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center notification text-center">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img src="{{ asset('/user/images/language-modal.png') }}" alt="対応言語一覧">
                <h4 class="notification-title">対応言語一覧</h4>
                <p class="lang-modal-subtitle">
                    現在対応している言語は、下記となります。
                </p>
                <ul class="lang-modal-subtitle">
                    <li>中国語</li>
                    <li> 英語</li>
                    <li>フランス語</li>
                    <li>ドイツ語</li>
                    <li>イタリア語</li>
                    <li>日本語</li>
                    <li>ポルトガル語</li>
                    <li>ロシア語</li>
                    <li>スペイン語</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="container-fluid footer-content">
        <div class="row mb-5">
            <div class="col-md-5 col-12">
                <div class="footer-logo footer-title">
                    <img src="{{ asset('user/images/logo-text-white.png') }}" alt="音声テキスト化・文字起こしサービスのvoitra">
                </div>
                <div class="row intro">
                    <div class="col-12 col-md-6">
                        <ul class="col-footer mb-0">
                            <li><a href="/home/terms.php " target="_blank">利用規約</a></li>
                            <li><a href="/home/privacy.php" target="_blank">
                                    プライバシーポリシー</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-6">
                        <ul class="col-footer">
                            <li><a href="/home/ecommerce-transaction.php"
                                   target="_blank">特定商取引法に基づく表記</a></li>
                            <li><a href="/home/security-policy.php" target="_blank">情報セキュリティ方針</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="footer-certi">
                    <img src="{{ asset('user/images/footer-certi.png') }}" alt="プライバシーポリシー・セキュリティポリシー">
                </div>
            </div>
            <div class="col-md-2 col-6 footer-voitra">
                <p class="footer-title">VOITRA</p>
                <ul class="col-footer link-top-page">
                    <li><a href="/#overview" to="overview">概要</a></li>
                    <li><a href="/#flow" to="flow">流れ</a></li>
                    <li><a href="/#strength" to="strength">強み</a></li>
                    <li><a href="/#fee" to="fee">料金</a></li>
                    <li><a href="/#faq" to="faq">よくある質問</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-6">
                <p class="footer-title">会員メニュー</p>
                <ul class="col-footer">
                    <li><a href="/login">ログイン</a></li>
                    <li><a href="/register">新規会員登録</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-6">
                <p class="footer-title">会社情報</p>
                <ul class="col-footer">
                    <li><a href="/home/company.php" target="_blank">運営会社</a></li>
                    <li><a href="/contact">お問い合わせ</a></li>
                </ul>
            </div>
        </div>
        <div class="copy-right text-center">
            VOITRA . All rights reserved.
        </div>
    </div>
    <div class="vector">
        <img src="{{ asset('./user/images/vector.png') }}" alt="音声テキスト化・文字起こしサービスvoitraの運営会社は、アップセルテクノロジィーズ株式会社">
    </div>
</div>
<script src="{{ asset('/user/js/main.js') }}"></script>
<script>
    $(document).ready(function () {
        $('header .logo img').attr('src', '/user/images/logo.png')
        $('.qa-icon').click(function () {
            const isActive = $(this).hasClass('active')
            if (isActive) {
                $(this).children().attr('src', '/user/images/chervon-down-contact.png')
                $(this).removeClass('active')
                $(this).parent().next().css({
                    'height': `0`,
                    'padding-top': '0'
                })
                $(this).parent().css({
                    'border-bottom': 'none',
                    'padding-top': '0',
                    'padding-bottom': '0',
                })
                $(this).parent().parent().css('border-radius', '47px')
            } else {
                $(this).children().attr('src', '/user/images/chervon-up-contact.png')
                $(this).addClass('active')
                let h = $(this).parent().next().find('.answer-content').height() + 10
                $(this).parent().next().css({
                    'height': `${h}px`,
                    'padding-top': '10px'
                })
                $(this).parent().css({
                    'border-bottom': '1px solid #E3DCD6',
                    'padding-top': '10px',
                    'padding-bottom': '10px',
                })
                $(this).parent().parent().css('border-radius', '19px')
            }
        })
        $('.register-option-btn').click(function (){
            sessionStorage.setItem('#modal_show_campaign', 'false');
            window.location.href = '/upload#campaign'
        })
    })
</script>
</body>
