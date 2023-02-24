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

<header class="site-navbar site-navbar-target user-header" role="banner">
    <div class="container-fluid">
        <div class="row div-nav align-items-center position-relative">
            <div class="col-12 text-left">
                <nav class="site-navigation text-left ml-auto d-none d-lg-block" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav ml-auto link-top-page">
                        <li class="div-nav logo"><a href="/"><img src="{{ asset('./user/images/logo-white.png') }}"></a>
                        </li>
                        <li><a href="/upload" to="overview" class="nav-link">会員メニュートップ</a></li>
                        <li><a href="/audio" to="flow" class="nav-link">ファイル一覧</a></li>
                        <li><a href="/info" to="strength" class="nav-link">ユーザー情報</a></li>
                        <li><a href="/card-management" to="strength" class="nav-link">クレジット管理</a></li>
                        <li><a href="/coupons" class="nav-link">クーポン一覧</a></li>
                        <li><a href="/address/management" to="strength" class="nav-link">請求先情報</a></li>
                        <li><a href="/payment-history" to="strength" class="nav-link">支払明細</a></li>
                        <li><a href="/contact" to="fee" class="nav-link">お問い合わせ</a></li>
                        <li class="div-nav-mb d-flex justify-content-center">
                            <div class="mt-4">
                                <button class="btn-common-outline my-0 mx-1 btn-bs-white btn-menu"
                                        onclick="window.location.href = '/upload'">マイページ
                                </button>
                                <button class="btn-common mx-1 my-0 btn-menu"
                                        onclick="window.location.href = '/logout'">ログアウト
                                </button>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="row div-nav-mb align-items-center position-relative">
            <div class="col-6 text-left d-flex">
                <span class="d-inline-block d-lg-none"><a href="#"
                                                          class="site-menu-toggle js-menu-toggle"><i
                            class="fas fa-bars fa-2x"></i></a></span>
                <div class="site-logo ml-4">
                    <a href="/"><img src="{{ asset('user/images/logo-white.png') }}"></a>
                </div>
            </div>
        </div>
    </div>

</header>
<div class="user-big-header">
    <div class="{{View::hasSection('mining') ? 'left-header-tm': 'left-header'}}">
        <img src="{{ asset('user/images/header-banner-left.png') }}">
        @if(View::hasSection('mining'))
            <h1 class="user-header-text-tm">@yield('mining')</h1>
        @else
            <h1 class="user-header-text">MY PAGE</h1>
        @endif
    </div>
    <div class="{{View::hasSection('mining') ? 'right-header-tm': 'right-header'}}">
        <img src="{{ asset('user/images/header-banner-right.png') }}">
    </div>
</div>

