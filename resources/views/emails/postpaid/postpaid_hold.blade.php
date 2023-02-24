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

        <p>結果：保留<br>
        メッセージ：後払の審査が保留になりました。以下の修正内容を確認し、修正をお願いいたします。<br>
        修正していただいた後、後払いの与信をかけなおします。<br>
        ※審査は翌営業日の12時まで時間がかかる場合がありますのでご了承ください。<br>
        ※急ぎの場合は、クレジットカード払いに変更することも可能です。</p>

        @if($data['type'] != 3)
        修正内容： {{ $data['payment_description'] }} <br>
        修正リンク： {{ route('fixAddress', ['type' => $data['type'], 'order_id' => $data['order']->id]) }} <br>
        @else
        修正内容： {{ $data['payment_description'] }} <br>
        修正リンク： {{ route('fixAddress', ['type' => $data['type']]) }} <br>
        @endif

        <p>■クレジットカード払いへ変更<br>
        後払いをキャンセルし、クレジットカード払いへ変更する場合は、以下のリンクよりお願い致します。<br>
        @if($data['type'] != 3)
        {{ route('repay', ['type' => $data['type'], 'order_id' => $data['order']->id]) }}</p>
        @else
        {{ route('repay', ['type' => $data['type']]) }}</p>
        @endif
        <p>──────────────────<br>
        @if(isset($data['reason']))
        保留コード：{{ $data['reason'] }}<br>
        @endif
        ──────────────────</p>

        <p>※当メールにお心当たりの無い場合は、下記URLにアクセスし、<br>
        お問い合わせフォームよりご連絡下さい。<br>
        URL：{{ $app['url']->to('/contact') }}</p>

        <p>──────────────────<br>
        音声文字起こしサービス　voitra（ボイトラ）<br>
        URL：{{ $app['url']->to('/') }}<br>
        ──────────────────</p>
    </div>
@endsection
