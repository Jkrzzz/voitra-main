@extends('user.layouts.mail_layout')
@section('content')
<div class="mail-template">
    <p>{{$user->name}}様</p>

    <p>【voitra】の登録が完了しました。</p>
    <p>ID：{{ $user->email }}</p>

    <p>下記URLよりログインしてください。<br>
        {{ $app['url']->to('/login') }}</p>

    <p>※お使いのメールソフトによってはURLが途中で改行されることがあります。<br>
        その場合は、最初の「https://」から末尾の英数字までをブラウザに<br>
        直接コピー＆ペーストしてアクセスしてください。</p>

    <p>※当メールは送信専用メールアドレスから配信されています。<br>
        このままご返信いただいてもお答えできませんのでご了承ください。</p>

    <p>※当メールにお心当たりの無い場合は、誠に恐れ入りますが<br>
        破棄して頂けますよう、よろしくお願い致します。</p>
</div>
@endsection


