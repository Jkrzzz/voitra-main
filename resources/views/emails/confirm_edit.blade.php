@extends('user.layouts.mail_layout')
@section('content')

    <div class="mail-template">

        <p>【voitra 管理者対応】編集結果確認タスクが入りました</p>

        <p>ブラッシュアッププランのスタッフ対応が完了いたしました。<br>
            内容を確認して、お客様に納品してください。</p>
        　
        <p>＜納品予定日＞<br>
            {{date('m月d日', strtotime($data['order']->deadline))}}<br>
            ＜ファイル内容＞<br>
            名前：{{$data['user']->name}}様<br>
            ファイル名：@foreach($data['audios'] as $audio){{$audio->name}}<br>
            @endforeach
            文字数： {{$data['order']->total_time}}文字<br>
            金額： {{$data['order']->total_price}}円<br>
            希望納品日：{{date('m月d日', strtotime($data['order']->audios[0]->pivot->user_estimate))}}</p>

        　 <p>申込ID：{{$data['order']->id}}</p>

        　 <p>対象ファイルを下記からご確認下さい。<br>
            <a href="{{$app['url']->to('/admin/orders/' . $data['order']->id . '/edit')}}">{{$app['url']->to('/admin/orders/' . $data['order']->id . '/edit')}}</a>
        </p>
    </div>
@endsection
