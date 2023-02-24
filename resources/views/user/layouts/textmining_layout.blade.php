<!DOCTYPE html>
<html lang="ja">

<head>
    <title>@yield('mining_qu')</title>
    @section('mining','TEXT MINING INQUIRY PAGE')
    @include('user.layouts.meta')
    @section('right-header-img')
        <img src="{{ asset('user/images/text-top.png') }}">
    @endsection
    @yield('style')
</head>
<body>
    @section('mining','企業テキストマイニングの問い合わせ｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）')
    @include('user.layouts.header')
    @yield('content')
    @include('user.layouts.footer')
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
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/svg-with-js.min.css" 
    integrity="sha512-j+8sk90CyNqD7zkw9+AwhRuZdEJRLFBUg10GkELVu+EJqpBv4u60cshAYNOidHRgyaKNKhz+7xgwodircCS01g==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    @yield('script')
</body>
