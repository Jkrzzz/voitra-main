@extends('user.layouts.mail_layout')
@section('content')

    <div class="mail-template">
        <p>後払いの審査結果をお知らせいたします。<br>
        ──────────────────<br>
        名前：{{ $data['user']->name }}様<br>
        @if($data['type'] != 3)
            申込ID：{{ $data['order']->id }}<br>
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
        ※急ぎの場合は、クレジットカード払いに変更することも可能です。<br>
        @if($data['type'] != 3)
            @if($data['order'])
                修正内容：{{ $data['payment_description'] }}<br>
            @endif
        @endif
        ──────────────────<br>
        @if(isset($data['reason']))
            保留コード：{{ $data['reason'] }}<br>
        @endif
        ──────────────────</p>
    </div>
@endsection
