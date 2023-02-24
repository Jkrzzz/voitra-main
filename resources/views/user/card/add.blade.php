@extends('user.layouts.user_layout')
@section('title','クレジット管理')
@section('style')
<link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
@endsection
@section('content')
<div class="main-content">
  <p class="breadcrumb-common">クレジット管理</p>

  <div class="card-management">
    <div class="row information-sub-header">
      <div class="col-md-6 col-6">
        <h4 class="information-sub-title">支払方法</h4>
      </div>
    </div>
    <div class="row">
      <div class="upload-container col-12">
        <div class="card pb-0">
          <form>
            {{ csrf_field() }}
            <input type="text" id="token" name="token" hidden>
            <input type="text" id="account_id" name="account_id" value="{{ $account_id }}" hidden>
            <input type="text" id="req_card_number" name="req_card_number" hidden>
            <div class="block-content-sm">
              <span class="block-title" style="color: black">決済カード情報入力</span>
              <hr>
              <div class="list-credit">
                <div class="item">
                  <img src="{{ asset('user/images/visa.png') }}" />
                </div>
                <div class="item">
                  <img src="{{ asset('user/images/master.png') }}" />
                </div>
                <div class="item">
                  <img src="{{ asset('user/images/jbc.png') }}" />
                </div>
                <div class="item">
                  <img src="{{ asset('user/images/diner.png') }}" />
                </div>
                <div class="item">
                  <img src="{{ asset('user/images/amexpress.png') }}" />
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6 col-12">
                  <label for="inputCity">カード名義</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="TARO YAMADA">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6 col-12">
                  <label for="inputCity">クレジットカード番号</label>
                  <input type="text" class="form-control" id="card_number" placeholder="0000 0000 0000 0000">
                </div>
                <div class="form-group col-md-3 col-12">
                  <label for="inputState">有効期間</label>
                  <input type="text" class="form-control" id="cc-exp" name="expdate" style="width:200px" placeholder="MM/YY">
                </div>
                <div class="form-group col-md-3 col-12">
                  <label for="inputZip">セキュリティコード</label>
                  <input maxlength="4" type="password" class="form-control" id="cc-csc" style="width:150px" placeholder="0000">
                </div>
              </div>
              @if(isset($more) && $more)
              <div class="form-row form-inline">
                <div class="form-group col-md-12 add-card-checkbox">
                  <input type="checkbox" id="default">
                  <label for="default">
                    このカードをデフォルトに設定する
                  </label>
                </div>
              </div>
              @else
              <input type="checkbox" id="default" checked="checked" hidden>
              @endif
            </div>
          </form>
        </div>
        <span id="token_api_url" hidden>{{ $api_url }}</span>
        <span id="token_api_key" hidden>{{ $api_token }}</span>

        <div class="upload-button">
          <button id="pay" class="btn custom-btn btn-primary">
            確認画面へ進む
            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12.5" cy="12" r="11.5" stroke="black" />
              <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@include('user.modal.notify_modal')
@include('user.modal.success')
<script src="{{ asset('/user/js/card.js')}} "></script>
@endsection
