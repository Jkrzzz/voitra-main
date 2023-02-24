<div class="modal fade info-modal" id="modal_show_campaign" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img class="campaign-img" src="{{ asset('/user/images/campaign.png') }}" style="margin: 20px 0;">
                <h4 class="notification-title">話者分離オプション申し込み</h4>
                <p class="notification-body">
                <p>只今、話者分離オプションは、無料トライアル中のため、</br>
                {{ date('Y年m月d日', strtotime($trail->expired_date)) }}まで無料でご利用いただけます。</p>
                <p>
                <ul style="color: #03749C; width: 60%; margin: 20px auto;text-align: left">
                    <li>最大５人までの同時発話を自動認識</li>
                    <li>月額300円（税込）で何回でも利用可能</li>
                </ul>
                </p>
                <p>この機会に是非ご利用下さい。</p>
                </p>
                <div class="text-center" style="margin-top: 20px">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>キャンセル</span></button>
                    <button type="button" id="register-service" class="btn-primary-info group" data-dismiss="modal"><span id='text'>申し込む</span><i class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
