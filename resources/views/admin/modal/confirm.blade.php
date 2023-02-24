<div class="modal fade info-modal" id="confirm_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal" style="text-align: right;">
                    <i class="fas fa-times-circle "></i>
                </div>
                @if(isset($icon) && $icon == 'lock')
                    <img src="{{ asset('/user/images/icon-lock.png') }}">
                @else
                <img src="{{ asset('/user/images/info.png') }}">
                @endif
                <h4 class="notification-title"> {{$title}}</h4>
                <p class="notification-body">{{$content}}</p>
                <div class="text-center">
                    <button type="button" class="btn-secondary-info group mr-3" data-dismiss="modal">
                        <i class="far fa-arrow-alt-circle-left"></i> <span id='text-prev'>いいえ</span>
                    </button>
                    <button type="submit" id="confirmed" form-id="" class="btn-primary-info group">
                        <span id='text'>はい </span><i class="far fa-arrow-alt-circle-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
