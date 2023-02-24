<div class="modal fade info-modal" id="confirm_change_password_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img src="{{ asset('/user/images/icon-lock.png') }}">
                <h4 class="notification-title">パスワードを変更する</h4>
                <p class="notification-body">パスワードを変更してもよろしいですか？</p>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> キャンセル</button>
                    <button type="submit" id="change" class="btn-primary-info group" >変更 <i class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
