@extends('user.layouts.mail_layout')
@section('content')
    <div class="mail-template">
        <p>【voitra アンケート】オプション解除のアンケート</p>

        <p>オプション解除のアンケート内容になります。</p>

        <p>------------------<br>
            ■ユーザーID：{{$data['user']->email}}</p>

        <p>■アンケート内容</p>

        <p>Q：退会する理由をお聞かせ下さい。</p>

        <p>A：@foreach($data['survey']['survey'] as $e){{$e}}<br>@endforeach
            @if($data['survey']['survey_content'] != null && $data['survey']['survey_content'] != ''){{$data['survey']['survey_content']}}<br>@endif
            ------------------</p>
    </div>
@endsection

