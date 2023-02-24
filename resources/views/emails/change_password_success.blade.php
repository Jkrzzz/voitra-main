@extends('user.layouts.mail_layout')
@section('content')
    <div class="mail-template">
        <p>{{$user->name}}様</p>

        <p>【voitra】のパスワード再発行が完了しました。</p>

        <p>新しいパスワードでのログイン確認をお願い致します。</p>

        <p>下記URLよりログインしてください。<br>
            {{ $app['url']->to('/login') }}</p>

        <p>※当メールは送信専用メールアドレスから配信されています。<br>
            このままご返信いただいてもお答えできませんのでご了承ください。</p>

        <p>※当メールにお心当たりの無い場合は、下記URLにアクセスし、<br>
            お問い合わせフォームよりご連絡下さい。<br>
            URL：{{ $app['url']->to('/contact') }}</p>
    </div>
@endsection
