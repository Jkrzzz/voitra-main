<div class="modal fade info-modal" id="feedback_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body pb-5" data-plan="{{$plan}}">
                <img src="{{ asset('/user/images/icon-feedback.png') }}">
                <h4 class="notification-title">{{ $plan == 1 ? 'AI文字起こしプランの満足度' : 'ブラッシュアッププランの満足度' }}</h4>
                <div class="notification-body">
                    <input type="hidden"
                           name="rate-plan-{{$plan}}-popup"
                           class="rating"
                           data-popup="1"
                           data-filled="fas fa-star"
                           data-empty="far fa-star"
                    />
                    <div class="comment-box">
                        <textarea class="form-control" name="comment-plan-{{$plan}}-popup"
                                  placeholder="ご意見・ご要望がございましたら、コメントをお願いします。（最大255文字まで）" maxlength="255"></textarea>
                        <p class="count-char"><span>0</span>/255</p>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" id="not-feedback"><i
                            class="far fa-arrow-alt-circle-left"></i> キャンセル
                    </button>
                    <button type="button" class="btn-primary-info group submit-feedback" disabled>送信<i
                            class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
