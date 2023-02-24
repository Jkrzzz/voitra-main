@extends('user.layouts.user_layout')
@section('title','ユーザー情報')
@section('style')
    <link rel="stylesheet" href="{{ asset('/user/css/information.css') }}">
    <style>
        .checkmark {
            top: 0;
        }

        .my-form-check {
            justify-content: left;
        }
    </style>
@endsection
@section('content')
    <div class="main-content">
        <p class="breadcrumb-common">ユーザー情報</p>
        <h4 class="information-title">voitraの退会</h4>

        <div class="information-box">
            <h4 class="remove-member-title">退会する理由をお聞かせ下さい。</h4>
            <form class="text-left form-survey" action="/remove-member/survey" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="form-group my-form-check">
                    <div class="regular-checkbox-group">
                        <input class="regular-checkbox" type="checkbox" value="料金が高いため" name="survey[]">
                        <span class="checkmark"></span>
                    </div>
                    <label class="form-check-label" for="accept">料金が高いため</label>
                </div>
                <div class="form-group my-form-check">
                    <div class="regular-checkbox-group">
                        <input class="regular-checkbox" type="checkbox" value="キャンペーンが終了したため" name="survey[]">
                        <span class="checkmark"></span>
                    </div>
                    <label class="form-check-label" for="accept">キャンペーンが終了したため</label>
                </div>
                <div class="form-group my-form-check">
                    <div class="regular-checkbox-group">
                        <input class="regular-checkbox" type="checkbox" value="使い方がわからないため" name="survey[]">
                        <span class="checkmark"></span>
                    </div>
                    <label class="form-check-label" for="accept">使い方がわからないため</label>
                </div>
                <div class="form-group my-form-check">
                    <div class="regular-checkbox-group">
                        <input class="regular-checkbox" type="checkbox" value="思うような結果が得られなかったため" name="survey[]">
                        <span class="checkmark"></span>
                    </div>
                    <label class="form-check-label" for="accept">思うような結果が得られなかったため</label>
                </div>
                <div class="form-group my-form-check">
                    <div class="regular-checkbox-group">
                        <input class="regular-checkbox survey-other" type="checkbox" value="その他（具体的に）" name="survey[]">
                        <span class="checkmark"></span>
                    </div>
                    <label class="form-check-label" for="accept">その他（具体的に）</label>
                </div>
                <div class="form-group my-form-check">
                    <textarea name="survey_content" style="width: 100%" disabled></textarea>
                </div>
                <div class="upload-button">
                    <a class="btn custom-btn btn-default" href="/remove-member">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle r="11.5" transform="matrix(-1 0 0 1 12 12)" stroke="black"></circle>
                            <path d="M12.2404 6.85693L7.20039 11.9998L12.2404 17.1426M18.4004 11.9998H7.20039H18.4004Z"
                                  stroke="black" stroke-width="2"></path>
                        </svg>
                        戻る
                    </a>
                    <button class="btn custom-btn btn-primary" type="button" disabled>
                        退会する
                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="12.5" cy="12" r="11.5" stroke="black"></circle>
                            <path d="M12.3619 6.85693L17.3275 11.9998L12.3619 17.1426M6.29297 11.9998H17.3275H6.29297Z"
                                  stroke="black" stroke-width="2"></path>
                        </svg>
                    </button>
                </div>
                <div class="modal fade info-modal" id="remove_member" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="btn-close-modal" data-dismiss="modal">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <img src="{{ asset('/user/images/icon_x.png') }}">
                                <h4 class="notification-title">voitraの退会</h4>
                                <p class="notification-body">
                                    本当に退会してよろしいでしょうか？<br>
                                    退会すると、全てのデータが削除されてしまいます。<br>
                                    予め、データの保存をお勧めします。<br>
                                </p>
                                <div class="text-center">
                                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i
                                            class="far fa-arrow-alt-circle-left"></i> いいえ
                                    </button>
                                    <button type="button" id="remove" class="btn-primary-info group">はい <i
                                            class="far fa-arrow-alt-circle-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade info-modal" id="remove_member_success" tabindex="-1" role="dialog"
                     aria-labelledby="exampleModalLabel"
                     aria-hidden="true" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <img src="{{ asset('/user/images/icon-success.png') }}">
                                <h4 class="notification-title">voitra退会完了</h4>
                                <p class="notification-body">
                                    voitra退会が完了しました。
                                </p>
                                <div class="text-center">
                                   <a href="/logout"><button type="button" class="btn-primary-info group">OK<i
                                               class="far fa-arrow-alt-circle-right"></i></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
@section('script')
    <script>
        $('.checkmark').click(function () {
            $(this).prev().trigger('click')
        })
        $('.form-survey').change(function () {
            if ($(this).find('.survey-other').is(':checked')) {
                $('textarea[name=survey_content]').removeAttr('disabled')
            } else {
                $('textarea[name=survey_content]').val('')
                $('textarea[name=survey_content]').prop('disabled', true)
            }
            if ($('input[name="survey[]"]:checked').length > 0) {
                if ($(this).find('.survey-other').is(':checked') && $('textarea[name=survey_content]').val() == ''){
                    $('.btn-primary').prop('disabled', true)
                } else {
                    $('.btn-primary').removeAttr('disabled')
                }
            } else {
                $('.btn-primary').prop('disabled', true)
            }
        })
        $('textarea[name=survey_content]').keyup(function () {
            if ($(this).val() != '') {
                $('.btn-primary').removeAttr('disabled')
            } else {
                $('.btn-primary').prop('disabled', true)
            }
        })
        $('.btn-primary').click(function () {
            $('#remove_member').modal('show')
        })


        $('#remove').click(function (){
            $('#remove_member').modal('hide')
            const survey = []
            $("body").addClass("load");
            $('input[name="survey[]"]:checked').each(function (){
                survey.push($(this).val())
            })
            const data = {
                '_token': '{{ csrf_token() }}',
                'survey_content' :  $('textarea[name=survey_content]').val(),
                'survey' : survey
            }
            $.ajax({
                url: "/remove-member/survey",
                type: 'POST',
                data: data,
                success:function(data){
                    $("body").removeClass("load");
                    $('#remove_member_success').modal('show')
                }
            });
        })
    </script>
@endsection

