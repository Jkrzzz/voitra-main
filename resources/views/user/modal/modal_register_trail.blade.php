<div class="modal fade info-modal" id="modal_register_trail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img src="{{ asset('/user/images/speaker.png') }}">
                <h4 class="notification-title">話者分離オプション申し込み</h4>
                <p class="notification-body">
                    只今、話者分離オプションは、無料トライアル中のため、</br>
                    {{ date('Y年m月d日', strtotime($trail->expired_date)) }}まで無料でご利用いただけます。</br>
                    この機会に是非ご利用下さい。</br>
                </p>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>キャンセル</span></button>
                    <button type="button" id="register-service" class="btn-primary-info group" data-dismiss="modal"><span id='text'>申し込む</span><i class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
