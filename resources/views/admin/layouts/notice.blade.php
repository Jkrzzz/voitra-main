<li class="c-header-nav-item d-md-down-none mx-5">
    <a id="notifications" class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
        aria-expanded="false">
        @if ($unread_notice_counter)
            <span class="notify-count">{{ $unread_notice_counter < 100 ? $unread_notice_counter : '99+' }}</span>
        @else
            <span class="notify-count"></span>
        @endif
        <svg class="c-icon">
            <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-bell"></use>
        </svg>
    </a>
    <div class="dropdown-menu dropdown-menu-right pt-0">
        <div class="dropdown-div" style="position: relative;">
            <span class="dropdown-item">通知</span>
            <div id="notification-list-items" style="height: 90%; max-height: 400px !important; overflow-y: auto">
                @foreach ($showup_notices as $notice)
                    <a class="dropdown-item noty-content {{ $notice['status_class'] }}" id="{{ $notice['id'] }}"
                        href="{{ $notice['reference_url'] }}">
                        <div class="head">
                            <b class="username">{{ $notice['reference_id'] }}</b>
                            <span class="noti-date">{{ $notice['created_at'] }}</span>
                        </div>
                        <div class="content">
                            {{ $notice['data'] }}
                        </div>
                        <div class="footer">
                            <div class="tag {{ $notice['label_class'] }}">{{ $notice['label_title'] }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div>
                <a class="read-more" href="{{ url('/admin/notifications') }}">
                    <span class="dropdown-item">通知一覧へ</span>
                </a>
            </div>
        </div>
    </div>
</li>
