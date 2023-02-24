<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/orders');
        }
        return view('admin.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => '入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'password.required' => 'パスワードを入力してください。'
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && $admin->status == 1 && Auth::guard('admin')->attempt($data)) {
            return redirect('/admin/orders');
        } else {
            $request->session()->flash('error', 'メールアドレスまたはパスワードが間違っています。');
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }
}
