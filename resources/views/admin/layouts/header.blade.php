<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
    <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
        data-class="c-sidebar-show">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-menu"></use>
        </svg>
    </button>
    <a class="c-header-brand d-lg-none" href="#">
        <svg width="118" height="46" alt="CoreUI Logo">
            <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#full"></use>
        </svg>
    </a>
    <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
        data-class="c-sidebar-lg-show" responsive="true">
        <svg class="c-icon c-icon-lg">
            <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-menu"></use>
        </svg>
    </button>
    <ul class="c-header-nav ml-auto mr-4">
        @include('admin.layouts.notice')
        <li class="c-header-nav-item dropdown">
            <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                aria-expanded="false">
                <div class="c-avatar">
                    <img class="c-avatar-img" src="{{ asset('./admin/assets/img/avatars/blank-avatar.png') }}"
                        alt="user@email.com">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right pt-0">
                @if (\Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 2)
                    <a class="dropdown-item" href="/admin/information">
                        {{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}</a>
                @else
                    <a class="dropdown-item" href="javascript:void(0)">
                        {{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}</a>
                @endif

                <a class="dropdown-item" href="/admin/logout">
                    <svg class="c-icon mr-2">
                        <use
                            xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-account-logout">
                        </use>
                    </svg>
                    ログアウト</a>
            </div>
        </li>
    </ul>
</header>
