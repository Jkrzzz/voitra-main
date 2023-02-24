@extends('user.layouts.mail_layout')
@section('content')
    <div class="mail-template">
        　<p>{{ $contact->name }}様</p>
        　
        　<p>お問い合わせ頂き、ありがとうございます。</p>

        <p>改めて、担当者よりご連絡させていただきます。</p>

        <p>お問い合わせ日時： {{ $contact->created_at->format('m月d日 h:m') }}（日本時間）</p>

        <p>＜お問い合わせ内容＞</p>

        <p>法人/個人: {{ \Illuminate\Support\Facades\Config::get('const.userType')[$contact->type] }}<br>
            @if($contact->company_name)会社名: {{ $contact->company_name }}<br>@endif
            名前: {{ $contact->name }}<br>
            メールアドレス: {{ $contact->email }}<br>
            電話番号: {{ $contact->phone_number }}<br>
            お問い合わせの種類: {{ \Illuminate\Support\Facades\Config::get('const.contactType')[$contact->content_type] }}<br>
            お問い合わせ内容: {{ $contact->content }}<br>
            プライバシーポリシーの同意</p>
    </div>
@endsection
