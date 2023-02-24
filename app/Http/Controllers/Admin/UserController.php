<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use function PHPUnit\Framework\isNull;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $userType = $request->userType;
        $status = $request->status;
        $users = User::orderBy('created_at', 'DESC')->where('status', '!=', 3)
            ->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
        if ($userType) {
            $users = $users->where('type', $userType);
        }
        if (isset($status)) {
            $users = $users->where('status', $status);
        }
        $users = $users->paginate(10)->appends($request->only('name'))->appends($request->only('userType'))->appends($request->only('status'));
        foreach ($users as $user){
            if ($user->status == 0) {
                $user->email = $user->removed_email;
            }
        }
        $userTypeConst = Config::get('const.userType');
        $statusConst = Config::get('const.status');
        $languageConst = Config::get('const.language');
        $genderConst = Config::get('const.gender');
        $industryConst = Config::get('const.industry');
        if (count($request->query())) {
            $downloadUrl =  route('admin.exportUser', $request->query()); // str_replace('?', '/download?', $request->getRequestUri());
        } else {
            $downloadUrl = route('admin.exportUser', );
        }
        return view('admin.user.index',
            [
                'users' => $users,
                'userTypeConst' => $userTypeConst,
                'statusConst' => $statusConst,
                'name' => $name,
                'userType' => $userType,
                'status' => $status,
                'languageConst' => $languageConst,
                'genderConst' => $genderConst,
                'industryConst' => $industryConst,
                'downloadUrl' => $downloadUrl,
            ]);
    }

    public function detail($id, Request $request)
    {
        $user = User::find($id);
        $auth = Auth::guard('admin')->user();
        $orderArr = Order::where(function ($q) use ($auth) {
            $q->where('estimate_staff', $auth->id)->orWhere('edit_staff', $auth->id);
        })->get()->toArray();

        $userIds = array_unique(array_map(function ($el) {
            return $el['user_id'];
        }, $orderArr));

        if (!$user || $user->status == 3 || ($auth->role != 1 && !in_array($user->id, $userIds))) {
            return redirect()->back()->withErrors(['msg' => 'このユーザーが存在しません。']);
        }
        $userTypeConst = Config::get('const.userType');
        $statusConst = Config::get('const.status');
        $languageConst = Config::get('const.language');
        $genderConst = Config::get('const.gender');
        $industryConst = Config::get('const.industry');
        // $isEdit = isset($request->edit);

        if ($user->status == 0) {
            $user->email = $user->removed_email;
        }
        return view('admin.user.form', [
            'user' => $user,
            'userTypeConst' => $userTypeConst,
            'statusConst' => $statusConst,
            'languageConst' => $languageConst,
            'genderConst' => $genderConst,
            'industryConst' => $industryConst,
            // 'isEdit' => $isEdit
        ]);
    }

    public function update(Request $request, $id)
    {
//        $request->validate([
//            'name' => 'required',
//            'email' => 'required',
//            'phone_number' => 'required|max:20'
//        ]);
        $user = User::find($id);
//        $user->name = $request->name;
//        $user->email = $request->email;
//        $user->phone_number = $request->phone_number;
//        $user->type = $request->userType;
        $user->status = $request->status;
//        $user->memo = $request->memo;
        $user->save();

        return redirect('/admin/users/'.$id)->with('success', '変更を完了しました。');
    }

    public function updateMemo(Request $request, $id)
    {
        $user = User::find($id);
        $user->memo = $request->memo;
        $user->save();
        return redirect('/admin/users/'.$id)->with('success', 'メモを保存しました。');
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (!$user || $user->status == 3) {
            return redirect()->back()->withErrors(['msg' => 'このユーザーが存在しません。']);
        }
        $user->status = 3;
        $user->save();
        return redirect('/admin/users')->with('success', '削除成功しました。');
    }

    public function writeFormatDownloadToCsv($users, $path)
    {
        $userTypeConst = Config::get('const.userType');
        $userStatusConst = Config::get('const.status');
        $csv = fopen($path, 'w');
        fputcsv($csv, [
            mb_convert_encoding('名前', "SJIS-win", "UTF-8"),
            mb_convert_encoding('会社名', "SJIS-win", "UTF-8"),
            mb_convert_encoding('メールアドレス', "SJIS-win", "UTF-8"),
            mb_convert_encoding('電話番号', "SJIS-win", "UTF-8"),
            mb_convert_encoding('会社電話番号', "SJIS-win", "UTF-8"),
            mb_convert_encoding('種別', "SJIS-win", "UTF-8"),
            mb_convert_encoding('ステータス', "SJIS-win", "UTF-8"),
            mb_convert_encoding('登録時間', "SJIS-win", "UTF-8"),
            mb_convert_encoding('最新のログイン', "SJIS-win", "UTF-8"),
            mb_convert_encoding('現在の話者分離申込有無', "SJIS-win", "UTF-8"),
        ]);
        if (!is_null($users)) {
            foreach ($users as $e) {
                fputcsv($csv, [
                    mb_convert_encoding($e['name'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['company_name'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['email'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['phone_number'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['company_phone_number'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($userTypeConst[$e['type']], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($userStatusConst[$e['status']], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['created_at'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['last_login_at'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['diarization'], "SJIS-win", "UTF-8"),
                ]);
            }
        }
        fclose($csv);
    }

    public function download(Request $request)
    {
        $name = $request->name;
        $userType = $request->userType;
        $status = $request->status;
        $users = User::with('services')->orderBy('created_at', 'DESC')
            ->where('status', '!=', 3)
            ->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })->get();
        if ($userType) {
            $users = $users->where('type', $userType);
        }
        if (isset($status)) {
            $users = $users->where('status', $status);
        }
        foreach ($users as $user){
            if ($user->status == 0) {
                $user->email = $user->removed_email;
            }
            $user->diarization = '未';
            foreach ($user->services as $service) {
                if (!$service->pivot->remove_at) {
                    $user->diarization = '有';
                    break;
                } else {
                    $user->diarization = '無';
                }
            }
        }
        $uniqueid = uniqid();
        $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.csv';
        $path = Storage::path('data/' . $filename);
        $this->writeFormatDownloadToCsv($users, $path);
        return response()->json(['success' => true, 'filename' => $filename, 'url' => Storage::url('data/' . $filename)]);
    }
}
