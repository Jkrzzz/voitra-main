<div class="modal fade info-modal" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <style>
    </style>
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content" style="position: relative;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            width: 100%;
            pointer-events: auto;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: .3rem;
            outline: 0;
            text-align: center;">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img src="{{ asset('/user/images/icon-lock.png') }}">
                <h4 class="notification-title">  更新してもよろしいですか？</h4>
                <p class="notification-body">お客様にお知らせのメールが送信されます。</p>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal" style="background: #121D26;
                        color: #121D26;
                        border-radius: 26px;
                        color: #ffffff;
                        font-size: 18px;
                        font-weight: bold;
                        border: #121D26;
                        cursor: pointer;
                        position: relative;
                        overflow: hidden;
                        z-index: 1;
                        transition: all .2s ease-in-out;
                        margin-top: 40px;
                        padding: 10px 30px;">
                        <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>いいえ</span>
                    </button>
                    <button type="button" id="action" class="btn-primary-info group" data-dismiss="modal" style="background: #121D26;
                            background-color: #FFC100;
                            color: #121D26;
                            border-radius: 26px;
                            color: #ffffff;
                            font-size: 18px;
                            font-weight: bold;
                            border: #121D26;
                            cursor: pointer;
                            position: relative;
                            overflow: hidden;
                            z-index: 1;
                            transition: all .2s ease-in-out;
                            margin-top: 40px;
                            padding: 10px 30px;">
                        <span id='text'>はい</span><i class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
