@extends('user.layouts.mail_layout')
@section('content')
    <div class="mail-template">
        <p>【voitra】 アンケート】退会のアンケート</p>

        <p>退会のアンケート内容になります。</p>

        <p>------------------<br>
            ■ユーザーID：{{ $user->id }}</p>

        <p>■アンケート内容</p>

        <p>Q：退会する理由をお聞かせ下さい。</p>

        <p>A：@foreach($survey as $e){{$e}}<br>@endforeach
            @if($survey_content != null && $survey_content != ''){{$survey_content}}<br>@endif
            ------------------</p>
    </div>
@endsection

