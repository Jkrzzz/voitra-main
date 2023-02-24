<!DOCTYPE html>
<html lang="ja">
<head>
    @include('admin.layouts.meta')
    @yield('style')
</head>
<body class="c-app">
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
    <div class="c-sidebar-brand d-lg-down-none">
        <img  class="c-sidebar-brand-full" width="100" height="auto" src="{{ asset('./admin/assets/img/logo/logo-big-white.png') }}">
        <img  class="c-sidebar-brand-minimized" width="40" height="auto" src="{{ asset('./admin/assets/img/logo/logo-small.png') }}">
    </div>
    @include('admin.layouts.side_menu')
    <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
            data-class="c-sidebar-minimized"></button>
</div>
<div class="c-wrapper c-fixed-components">
    @include('admin.layouts.header')
    <div class="c-body">
        <main class="c-main">
            <div class="container-fluid">
                <div class="modal fade info-modal" id="not_found_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                                    <i class="fas fa-times-circle "></i>
                                </div>
                                <img src="{{ asset('/user/images/info.png') }}">
                                <h4 class="notification-title"></h4>
                                <p class="notification-body">アサインが解除されました。</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if(session()->has('orderViewStatus') && session()->get('orderViewStatus') == false)
                    <script>
                        $(function() {
                            $('#not_found_modal').modal('show');
                        });
                    </script>
                    @php
                        session()->forget('orderViewStatus')
                    @endphp
                @endif
                <div class="fade-in">
                    @yield('content')
                </div>
            </div>
        </main>
        <footer class="c-footer"></footer>
    </div>
</div>
<script src="{{ asset('./admin/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}?v=3.4.0"></script>
<script src="{{ asset('./admin/vendors/@coreui/icons/js/svgxuse.min.js') }}?v=3.4.0"></script>
@include('admin.layouts.notice_script')
@yield('script')
</body>
</html>
