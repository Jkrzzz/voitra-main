@extends('user.layouts.user_layout')
@section('title','ユーザー情報')
@section('style')
    <link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
    <style>
        .right-content{
            padding: 30px 0;
        }
    </style>
@endsection
@section('content')
    <div class="main-content">
        <div class="right-content-member">
            <p class="breadcrumb-common">ユーザー情報</p>
            <h4 class="information-title mb-0">よくあるトラブル</h4>
        </div>
        <div class="information-box">
            <div class="row difficult-box right-content-member">
                <div class="col-md-6 col-12">
                    <h4 class="remove-member-title">テキスト化の精度が悪い場合</h4>
                    <p class="remove-member-content">
                        アップロードした音声にノイズが含まれていたり、マイクから遠い人の声をテキスト化したりすると、誤変換やそもそも音声として認識されないケースがございます。<br>
                        できるだけマイクに近づいて発言し、なるべく静かな場所で録音したデータをご利用下さい。<br>
                        ※タイピングの音や書類の摩擦音などもマイクによっては、音声認識の妨げになる可能性がございます。</p>
                </div>
                <div class="col-md-6 col-12 text-center">
                    <img src="{{ asset('/user/images/difficult.png') }}">
                </div>
            </div>
            <div class="row difficult-box bg-yellow-light right-content-member">
                <div class="col-md-6 col-12">
                    <h4 class="remove-member-title">文章の修正が面倒、活用しにくい場合</h4>
                    <p class="remove-member-content">
                        まずは、ブラッシュアッププランをご検討下さい。AIによるテキスト化精度には、音声の品質や話し方等が大きく影響いたします。そこで、人による修正を行うことで、句読点、改行、誤字脱字などを解消いたします。また、話者分離オプションをご利用いただくことで、誰が話したかを自動検出し、テキスト化に反映することも可能です。
                    </p>
                </div>
                <div class="col-md-6 col-12 text-center">
                    <img src="{{ asset('/user/images/difficult-2.png') }}">
                </div>
            </div>
            <div class="row difficult-box right-content-member">
                <div class="col-md-6 col-12">
                    <h4 class="remove-member-title">アップした音声の個人情報に不安がある場合</h4>
                    <p class="remove-member-content">
                        ご安心下さい。アップロードされた音声ファイルやテキスト化された情報は、ご利用頂いた後に必要がなければ、ご自身で削除することができます。その際、voitraのサーバーからも完全に削除されます。<br>
                        また、ご利用から30日経過したデータに関しても、自動削除されますのでvoitraサーバーに永続的に残ることはございません。<br>
                    </p>
                </div>
                <div class="col-md-6 col-12 text-center">
                    <img src="{{ asset('/user/images/difficult-3.png') }}">
                </div>
            </div>
        </div>
        <div class="upload-button">
            <a class="btn custom-btn btn-default" href="/info">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black"></circle>
                    <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z" stroke="black" stroke-width="2"></path>
                </svg>
                戻る
            </a>
            <a class="btn custom-btn btn-primary" href="/remove-member/survey">
                進む
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                    <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
                </svg>
            </a>
        </div>
    </div>
@endsection

