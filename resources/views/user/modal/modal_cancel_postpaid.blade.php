<div class="modal fade" id="modal-cancel-postpaid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body" style="text-align: center; padding: 50px 20px">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img src="{{ asset('/user/images/info.png') }}">
                <h4 class="notification-title">後払をキャンセルして</br>クレジットカードに変更</h4>
                <p class="notification-body">後払いが自動的にキャンセルされます。</br>よろしいでしょうか？</p>
                <div class="text-center" style="margin-top: 20px;">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                        <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>いいえ</span>
                    </button>
                    <button type="action" id="cancel-action" form-id="" class="btn-primary-info group">
                        <span id='text'>はい</span><i class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>