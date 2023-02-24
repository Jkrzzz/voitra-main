<div class="modal fade" id="delete-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body text-center notification modal-change-default">
        <div class="btn-close-modal" data-dismiss="modal">
          <i class="fas fa-times-circle "></i>
        </div>
        <img src="{{ asset('/user/images/info.png') }}">
        <h4 id="notify-title">請求先削除確認</h4>
        <p class="body">以下の請求先を削除します。</br>よろしいでしょうか？</p>
        <p class="notify-body">
        </p>
        <div class="text-center">
          <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>キャンセル</span></button>
          <button type="button" id="delete-address" class="btn-primary-info group" data-dismiss="modal"><span id='text'>削除</span><i class="far fa-arrow-alt-circle-right"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>
