@extends('user.layouts.textmining_layout')
@section('mining_qu')
テキストマイニングお問い合わせ完了｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）
@endsection
@section('content')
    
    <div class="container my-5">
        <div class="row mining-c-bg py-5 px-3 d-flex align-items-center">
            <div class="col-lg-6 col-12 mb-lg-0 mb-3 d-flex justify-content-center mining-completed">
                <img src="{{asset('user/images/mining-complete.png')}}" alt="">
            </div>
            <div class="col-lg-6 col-12 ">
                <div class="row d-flex align-items-center">
                    <form action="">
                        <div class="col-12 text-center mb-5">
                            <h4 class="font-weight-bold">問い合わせ完了</h4>
                        </div>
                        <div class="col-12 d-flex justify-content-center mb-5">
                            <p class="w-75 text-center text-justify font-weight-bold">テキストマイニングのお問い合わせについて受領しました。弊社担当者から後日ご連絡させていただきます。</p>
                        </div>
                        <div class="col-12 d-flex justify-content-center mb-5">
                            <p class="w-75 text-center text-justify">稀に迷惑メールボックスにもメールが送信される場合がございます</p>
                        </div>
                        <div class="col-12 text-center">
                            <a class="btn btn-dark" href="{{route('index')}}">トップページに戻る<i class="pl-2 fa-solid fa-circle-arrow-right"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection