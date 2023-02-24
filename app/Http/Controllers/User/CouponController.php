<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function list()
    {
        $user  = \Auth::user();
        $today = Carbon::now()->format('Y-m-d');
        // \Log::info($today);

        $limited_coupons_used = DB::table('orders')
            ->join('coupons', 'coupons.id', '=', 'orders.coupon_id')
            ->where('coupons.is_limited', '=', 1)
            ->where('orders.user_id', '=', $user->id)
            ->get()
            ->pluck('coupon_id')
            ->toArray();
        // \Log::info($used_coupons);
        // dd($used_coupons);

        $coupons = DB::table('coupons')
            ->where('status', 1)
            ->where('is_private', 0)
            ->whereDate('end_at', '>=', $today) // not work
            ->whereNotIn('id', $limited_coupons_used)
            // ->whereNotIn('id', function ($query) use ($user) {
            //     $query->select('coupon_id')
            //         ->from('orders')
            //         ->join('coupons', 'coupons.id', '=', 'orders.coupon_id')
            //         ->where('coupons.is_limited', 1)
            //         ->where('orders.user_id', $user->id)
            //         ->distinct();
            // })
            ->whereRaw('quantity IS NULL OR (quantity IS NOT NULL AND used_quantity < quantity)')
            ->orderBy('created_at','desc')
            ->get();

        foreach ($coupons as $key => $coupon) {
            if ($coupon->status !== 1) {
                unset($coupons[$key]);
                continue;
            }

            if ($coupon->is_private !== 0) {
                unset($coupons[$key]);
                continue;
            }

            if ($coupon->end_at < $today) {
                unset($coupons[$key]);
                continue;
            }

            if (in_array($coupon->id, $limited_coupons_used)) {
                unset($coupons[$key]);
                continue;
            }

            if ($coupon->quantity > 0 && $coupon->used_quantity >= $coupon->quantity) {
                unset($coupons[$key]);
                continue;
            }
        }

        return view('user.coupon.list', [
            'coupons' => $coupons
        ]);
    }
}
