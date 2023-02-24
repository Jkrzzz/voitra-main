<!DOCTYPE html>
<html lang="ja">

<head>
    <title>@yield('title')｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）</title>
    @include('user.layouts.meta')
    @yield('style')
</head>

<body>
    @include('user.layouts.user_header')
    <main>
        <div class="page">
            <div class="user-container">
                <div class="left-menu">
                    <ul class="left-menu-list">
                        <li>
                            <a href="/upload" class="meunu-item {{ request()->is('upload*') ? 'active' : '' }}">
                                <svg width="38" height="38" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)" />
                                    <path d="M20.1254 18.8591C20.1093 18.8385 20.0888 18.8218 20.0653 18.8104C20.0418 18.7989 20.016 18.793 19.9899 18.793C19.9638 18.793 19.938 18.7989 19.9146 18.8104C19.8911 18.8218 19.8705 18.8385 19.8544 18.8591L17.4457 21.9099C17.4258 21.9353 17.4135 21.9658 17.4101 21.9978C17.4067 22.0299 17.4125 22.0623 17.4266 22.0912C17.4407 22.1202 17.4627 22.1446 17.4901 22.1617C17.5174 22.1787 17.549 22.1877 17.5812 22.1877H19.1705V27.4066C19.1705 27.5014 19.2479 27.5789 19.3426 27.5789H20.633C20.7276 27.5789 20.805 27.5014 20.805 27.4066V22.1898H22.3987C22.5428 22.1898 22.6223 22.024 22.5342 21.9121L20.1254 18.8591Z" fill="white" />
                                    <path d="M26.4276 16.8722C25.4426 14.2713 22.9328 12.4219 19.9928 12.4219C17.0529 12.4219 14.543 14.2692 13.558 16.8701C11.7149 17.3545 10.3535 19.036 10.3535 21.0341C10.3535 23.4132 12.2784 25.3401 14.6527 25.3401H15.5151C15.6098 25.3401 15.6872 25.2626 15.6872 25.1679V23.8761C15.6872 23.7813 15.6098 23.7038 15.5151 23.7038H14.6527C13.9279 23.7038 13.2462 23.4153 12.7386 22.8921C12.2332 22.3711 11.9644 21.6692 11.988 20.9415C12.0074 20.3731 12.2009 19.8391 12.5515 19.3891C12.9107 18.9305 13.4139 18.5968 13.9731 18.4482L14.7882 18.2351L15.0871 17.4471C15.2721 16.9562 15.5302 16.4976 15.8549 16.0821C16.1755 15.6702 16.5553 15.3081 16.9819 15.0077C17.8658 14.3855 18.9067 14.056 19.9928 14.056C21.0789 14.056 22.1198 14.3855 23.0038 15.0077C23.4317 15.3091 23.8103 15.6708 24.1307 16.0821C24.4555 16.4976 24.7135 16.9583 24.8985 17.4471L25.1953 18.2329L26.0082 18.4482C27.1739 18.7626 27.989 19.824 27.989 21.0341C27.989 21.7467 27.7116 22.4185 27.2083 22.9223C26.9615 23.1708 26.6679 23.3678 26.3445 23.502C26.0211 23.6361 25.6744 23.7048 25.3243 23.7038H24.4619C24.3673 23.7038 24.2899 23.7813 24.2899 23.8761V25.1679C24.2899 25.2626 24.3673 25.3401 24.4619 25.3401H25.3243C27.6987 25.3401 29.6235 23.4132 29.6235 21.0341C29.6235 19.0382 28.2664 17.3588 26.4276 16.8722Z" fill="white" />
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="20" y1="1" x2="20" y2="44.8462" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#353535" />
                                            <stop offset="1" stop-color="#4F4C4C" stop-opacity="0.58" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="20" y1="1" x2="20" y2="39" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#717171" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span>会員メニュートップ</span>
                            </a>
                            <a href="/audio" class="meunu-item {{ request()->is('audio*') ? 'active' : '' }}">
                                <svg width="38" height="38" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.667 15.9997C11.667 16.9201 12.4132 17.6663 13.3337 17.6663C14.2541 17.6663 15.0003 16.9201 15.0003 15.9997C15.0003 15.0792 14.2541 14.333 13.3337 14.333C12.4132 14.333 11.667 15.0792 11.667 15.9997ZM28.3337 15.1663V16.833H16.667V15.1663H28.3337ZM28.3337 21.833V20.1663H16.667V21.833H28.3337ZM16.667 26.833H28.3337V25.1663H16.667V26.833ZM11.667 25.9997C11.667 26.9201 12.4132 27.6663 13.3337 27.6663C14.2541 27.6663 15.0003 26.9201 15.0003 25.9997C15.0003 25.0792 14.2541 24.333 13.3337 24.333C12.4132 24.333 11.667 25.0792 11.667 25.9997ZM13.3337 22.6663C12.4132 22.6663 11.667 21.9201 11.667 20.9997C11.667 20.0792 12.4132 19.333 13.3337 19.333C14.2541 19.333 15.0003 20.0792 15.0003 20.9997C15.0003 21.9201 14.2541 22.6663 13.3337 22.6663Z" fill="white" />
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="20" y1="1" x2="20" y2="44.8462" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#353535" />
                                            <stop offset="1" stop-color="#4F4C4C" stop-opacity="0.58" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="20" y1="1" x2="20" y2="39" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#717171" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span>ファイル一覧</span>
                            </a>
                            <a href="/info" class="meunu-item {{ request()->is('info*') ? 'active' : '' }}">
                                <svg width="38" height="38" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.9997 30.1663C14.9371 30.1663 10.833 26.0623 10.833 20.9997C10.833 15.9371 14.9371 11.833 19.9997 11.833C25.0623 11.833 29.1663 15.9371 29.1663 20.9997C29.1663 26.0623 25.0623 30.1663 19.9997 30.1663ZM26.1659 25.2702C27.0069 24.0583 27.4997 22.5865 27.4997 20.9997C27.4997 16.8575 24.1418 13.4997 19.9997 13.4997C15.8575 13.4997 12.4997 16.8575 12.4997 20.9997C12.4997 22.5865 12.9925 24.0583 13.8334 25.2702C14.7713 24.0314 16.9752 23.4997 19.9997 23.4997C23.0242 23.4997 25.228 24.0314 26.1659 25.2702ZM24.9702 26.6161C24.7263 25.7391 22.9742 25.1663 19.9997 25.1663C17.0252 25.1663 15.273 25.7391 15.0291 26.6161C16.3524 27.7882 18.093 28.4997 19.9997 28.4997C21.9064 28.4997 23.6469 27.7882 24.9702 26.6161ZM19.9997 15.9997C17.9823 15.9997 16.6663 17.4628 16.6663 19.333C16.6663 22.1892 18.1337 23.4997 19.9997 23.4997C21.8481 23.4997 23.333 22.2327 23.333 19.4997C23.333 17.601 22.0115 15.9997 19.9997 15.9997ZM18.333 19.333C18.333 21.2241 19.0148 21.833 19.9997 21.833C20.9811 21.833 21.6663 21.2483 21.6663 19.4997C21.6663 18.4584 21.0127 17.6663 19.9997 17.6663C18.9445 17.6663 18.333 18.3462 18.333 19.333Z" fill="white" />
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="20" y1="1" x2="20" y2="44.8462" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#353535" />
                                            <stop offset="1" stop-color="#4F4C4C" stop-opacity="0.58" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="20" y1="1" x2="20" y2="39" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#717171" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span>ユーザー情報</span>
                            </a>
                            <a href="/card-management" class="meunu-item {{ request()->is('card-management*') ? 'active' : '' }}">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)" />
                                    <path d="M28 11H12C10.89 11 10.01 11.89 10.01 13L10 25C10 26.11 10.89 27 12 27H28C29.11 27 30 26.11 30 25V13C30 11.89 29.11 11 28 11ZM28 25H12V19H28V25ZM28 15H12V13H28V15Z" fill="white" />
                                </svg>
                                <span>クレジット管理</span>
                            </a>
                            <a href="/coupons" class="meunu-item {{ request()->is('coupons*') ? 'active' : '' }}">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)"/>
                                    <path d="M29 14H11C10.7348 14 10.4804 14.1054 10.2929 14.2929C10.1054 14.4804 10 14.7348 10 15V19H10.893C11.889 19 12.813 19.681 12.973 20.664C13.0217 20.951 13.0073 21.2453 12.9306 21.5261C12.8539 21.807 12.7168 22.0677 12.5289 22.2902C12.3411 22.5126 12.1069 22.6913 11.8429 22.8139C11.5788 22.9365 11.2911 23 11 23H10V27C10 27.2652 10.1054 27.5196 10.2929 27.7071C10.4804 27.8946 10.7348 28 11 28H29C29.2652 28 29.5196 27.8946 29.7071 27.7071C29.8946 27.5196 30 27.2652 30 27V23H29C28.7089 23 28.4212 22.9365 28.1571 22.8139C27.8931 22.6913 27.6589 22.5126 27.4711 22.2902C27.2832 22.0677 27.1461 21.807 27.0694 21.5261C26.9927 21.2453 26.9783 20.951 27.027 20.664C27.187 19.681 28.111 19 29.107 19H30V15C30 14.7348 29.8946 14.4804 29.7071 14.2929C29.5196 14.1054 29.2652 14 29 14ZM19 26H17V24H19V26ZM19 22H17V20H19V22ZM19 18H17V16H19V18Z" fill="white"/>
                                </svg>
                                <span>クーポン一覧</span>
                            </a>
                            <a href="/address/management" class="meunu-item {{ request()->is('address*') ? 'active' : '' }}">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)" />
                                    <path d="M22 12V15.5556C22 15.7913 22.0937 16.0174 22.2603 16.1841C22.427 16.3508 22.6531 16.4444 22.8889 16.4444H26.4444" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M24.6667 28H15.7778C15.3063 28 14.8541 27.8127 14.5207 27.4793C14.1873 27.1459 14 26.6937 14 26.2222V13.7778C14 13.3063 14.1873 12.8541 14.5207 12.5207C14.8541 12.1873 15.3063 12 15.7778 12H22L26.4444 16.4444V26.2222C26.4444 26.6937 26.2571 27.1459 25.9237 27.4793C25.5903 27.8127 25.1382 28 24.6667 28Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M17.5552 15.5542H18.4441" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M17.5552 20.8875H22.8885" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M21.1115 24.4458H22.8892" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>請求先情報</span>
                            </a>
                            <a href="/payment-history" class="meunu-item {{ request()->is('payment-history*') ? 'active' : '' }}">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)" />
                                    <path d="M25.6675 12.5176L23.6202 11.3378L21.5728 12.5176L19.5255 11.3378L17.4781 12.5176L14.8443 11V26.7269H11.6982V28.8406C11.6982 30.0313 12.667 31 13.8577 31H26.1419C27.3326 31 28.3013 30.0313 28.3013 28.8406V11L25.6675 12.5176ZM13.8577 29.8273C13.3136 29.8273 12.871 29.3847 12.871 28.8406V27.8996H23.9824V28.8406C23.9824 29.1958 24.0687 29.5314 24.2213 29.8273H13.8577ZM26.1418 29.8273C25.5978 29.8273 25.1552 29.3847 25.1552 28.8406V26.7269H16.0171V13.0292L17.478 13.8711L19.5254 12.6914L21.5728 13.8711L23.6202 12.6913L25.6676 13.8711L27.1286 13.0292V28.8406C27.1286 29.3847 26.6859 29.8273 26.1418 29.8273Z" fill="white" />
                                    <path d="M25.9562 16.293H17.1904V17.4657H25.9562V16.293Z" fill="white" />
                                    <path d="M25.9562 18.5273H17.1904V19.7001H25.9562V18.5273Z" fill="white" />
                                    <path d="M21.5734 20.7656H17.1904V21.9384H21.5734V20.7656Z" fill="white" />
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="20" y1="1" x2="20" y2="44.8462" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#353535" />
                                            <stop offset="1" stop-color="#4F4C4C" stop-opacity="0.58" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="20" y1="1" x2="20" y2="39" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#717171" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span>支払明細</span>
                            </a>
                            <a href="/contact" class="meunu-item">
                                <svg width="38" height="38" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.25 14.25H26.75C27.5784 14.25 28.25 14.9216 28.25 15.75V26.25C28.25 27.0784 27.5784 27.75 26.75 27.75H13.25C12.4216 27.75 11.75 27.0784 11.75 26.25V15.75C11.75 14.9216 12.4216 14.25 13.25 14.25ZM13.25 19.2136V26.25H26.75V19.2139L20 22.5889L13.25 19.2136ZM13.25 17.5365L20 20.9118L26.75 17.5369V15.75H13.25V17.5365Z" fill="white" />
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="20" y1="1" x2="20" y2="44.8462" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#353535" />
                                            <stop offset="1" stop-color="#4F4C4C" stop-opacity="0.58" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="20" y1="1" x2="20" y2="39" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#717171" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span>お問い合わせ</span>
                            </a>
                            <a href="/logout" class="meunu-item">
                                <svg width="38" height="38" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="20" cy="20" r="19.5" fill="url(#paint0_linear)" stroke="url(#paint1_linear)" />
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M20.75 23.0001V15.0608L23.2197 17.5304L24.2803 16.4698L20 12.1895L15.7197 16.4698L16.7803 17.5304L19.25 15.0608V23.0001H20.75ZM26.75 26.0001V19.2501H25.25V26.0001H14.75V19.2501H13.25V26.0001C13.25 26.8286 13.9216 27.5001 14.75 27.5001H25.25C26.0784 27.5001 26.75 26.8286 26.75 26.0001Z" fill="white" />
                                    <defs>
                                        <linearGradient id="paint0_linear" x1="20" y1="1" x2="20" y2="44.8462" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#353535" />
                                            <stop offset="1" stop-color="#4F4C4C" stop-opacity="0.58" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear" x1="20" y1="1" x2="20" y2="39" gradientUnits="userSpaceOnUse">
                                            <stop stop-color="#717171" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <span>ログアウト</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="right-content">
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
    <div class="loader">
        <img src="{{ asset('user/images/loading.svg') }}">
    </div>
    <script>
        $(document).ready(function() {
            var siteSticky = function() {
                $(".js-sticky-header").sticky({
                    topSpacing: 0
                });
            };
            siteSticky();

            var siteMenuClone = function() {

                $('.js-clone-nav').each(function() {
                    var $this = $(this);
                    $this.clone().attr('class', 'site-nav-wrap link-top-page').appendTo('.site-mobile-menu-body');
                });


                setTimeout(function() {

                    var counter = 0;
                    $('.site-mobile-menu .has-children').each(function() {
                        var $this = $(this);

                        $this.prepend('<span class="arrow-collapse collapsed">');

                        $this.find('.arrow-collapse').attr({
                            'data-toggle': 'collapse',
                            'data-target': '#collapseItem' + counter,
                        });

                        $this.find('> ul').attr({
                            'class': 'collapse',
                            'id': 'collapseItem' + counter,
                        });

                        counter++;

                    });

                }, 1000);

                $('body').on('click', '.arrow-collapse', function(e) {
                    var $this = $(this);
                    if ($this.closest('li').find('.collapse').hasClass('show')) {
                        $this.removeClass('active');
                    } else {
                        $this.addClass('active');
                    }
                    e.preventDefault();

                });

                $(window).resize(function() {
                    var $this = $(this),
                        w = $this.width();

                    if (w > 768) {
                        if ($('body').hasClass('offcanvas-menu')) {
                            $('body').removeClass('offcanvas-menu');
                        }
                    }
                })

                $('body').on('click', '.js-menu-toggle', function(e) {
                    var $this = $(this);
                    e.preventDefault();

                    if ($('body').hasClass('offcanvas-menu')) {
                        $('body').removeClass('offcanvas-menu');
                        $this.removeClass('active');
                    } else {
                        $('body').addClass('offcanvas-menu');
                        $this.addClass('active');
                    }
                })

                // click outisde offcanvas
                $(document).mouseup(function(e) {
                    var container = $(".site-mobile-menu");
                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        if ($('body').hasClass('offcanvas-menu')) {
                            $('body').removeClass('offcanvas-menu');
                        }
                    }
                });
            };
            siteMenuClone();
        })
    </script>
    @yield('script')
</body>
