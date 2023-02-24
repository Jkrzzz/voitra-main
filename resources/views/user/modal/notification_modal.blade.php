<div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center notification">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle "></i>
                </div>
                @if($type == 'error')
                    <img src="{{ asset('/user/images/icon_x.png') }}">
                @elseif($type == 'password')
                    <img src="{{ asset('/user/images/icon-lock.png') }}">
                @endif
                <h4 class="notification-title">{{ $title }}</h4>
                <p class="notification-body">
                    @foreach($body as $el)
                        {{ $el }} <br>
                    @endforeach
                </p>
                <button class="btn-common btn-yellow text-uppercase" data-dismiss="modal">OK <i class="far fa-check-circle"></i></button>
            </div>
        </div>
    </div>
</div>
