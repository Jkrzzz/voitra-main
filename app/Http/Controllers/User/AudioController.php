<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ChangePasswordSuccessMail;
use App\Models\Coupon;
use App\Models\SettingParam;
use App\Models\User;
use Carbon\Carbon;
use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Services\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Audio;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentHistory;
use App\Traits\NotificationTrait;

class AudioController extends Controller
{
    use NotificationTrait;

    protected $TARGET_GROUP_ID;

    function __construct()
    {
        $this->order_status = Config::get('const', 'default');
    }

    public function brushupPayment(Request $request)
    {
        $order_id = $request->order_id;
        $orderInfo = Order::findOrFail($order_id);
        return view('user.upload.brushup_payment', [
            'order_id' => $orderInfo->id,
            'api_token' => config('veritrans.api_token'),
            'api_url' => config('veritrans.api_url'),
            'payment_id' => TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100,999))
        ]);
    }

    public function confirmRequest($id,Request $request)
    {
        $orderInfo = Order::findOrFail($id);
        $total_text = 0;
        $total_price = 0;
        $audios = array();
        $time_est = null;
        $couponCode = $request->coupon_code;
        $isUseCoupon = $request->has('coupon_code');
        $coupon = Coupon::with('orders')->where('code', $couponCode)->where('status', 1)->where('start_at','<=', date('Y-m-d'))->first();
        if ($isUseCoupon && $coupon && $coupon->is_limited && count($coupon->orders) > 0){
            $coupon = null;
        }
        foreach ($orderInfo->audios as $audio) {
            $audio->expected = $audio->pivot->user_estimate;
            $audio->deadline = $audio->pivot->admin_estimate;
            $data = $this->getInfor($audio);
            $audio->price = ceil($data['price']);
            $total_text += $data['length'];
            $audio->length = $data['length'];
            $total_price += ceil($data['price']);
            $time_est = $orderInfo->audios()->find($audio->id)->pivot->user_estimate;
            array_push($audios, $audio);
        }
        $orderInfo->total_price = $total_price;
        $orderInfo->total_time = $total_text;
        $orderInfo->save();
        $orderInfo['time_est'] = $time_est;
        $discountedMoneyTotal = null;
        if ($isUseCoupon) {
            $discountedMoneyTotal = (new UserController())->getDiscountedTotal($coupon, $orderInfo->total_price);
        }
        return view('user.upload.confirm_request', [
            'order' => $orderInfo,
            'audios' => $audios,
            'isUseCoupon' => $isUseCoupon,
            'coupon' => $coupon,
            'discountedMoneyTotal' => $discountedMoneyTotal,
        ]);
    }

    public function brushupConfirm(Request $request)
    {
        $order_id = $request->order_id;
        $token = $request->token;
        $req_card_number = $request->req_card_number;
        $username = $request->username;
        $expdate = $request->expdate;
        $payment_id = $request->payment_id;
        $orderInfo = Order::findOrFail($order_id);
        $audios = array();
        $coupon_id = $request->coupon_id;
        $coupon = Coupon::find($coupon_id);
        $discountedMoneyTotal = (new UserController())->getDiscountedTotal($coupon, $orderInfo->total_price);
        foreach ($orderInfo->audios as $audio) {
            $data = $this->getInfor($audio);
            $audio->expected = $audio->pivot->user_estimate;
            $audio->deadline = $audio->pivot->admin_estimate;
            $audio->length = $data['length'];
            $audio->price = $orderInfo->audios()->find($audio->id)->pivot->price;
            array_push($audios, $audio);
        }
        $orderInfo = Order::findOrFail($order_id);
        return view('user.upload.brushup_confirm', [
            'data' => $orderInfo,
            'order_id' => $order_id,
            'audios' => $audios,
            'token' => $token,
            'req_card_number' => $req_card_number,
            'username' => $username,
            'expdate' => $expdate,
            'payment_id' => $payment_id,
            'coupon' =>  $coupon,
            'discountedMoneyTotal' =>  $discountedMoneyTotal
        ]);
    }

    public function requestBrushup(Request $request)
    {
        $user = User::find(Auth::id());
        $order_id = $request->order_id;
        $estimate = $request->user_estimate;
        $orderInfo = Order::find($order_id);
        foreach ($orderInfo->audios as $audio) {
            $rel = $audio->orders()->where('plan', 1)->first();
            $rel2 = $audio->orders()->find($order_id);
            $rel2->pivot->diarization = $rel->pivot->diarization;
            $rel2->pivot->num_speaker = $rel->pivot->num_speaker;
            $rel2->pivot->user_estimate = $estimate;
            $rel2->pivot->status = 2;
            $audio->save();
            $rel2->pivot->save();
        }
        $orderInfo->status = ORDER_PROCESSING;
        foreach ($orderInfo->audios as $audio) {
            $audio->total_time = $this->getInfor($audio)['length'];
            $audio->total_price = $this->getInfor($audio)['price'];
            $orders = $audio->orders()->where('plan', 2)->where('orders.status', '!=', 0)->get();
            foreach ($orders as $order) {
                if ($order->id != $orderInfo->id) {
                    $order->audios()->detach($audio->id);
                    if (empty($order->audios)) {
                        $order->status = 0;
                    }
                }
            }
        }
        $orderInfo->save();
        $this->broadcastNoticeToAllAdminUsers('user_est_requested', $orderInfo->id, $user->name);
        Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】ブラッシュアッププラン 予約完了', 'emails.request_success'));
        Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra 対応】ブラッシュアッププラン 納品予定日確認予約が入りました', 'emails.send_admin_request'));
        return view('user.upload.brushup_success');
    }

    public function audioView($id)
    {
        $audio = Audio::where('user_id', Auth::id())->findOrFail($id);
        $order_p1 = $audio->orders()->where('plan', 1)->where('orders.status', '!=', 0)->first();
        $order_p2 = $audio->orders()->where('plan', 2)->where('orders.status', '!=', 0)->first();
        $now = Carbon::now();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $order_p1->created_at)->addDays(31);
        if ($order_p2) {
            $order_p2->total_time = $this->getInfor($audio)['length'];
            $order_p2->total_price = $this->getInfor($audio)['price'];
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $order_p2->created_at)->addDays(31);
        }
        $isDeleted = $now > $date;
        $isOption = $audio->orders[0]->pivot->diarization;
        $feedbackPlan = 0;
        if (!$isDeleted){
            if ($order_p1->pivot->status == 2 && !$order_p1->pivot->is_seen) {
                $feedbackPlan = 1;
            }
            if ($order_p2 && $order_p2->status == 6 && !$order_p2->pivot->is_seen) {
                $feedbackPlan = 2;
            }
        }
        foreach ($audio->orders as $e) {
            if ($e->pivot->is_seen == 0 && (($e->plan == 1 && $e->pivot->status == 2) || ($e->plan == 2 && $e->status == 6))) {
                $audio->orders()->updateExistingPivot($e->id, ['is_seen' => 1]);
            }
        }
        return view('user.audio.view', [
            'isOption' => $isOption,
            'data' => $audio,
            'order_p1' => $order_p1,
            'order_p2' => $order_p2,
            'isDeleted' => $isDeleted,
            'date' => $date,
            'feedbackPlan' => $feedbackPlan
        ]);
    }

    public function audioEdit($id, Request $request)
    {
        $audio = Audio::with('orders')->where('user_id', Auth::id())->findOrFail($id);
        $type = $request->query('type');
        $order_p1 = $audio->orders()->where('plan', 1)->where('orders.status', '!=', 0)->first();
        $order_p2 = $audio->orders()->where('plan', 2)->where('orders.status', '!=', 0)->first();
        $now = Carbon::now();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $order_p1->created_at)->addDays(31);
        if ($order_p2) {
            $order_p2->total_time = $this->getInfor($audio)['length'];
            $order_p2->total_price = $this->getInfor($audio)['price'];
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $order_p2->created_at)->addDays(31);
        }
        $isDeleted = $now > $date;
        if ($isDeleted) {
            return redirect()->back();
        }
        if ($type == 1) {
            $numSpeaker = $order_p2->pivot->num_speaker;
            if ($order_p2->pivot->status != 2) {
                return redirect()->back();
            }
        } else {
            $numSpeaker = $order_p1->pivot->num_speaker;
            if ($order_p1->pivot->status != 2) {
                return redirect()->back();
            }
        }
        foreach ($audio->orders as $e) {
            if ($e->plan == 1 && $e->pivot->is_seen == 0 && $e->pivot->status == 2) {
                $audio->orders()->updateExistingPivot($e->id, ['is_seen' => 1]);
            }
        }
        $isOption = DB::table('orders_audio')->where('audio_id', $id)->where('order_id', $order_p1->id)->first()->diarization;
        return view('user.audio.edit', ['isOption' => $isOption, 'data' => $audio, 'type' => $type, 'numSpeaker' => $numSpeaker, 'order_p1' => $order_p1, 'order_p2' => $order_p2, 'isDeleted' => $isDeleted]);
    }

    public function save(Request $request)
    {
        $id = $request->audio_id;
        $content = $request->content;
        Audio::where('id', $id)->update(['result' => $content]);
        return response()->json(['success' => true]);
    }

    public function editFilename(Request $request)
    {
        $id = $request->audio;
        $name = $request->name;
        Audio::where('id', $id)->update(['name' => $name]);
        return response()->json(['success' => true, 'name' => $name]);
    }

    public function deleteAudio(Request $request)
    {
        DB::beginTransaction();
        try {
            $audios = $request->audios;
            foreach ($audios as $audio) {
                $audioInfo = Audio::find($audio);
                foreach ($audioInfo->orders as $order) {
                    if (($order->plan == 2 && !in_array($order->status, [6, 7, 8])) || ($order->plan == 1 && !in_array($order->pivot->status, [2, 3, 0, 7, 9]))) {
                        return response()->json(['success' => false, 'mess' => ''], 400);
                    }
                    DB::table('orders_audio')->where('order_id', $order->id)
                        ->where('audio_id', $audioInfo->id)
                        ->update([
                            'diarization' => null,
                            'num_speaker' => null,
                            'status' => 4
                        ]);
                }
                $array = explode('/', $audioInfo->url);
                Storage::delete('audios/' . end($array));
                $audioInfo->url = '';
                $audioInfo->api_result = null;
                $audioInfo->result = null;
                $audioInfo->edited_result = null;
                $audioInfo->save();
            }
            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'mess' => $e->getMessage()]);
        }
    }


    public function cancelBrushup(Request $request)
    {
        DB::beginTransaction();
        $userId = Auth::id();
        try {
            $audios = $request->audios;
            foreach ($audios as $audio) {
                $audioInfo = Audio::find($audio);
                $orders = $audioInfo->orders()->where('plan', 2)->where('orders.status', '!=', 0)->get();
                foreach ($orders as $order) {
                    if ($order->status == 6 || $order->status == 1 || $order->status == 3) {
                        return response()->json(['success' => false, 'mess' => 'ファイルを処理中です。']);
                    }
                }
            }
            $orderInfo = Order::create([
                'plan' => 2,
                'status' => 0,
                'user_id' => $userId
            ]);
            $total_time = 0;
            $total_price = 0;
            foreach ($audios as $audio) {
                $audioInfo = Audio::find($audio);
                if (!isset($audioInfo) || is_null($audioInfo->api_result)) {
                    return response()->json(['success' => false, 'mess' => 'ファイルを処理中です。']);
                } else {
                    $data = $this->getInfor($audioInfo);
                    $orderInfo->audios()->attach([$audioInfo->id => ['price' => ceil($data['price']), 'status' => 1]]);
                    $total_price += ceil($data['price']);
                    $total_time += $data['length'];
                }
            }
            $orderInfo->total_price = $total_price;
            $orderInfo->total_time = $total_time;
            $order_id = $orderInfo->id;
            $orderInfo->save();
            DB::commit();
            return response()->json(['success' => true, 'order_id' => $order_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'mess' => $e->getMessage()]);
        }
    }

    public function newBrushup($id)
    {
        $userId = Auth::id();
        $order = Order::find($id);
        try {
            DB::beginTransaction();
            $orderInfo = Order::create([
                'plan' => 2,
                'status' => 0,
                'user_id' => $userId
            ]);
            $total_time = 0;
            $total_price = 0;
            foreach ($order->audios as $audioInfo) {
                // $audioInfo = Audio::find($audio);
                $orderp2 = $audioInfo->orders()->where('plan', 2)->where('orders.status', '!=', 0)->first();
                if ($orderp2) {
                    abort(404);
                }
                if (!isset($audioInfo) || is_null($audioInfo->api_result) || $audioInfo->api_result == '') {
                    abort(404);
                } else {
                    $data = $this->getInfor($audioInfo);
                    $orderInfo->audios()->attach([$audioInfo->id => ['price' => ceil($data['price']), 'status' => 1]]);
                    $total_price += ceil($data['price']);
                    $total_time += $data['length'];
                }
            }
            $orderInfo->total_price = $total_price;
            $orderInfo->total_time = $total_time;
            $orderInfo->save();
            $order_id = $orderInfo->id;
            DB::commit();
            return redirect('/audio/brushup/' . $order_id);
        } catch (\Exception $e) {
            DB::rollBack();
            abort(404);
        }
    }

    public function writeString($audioInfo, $path)
    {
        $csv = fopen($path, 'w');
        fputcsv($csv, array(mb_convert_encoding('認識結果', "SJIS-win", "UTF-8"), mb_convert_encoding($audioInfo->api_result, "SJIS-win", "UTF-8")), ",", '"');
        fputcsv($csv, array(mb_convert_encoding('編集結果', "SJIS-win", "UTF-8"), mb_convert_encoding($audioInfo->edited_result, "SJIS-win", "UTF-8")), ",", '"');
        fputcsv($csv, array(mb_convert_encoding('ブラッシュアップ結果', "SJIS-win", "UTF-8"), mb_convert_encoding($audioInfo->result, "SJIS-win", "UTF-8")), ",", '"');
        fclose($csv);
    }

    public function writeJson($audioInfo, $path)
    {
        $api_result = json_decode($audioInfo->api_result);
        $edited_result = json_decode($audioInfo->edited_result);
        $result = json_decode($audioInfo->result);
        $csv = fopen($path, 'w');
        fputcsv($csv, array(mb_convert_encoding('認識結果', "SJIS-win", "UTF-8")), ",", '"');
        fputcsv($csv, array(mb_convert_encoding('話者', "SJIS-win", "UTF-8"), mb_convert_encoding('スタート時間', "SJIS-win", "UTF-8"), mb_convert_encoding('終了時間', "SJIS-win", "UTF-8"), mb_convert_encoding('会話内容', "SJIS-win", "UTF-8")), ",", '"');
        if (!is_null($api_result)) {
            foreach ($api_result as $item) {
                fputcsv($csv, array(mb_convert_encoding('スピーカー ' . $item->speaker, "SJIS-win", "UTF-8"), gmdate("H:i:s", $item->start), gmdate("H:i:s", $item->stop), mb_convert_encoding($item->text, "SJIS-win", "UTF-8")), ",", '"');
            }
        }
        fputcsv($csv, array(""), ",", '"');
        fputcsv($csv, array(mb_convert_encoding('編集結果', "SJIS-win", "UTF-8")), ",", '"');
        fputcsv($csv, array(mb_convert_encoding('話者', "SJIS-win", "UTF-8"), mb_convert_encoding('スタート時間', "SJIS-win", "UTF-8"), mb_convert_encoding('終了時間', "SJIS-win", "UTF-8"), mb_convert_encoding('会話内容', "SJIS-win", "UTF-8")), ",", '"');
        if (!is_null($edited_result)) {
            foreach ($edited_result as $item) {
                fputcsv($csv, array(mb_convert_encoding('スピーカー ' . $item->speaker, "SJIS-win", "UTF-8"), gmdate("H:i:s", $item->start), gmdate("H:i:s", $item->stop), mb_convert_encoding($item->text, "SJIS-win", "UTF-8")), ",", '"');
            }
        }
        fputcsv($csv, array(""), ",", '"');
        fputcsv($csv, array(mb_convert_encoding('ブラッシュアップ結果', "SJIS-win", "UTF-8")), ",", '"');
        fputcsv($csv, array(mb_convert_encoding('話者', "SJIS-win", "UTF-8"), mb_convert_encoding('スタート時間', "SJIS-win", "UTF-8"), mb_convert_encoding('終了時間', "SJIS-win", "UTF-8"), mb_convert_encoding('会話内容', "SJIS-win", "UTF-8")), ",", '"');
        if (!is_null($result)) {
            foreach ($result as $item) {
                fputcsv($csv, array(mb_convert_encoding('スピーカー ' . $item->speaker, "SJIS-win", "UTF-8"), gmdate("H:i:s", $item->start), gmdate("H:i:s", $item->stop), mb_convert_encoding($item->text, "SJIS-win", "UTF-8")), ",", '"');
            }
        }
        fclose($csv);
    }

    public function writeToCSV($audioInfo, $path)
    {
        $data = json_decode($audioInfo->api_result);
        if (is_null($data) && is_string($audioInfo->api_result)) {
            $this->writeString($audioInfo, $path);
        } elseif (is_string($data)) {
            $this->writeString($audioInfo, $path);
        } elseif (is_array($data)) {
            $this->writeJson($audioInfo, $path);
        }
    }

    public function download(Request $request)
    {
        $audios = $request->audios;
        $type = $request->type;

        if ($type == 1) {
            $audiosData = Audio::with('orders')
                ->whereIn('id', $audios)->get();
            foreach ($audiosData as $el) {
                $order = $el->orders()->where('plan', 1)->first();
                if ($order->pivot->status != 2) {
                    return response()->json(['success' => false, 'msg' => 'ダウンロード出来るデーターがありません。'], 400);
                }
            }
        }
        if (count($audios) == 1) {
            $audioInfo = Audio::find($audios[0]);
            $file = $audioInfo->id . '_' . $audioInfo->name . '.csv';
            $path = Storage::path('data/' . $file);
            $this->writeToCSV($audioInfo, $path);
            return response()->json(['success' => true, 'filename' => $file, 'url' => Storage::url('data/' . $file)]);
        } else {
            $zip = new \ZipArchive();
            $uniqueid = uniqid();
            $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.zip';
            if ($zip->open(Storage::path('data/' . $filename), \ZipArchive::CREATE) == TRUE) {
                foreach ($audios as $audio) {
                    $audioInfo = Audio::find($audio);
                    $file = $audioInfo->id . '_' . $audioInfo->name . '.csv';
                    $path = Storage::path('data/' . $file);
                    $this->writeToCSV($audioInfo, $path);
                    $zip->addFile($path, $file);
                }
                $zip->close();
            }
            return response()->json(['success' => true, 'filename' => $filename, 'url' => Storage::url('data/' . $filename)]);
        }
    }


    public function brushupOrder($id)
    {
        $orderInfo = Order::findOrFail($id);
        $total_time = 0;
        $total_price = 0;

        foreach ($orderInfo->audios as $audio) {
            $data = $this->getInfor($audio);
            $total_time += $data['length'];
            $total_price += ceil($data['price']);
            $audio->length = $data['length'];
        }
        $orderInfo->total_time = $total_time;
        $orderInfo->total_price = $total_price;
        Order::where('id', $id)->update(['total_time' => $total_time, 'total_price' => $total_price]);

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
        $total_duration_processing = $totalDurationProcessing;
        return view('user.upload.order_brushup', [
            'data' => $orderInfo,
            'audios' => $orderInfo->audios,
            'time_end_daily' => $time_end_daily,
            'time_processing_daily' => $time_processing_daily,
            'day_off' => $day_off,
            'day_delay' => $day_delay,
            'audio_duration' => $audio_duration,
            'total_duration_processing' => $total_duration_processing
        ]);
    }

    public function getInfor($audioInfo)
    {
        $data = json_decode($audioInfo->api_result);
        $length = 0;
        if (is_null($data) && is_string($audioInfo->api_result)) {
            $length = strlen(utf8_decode($audioInfo->api_result));
        } elseif (is_string($data)) {
            $length = strlen(utf8_decode($data));
        } elseif (is_array($data)) {
            foreach ($data as $item) {
                $length += strlen(utf8_decode($item->text));
            }
        }
        $price = (int)($length * 1.1);
        return ['price' => $price, 'length' => $length];
    }

    public function brushup(Request $request)
    {
        $audios = $request->audios;
        $userId = Auth::id();
        try {
            DB::beginTransaction();
            $orderInfo = Order::create([
                'plan' => 2,
                'status' => 0,
                'user_id' => $userId
            ]);
            $total_time = 0;
            $total_price = 0;
            foreach ($audios as $audio) {
                $audioInfo = Audio::find($audio);
                $orderp2 = $audioInfo->orders()->where('plan', 2)->where('orders.status', '!=', 0)->first();
                if ($orderp2) {
                    return response()->json(['success' => false, 'mess' => 'Requested。']);
                }
                if (!isset($audioInfo) || is_null($audioInfo->api_result) || $audioInfo->api_result == '') {
                    return response()->json(['success' => false, 'mess' => 'ファイルを処理中です。']);
                } else {
                    $data = $this->getInfor($audioInfo);
                    $orderInfo->audios()->attach([$audioInfo->id => ['price' => ceil($data['price']), 'status' => 1]]);
                    $total_price += ceil($data['price']);
                    $total_time += $data['length'];
                }
            }
            $orderInfo->total_price = $total_price;
            $orderInfo->total_time = $total_time;
            $orderInfo->save();
            $order_id = $orderInfo->id;
            DB::commit();
            return response()->json(['success' => true, 'order_id' => $order_id]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'mess' => $e->getMessage()]);
        }
    }

    public function uploadAudioProcess(Request $request)
    {
        $audios = $request->data;
        $order = $request->order;
        try {
            DB::beginTransaction();
            foreach ($audios as $audio) {
                $audioInfo = Audio::find($audio['id']);
                $rel = $audioInfo->orders()->find($order);
                $rel->pivot->diarization = $audio['diz'] == "true" ? 1 : 0;
                if ($audio['diz'] == "true") {
                    $rel->pivot->num_speaker = $audio['num'];
                }
                $rel->pivot->save();
            }
            DB::commit();
            return response()->json(['success' => true, 'order_id' => $order]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'mess' => $e->getMessage()]);
        }
    }

    public function textResponse($orderId, $audioId, $token, Request $request)
    {
        try {
            $data = $request->json()->all();
            $status = $data['status'];
            $results = $data['results'];
            $totalTime = $data['total_time'];
            Log::info($request);
            DB::beginTransaction();
            $audioInfo = Audio::find($audioId);
            if ($token == $audioInfo->token) {
                if ($status) {
                    $audioInfo->api_result = json_encode($results, JSON_UNESCAPED_UNICODE);
                    $audioInfo->save();
                    $rel = $audioInfo->orders()->find($orderId);
                    $rel->pivot->status = 2;
                    $rel->pivot->actual_processing_time = $totalTime;
                    $rel->pivot->save();
                } else {
                    $rel = $audioInfo->orders()->first();
                    $rel->pivot->status = 3;
                    $rel->pivot->save();
                }
            }
            $orderInfo = Order::find($orderId);
            $processing = 0;
            foreach ($orderInfo->audios as $audio) {
                $rel = $orderInfo->audios()->find($audio->id);
                if ($rel->pivot->status == 1) {
                    $processing += 1;
                }
            }
            if ($processing <= 0) {
                $orderInfo->status = 2;
                $orderInfo->save();
                Mail::to($orderInfo->user->email)->send(new SendMail(['user' => $orderInfo->user, 'order' => $orderInfo], '【voitra】AI文字起こしプラン テキスト化完了のお知らせ', 'emails.recognize_success'));
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'mess' => $e->getMessage()]);
        }
    }

    public function audioFeedback(Request $request, $id)
    {
        $audio = Audio::with('orders')->find($id);
        $plan = $request->plan;
        $comment = $request->comment;
        if (mb_strlen($comment) > 255){
            return response()->json(['success' => false],400);
        }
        $rate = $request->rate;
        $data = [];
        if ($rate) {
            $data['rate'] = $rate;
            $data['rate_at'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        if ($comment != null && $comment != '') {
            $data['comment'] = $comment;
            $data['comment_at'] = Carbon::now()->format('Y-m-d H:i:s');
        }
        foreach ($audio->orders as $e) {
            if ($e->plan == $plan) {
                $audio->orders()->updateExistingPivot($e->id, $data);
            }
        }
        return response()->json(['success' => true, 'mess' => ['title' => '送信しました。', 'body' => 'レビューありがとうございました。']]);
    }
}
