@extends('user.layouts.layout')

@section('title','お問い合わせ内容確認')
@section('right-header-img')
    <img src="{{ asset('user/images/contact-header.png') }}">
@endsection
@section('content')
    <div class="page">
        <div class="section">
            <div class="container">
                <h4 class="section-title">Verification</h4>
                <h1 class="section-sub-title">確認</h1>
                <div class="justify-content-center align-items-center d-flex">
                    <form class="form-normal" action="/contact/send" method="post">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">法人/個人</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <label class="col-form-label confirm">{{ $userType[$contact->type] }}</label>
                                <input type="hidden" name="type" value="{{ $contact->type }}">
                            </div>
                        </div>
                        @if($selectType == 1)
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">会社名</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <label class="col-form-label confirm">{{ $contact->company_name }}</label>
                                <input type="hidden" name="company_name" value="{{ $contact->company_name }}">
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">名前</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <label class="col-form-label confirm">{{ $contact->name }}</label>
                                <input type="hidden" name="name" value="{{ $contact->name }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">メールアドレス</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <label class="col-form-label confirm">{{ $contact->email }}</label>
                                <input type="hidden" name="email" value="{{ $contact->email }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">電話番号</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <label class="col-form-label confirm">{{ $contact->phone_number }}</label>
                                <input type="hidden" name="phone_number" value="{{ $contact->phone_number }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">お問い合わせの種類</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <label class="col-form-label confirm">{{ $contactType[$contact->content_type] }}</label>
                                <input type="hidden" name="content_type" value="{{ $contact->content_type }}">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-5 col-12">
                                <label class="col-form-label">お問い合わせ内容</label>
                            </div>
                            <div class="col-md-7 col-12">
                                <label class="col-form-label confirm">{{ $contact->content }}</label>
                                <input type="hidden" name="content" value="{{ $contact->content }}">
                            </div>
                        </div>
                        <div class="text-center">
                            <button id="submit" class="btn-common btn-yellow submit" >送信 <i class="far fa-arrow-alt-circle-right"></i></button>
                        </div>
                    </form>
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
