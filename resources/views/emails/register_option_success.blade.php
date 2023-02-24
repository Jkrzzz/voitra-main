@extends('user.layouts.mail_layout')
@section('content')
    <div class="mail-template">
        <p>{{$data['user']->name}}様 </p>

        <p>【voitra】をご利用頂きましてありがとうございます。</p>

        <p>{{$data['option']}}のお申し込みが完了いたしました。</p>

        <p>voitraサイトのマイページにてご確認ください。</p>

        <p>URL：{{ $app['url']->to('/upload') }}</p>
        <p>※当メールは送信専用メールアドレスから配信されています。<br>
          このままご返信いただいてもお答えできませんのでご了承ください。</p>
        <p>※当メールにお心当たりの無い場合は、下記URLにアクセスし、<br>お問い合わせフォームよりご連絡下さい。</p>
        <p>URL：{{ $app['url']->to('/contact') }}</p>
        <p>
        ──────────────────<br>
        音声文字起こしサービス　voitra（ボイトラ）<br>
        URL：{{ $app['url']->to('/') }}<br>
        ──────────────────
        </p>
    </div>
@endsection
