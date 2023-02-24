

@extends('user.layouts.mail_layout')
@section('content')
    お問い合わせがありました。<br>
    お問い合わせ内容は下記の通りです。<br>
    <br>
    <br>

    お問い合わせ日時： {{$date}}<br>

    <br>
    <br>
    ＜お問い合わせ内容＞<br>

    <br>
    <br>
    法人 : 法人<br>
    プラン: {{$plan}}<br>
    会社名: {{$company}}<br>
    名前: {{$name}}<br>
    <br>
    メールアドレス: {{$email}}<br>
    電話番号: {{$phone}}<br>
    <br>
    お問い合わせの種類: P3お問合せ<br>
    【お問い合わせ内容】<br>

    {{$text}}
@endsection
