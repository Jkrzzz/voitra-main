@extends('user.layouts.layout')

@section('title','お問い合わせフォーム')
@section('right-header-img')
    <img src="{{ asset('user/images/contact-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Contact us</h4>
                <h1 class="section-sub-title">お問い合わせ</h1>
                <div class="justify-content-center align-items-center d-flex">
                    <form class="form-normal" action="/contact?selectType={{$selectType}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label required">法人/個人</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <div class="select-input">
                                    <select class="form-control" name="type" id="type">
                                        <option value="">選択して下さい</option>
                                        @foreach($userType as $key => $type)
                                            <option {{ old('type', $selectType) == $key ? 'selected' : '' }} value="{{ $key }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('type')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>  @if($selectType == 1)
                            <div class="form-group row">
                                <div class="col-md-5 col-12">
                                    <label class="col-form-label required">会社名</label>
                                </div>
                                <div class="col-md-7 col-12">
                                    <input type="text" maxlength="255" class="form-control" name="company_name" value="{{ old('company_name') }}" placeholder="株式会社ボイトラ">
                                    @error('company_name')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label required">名前</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <input type="text" maxlength="255" class="form-control" name="name" value="{{ old('name') }}" placeholder="音声　太郎">
                                @error('name')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label required">メールアドレス</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <input type="text" maxlength="255" class="form-control" name="email" value="{{ old('email') }}" placeholder="voice@voitra.jp">
                                @error('email')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label required">電話番号</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <input type="text" maxlength="255" class="form-control" name="phone_number" value="{{ old('phone_number') }}" placeholder="09012345678">
                                @error('phone_number')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label required">お問い合わせの種類</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <div class="select-input">
                                    <select class="form-control" name="content_type">
                                        <option value="">選択して下さい</option>
                                        @foreach($contactType as $key => $type)
                                            <option {{ old('content_type') == $key ? 'selected' : '' }} value="{{ $key }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('content_type')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label required">お問い合わせ内容</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <textarea class="form-control" name="content">{{ old('content') }}</textarea>
                                @error('content')
                                <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group my-form-check mb-0">
                            <div class="regular-checkbox-group">
                                <input class="regular-checkbox" type="checkbox" value="" id="accept">
                                <span class="checkmark"></span>
                            </div>
                            <label class="form-check-label" for="accept">
                                <a class="text-link" href="/home/terms.php " target="_blank">利用規約</a>と<a class="text-link" target="_blank" href="/home/privacy.php">プライバシーポリシー</a>に同意します。
                            </label>
                        </div>
                        <div class="text-center">
                            <button id="submit" class="btn-common btn-yellow submit" disabled>確認 <i class="far fa-arrow-alt-circle-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="contact-bg">
            <img src="{{ asset('/user/images/contact-bg.png') }}">
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#type').change(function () {
                if ($(this).val() == 1) {
                    window.location.href = '/contact?selectType=1'
                } else if($(this).val() == 2) {
                    window.location.href = '/contact?selectType=2'
                }
            })
        })
    </script>
@endsection
