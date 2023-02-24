<!DOCTYPE html>
<html lang="ja">
<head>
    <title>@yield('title')｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ） </title>
    @include('user.layouts.meta')
    @yield('style')
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6JH4BR"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@include('user.layouts.header')
<main>
    @yield('content')
</main>
@include('user.layouts.footer')
<script src="{{ asset('/user/js/main.js') }}"></script>
@yield('script')
</body>
