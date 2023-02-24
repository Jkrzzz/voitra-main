@extends('user.layouts.mail_layout')
@section('content')

    <div class="mail-template">

        <p>【voitra 管理者対応】納品予定日確認タスクが入りました</p>

        <p>スタッフが納品予定日を決定しました。<br>
            問題ないかを確認して、お客様に通知をしてください。</p>
        　
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
