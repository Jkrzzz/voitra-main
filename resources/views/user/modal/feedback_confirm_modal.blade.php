<div class="modal fade info-modal" id="feedback_confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body pb-5">
                <img src="{{ asset('/user/images/icon-feedback.png') }}">
                <h4 class="notification-title"></h4>
                <div class="notification-body">
                    <input type="hidden"
                           class="rating"
                           data-filled="fas fa-star"
                           data-empty="fas fa-star empty"
                           disabled
                    />
                    <div class="comment-box">
                        <textarea class="form-control confirm-comment" disabled></textarea>
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i
                            class="far fa-arrow-alt-circle-left"></i> キャンセル
                    </button>
                    <button type="button" class="btn-primary-info group" id="send-feedback">送信<i
                            class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
