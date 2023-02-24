<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\RegisterVerifyMail;
use App\Mail\SendAdminContact;
use App\Mail\SendContactMail;
use App\Models\Contact;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\SettingParam;
use Illuminate\Support\Facades\DB;
use App\Traits\NotificationTrait;

class HomeController extends Controller
{
    use NotificationTrait;

    public function index()
    {
    $trail = SettingParam::where('key', 'diarization_trail')->first();
    $userTrail = DB::table('user_services')->where('user_id',Auth::id())->where('service_id', 1)->first();
    $isRegisterTrail = $userTrail && $userTrail->status;
        return view('user.index', ['trail' => $trail, 'isRegisterTrail' => $isRegisterTrail]);
    }

    public function test() {
        $isSuccess = false;
        return view('user.auth.verify_status', ['isSuccess' => $isSuccess]);
    }

    public function termsOfUse()
    {
        return view('user.terms_of_use');
    }

    public function privacyPolicy()
    {
        return view('user.privacy_policy');
    }

    public function contact(Request $request)
    {
        $selectType = null;
        if ($request->selectType) {
            $selectType = intval($request->selectType);
        }
        $userType = Config::get('const.userType');
        $contactType = Config::get('const.contactType');
        return view('user.contact.contact', ['userType' => $userType, 'contactType' => $contactType, 'selectType' => $selectType]);
    }

    public function confirmContact(Request $request)
    {
        if ($request->selectType == 1) {
            $request->validate([
                'type' => 'required',
                'name' => 'required',
                'company_name' => 'required',
                'email' => 'required|email',
                'phone_number' => 'required|regex:/\A0[0-9]{9,10}\z/',
                'content_type' => 'required',
                'content' => 'required',
            ], [
                'type.required' => '選択してください。',
                'name.required' => '入力してください。',
                'company_name.required' => '入力してください。',
                'email.required' => '入力してください。',
                'email.email' => '有効なメールアドレスを入力してください。',
                'phone_number.required' => '入力してください。',
                'phone_number.regex' => '電話番号の形式が間違っています。',
                'content_type.required' => '選択してください。',
                'content.required' => '入力してください。',
            ]);
        } else {
            $request->validate([
                'type' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone_number' => 'required|regex:/\A0[0-9]{9,10}\z/',
                'content_type' => 'required',
                'content' => 'required',
            ], [
                'type.required' => '選択してください。',
                'name.required' => '入力してください。',
                'email.required' => '入力してください。',
                'email.email' => '有効なメールアドレスを入力してください。',
                'phone_number.required' => '入力してください。',
                'phone_number.regex' => '電話番号の形式が間違っています。',
                'content_type.required' => '選択してください。',
                'content.required' => '入力してください。',
            ]);
        }
        $userType = Config::get('const.userType');
        $contactType = Config::get('const.contactType');
        $contact = new Contact();
        $contact->type = $request->type;
        if ($request->selectType == 1) {
            $contact->company_name = $request->company_name;
        }
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone_number = $request->phone_number;
        $contact->content_type = $request->content_type;
        $contact->content = $request->content;

        return view('user.contact.confirm', ['contact' => $contact, 'userType' => $userType, 'contactType' => $contactType, 'selectType' => $request->selectType]);
    }

    public function sendContact(Request $request)
    {
        $contact = new Contact();
        $contact->type = $request->type;
        if ($request->type == 2) {
            $contact->company_name = '';
        } else {
            $contact->company_name = $request->company_name;
        }
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone_number = $request->phone_number;
        $contact->content_type = $request->content_type;
        $contact->content = $request->content;
        $contact->status = 0;
        $contact->created_at = Carbon::now();
        $contact->save();
        $this->broadcastNoticeToAllAdminUsers('contact', $contact->id, $contact->name);
        \Mail::to(config('mail.admin_email'))->send(new SendAdminContact($contact));
        \Mail::to($contact->email)->send(new SendContactMail($contact));
        return view('user.contact.success');
    }
}
