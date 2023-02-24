<div class="modal fade info-modal" id="change_password_error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="btn-close-modal" data-dismiss="modal">
                    <i class="fas fa-times-circle"></i>
                </div>
                <img src="{{ asset('/user/images/icon-lock.png') }}">
                <h4 class="notification-title">{{ $title }}</h4>
                <p class="notification-body">
                    @foreach($body as $el)
                        {{ $el }} <br>
                    @endforeach
                </p>
                <div class="text-center">
                    <button type="button" class="btn-primary-info btn-ok" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>
