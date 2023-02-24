<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStaffAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->status == 1) {
            $role = Admin::where('id', Auth::guard('admin')->id())->first()->role;
            if ($role == 1 || $role == 2) {
                return $next($request);
            }
        }
        return redirect('/admin/login');
    }
}
