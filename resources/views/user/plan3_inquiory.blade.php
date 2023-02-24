@extends('user.layouts.textmining_layout')
@section('mining_qu')
テキストマイニング｜AI文字起こし 音声のテキスト化サービス｜voitra（ボイトラ）
@endsection
@section('content')
<div class="bg-bdy">
    <div>
        {{-- explanation --}}
        <div class=" mt-5 ml-5 ms-a t-color">
            <h1>企業向け 一括文字起こし・テキストマイニング</h1>
        </div>
       <div class=" m-5 t-2">
            <div class="row my-5 d-flex align-items-center">
                <div class="col-md-6 col-12">
                    <p class=" t-center px-3 s-size">
                        多数の音声を、一括で文字起こしすることが可能で、コールセンターの通話データや、
                        会議等で蓄積された音声や動画データもまとめて、文字起こしすることができます。<br>
                        さらに、文字起こしした内容をテキストマイニングすることで、
                        会話の傾向分析を行うことで、サービスの課題解決や業務改善につながります
                    </p>
                    <a class="btn btn-down" href="#mining-in">
                        今すぐ問い合わせ
                        <i class="fa-solid fa-circle-arrow-down"></i>
                    </a>
                </div>
                <div class="col-md-6 col-12">
                    <div class="right-intro">
                        <img class="w-100 img-intro" src="{{asset('user/images/text-intro.jpeg')}}" alt="">
                    </div>
                </div>
            </div>
       </div>
        <div class="section pt-2 responsive-section" id="strength">
            <div class="bg-s">
                <h3 class="section-title">SERVICES</h3>
                <h1 class="section-sub-title m-sub mb-5">サービス概要</h1>
                <div class="steps">
                    <div class="strength">
                        <div class="strength-bg" style="text-align: right">
                            <img src="{{ asset('/user/images/text-show-1.png') }}" alt="VOITRAの強みは安くて早くて使いやすい音声テキスト化アプリ">
                        </div>
                        <div class="strength-body text-body">
                            <h3 class="strength-title">多数の音声・動画を一括で文字起こし</h3>
                            <p class="strength-sub-title">Numerous Voice Transcriptions</p>
                            <ul class="strength-list">
                                <li>
                                    <img src="{{ asset('/user/images/text-show-icon.png') }}" alt="コールセンター">
                                    <span class="text-head">コールセンター</span> 
                                    <br>毎日蓄積される多数の音声データを文字起こし
                                </li>
                                <li>
                                    <img src="{{ asset('/user/images/text-show-icon.png') }}" alt="会議や講義の蓄積データ">
                                     <span class="text-head">会議や講義の蓄積データ</span> 
                                    <br>会議や講義で残した音声・動画データの文字起こし
                                </li>
                                <li>
                                    <img src="{{ asset('/user/images/text-show-icon.png') }}" alt="動画の字幕作成">
                                     <span class="text-head">動画の字幕作成</span> 
                                    <br>たまった動画の字幕を一括で文字起こし
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="strength right">
                        <div class="strength-bg right">
                            <img src="{{ asset('/user/images/text-show-2.png') }}" alt="ポイント２：様々な言語に対応">
                        </div>
                        <div class="strength-body text-body right">
                            <h3 class="strength-title">一括文字起こし＋テキストマイニング</h3>
                            <p class="strength-sub-title">Voice Transcriptions ＆ Text Mining</p>
                            <ul class="strength-list">
                                <li>
                                    <img src="{{ asset('/user/images/text-show-icon.png') }}" alt="傾向分析">
                                    <span class="text-head">傾向分析</span> 
                                    <br>お客様の声やオペレーターの声を分析し傾向を把握
                                </li>
                                <li>
                                    <img src="{{ asset('/user/images/text-show-icon.png') }}" alt="営業効率化">
                                     <span class="text-head">営業効率化</span> 
                                    <br>会話の分析を行い、テレアポ業務の成約率向上が可能
                                </li>
                                <li>
                                    <img src="{{ asset('/user/images/text-show-icon.png') }}" alt="業務改善">
                                     <span class="text-head">業務改善</span> 
                                    <br>傾向分析から改善点を抽出し業務改善が可能
                                </li>
                            </ul>
                        </div>

                    </div>

                </div>
                <div class="text-center">
                    <a class="btn btn-down" href="#mining-in">
                        今すぐ問い合わせ
                        <i class="fa-solid fa-circle-arrow-down"></i>
                    </a>
                </div>
            </div>
            <div class="strength-layout">
                <img src="{{ asset('/user/images/strength-layout.png') }}" alt="音声テキスト化の料金">
            </div>
        </div>
       <div class="bg-common bg-s">
            <div class="section responsive-section" id="overview">
                <div class="mb-5">
                    <h3 class="section-title">MERITS</h3>
                    <h1 class="section-sub-title">メリット</h1>
                </div>
                <div class="service-top h-20 merits-top" >
                    <div class=" p-200">
                        <div class="service-box">
                            <h4 class="service-title">オペレーターの教育</h4>
                            <p class="text20 mb-3">
                                お客様との会話内容、スクリプトの改善など、今までは、属人的なものになりがちでしたが、オペレーターの会話をテキストマイニングし、
                                見本となるオペレーターや、成約率の高いオペーレーターと、それ以外のオペレーターを比較することで、
                                何が成約率を下げているのかという原因を明らかにします。オペレーターへの教育・指導の工数も削減することができます。
                            </p>
                        </div>
                    </div>
                    <div class="service-bg">
                        <img class="text-png" src="{{ asset('/user/images/text-png-1.png') }}">
                    </div>
                </div>
                <div class="service-top  pb-0 merits-top ">
                    <div class=" p-200 p-200-r">
                        <div class="service-box float-right">
                            <h4 class="service-title">売上アップ</h4>
                            <p class="text20">
                                お客様との会話内容、スクリプトの改善など、今までは、属人的なものになりがちでしたが、オペレーターの会話をテキストマイニングし、
                                見本となるオペレーターや、成約率の高いオペーレーターと、それ以外のオペレーターを比較することで、
                                何が成約率を下げているのかという原因を明らかにします。オペレーターへの教育・指導の工数も削減することができます。
                            </p>
                        </div>
                    </div>
                    <div class="service-bg right">
                        <img class="text-png"  src="{{ asset('/user/images/text-png-2.png') }}" alt="簡単便利なvoitraは、アップするだけで、音声をテキスト化・文字起こしが可能です！">
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <a class="btn btn-down" href="#mining-in">
                今すぐ問い合わせ
                <i class="fa-solid fa-circle-arrow-down"></i>
            </a>
        </div>
        <div>
            <div class="m-5 p-3 text-title">
                <h3 class="section-title">TEXT MINING REPORT</h3>
                <h1 class="section-sub-title">テキストマイニングレポート</h1>
            </div>
            <div class=" d-flex justify-content-center mb-5 position-relative slide-n" id="slide-up-p">
                <div class="bg-ss">
                    <img src="{{asset('user/images/mining-slide-bg.png')}}" alt="">
                </div>
                <div class="slider-w slider-img">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="2000">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{asset('user/images/mining-slide-1.png')}}" alt="First slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset('user/images/mining-slide-2.png')}}" alt="Second slide">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="{{asset('user/images/mining-slide-3.png')}}" alt="Third slide">
                            </div>

                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="m-5 p-5 slid-p">
                <div class="row row-flex" style="overflow-x: auto">
                    <div class="col-lg-4  slide-col-1 col-md-4 col-sm-12 col-12 mb-5" >
                        <div 
                        data-target="#carouselExampleIndicators" data-slide-to="0" 
                        class="border border-dark p-3 slide-col slide-col-active" 
                        >
                            <h2 class="my-4 text-center">ワードクラウド分析</h2>
                            <div class="text-center">
                                <img class="slide-img" src="{{asset('user/images/text-slide-icon-1.png')}}" alt="">
                            </div>
                            <p class="slide-p t-center">
                                文章中に出てくる単語を頻度
                                重要度に応じた大きさで図示
                                します。
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4  slide-col-1 col-md-4 col-sm-12 col-12 mb-5" >
                        <div 
                        data-target="#carouselExampleIndicators" data-slide-to="1" 
                        class="border border-dark p-3 slide-col" 
                        >
                            <h2 class="my-4 text-center">単語出現頻度分析</h2>
                            <div class="text-center">
                                <img class="slide-img" src="{{asset('user/images/text-slide-icon-2.png')}}" alt="">
                            </div>
                            <p class="slide-p t-center">
                                文章中の各単語を分類し、
                                ワードの出現回数で並び替え、
                                出現頻度を分析します。
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4  slide-col-1 col-md-4 col-sm-12 col-12 mb-5" >
                        <div 
                        data-target="#carouselExampleIndicators" data-slide-to="2" 
                        class="border border-dark p-3 slide-col" 
                        >
                            <h2 class="my-4 text-center">ワード組合せ分析</h2>
                            <div class="text-center">
                                <img class="slide-img" src="{{asset('user/images/text-slide-icon-3.png')}}" alt="">
                            </div>
                            <p class="slide-p t-center">
                                文章中に、セットで出てくる単語の組み合わせを線でつなぎ、単語同士の結びつきの強さを示している。
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="m-5 p-3 contact-us"  id="mining-in">
                <h3 class="section-title">CONTACT US</h3>
                <h1 class="section-sub-title">お問い合わせ</h1>
            </div>
            <div class="d-flex justify-content-center p-0 pt-3">
                <form action="/textmining-complete" class="form-group inqo-form" method="POST">
                    {{ csrf_field() }}
                    <div class="mt-inquiory-right py-3 px-5 test-2">
                        <div class="row mt-3 d-flex align-items-center">
                            <div class="col-lg-4 col-12">
                                <p class="right-note font-weight-bold mb-2 mb-lg-0">
                                    プラン <span class="btn btn-required">必須</span>
                                </p>
                            </div>
                            <div class="col-lg-8 col-12">
                                <select name="plan" class="form-control">
                                <option selected disabled>プラン</option>
                                <option  value="一括文字起こし" {{'一括文字起こし'=== old('plan') ? 'selected': ''}} >一括文字起こし</option>
                                <option value="一括文字起こし＋テキストマイニング" {{'一括文字起こし＋テキストマイニング'=== old('plan') ? 'selected': ''}}>一括文字起こし＋テキストマイニング</option>
                                </select>
                            </div>
                        </div>
                        @error('plan')
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-lg-8 col-12">
                                <p class="text-danger ml-2">
                                    プラン必須です
                                </p>
                            </div>    
                        </div>
                        @enderror
                        <div class="row mt-3 d-flex align-items-center">
                            <div class="col-lg-4 col-12">
                                <p class="right-note font-weight-bold mb-2 mb-lg-0">
                                    会社名 <span class="btn btn-required">必須</span>
                                </p>
                            </div>
                            <div class="col-lg-8 col-12">
                                <input type="text" name="company" value="{{old('company')}}" placeholder="会社〇〇" class="w-100 form-control">
                            </div>
                        </div>
                        @error('company')
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-lg-8 col-12">
                                <p class="text-danger ml-2">
                                    会社名必須です
                                </p>
                            </div>    
                        </div>
                        @enderror
                        <div class="row mt-3 d-flex align-items-center">
                            <div class="col-lg-4 col-12">
                                <p class="right-note font-weight-bold mb-2 mb-lg-0">
                                    名前 <span class="btn btn-required">必須</span>
                                </p>
                            </div>
                            <div class="col-lg-8 col-12">
                                <input type="text" name="name" value="{{old('name')}}" placeholder="音声　太郎" class="w-100 form-control">
                            </div>
                        </div>
                        @error('name')
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-lg-8 col-12">
                                <p class="text-danger ml-2">
                                    お名前必須です
                                </p>
                            </div>    
                        </div>
                        @enderror
                        <div class="row mt-3 d-flex align-items-center">
                            <div class="col-lg-4 col-12">
                                <p class="right-note font-weight-bold mb-2 mb-lg-0">
                                    メールアドレス<span class="btn btn-required">必須</span>
                                </p>
                            </div>
                            <div class="col-lg-8 col-12">
                                <input type="email" name="email" value="{{old('email')}}" placeholder="voice@voitra.jp" class="w-100 form-control">
                            </div>
                        </div>
                        @error('email')
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-lg-8 col-12">
                                <p class="text-danger ml-2">
                                    {{$message}}
                                </p>
                            </div>    
                        </div>
                        @enderror
                        <div class="row mt-3 d-flex align-items-center">
                            <div class="col-lg-4 col-12">
                                <p class="right-note font-weight-bold mb-2 mb-lg-0">
                                    電話番号<span class="btn btn-required">必須</span>
                                </p>
                            </div>
                            <div class="col-lg-8 col-12">
                                <input type="tel" name="phone" value="{{old('phone')}}" placeholder="09012345678" class="w-100 form-control">
                            </div>
                        </div>
                        @error('phone')
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-lg-8 col-12">
                                <p class="text-danger ml-2">
                                    {{$message}}
                                </p>
                            </div>    
                        </div>
                        @enderror
                        <div class="row mt-3 d-flex align-items-start">
                            <div class="col-lg-4 col-12">
                                <p class="right-note font-weight-bold mb-2 mb-lg-0">
                                    お問合せ内容<span class="btn btn-required">必須</span>
                                </p>
                            </div>
                            <div class="col-lg-8 col-12">
                                <textarea name="text" id="" class="form-control">{{old('text')}}</textarea>
                            </div>
                        </div>
                        @error('text')
                        <div class="row mt-2">
                            <div class="col-4"></div>
                            <div class="col-lg-8 col-12">
                                <p class="text-danger ml-2">
                                    リクエストフィールドは必須です
                                </p>
                            </div>    
                        </div>
                        @enderror
                        <div class="mb-4 mt-3">    
                            <label for="" class="m-0 d-flex justify-content-center align-items-center">
                                <span><input type="checkbox" id="check-mining" class="mt-2 mr-2" onclick="checkPolicy()"></span>
                                <p>このフォームに記入することにより、 
                                    <span>
                                        <a href="/home/privacy.php " target="_blank"><u>プライバシーポリシー</u></a>
                                    </span>に同意します
                                </p>
                            </label>
                        </div>
                        <div class="d-flex justify-content-center mb-3">
                            <button class="btn btn-go d-flex align-items-center" type="submit" disabled id="check-btn">
                                <span class="pr-2">送信</span>
                                <svg width="20" height="20" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="12.5" cy="12" r="11.5" stroke="#000"/>
                                    <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z"
                                        stroke="#000" stroke-width="2"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form> 
            </div>
        </div> 
    </div>
</div>
@endsection