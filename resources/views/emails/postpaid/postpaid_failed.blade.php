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

        <p>結果：失敗<br>
        メッセージ：クレジットカードで以下のリンクから再決済お願いします。<br>
        
        @if($data['type'] != 3)
        再決済URL： <a href="{{ route('repay', ['type' => $data['type'], 'order_id' => $data['order']->id]) }}">{{ route('repay', ['type' => $data['type'], 'order_id' => $data['order']->id]) }}</a> <br>
        @else
        再決済URL： <a href="{{ route('repay', ['type' => $data['type']]) }}">{{ route('repay', ['type' => $data['type']]) }}</a> <br>
        @endif
        ──────────────────<br>
        ※当メールにお心当たりの無い場合は、下記URLにアクセスし、<br>
        お問い合わせフォームよりご連絡下さい。<br>
        URL：{{ $app['url']->to('/contact') }}</p>

        <p>──────────────────<br>
        音声文字起こしサービス　voitra（ボイトラ）<br>
        URL：{{ $app['url']->to('/') }}<br>
        ──────────────────</p>
    </div>
@endsection

