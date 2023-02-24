@extends('user.layouts.mail_layout')
@section('content')
    <div class="mail-template">
        <p>【voitra 対応】ブラッシュアッププラン お申し込みが入りました。</p>

        <p>お申し込みいただいた内容を元に、テキストのブラッシュアップをお願いします。<br>
        ブラッシュアップの完了は、納品日の前日までに、お願いします。</p>
        　
        <p>申込ID：{{$data['order']->id}}</p>

        <p>対象ファイルを下記からご確認下さい。</p>

        <p>URL:{{ $app['url']->to('/admin/orders/' . $data['order']->id . '/edit') }}</p>
    </div>
@endsection

