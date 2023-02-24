<div class="modal fade info-modal" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img src="{{ asset('/user/images/icon-success.png') }}">
                <h4 class="notification-title"></h4>
                <div class="detail">
                    <img class="card-image" style="margin-right: 10px;">
                    <span class="card-number"></span>
                </div>
                <p class="notification-body"></p>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>キャンセル</span></button>
                    <button type="button" id="action" class="btn-primary-info group" data-dismiss="modal"><span id='text'>削除</span><i class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
