<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\TextMiningSendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function planSanMail(){
        return view('user.plan3_inquiory');
    }

    public function sendMail(Request $request){ 
        if(isset($_POST)){
            $validator = Validator::make($request->all(), [
            'company' => 'required',
            'name' => 'required',
            'phone' =>  'required|regex:/\A0[0-9]{9,10}\z/',
            'email' => 'required',
            'text' => 'required',
            'plan' => 'required',
            ],[
                'email.required' => 'メールアドレスは必須です',
                'email.email' => '有効なメールアドレスを入力してください。',
                'phone.required' => '電話番号が必要です',
                'phone.regex' => '電話番号の形式が間違っています。',
            ]);
            if ($validator->fails()) {
                return redirect(url()->previous() .'#mining-in')
                    ->withErrors($validator)
                    ->withInput();
            }   
            Mail::to('voitra_support@upselltech-group.co.jp')->send(new TextMiningSendMail($request));
        }
        return view('user.mining-completed');
    }
    public function sendGetMail(){
        return view('user.mining-completed');
    }
}
