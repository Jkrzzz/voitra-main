<div class="site-mobile-menu site-navbar-target">
    <div class="site-mobile-menu-header">
        <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"><i class="fas fa-times"></i></span>
        </div>
    </div>
    <div class="site-mobile-menu-body"></div>
</div>

<header class="site-navbar site-navbar-target" role="banner">
    <div class="container-fluid">
        <div class="row div-nav align-items-center position-relative">
            <div class="col-md-8 text-left">
                <nav class="site-navigation text-left ml-auto d-none d-lg-block" role="navigation">
                    <ul class="site-menu main-menu js-clone-nav ml-auto ">
                        <li class="div-nav logo"><img src="{{ asset('./user/images/logo.png') }}"></li>
                        <li><a href="#" class="nav-link">特徴</a></li>
                        <li><a href="#" class="nav-link">料金</a></li>
                        <li><a href="#" class="nav-link">よくある質問</a></li>
                        <li><a href="#" class="nav-link">お問い合わせ</a></li>
                        <li class="div-nav-mb" ><a href="/login">
                                <button class="btn-common-outline mx-1 mt-2 btn-bs-white">ログイン</button>
                            </a></li>
                        <li class="div-nav-mb"><a href="/register">
                                <button class="btn-common mx-1 btn-bs-black my-0">会員登録</button>
                            </a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-md-4 text-right">
                <a href="/login">
                    <button class="btn-common-outline mx-1 my-0">ログイン</button>
                </a>
                <a href="/register">
                    <button class="btn-common mx-1 my-0">会員登録</button>
                </a>
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
            <div class="col-6 text-right">
                <a href="/login">
                    <button class="btn-common-outline mx-1 my-0">ログイン</button>
                </a>
            </div>
        </div>
    </div>

</header>

