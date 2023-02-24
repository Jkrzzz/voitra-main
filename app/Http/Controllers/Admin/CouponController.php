<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index(){
        $couponStatusConst = Config::get('const.couponStatus');
        $coupons = Coupon::orderBy('created_at','desc')->paginate(10);
        foreach ($coupons as $coupon) {
            if (is_null($coupon->quantity)) {
                $coupon->quantity = '---';
                $coupon->remaining_quantity = '---';
            }
            else {
                $coupon->remaining_quantity = $coupon->quantity - $coupon->used_quantity;
            }
        }
        return view('admin.coupon.index',[
            'coupons' => $coupons,
            'couponStatusConst' => $couponStatusConst,
        ]);
    }

    public function create(){
        return view('admin.coupon.create');
    }

    public function confirm(Request $request){
        $request->validate([
            'name' => 'required',
            'start_at' => 'required',
            'end_at' => 'required|gte_field:start_at',
            'code' => "required|sunique:coupons,code|regex:/^[a-zA-Z\d._^%$#!~@,-]+$/",
            'discount_amount' => 'required'
        ],[
            'name.required' => '入力してください。',
            'start_at.required' => '入力してください。',
            'end_at.required' => '入力してください。',
            'code.required' => '入力してください。',
            'discount_amount.required' => '入力してください。',
            'code.sunique' => '使用したクーポンコードです。',
            'code.regex' => '半角で入力してください。',
            'end_at.gte_field' => '不適切日付です。'
        ]);

        $coupon = new Coupon;
        $coupon->name= $request->name;
        $coupon->start_at= $request->start_at;
        $coupon->end_at= $request->end_at;
        $coupon->code= $request->code;
        $coupon->discount_amount= $request->discount_amount;
        $coupon->quantity= $request->quantity;
        $coupon->is_limited= $request->is_limited;
        $coupon->is_private= $request->is_private;

        return view('admin.coupon.confirm',['coupon' => $coupon]);
    }

    public function store(Request $request){
        $coupon = new Coupon;
        $coupon->name= $request->name_confirmed;
        $coupon->start_at= $request->start_at_confirmed;
        $coupon->end_at= $request->end_at_confirmed;
        $coupon->code= $request->code_confirmed;
        $coupon->discount_amount = $request->discount_amount_confirmed;
        $coupon->quantity= $request->quantity_confirmed;
        $coupon->is_limited= $request->is_limited_confirmed;
        $coupon->is_private= $request->is_private_confirmed;
        $coupon->status = 1;
        $coupon->save();
        return redirect('/admin/coupons')->with('success', 'クーポンを作成しました。');
    }

    public function detail($id) {
        $couponStatusConst = Config::get('const.couponStatus');
        $coupon = Coupon::find($id);
        if (is_null($coupon->quantity)) {
            $coupon->quantity = '---';
            $coupon->remaining_quantity = '---';
        }
        else {
            $coupon->remaining_quantity = $coupon->quantity - $coupon->used_quantity;
        }
        return view('admin.coupon.detail',['coupon' => $coupon,'couponStatusConst' => $couponStatusConst]);
    }

    public function edit($id) {
        $couponStatusConst = Config::get('const.couponStatus');
        $coupon = Coupon::find($id);
        if (is_null($coupon->quantity)) {
            $coupon->remaining_quantity = '---';
        }
        else {
            $coupon->remaining_quantity = $coupon->quantity - $coupon->used_quantity;
        }
        return view('admin.coupon.edit',['coupon' => $coupon,'couponStatusConst' => $couponStatusConst]);
    }

    public function update($id,Request $request) {
        $coupon = Coupon::find($id);
        $coupon->status = $request->status;
        $coupon->save();
        if ($coupon->status == 1){
            $message = 'クーポンを公開しました。';
        } else {
            $message = 'クーポンを停止しました。';
        }
        return redirect('/admin/coupons')->with('success', $message);
    }
}
