@extends('user.layouts.mail_layout')
@section('content')
    <div class="mail-template">
        <p>{{ $user->name }}様 </p>

        <p>【voitra】をご利用頂き、誠にありがとうございました。</p>

        <p>【voitra】の退会手続きが完了しましたので、お知らせいたします。</p>

        <p>またの機会がありましたら、ご利用よろしくお願い申し上げます。</p>

        <p>当メールを持ちまして、ユーザー情報および音声・テキストデータは全て削除されました。<br>
            元に戻すことは出来ませんのでご了承ください。</p>

        <p>※当メールは送信専用メールアドレスから配信されています。<br>
            このままご返信いただいてもお答えできませんのでご了承ください。</p>

        <p>※当メールにお心当たりの無い場合は、下記URLにアクセスし、<br>
            お問い合わせフォームよりご連絡下さい。<br>
            URL：{{ $app['url']->to('/contact') }}</p>

        <p>─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─<br>
            音声文字起こしサービス　voitra（ボイトラ）<br>
            URL：{{ $app['url']->to('/') }}<br>
            ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─ ─</p>
    </div>
@endsection
