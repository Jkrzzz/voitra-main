<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header d-flex mt-3">
        <div class="site-mobile-menu-close">
            <span class="icon-close2 js-menu-toggle"><i class="fas fa-times"></i></span>
        </div>
        <div class="site-logo-mb">
            <a href="/"><img src="{{ asset('./user/images/logo-white.png') }}"></a>
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
                        <li class="div-nav logo"><a href="/"><img src="{{ asset('./user/images/logo-white.png') }}"></a>
                        </li>
                        @if (!View::hasSection('mining'))
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
                        @endif
                    </ul>
                </nav>
            </div>
            @If (!View::hasSection('mining'))
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
            @endif

        </div>
        <div class="row div-nav-mb align-items-center position-relative">
            <div class="col-6 text-left d-flex">
                @if(!View::hasSection('mining'))
                    <span class="d-inline-block d-lg-none">
                        <a href="#"class="site-menu-toggle js-menu-toggle">
                            <i class="fas fa-bars fa-2x"></i>
                        </a>
                    </span>
                @endif
                <div class="site-logo ml-4">
                    <a href="/"><img src="{{ asset('user/images/logo-white.png') }}"></a>
                </div>
            </div>
            <div class="col-6 text-right">
                 @if(!View::hasSection('mining'))
                    @if (Auth::check())
                        <a href="/upload">
                            <button class="btn-common-outline mx-1 my-0 btn-menu">マイページ</button>
                        </a>
                    @else
                        <a href="/login">
                            <button class="btn-common-outline mx-1 my-0 btn-menu">ログイン</button>
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</header>
<div class="big-header">
    <div class="left-header">
        <img src="{{ asset('user/images/left-header.png') }}">
        @if (!View::hasSection('mining'))
            <h1 class="left-header-text">VOICE <br>
                TRANSCRIPTION
            </h1>
        @else
            <h1 class="left-header-text">一括文字起こし・テキストマイニング　お問合せフォーム<br>
                <span>
                    TRANSCRIPTION & TEXT MINING
                </span>     
            </h1>
        @endif           
    </div>
    <div class="right-header">
        @yield('right-header-img')
    </div>
</div>
