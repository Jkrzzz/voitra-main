@extends('admin.layouts.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    新規クーポン作成
                </div>
                <form class="form" method="post" action="/admin/coupons/confirm">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">クーポン名*</label>
                                    <input class="form-control" name="name" id="name" type="text"
                                           maxlength="255" value="{{ old('name') }}">
                                    @error('name')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">開始日*</label>
                                    <input class="form-control" name="start_at" id="start_at" type="date" value="{{ old('start_at') }}">
                                    @error('start_at')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">終了日*</label>
                                    <input class="form-control" name="end_at" id="end_at" type="date" value="{{ old('end_at') }}">
                                    @error('end_at')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">クーポンコード*</label>
                                    <input class="form-control" name="code" id="code" type="text" value="{{ old('code') }}" maxlength="10">
                                    @error('code')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">発行枚数</label>
                                    <input class="form-control" name="quantity" id="quantity" type="text" value="{{ old('quantity') }}" maxlength="11">
                                    <span class="coupon-note">※1~99,999,999,999の整数を入力いただけます。</span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">割引金額*</label>
                                    <div class="input-money">
                                        <input class="form-control" name="discount_amount" id="discount_amount" type="text"
                                               maxlength="11" value="{{ old('discount_amount') }}">
                                        <span>円</span>
                                    </div>
                                    <span class="coupon-note">※1~99,999,999,999の整数を入力いただけます。</span>
                                    @error('discount_amount')
                                    <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label coupon-check-label" for="is_limited">１アカウントにつき１回限定</label>
                                    <input class="form-check-input" name="is_limited" type="checkbox" id="is_limited" {{ old('is_limited') ? 'checked' : ''}}>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label coupon-check-label" for="is_private">プライベート</label>
                                    <input class="form-check-input" name="is_private" type="checkbox" id="is_private" {{ old('is_private') ? 'checked' : ''}}>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="javascript:history.back()" >
                            <button type="button" class="btn  btn-common-outline">戻る</button>
                        </a>
                        <button type="submit" class="btn btn-common">確認</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('/admin/js/coupon.js') }}"></script>
@endsection
