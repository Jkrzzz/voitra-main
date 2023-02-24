<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.meta')
</head>
<body class="c-app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card-group">
                <div class="card p-4">
                    <div class="card-body">
                        <div class="c-sidebar-brand mb-3">
                            <img  class="c-sidebar-brand-full" width="100" height="auto" src="{{ asset('./admin/assets/img/logo/logo-big.png') }}">
                        </div>
                        <h1 class="mb-3 text-center">Login</h1>
                        <form method="post" action="/admin/login">
                            @csrf
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                            @endif
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">
                      <svg class="c-icon">
                        <use xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-user"></use>
                      </svg></span></div>
                                <input class="form-control" value="{{ old('email') }}" type="email" name="email"
                                       maxlength="255"
                                       placeholder="Email">
                            </div>
                            <div class="mb-3">
                                @if ($errors->has('email'))
                                    <p> {{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">
                                  <svg class="c-icon">
                                    <use
                                        xlink:href="{{ asset('./admin/vendors/@coreui/icons/svg/free.svg') }}#cil-lock-locked"></use>
                                  </svg></span></div>
                                <input class="form-control" value="{{ old('password') }}" type="password"
                                       name="password"
                                       maxlength="255"
                                       placeholder="Password">
                            </div>
                            <div class="mb-4">
                                @if ($errors->has('password'))
                                    <p> {{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-common px-4" style="width: 100%" type="submit">Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('./admin/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
<script src="{{ asset('./admin/vendors/@coreui/icons/js/svgxuse.min.js') }}"></script>
</body>
</html>
