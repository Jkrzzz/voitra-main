@extends('user.layouts.user_layout')
@section('title','請求先情報')
@section('style')
<link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
@endsection
@section('content')
<div class="main-content">
    <p class="breadcrumb-common">請求先情報</p>
    <div class="card-management">
        <div class="row information-sub-header">
            <div class="col-md-6 col-6">
                <h4 class="information-sub-title">請求先情報</h4>
            </div>
        </div>
        {{ csrf_field() }}
        <input type="text" id="account_id" name="account_id" value="{{ $account_id ?? '' }}" hidden>

        @if(empty($addresses))
        <div>
            <div>
                <p class="information-field">請求先はありません。</p>
            </div>
            <div class="mt-5">
                <a class="process-btn btn-primary btn-md" href="/address/register" style="padding: 10px 50px; text-align: center; margin-left: 0">
                    追加
                    <svg width="25" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                        <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
                    </svg>
                </a>
            </div>
        </div>
        @else
        <div class="row">
            @foreach ($addresses as $address)
            <div class="col-md-6">
                <div class="address-item {{ $address['default'] ? 'card-active' : ''}}">
                    <div class="addr-body">
                        <div><b>{{ $userType[$address['type']] }}</b></div>
                        <div><b>{{ $address['full_name'] }}</b></div>
                        <div>{{ $address['tel'] }}</div>
                        <div>{{ $address['mobile'] }}</div>
                        <div>{{ $address['email'] }}</div>
                        <div>{{ '〒' . $address['zipcode'] . $address['address1'] . $address['address2'] . $address['address3'] }}</div>
                        @if ($address['type'] == 1)
                        <div>{{ $address['company_name'] }}</div>
                        <div>{{ $address['department_name'] }}</div>
                        @endif
                    </div>
                    <div class="row mt-3 action">
                        <div class="{{ $address['default'] ? 'col-md-8' : 'col-md-5'}} default-btn">
                            @if($address['default'])
                            <button class="custom-label nohide">
                                デフォルト
                            </button>
                            @endif
                        </div>
                        @if(!$address['default'])
                        <div class="col-md-3">
                            <a role="button" class="btn-link make-default" data-value="{{ $address->id }}">
                                デフォルトに設定
                            </a>
                        </div>
                        @endif
                        <div class="col-md-2">
                            <a role="button" class="btn-link" href="{{ route('editAddress', ['address_id' => $address->id]) }}">
                                編集
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a role="button" class="btn-link remove-address" data-value="{{ $address->id }}" data-def="{{ $address['default'] }}">
                                削除
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row">
            <div class="mt-5 ml-4">
                <a class="process-btn btn-primary btn-md" href="/address/register" style="padding: 10px 50px; text-align: center; margin-left: 0">
                    追加
                    <svg width="25" height="22" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                        <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2"></path>
                    </svg>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@include('user.modal.confirm_modal')
@include('user.modal.notify_modal')
@include('user.modal.success')
@include('user.modal.delete_address')

<script src="{{ asset('/user/js/address.js')}} "></script>
@endsection