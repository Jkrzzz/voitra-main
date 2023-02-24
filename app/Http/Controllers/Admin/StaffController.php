<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $staff_name = $request->staff_name;
        $staff_id = $request->staff_id;
        $order = $request->order;
        $order_by = $request->order_by;
        $staffs = Admin::query();
        if ($order && $order_by){
            $staffs = $staffs->orderBy($order_by, $order);
        } else {
            $staffs = $staffs->orderBy('created_at', 'DESC');
        }
        $staffs = $staffs->where('role', 2)->where('status', '!=', 3)
            ->where(function ($query) use ($staff_name, $staff_id) {
                $query->where('name', 'like', '%' . $staff_name . '%')->where('staff_id', 'like', '%' . $staff_id . '%');
            });
        if ($status) {
            $staffs = $staffs->where('status', $status);
        }
        $staffs = $staffs->paginate(10)
            ->appends($request->only('keyword'))
            ->appends($request->only('status'))
            ->appends($request->only('staff_name'))
            ->appends($request->only('staff_id'))
            ->appends($request->only('order'))
            ->appends($request->only('order_by'));
        $statusConst = Config::get('const.status');
        return view('admin.staff.index', [
            'staffs' => $staffs,
            'statusConst' => $statusConst,
            'status' => $status,
            'staff_name' => $staff_name,
            'staff_id' => $staff_id,
            'order' => $order,
            'order_by' => $order_by
        ]);
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|unique:admins,staff_id',
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&^._])[A-Za-z\d@$!%*#?&^._]{8,}$/'
        ],[
            'staff_id.required' => '入力してください。',
            'name.required' => '入力してください。',
            'email.required' => '入力してください。',
            'password.required' => '入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'password.regex' => '英数字混合の8文字以上で登録してください。',
            'staff_id.unique' => '入力したIDは既に登録されています。',
            'email.unique' => '入力したメールアドレスは既に登録されています。'
        ]);
        $staff = new Admin();
        $staff->staff_id = $request->staff_id;
        $staff->name = $request->name;
        $staff->email = $request->email;
        $staff->password = bcrypt($request->password);
        $staff->role = 2;
        $staff->status = 1;
        $staff->save();
        return redirect('/admin/staffs')->with('success', '新スタッフアカウントを作成完了しました。');
    }


    public function detail($id)
    {
        $staff = Admin::find($id);
        if (!$staff || $staff->status == 3) {
            return redirect()->back()->withErrors(['msg' => 'このスタッフは存在しません。']);
        }
        return view('admin.staff.detail',[
            'staff' => $staff
        ]);
    }
    public function edit($id)
    {
        $staff = Admin::find($id);
        if (!$staff || $staff->status == 3) {
            return redirect()->back()->withErrors(['msg' => 'このスタッフは存在しません。']);
        }
        $statusConst = Config::get('const.status');
        return view('admin.staff.edit',[
            'staff' => $staff,
            'statusConst' => $statusConst
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ],[
            'name.required' => '入力してください。'
        ]);
        $staff = Admin::find($id);
        if (!$staff || $staff->status == 3) {
            return redirect()->back()->withErrors(['msg' => 'このスタッフは存在しません。']);
        }
        $staff->name = $request->name;
        $staff->status = $request->status;
        $staff->save();

        return redirect('/admin/staffs')->with('success', '変更を完了しました。');;
    }

//    public function delete($id)
//    {
//        $staff = Admin::find($id);
//        if (!$staff || $staff->status == 3) {
//            return redirect()->back()->withErrors(['msg' => 'このスタッフは存在しません。']);
//        }
//        $staff->status = 3;
//        $staff->save();
//        return redirect('/admin/staffs')->with('success', '削除成功しました。');;
//    }

    public function changePassword($id){
        $staff = Admin::find($id);
        if (!$staff || $staff->status == 3) {
            return redirect()->back()->withErrors(['msg' => 'このスタッフは存在しません。']);
        }
        return view('admin.staff.change_password',[
            'staff' => $staff
        ]);
    }
    public function changePasswordProcess(Request $request, $id){
        $request->validate([
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&^._])[A-Za-z\d@$!%*#?&^._]{8,}$/'
        ],[
            'password.required' => '入力してください。',
            'password.regex' => '新しいパスワードがパスワードの条件を満たされていないです。',
        ]);
        $staff = Admin::find($id);
        if (!$staff || $staff->status == 3) {
            return redirect()->back()->withErrors(['msg' => 'このスタッフは存在しません。']);
        }
        $staff->password = bcrypt($request->password);
        $staff->save();
        return redirect('/admin/staffs')->with('success', 'パスワードを変更しました。');;
    }

    public function information(){
        $staff = Auth::guard('admin')->user();
        return view('admin.staff.edit',[
            'staff' => $staff
        ]);
    }

    public function changeInformation(Request $request){
        $request->validate([
            'name' => 'required'
        ],[
            'name.required' => '入力してください。'
        ]);
        $staff = Auth::guard('admin')->user();
        $staff->name = $request->name;
        $staff->save();
        return redirect('/admin/orders')->with('success', 'アップデート成功しました。');
    }

    public function changeInformationPassword(Request $request){
        $staff = Auth::guard('admin')->user();
        return view('admin.staff.change_password',[
            'staff' => $staff
        ]);
    }

    public function changeInformationPasswordProcess(Request $request){
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&^._])[A-Za-z\d@$!%*#?&^._]{8,}$/',
            'confirm_password' => 'required|same:password',
        ], [
            'current_password.required' => '入力してください。',
            'password.required' => '入力してください。',
            'confirm_password.required' => '入力してください。',
            'password.regex' => '新しいパスワードがパスワードの条件を満たされていないです。',
            'confirm_password.same' => 'パスワードが一致しません。',
        ]);

        $staff = Auth::guard('admin')->user();
        if (!Hash::check($request->current_password, $staff->password)) {
            return redirect()->back()->with(['error' => '現在のパスワードが間違っています。']);
        }
        $staff->password = bcrypt($request->password);
        $staff->save();
        return redirect('/admin/orders')->with('success', 'アップデート成功しました。');
    }
}
