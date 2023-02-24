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

        <p>結果：失敗<br>
        メッセージ：クレジットカードで以下のリンクから再決済お願いします。<br>
        ──────────────────</p>
    </div>
@endsection

