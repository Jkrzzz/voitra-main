<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SettingParam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = SettingParam::orderBy('created_at', 'DESC')->paginate(10);
        $totalBrushUpProcessing = Order::with('audios')->where('plan', 2)->whereNotIn('status', [6, 7, 8, 0])->get();
        $totalDurationProcessing = 0;
        foreach ($totalBrushUpProcessing as $e) {
            foreach ($e->audios as $audio) {
                if ($audio->status != 3) {
                    $totalDurationProcessing += $audio->duration;
                }
            }
        }
        $time_end_daily = SettingParam::where('key', 'time_end_daily')->first();
        $time_processing_daily = SettingParam::where('key', 'time_processing_daily')->first();
        $day_off = SettingParam::where('key', 'day_off')->first();
        $day_delay = SettingParam::where('key', 'day_delay')->first();
        $audio_duration = SettingParam::where('key', 'audio_duration')->first();
        $delete_file_time = SettingParam::where('key', 'delete_file_time')->first();
        return view('admin.setting.index', [
            'settings' => $settings,
            'totalDurationProcessing' => $totalDurationProcessing,
            'time_end_daily' => $time_end_daily,
            'time_processing_daily' => $time_processing_daily,
            'day_off' => $day_off,
            'day_delay' => $day_delay,
            'audio_duration' => $audio_duration,
            'delete_file_time' => $delete_file_time
        ]);
    }

    public function setting(Request $request, $id)
    {
        $value = $request->value;
        $expired_date = $request->expired_date;
        $setting = SettingParam::find($id);
        if (!$setting) {
            return response()->json(['message' => 'エラー'], 400);
        }

        $setting->value = $value;
        $setting->expired_date = $expired_date ? $expired_date : '';
        $setting->save();
        return response()->json(['message' => '設定しました。']);
    }

    public function changeSetting(Request $request)
    {
        $data = $request->except('_token');
        DB::beginTransaction();
        try {
            foreach ($data as $key => $el) {
                $setting = SettingParam::where('key', $key)->first();
                $setting->value = $el;
                $setting->save();
            }
            DB::commit();
            return response()->json(['message' => '設定しました。']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => ''], 400);
        }
    }
}
