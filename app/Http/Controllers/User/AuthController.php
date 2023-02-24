<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\RegisterSuccessMail;
use App\Mail\RegisterVerifyMail;
use App\Mail\ResetPasswordMail;
use App\Mail\ResetPasswordSuccessMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('user.auth.login');
    }

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => '入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'password.required' => '入力してください。',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        $user = User::where('email', $request->email)->where('status', 1)->first();
        if ($user && $user->status == 1 && Auth::attempt($data)) {
            $user->last_login_at = Carbon::now();
            $user->save();
            return redirect('/upload');
        } else {
            return redirect()->back()->with(['error' => ['入力したIDもしくはパスワードが間違っています。', '再度入力してください。']]);
        }
    }

    public function register(Request $request)
    {
        $selectType = null;
        if ($request->selectType) {
            $selectType = intval($request->selectType);
        }
        $userType = Config::get('const.userType');
        return view('user.auth.register', ['userType' => $userType, 'selectType' => $selectType]);
    }

    public function registerConfirm(Request $request)
    {
        $userType = Config::get('const.userType');
        if ($request->selectType == 1) {
            $request->validate([
                'type' => 'required',
                'name' => 'required',
                'company_name' => 'required',
                'phone_number' => 'nullable|regex:/\A0[0-9]{9,10}\z/',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/',
            ], [
                'type.required' => '選択してください。',
                'name.required' => '入力してください。',
                'company_name.required' => '入力してください。',
                'email.required' => '入力してください。',
                'password.required' => '入力してください。',
                'password.regex' => '英数字混合の8文字以上で登録してください。',
                'email.email' => '有効なメールアドレスを入力してください。',
                'email.unique' => '入力したメールアドレスは既に登録されています。',
                'phone_number.regex' => '電話番号の形式が間違っています。'
            ]);
        } else {
            $request->validate([
                'type' => 'required',
                'name' => 'required',
                'phone_number' => 'nullable|regex:/\A0[0-9]{9,10}\z/',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/',
            ], [
                'type.required' => '選択してください。',
                'name.required' => '入力してください。',
                'email.required' => '入力してください。',
                'password.required' => '入力してください。',
                'password.regex' => '英数字混合の8文字以上で登録してください。',
                'email.email' => '有効なメールアドレスを入力してください。',
                'email.unique' => '入力したメールアドレスは既に登録されています。',
                'phone_number.regex' => '電話番号の形式が間違っています。'
            ]);
        }

        $user = new User();
        $user->userType = $request->type;
        $user->name = $request->name;
        if ($request->company_name) {
            $user->company_name = $request->company_name;
        }
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->password = $request->password;
        $user->confirmPassword = str_repeat('*', strlen($user->password));
        return view('user.auth.register_confirm', ['user' => $user, 'userType' => $userType]);
    }

    public function registerProcess(Request $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->type = $request->userType;
            if ($request->userType == 1){
                $user->company_name = $request->company_name;
                $user->company_phone_number = $request->phone_number;
            } else {
                $user->phone_number = $request->phone_number;
            }
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->status = 2;
            $user->save();
        } catch (\Exception $e){
            return redirect()->back();
        }
        $url = URL::temporarySignedRoute('register.verify', now()->addHours(24), ['user_id' => $user->id]);
        \Mail::to($user->email)->send(new RegisterVerifyMail($url, $user));
        return view('user.auth.register_verify', ['user' => $user]);
    }

    public function registerVerify(Request $request)
    {
        $user = User::find($request->user_id);
        if (!$request->hasValidSignature() || !$user || $user->status != 2) {
            return view('user.auth.verify_status', ['isSuccess' => false, 'user' => $user]);
        }
        $user->status = 1;
        $user->email_verified_at = Carbon::now();
        $user->save();
        \Mail::to($user->email)->send(new RegisterSuccessMail($user));
        Auth::loginUsingId($user->id);
        return view('user.auth.verify_status', ['isSuccess' => true]);
    }

    public function resendVerify(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $url = URL::temporarySignedRoute('register.verify', now()->addHours(24), ['user_id' => $user->id]);
        \Mail::to($user->email)->send(new RegisterVerifyMail($url, $user));
        return view('user.auth.register_verify', ['user' => $user]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function forgotPassword()
    {
        return view('user.auth.forgot_password');
    }

    public function forgotPasswordProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => '入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。'
        ]);
        $user = User::where('email', $request->email)->where('status', 1)->first(); // Only active user.
        if ($user) {
            $token = bin2hex(random_bytes(32));
            DB::table('password_resets')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
            $url = url('/password/reset/' . $user->id . '/' . $token);
            \Mail::to($user->email)->send(new ResetPasswordMail($url, $user));
            return view('user.auth.reset_password_verify');
        }
        return redirect()->back()->with(['error' => ['入力したメールアドレスが存在しません。', '再度入力してください。']]);
    }

    public function resetPassword($id, $token)
    {
        return view('user.auth.reset_password', ['user_id' => $id, 'token' => $token]);
    }

    public function resetPasswordProcess(Request $request)
    {
        $request->validate([
            'password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/',
            'password_confirm' => 'required|same:password',
        ], [
            'password.required' => '入力してください。',
            'password.regex' => '英数字混合の8文字以上で登録してください。',
            'password_confirm.required' => '入力してください。',
            'password_confirm.same' => 'パスワードが一致しません。',
        ]);
        $user = User::find($request->user_id);
        $password_reset = DB::table('password_resets')->where('email', $user->email)->orderBy('created_at', 'desc')->first();
        if ($password_reset && $password_reset->token == $request->token && $password_reset->created_at >= Carbon::now()->addMinutes(-30)) {
            $user->password = bcrypt($request->password);
            DB::beginTransaction();
            try {
                $user->save();
                DB::table('password_resets')->where(['email' => $user->email])->delete();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with(['error' => ['パスワード再発行用URLの期限が切れました。', '再度、パスワードの再発行を行って下さい。']]);

            }
            \Mail::to($user->email)->send(new ResetPasswordSuccessMail($user));
            return view('user.auth.reset_password_status');
        }
        return redirect()->back()->with(['error' => ['パスワード再発行用URLの期限が切れました。', '再度、パスワードの再発行を行って下さい。']]);
    }
}
