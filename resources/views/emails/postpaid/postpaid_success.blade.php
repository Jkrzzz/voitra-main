@extends('user.layouts.mail_layout')
@section('content')

    <div class="mail-template">

        <p>{{ $data['user']->name }}様</p>

        <p>【voitra】をご利用頂き、誠にありがとうございました。</p>

        <p>後払いの審査結果をお知らせいたします。<br>
        ──────────────────<br>
        @if($data['type'] != 3)
        @foreach ( $data['order']->audios as $audio)
            <p>ファイル名：{{ $audio->name }}</p></br>
        @endforeach
        @endif
        @switch($data['type'])
            @case(1)
                プラン：AI文字起こしプラン
                @break
            @case(2)
                プラン：ブラッシュアッププラン
                @break
            @case(3)
                オプション：話者分離オプション
                @break
            @case(4)
                プラン：AI文字起こしプラン<br>
                オプション：話者分離オプション
                @break
            @default
        @endswitch
        </p>

        <p>結果：成功<br>
        メッセージ：無し<br>
        ──────────────────<br>
        ※請求書はサービス提供後に株式会社SCOREより郵送されます。発行から14日以内にコンビニでお支払いください。</p>


        <p>詳細は、マイページをご確認ください。<br>
            {{ $app['url']->to('/upload') }}</p>

        <p>──────────────────</p>

        <p>※当メールにお心当たりの無い場合は、下記URLにアクセスし、<br>
        お問い合わせフォームよりご連絡下さい。<br>
        URL：{{ $app['url']->to('/contact') }}</p>

        <p>──────────────────<br>
        音声文字起こしサービス　voitra（ボイトラ）<br>
        URL：{{ $app['url']->to('/') }}<br>
        ──────────────────</p>
    </div>
@endsection

