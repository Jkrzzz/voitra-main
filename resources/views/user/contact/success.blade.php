@extends('user.layouts.layout')

@section('title','お問い合わせ完了')
@section('right-header-img')
    <img src="{{ asset('user/images/contact-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Verification</h4>
                <h1 class="section-sub-title">お問い合わせ完了</h1>

                <div class="text-center">
                    <img src="{{ asset('/user/images/icon-success.png') }}">
                   <div class="d-flex justify-content-center">
                       <div class="message-text">
                           <p>この度は、お問い合わせいただき、誠にありがとうございます。</p>
                           <p>ご入力いただいたメールアドレスに、確認用メールを送信いたしましたので、ご確認をお願いいたします。</p>
                           <p>24時間経過してもメールが届かない場合は、メールアドレスに誤りがある可能性がございますので、大変お手数ですが、再度フォームからお問い合わせくださいますようお願いいたします。</p>
                       </div>
                   </div>
                    <a href="/"><button class="btn-common submit btn-yellow">トップページへ <i class="far fa-arrow-alt-circle-right"></i></button></a>
                </div>

            </div>
        </div>
        <div class="contact-bg">
            <img src="{{ asset('/user/images/contact-bg.png') }}">
        </div>
        <div class="left-contact-bg">
            <img src="{{ asset('/user/images/left-contact-bg.png') }}">
        </div>
    </div>
@endsection
