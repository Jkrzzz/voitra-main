$(function () {
    var siteSticky = function () {
        $(".js-sticky-header").sticky({topSpacing: 0});
    };
    siteSticky();

    var siteMenuClone = function () {

        $('.js-clone-nav').each(function () {
            var $this = $(this);
            $this.clone().attr('class', 'site-nav-wrap link-top-page').appendTo('.site-mobile-menu-body');
        });


        setTimeout(function () {

            var counter = 0;
            $('.site-mobile-menu .has-children').each(function () {
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

        $('body').on('click', '.arrow-collapse', function (e) {
            var $this = $(this);
            if ($this.closest('li').find('.collapse').hasClass('show')) {
                $this.removeClass('active');
            } else {
                $this.addClass('active');
            }
            e.preventDefault();

        });

        $(window).resize(function () {
            var $this = $(this),
                w = $this.width();

            if (w > 768) {
                if ($('body').hasClass('offcanvas-menu')) {
                    $('body').removeClass('offcanvas-menu');
                }
            }
        })

        $('body').on('click', '.js-menu-toggle', function (e) {
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
        $(document).mouseup(function (e) {
            var container = $(".site-mobile-menu");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                if ($('body').hasClass('offcanvas-menu')) {
                    $('body').removeClass('offcanvas-menu');
                }
            }
        });
    };
    siteMenuClone();

    $('.form-normal').on('change', () => {
        if ($('#accept').is(':checked')) {
            $('#submit').removeAttr('disabled')
        } else {
            $('#submit').prop('disabled', 'disabled')
        }
    })
    $('.form-normal .checkmark').click(function () {
        $('.regular-checkbox').trigger('click')
    })

    $('.password-input .password-icon').click(function (){
        if ( $(this).prev().attr('type') === 'password'){
            $(this).prev().attr('type','text')
            $(this).attr('class', 'fas fa-eye-slash password-icon')
        } else {
            $(this).prev().attr('type','password')
            $(this).attr('class', 'fas fa-eye password-icon')
        }
    })

    if ($('#notification').val() !== undefined) {
        $('#modal-notification').modal('show')
    }
    $(window).scroll(function(){
        if ($(window).scrollTop() >= 62) {
            $('header').addClass('fixed-header')
            $('header .btn-common-outline').addClass('btn-bs-white')
            $('header .site-logo img').attr('src','/user/images/logo.png')
        }
        else {
            $('header').removeClass('fixed-header');
            $('header .btn-common-outline').removeClass('btn-bs-white')
            $('header .site-logo img').attr('src','/user/images/logo-white.png')
        }
    });
    $('.link-top-page li a').click(function (){
        const to = $(this).attr('to');
        $([document.documentElement, document.body]).animate({
            scrollTop: $(`#${to}`).offset().top - 100
        }, 1000);
        $('body').removeClass('offcanvas-menu').removeClass('active');
    })

    const currentUrl = window.location.href
    const arrUrl = currentUrl.split('#')
    if (arrUrl.length >= 2){
        const to = arrUrl[arrUrl.length - 1]
        $([document.documentElement, document.body]).animate({
            scrollTop: $(`#${to}`).offset().top - 100
        }, 1000);
        $('body').removeClass('offcanvas-menu').removeClass('active');
    }
    if ($('.select-input select option:selected').val() == "") {
        $('.select-input select').css('color', 'grey')
    } else {
        $('.select-input select').css('color', '#495057')
    }
    $('.select-input select').change(function (){
        if ($(this).val() == "") {
            $(this).css('color','grey')
        } else {
            $(this).css('color','#495057')
        }
    })
});
