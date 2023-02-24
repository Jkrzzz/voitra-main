<div class="modal fade info-modal" id="confirm_back_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                <img src="{{ asset('/user/images/icon-x_fill.png') }}">
                <h4 class="notification-title">{{ $title }}</h4>
                <p class="notification-body">{{ $body }}</p>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal"><i class="far fa-arrow-alt-circle-left"></i> いいえ</button>
                    <a href="{{ $link }}"><button type="button" class="btn-primary-info group" >はい <i class="far fa-arrow-alt-circle-right"></i></button></a>
                </div>
            </div>
        </div>
    </div>
</div>
