<div class="modal fade" id="notify-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center notification">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img id="modal-img" src="{{ asset('/user/images/icon_x.png') }}">
                <h4 id="notify-title"></h4>
                <p class="notify-body"></p>
                <button class="btn-common btn-yellow text-uppercase" data-dismiss="modal">閉じる <i class="far fa-check-circle"></i></button>
            </div>
        </div>
    </div>
</div>
