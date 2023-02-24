<div class="modal fade info-modal" id="postpaid_privacy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document" style="max-width: 700px">
        <div class="modal-content">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal" style="right: 20px;">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img src="/user/images/info.png" style="margin: auto;">
                <h4 class="title">コンビニ後払いの注意事項</h4>
                <div class="detail postpaid-modal-content">
                    <div class="block-list" style="background-color: #EFEFEF; border-radius: 10px; padding: 15px 10px; text-align: left; word-break: break-all">
                        <p>● 後払い手数料：350円（税込）</p>
                        <p>● 利用限度額：55,000円（税込）</p>
                        <p>● 請求書はサービス提供後に株式会社SCOREより郵送されます。発行から14日以内にコンビニでお支払いください。</p>
                        <p style="padding: 15px 0px">● お客様に対する代金債権とそれに付帯する個人情報（定義は、個人情報の保護に関する法律第2条第1項に従います。）は、包括的な決済サービスを提供する株式会社DGフィナンシャルテクノロジーに譲渡・提供されたうえで、さらに同社から後払い決済サービスを提供する 株式会社SCOREに対し、再譲渡・提供されますので、 当該第三者への譲渡・提供に同意の上、お申込みください。<br></p>
                        <p>【提供先の個人情報の利用目的】
                            <br>以下URL（個人情報の取扱いについて）よりご確認ください。
                        <ul>
                            <li>株式会社DGフィナンシャルテクノロジー<br><a target="_blank" href="https://www.veritrans.co.jp/privacy/operation.html">https://www.veritrans.co.jp/privacy/operation.html</a></li>
                            <li>株式会社SCORE ：<br><a target="_blank" href="https://corp.scoring.jp/privacypolicy/">https://corp.scoring.jp/privacypolicy/</a></li>
                        </ul>
                        </p>
                        <p style="padding: 15px 0px">【提供する個人情報】
                            <br>氏名、電話番号、住所、Eメールアドレス
                            <br>※その他、個人情報には該当しない、購入商品や取引金額等の決済データも専用システムにて提供されます。
                        </p>
                        <p>● 株式会社SCOREが行う与信審査の結果により、後払い決済をご利用頂けない場合がございます。</p>
                        <p>● 株式会社DGフィナンシャルテクノロジー、株式会社SCOREの詳細は以下URLよりご確認ください。
                        <ul>
                            <li>株式会社DGフィナンシャルテクノロジーについて<br><a target="_blank" href="https://www.veritrans.co.jp/">https://www.veritrans.co.jp/</a></li>
                            <li>株式会社SCOREについて<br><a target="_blank" href="https://www.scoring.jp/consumer/">https://www.scoring.jp/consumer/</a></li>
                        </ul>
                        </p>
                        <p style="padding: 15px 0px">個人情報の提供に関する問合せ先：voitra_support@upselltech-group.co.jp</p>
                        <p>●下記スマートフォンアプリからお支払い可能です。
                        <ul>
                            <li>LINEPay請求書支払い</li>
                            <li>楽天銀行コンビニ支払サービス（アプリで払込票支払）</li>
                        </ul>
                        </p>
                    </div>
                </div>
                <div class="form-group my-form-check">
                    <div class="regular-checkbox-group">
                        <input class="regular-checkbox" type="checkbox" value="" id="postpaid-accept">
                        <span class="checkmark"></span>
                    </div>
                    <label class="form-check-label order-page" for="postpaid-accept">注意事項に同意</label>
                </div>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.1094 12.5C16.3855 12.5 16.6094 12.7239 16.6094 13C16.6094 13.2761 16.3855 13.5 16.1094 13.5L16.1094 12.5ZM9.5336 13.3536C9.33834 13.1583 9.33834 12.8417 9.5336 12.6464L12.7156 9.46447C12.9108 9.2692 13.2274 9.2692 13.4227 9.46447C13.6179 9.65973 13.6179 9.97631 13.4227 10.1716L10.5943 13L13.4227 15.8284C13.6179 16.0237 13.6179 16.3403 13.4227 16.5355C13.2274 16.7308 12.9108 16.7308 12.7156 16.5355L9.5336 13.3536ZM16.1094 13.5L9.88715 13.5L9.88715 12.5L16.1094 12.5L16.1094 13.5Z" fill="#121D26" />
                            <circle r="12" transform="matrix(-1 0 0 1 13 13)" stroke="#121D26" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span id='text-prev'>キャンセル</span></button>
                    <button type="button" id="postpaid-confirm" class="btn-secondary-info group mr-3 btn-yellow" data-dismiss="modal" disabled><span id='text'>決済に進む</span>
                        <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.89063 12.5C9.61448 12.5 9.39063 12.7239 9.39062 13C9.39062 13.2761 9.61448 13.5 9.89062 13.5L9.89063 12.5ZM16.4664 13.3536C16.6617 13.1583 16.6617 12.8417 16.4664 12.6464L13.2844 9.46447C13.0892 9.2692 12.7726 9.2692 12.5773 9.46447C12.3821 9.65973 12.3821 9.97631 12.5773 10.1716L15.4057 13L12.5773 15.8284C12.3821 16.0237 12.3821 16.3403 12.5773 16.5355C12.7726 16.7308 13.0892 16.7308 13.2844 16.5355L16.4664 13.3536ZM9.89062 13.5L16.1128 13.5L16.1128 12.5L9.89063 12.5L9.89062 13.5Z" fill="#121D26" />
                            <circle cx="13" cy="13" r="12" stroke="#121D26" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
