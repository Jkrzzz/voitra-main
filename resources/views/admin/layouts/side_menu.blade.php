<ul class="c-sidebar-nav">
    @if (\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1)
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/users">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-user"></use>
                </svg>
                ユーザ管理</a>
        </li>
    @endif
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/orders">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-cart"></use>
            </svg>
            案件管理</a>
    </li>
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/notifications">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-bell"></use>
            </svg>
            通知
            <div class="w-100 text-right">
                @if ($unread_notice_counter)
                    <span class="sidebar-notify-number rounded-pill">{{ $unread_notice_counter < 100 ? $unread_notice_counter : '99+' }}</span>
                @else
                    <span class="sidebar-notify-number rounded-pill"></span>
                @endif
            </div>
        </a>
    </li>
    @if (\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1)
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/staffs">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-address-book">
                    </use>
                </svg>
                スタッフ管理</a>
        </li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/settings">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-cog"></use>
                </svg>
                設定</a>
        </li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="/admin/coupons">
                <svg class="c-sidebar-nav-icon">
                    <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-gift"></use>
                </svg>
                クーポン管理</a>
        </li>
    @endif
</ul>
