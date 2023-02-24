<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SettingParam;
use App\Models\Audio;

class TestController extends Controller
{
    public function test(){
        $audios = Audio::with('orders')->where('status', '!=', 3)->get();
        $now = Carbon::now();
        $deleteFileTime = SettingParam::where('key', 'delete_file_time')->first();
        foreach ($audios as $audio) {
            $order_p1 = $audio->orders()->where('plan', 1)->first();
            $order_p2 = $audio->orders()->where('plan', 2)->first();
            if ($order_p2) {
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $order_p2->created_at)->addDays($deleteFileTime->value);
            } else {
                if (!$order_p1){
                    continue;
                }
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $order_p1->created_at)->addDays($deleteFileTime->value);
            }
            if ($now > $date) {
                $array = explode('/', $audio->url);
                return 1;
            }
            return ($date<$now);
        }
        return 0;
    }
}
