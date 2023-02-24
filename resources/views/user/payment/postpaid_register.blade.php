@extends('user.layouts.upload_layout')
@section('title','会員メニュートップ')
@section('content')
<div class="main-content">
    <div class="d-title">
        <span class="page-title">@yield('title')</span>
    </div>
    <div class="section">
        <div class="container location-register">
            <h4 class="sub-title">新しい請求先を追加する</h4>
            <div class="align-items-center d-flex justify-content-center">
                <form class="form-normal" method="post" action="/address/register/pay" id="form-register">
                    @csrf
                    <input type="hidden" name="order_id" value="{{$order_id}}">
                    <input type="hidden" name="service_type" value="{{$service_type}}">
                    <input type="hidden" name="coupon_id" value="{{@$coupon->id}}">
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">法人/個人</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <div class="select-input">
                                <select name="type" class="form-control" id="type">
                                    <option selected value="">選択して下さい</option>
                                    @foreach($userType as $key => $type)
                                    <option value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('type')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">名前</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="text" maxlength="255" class="form-control" name="name" placeholder="音声　太郎" value="{{ old('name') }}">
                            @error('name')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">
                                電話番号
                                <i class="cust-icon fas fa-info-circle default" data-toggle="tooltip" data-placement="top" data-html="true" title="半角数字（ハイフン無し）電話番号か携帯番号を入力できます。"></i>
                            </label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="tel" maxlength="255" class="form-control" name="tel" placeholder="0312345678" value="{{ old('tel') }}">
                            @error('tel')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label optional">
                                携帯電話番号
                                <i class="cust-icon fas fa-info-circle default" data-toggle="tooltip" data-placement="top" data-html="true" title="半角数字（ハイフン無し）"></i>
                            </label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="tel" maxlength="255" class="form-control" name="mobile" placeholder="09012345678" value="{{ old('mobile') }}">
                            @error('mobile')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">メールアドレス</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="text" maxlength="255" class="form-control" name="email" placeholder="voice@voitra.jp" value="{{ old('email') }}">
                            @error('email')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">
                                郵便番号
                                <i class="cust-icon fas fa-info-circle default" data-toggle="tooltip" data-placement="top" data-html="true" title="半角数字（ハイフン無し）"></i>
                            </label>
                        </div>
                        <div class="col-md-4 col-12">
                            <input id="zipcode" type="text" maxlength="10" class="form-control" name="zipcode" placeholder="1710021" value="{{ old('zipcode') }}">
                            @error('zipcode')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-3 col-12">
                            <button id="check-zip" type="button" class="btn form-control btn-large">
                                自動入力
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 0C3.63438 0 0.5 3.13438 0.5 7C0.5 10.8656 3.63438 14 7.5 14C11.3656 14 14.5 10.8656 14.5 7C14.5 3.13438 11.3656 0 7.5 0ZM10.5234 4.71406L7.23281 9.27656C7.18682 9.34076 7.12619 9.39306 7.05595 9.42914C6.98571 9.46523 6.90787 9.48405 6.82891 9.48405C6.74994 9.48405 6.67211 9.46523 6.60186 9.42914C6.53162 9.39306 6.47099 9.34076 6.425 9.27656L4.47656 6.57656C4.41719 6.49375 4.47656 6.37813 4.57812 6.37813H5.31094C5.47031 6.37813 5.62187 6.45469 5.71562 6.58594L6.82812 8.12969L9.28438 4.72344C9.37813 4.59375 9.52812 4.51562 9.68906 4.51562H10.4219C10.5234 4.51562 10.5828 4.63125 10.5234 4.71406Z" fill="#808080" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">都道府県</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input id="address1" type="text" maxlength="255" class="form-control select-input select" name="address1" placeholder="東京都" value="{{ old('address1') }}">
                            @error('address1')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">市区町村</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input id="address2" type="text" maxlength="255" class="form-control" name="address2" placeholder="渋谷区渋谷" value="{{ old('address2') }}">
                            @error('address2')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">番地・建物名</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input id="address3" type="text" maxlength="255" class="form-control" name="address3" placeholder="5-26-19　陸王西池袋ビル6階" value="{{ old('address3') }}">
                            @error('address3')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">会社名</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="text" maxlength="255" class="form-control" name="company_name" placeholder="アップセルテクノロジィーズ株式会社" value="{{ old('company_name') }}">
                            @error('company_name')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 col-12 cst-label">
                            <label class="col-form-label required">部署名</label>
                        </div>
                        <div class="col-md-7 col-12">
                            <input type="text" maxlength="255" class="form-control" name="department_name" placeholder="営業部" value="{{ old('department_name') }}">
                            @error('department_name')
                            <p class="input-error"><i class="fas fa-times-circle"></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group my-form-check mb-0" style="justify-content: left">
                        <div class="regular-checkbox-group">
                            <input class="regular-checkbox" type="checkbox" value="on" id="public" name="public" checked>
                            <span class="checkmark"></span>
                        </div>
                        <label class="form-check-label" for="public">
                            請求先を保存する
                        </label>
                    </div>
                    <div class="upload-button m-4 create">
                        <button class="btn custom-btn btn-default" onclick="history.back()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black" />
                                <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z" stroke="black" stroke-width="2" />
                            </svg>
                            戻る
                        </button>
                        <button id="confirm" class="btn custom-btn btn-primary">
                            確認画面へ進む
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12.5" cy="12" r="11.5" stroke="black" />
                                <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                    <div class="upload-button m-4 confirm" style="display: none !important;">
                        <button class="btn custom-btn btn-default edit-data">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black" />
                                <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z" stroke="black" stroke-width="2" />
                            </svg>
                            戻る
                        </button>
                        <button id="submit-update" class="btn custom-btn btn-primary">
                            請求先を登録
                            <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12.5" cy="12" r="11.5" stroke="black" />
                                <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z" stroke="black" stroke-width="2" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input name="is_edit_page" type="hidden" value="0">
<script src="https://kmdsbng.github.io/zipcode_jp/api.js"></script>
<script src="{{ asset('/user/js/address.js') }}"></script>
<script>
    $(document).ready(function() {
        $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    });
    ZipCodeJp.setRootUrl('https://kmdsbng.github.io/zipcode_jp/')
    $(document).ready(function() {
        {{--$('#type').change(function() {--}}

        {{--    if ($(this).val() == 1) {--}}
        {{--        window.location.replace('/address/register/payment/{{$service_type}}/{{$order_id}}?selectType=1')--}}

        {{--    } else if ($(this).val() == 2) {--}}
        {{--        window.location.replace('/address/register/payment/{{$service_type}}/{{$order_id}}?selectType=2')--}}

        {{--    }--}}
        {{--})--}}
        if (window.performance && window.performance.navigation.type == window.performance.navigation.TYPE_BACK_FORWARD) {
            location.reload();
        }
        var availableTags = @json($prefectures);
        availableTags = Object.keys(availableTags).map(i => availableTags[i])
        $("#address1").autocomplete({
            source: availableTags,
            minLength: 0
        }).focusin(function() {
            $(this).autocomplete('search', $(this).val())
        });
        $("#check-zip").click(function(e) {
            e.preventDefault();
            let zipcode = $("#zipcode").val();
            console.log(zipcode)
            ZipCodeJp.getAddressesOfZipCode(
                zipcode,
                function(err, addresses) {
                    if (err || addresses.length === 0)  {
                        let txt = zipcode != '' ? '入力した郵便番号は存在しません。' : '入力してください。';
                        if(!$('#zipcode-error').length) {
                            $('#zipcode').after('<label id="zipcode-error" class="error" for="zipcode">'+txt+'</label>');
                        } else {
                            $('#zipcode-error').show().html(txt);
                        }
                        return;
                    }
                    let prefecture_jis_code = addresses[0].prefecture_jis_code
                    $('#province').val(prefecture_jis_code);
                    let city_name = addresses[0].city_name;
                    let town_name = addresses[0].town_name;
                    $("#address1").val(addresses[0].prefecture_name);
                    $("#address2").val(city_name + town_name);
                    $( "#form-register" ).validate().element( "#address1" );
                    $( "#form-register" ).validate().element( "#address2" );
                }
            );
        })
    })
</script>
@endsection
