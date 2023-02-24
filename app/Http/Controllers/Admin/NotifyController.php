<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ConfirmOrderMail;
use App\Mail\OrderDoneMail;
use App\Mail\RegisterVerifyMail;
use App\Models\Admin;
use App\Models\Audio;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\SendMail;
use App\Models\Contact;

use function PHPUnit\Framework\isNull;

class NotifyController extends Controller
{
    public function index(Request $request)
    {
        $counter = DB::table('notifications')
                         ->where('notifiable_id', auth()->guard('admin')->user()->id)
                         ->where('notifiable_type','App\Models\Admin')
                         ->where('created_at', '<=', Carbon::now()->addDay()->format('Y-m-d H:i:s'))
                         ->where('created_at', '>=', Carbon::now()->subMonths(3)->format('Y-m-d H:i:s'))
                         ->select('label', DB::raw('count(*) as total'))
                         ->groupBy('label')
                         ->get();

        $serviceCancelCounter = 0;
        $withdrawalCounter = 0;
        $contactCounter = 0;
        foreach($counter as $count) {
            if($count->label == config('app-notification.label.service_canceled')) {
                $serviceCancelCounter = $count->total;
            }
            if($count->label == config('app-notification.label.membership_canceled')) {
                $withdrawalCounter = $count->total;
            }
            if($count->label == config('app-notification.label.contact')) {
                $contactCounter = $count->total;
            }
        }
        $notifications = auth()->guard('admin')->user()->notifications()
                               ->where('created_at', '<=', Carbon::now()->addDay()->format('Y-m-d H:i:s'))
                               ->where('created_at', '>=', Carbon::now()->subMonths(3)->format('Y-m-d H:i:s'))
                               ->orderBy('created_at', 'desc')
                               ->paginate(20);

        $firstNotification = DB::table('notifications')->orderBy('created_at', 'asc')->first();
        return view('admin.notification.index', [
            'firstNotification' => $firstNotification,
            'notifications' => $notifications,
            'serviceCancelCounter' => $serviceCancelCounter,
            'withdrawalCounter' => $withdrawalCounter,
            'contactCounter' => $contactCounter
        ]);
    }

    public function contact(Request $request)
    {
        $contacts = DB::table('contacts')->orderBy('created_at', 'desc')->paginate(20);
        $userTypeConst = Config::get('const.userType');
        $contactTypeConst = Config::get('const.contactType');
        foreach($contacts as $contact) {
            $contact->status_class = '';
            $notifications = auth()->guard('admin')->user()->notifications()
                               ->where('reference_id', $contact->id)
                               ->orderBy('created_at', 'desc')
                               ->get()
                               ->toArray();
            foreach($notifications as $notification) {
                $contact->status_class = $notification['status_class'];
            }

            if (strlen($contact->content) >= 50) {
                $contact->short_desc = mb_substr($contact->content, 0, 50, 'UTF-8').'...';
            }
            else {
                $contact->short_desc = $contact->content;
            }
        }

        return view('admin.notification.contact', [
            'contacts' => $contacts,
            'userTypeConst' => $userTypeConst,
            'contactTypeConst' => $contactTypeConst,
            'request' => $request,
        ]);
    }

    public function detail($id)
    {
        $staffs = Admin::where('role', 2)->where('status', 1)->get();
        $order = Order::with('user')->with('admin')->with('audios')->find($id);
        $isAdmin = \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1;
        $isEstimateStaff = \Illuminate\Support\Facades\Auth::guard('admin')->id() == $order->estimate_staff || $isAdmin;
        $isEditStaff = \Illuminate\Support\Facades\Auth::guard('admin')->id() == $order->edit_staff || $isAdmin;
        if (!$isEstimateStaff && !$isEditStaff) {
            return redirect('/admin/orders');
        }

        $order->user_estimate = @DB::table('orders_audio')->where('order_id', $order->id)->first()->user_estimate;
        $order->user_name = $order->user->name;
        $order->total_price = $order->total_price . ' 円';
        $order->total_time = $order->total_time . ($order->plan == 1 ? ' 秒' : ' 文字');
        if ($order->plan == 2) {
            $order->estimate_staff_name = @$staffs->where('id', $order->estimate_staff)->first()->name;
            $order->edit_staff_name = @$staffs->where('id', $order->edit_staff)->first()->name;
        }
        $statusConst = Config::get('const.adminOrderStatus');
        $audioStatusConst = Config::get('const.audioStatus');

        if (!$order) {
            return redirect()->back()->withErrors(['msg' => 'この注文は存在しません。']);
        }
        $audios = $order->audios;
        foreach ($audios as $key => $audio) {
            $orderAudio = DB::table('orders_audio')->where('audio_id', $audio->id)->where('order_id', $order->id)->first();
            $audios[$key]->fullUrl = Storage::path($audio->url);
            $audios[$key]->diarization = $orderAudio->diarization;
            $audios[$key]->num_speaker = $orderAudio->num_speaker ?: '指定なし';
            $audios[$key]->audioStatus = $orderAudio->status;
        }
        $notifications = auth()->guard('admin')->user()->notifications()
                                ->where('reference_id', $id)
                               ->orderBy('created_at', 'desc')
                               ->get();

        return view('admin.order.detail', [
            'audios' => $audios,
            'order' => $order,
            'statusConst' => $statusConst,
            'audioStatusConst' => $audioStatusConst,
            'isAdmin' => $isAdmin,
            'isEstimateStaff' => $isEstimateStaff,
            'isEditStaff' => $isEditStaff,
            'notifications' => $notifications
        ]);
    }

    public function edit($id)
    {
        $staffs = Admin::where('role', 2)->where('status', 1)->get();
        $order = Order::with('user')->with('admin')->with('audios')->find($id);

        $isAdmin = \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1;
        $isEstimateStaff = \Illuminate\Support\Facades\Auth::guard('admin')->id() == $order->estimate_staff || $isAdmin;
        $isEditStaff = \Illuminate\Support\Facades\Auth::guard('admin')->id() == $order->edit_staff || $isAdmin;
        if (!$isEstimateStaff && !$isEditStaff) {
            return redirect('/admin/orders');
        }

        $order->user_estimate = @DB::table('orders_audio')->where('order_id', $order->id)->first()->user_estimate;
        $order->user_name = $order->user->name;
        $allPrice = $order->total_price;
        $userAddress = null;
        if ($order->payment_type == 2){
            $allPrice = $allPrice + VOITRA_POSTPAID_FEE;
            $userAddress = UserAddress::find($order->payid);
        }
        $sevice = Service::find($order->service_id);
        if ($sevice) {
            $allPrice = $allPrice + $sevice->price;
        }
        $order->all_price = $allPrice;
        $order->total_time = $order->total_time . ($order->plan == 1 ? ' 秒' : ' 文字');
        if ($order->plan == 2) {
            $order->estimate_staff_name = @$staffs->where('id', $order->estimate_staff)->first()->name;
            $order->edit_staff_name = @$staffs->where('id', $order->edit_staff)->first()->name;
        }
        $statusConst = Config::get('const.adminOrderStatus');
        $audioStatusConst = Config::get('const.audioStatus');
        $paymentTypeConst = Config::get('const.paymentType');
        $paymentStatusConst = Config::get('const.paymentStatus');
        $userTypeConst = Config::get('const.userType');
        if (!$order) {
            return redirect()->back()->withErrors(['msg' => 'この注文は存在しません。']);
        }
        $audios = $order->audios;
        $isEditComplete = true;
        foreach ($audios as $key => $audio) {
            $orderAudio = DB::table('orders_audio')->where('audio_id', $audio->id)->where('order_id', $order->id)->first();
            $audios[$key]->fullUrl = Storage::path($audio->url);
            $audios[$key]->diarization = $orderAudio->diarization;
            $audios[$key]->num_speaker = '';
            if ($audios[$key]->diarization == 1) {
                $audios[$key]->num_speaker = $orderAudio->num_speaker ?: '指定なし';
            }
            $audios[$key]->audioStatus = $orderAudio->status;
            if (!$audios[$key]->edited_result || trim($audios[$key]->edited_result) == '' || trim($audios[$key]->edited_result) == '[]') {
                $isEditComplete = false;
            }
            $audios[$key]->isSeen = $orderAudio->is_seen;
            $audios[$key]->estimated_processing_time = $orderAudio->estimated_processing_time;
            $audios[$key]->actual_processing_time = $orderAudio->actual_processing_time;

        }
        if ($order->status == 3 && $order->edit_staff == null && $order->estimate_staff != null) {
            $order->edit_staff = $order->estimate_staff;
        }
        return view('admin.order.edit', [
            'audios' => $audios,
            'order' => $order,
            'statusConst' => $statusConst,
            'audioStatusConst' => $audioStatusConst,
            'staffs' => $staffs,
            'isAdmin' => $isAdmin,
            'isEstimateStaff' => $isEstimateStaff,
            'isEditStaff' => $isEditStaff,
            'isEditComplete' => $isEditComplete,
            'paymentTypeConst' => $paymentTypeConst,
            'paymentStatusConst' => $paymentStatusConst,
            'service' => $sevice,
            'userAddress' => $userAddress,
            'userTypeConst'=> $userTypeConst
        ]);
    }

    public function audioResult($id, $audio_id)
    {
        $audio = Audio::with('orders')->find($audio_id);
        if (!$audio || $audio->orders[0]->pivot->status == 4) {
            return redirect()->back();
        }
        $audio->fullUrl = Storage::path($audio->url);
        $order = $audio->orders()->find($id);
//        if ($order->plan != 2 || (!in_array($order->status,[3, 11, 12]) && $isAdmin) || (!in_array($order->status,[11, 12]) && !$isAdmin)) {
//            return redirect()->back();
//        }
        $audio->diarization = $order->pivot->diarization;
        $staff = Admin::find($order->admin_id);
        $isAdmin = \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1;
        $isEditStaff = \Illuminate\Support\Facades\Auth::guard('admin')->id() == $order->edit_staff || $isAdmin;
        return view('admin.order.audio_result', [
            'audio' => $audio,
            'order' => $order,
            'staff' => $staff,
            'isAdmin' => $isAdmin,
            'isEditStaff' => $isEditStaff
        ]);
    }

    public function editAudioResult($id, $audio_id)
    {
        $isAdmin = \Illuminate\Support\Facades\Auth::guard('admin')->user()->role == 1;
        $audio = Audio::with('orders')->find($audio_id);
        if (!$audio || $audio->orders()->find($id)->pivot->status == 4 || $audio->status == 3) {
            return redirect()->back();
        }
        $audio->fullUrl = Storage::path($audio->url);
        $order = $audio->orders()->find($id);
        if ($order->plan != 2 || (!in_array($order->status, [3, 11, 12, 6]) && $isAdmin) || (!in_array($order->status, [11, 12]) && !$isAdmin)) {
            return redirect()->back();
        }
        $audio->diarization = $order->pivot->diarization;
        $staff = Admin::find($order->admin_id);
        return view('admin.order.edit_audio_result', ['audio' => $audio, 'order' => $order, 'staff' => $staff]);
    }

    public function updateAudio(Request $request)
    {
        $id = $request->audio_id;
        $orderId = $request->order_id;
        $content = $request->content;
        DB::beginTransaction();
        try {
            Audio::where('id', $id)->update(['edited_result' => $content]);
            $order = Order::find($orderId);
            $order->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $order->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function writeFormatToCsv($audioInfo, $path, $type)
    {
        if ($type == 1) {
            $api_result = json_decode($audioInfo->api_result);
            $csv = fopen($path, 'w');
            fputcsv($csv, array(mb_convert_encoding('話者', "SJIS-win", "UTF-8"), mb_convert_encoding('スタート時間', "SJIS-win", "UTF-8"), mb_convert_encoding('終了時間', "SJIS-win", "UTF-8"), mb_convert_encoding('会話内容', "SJIS-win", "UTF-8")), ",", '"');
            if (!is_null($api_result)) {
                foreach ($api_result as $item) {
                    fputcsv($csv, array(mb_convert_encoding('スピーカー ' . $item->speaker, "SJIS-win", "UTF-8"), gmdate("H:i:s", $item->start), gmdate("H:i:s", $item->stop), mb_convert_encoding($item->text, "SJIS-win", "UTF-8")), ",", '"');
                }
            }
        } else {
            $csv = fopen($path, 'w');
            fputcsv($csv, array(mb_convert_encoding('会話内容', "SJIS-win", "UTF-8")), ",", '"');
            fputcsv($csv, array(mb_convert_encoding($audioInfo->api_result, "SJIS-win", "UTF-8")), ",", '"');
            fclose($csv);
        }
    }

    public function exportCsv($orderId, $audioId)
    {
        $audioInfo = Audio::findOrFail($audioId);
        $uniqueid = uniqid();
        $type = $audioInfo->orders()->find($orderId)->pivot->diarization;
        $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.csv';
        $path = Storage::path('data/' . $filename);
        $this->writeFormatToCsv($audioInfo, $path, $type);
        return response()->json(['success' => true, 'filename' => $filename, 'url' => Storage::url('data/' . $filename)]);
    }


    function validateTime(string $date, string $format = 'H:i:s')
    {
        // $dateObj = \DateTime::createFromFormat($format, $date);
        $seconds = 0;
        if (preg_match('/(\d+\:\d+:\d+)/', $date)) {
            $seconds = strtotime($date) - strtotime('TODAY');
        } else {
            abort(400, 'Time stamp error');
        }
        return $seconds;
    }

    function validateSpeaker(string $speaker)
    {
        $pos = strpos($speaker, "スピーカー");

        if ($pos === false) {
            abort(400, 'スピーカーエラ');
        } else {
            $spk = (int)str_replace("スピーカー", "", $speaker);
            if ($spk && $spk >= 0 && $spk <= 15) {
                return $spk;
            } else {
                abort(400, 'スピーカーエラ');
            }
        }
        abort(400, 'スピーカーエラ');
    }

    public function updateByCsv(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $type = $request->type;
            try {
                $uniqueid = uniqid();
                $extension = $file->getClientOriginalExtension();
                $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
                $file->storeAs('data', $filename);
                $path = Storage::path('data/' . $filename);
                $content = file_get_contents($path);
                $content = mb_convert_encoding($content, "UTF-8", "SJIS-win");

                $data = str_getcsv($content, "\n");
                $json = array();
                $count = 0;
                if ($type == 1) {
                    foreach ($data as $row) {
                        $row = str_getcsv($row, ",");
                        if ($count != 0) {
                            if (count($row) != 4) {
                                abort(400, 'Number of columns errors');
                            }
                            $item = [
                                'speaker' => $this->validateSpeaker($row[0]),
                                'start' => $this->validateTime($row[1]),
                                'stop' => $this->validateTime($row[2]),
                                'text' => $row[3],
                            ];
                            array_push($json, $item);
                        }
                        $count += 1;
                    }
                } else {
                    $json = $data[1];
                }
                return response()->json(['success' => true, 'data' => $json]);
            } catch (\Exception $e) {
                abort(400, $e->getMessage());
            }
        }
    }

    public function exportNotify(Request $request)
    {
        $dateFrom = $request->from;
        $dateTo = Carbon::parse($request->to)->addDay()->format('Y-m-d');
        $uniqueid = uniqid();
        $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.csv';
        $path = Storage::path('data/' . $filename);
        $notifications = auth()->guard('admin')->user()->notifications()
                               ->where('created_at', '>=', $dateFrom)
                               ->where('created_at', '<', $dateTo)
                               ->orderBy('created_at', 'desc')
                               ->get();
        $csv = fopen($path, 'w');
        fputcsv($csv, [
            mb_convert_encoding('関連ID', "SJIS-win", "UTF-8"),
            mb_convert_encoding('通知内容', "SJIS-win", "UTF-8"),
            mb_convert_encoding('ラベル', "SJIS-win", "UTF-8"),
            mb_convert_encoding('時間', "SJIS-win", "UTF-8"),
        ], ",", '"');
        if (!is_null($notifications)) {
            foreach ($notifications as $e) {
                fputcsv($csv, [
                    mb_convert_encoding($e['reference_id'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['data'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['label_title'], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($e['created_at'], "SJIS-win", "UTF-8"),
                ], ",", '"');
            }
        }
        fclose($csv);
        return response()->json(['success' => true, 'filename' => $filename, 'url' => Storage::url('data/' . $filename)]);
    }

    public function download(Request $request)
    {
        $adminOrderStatusConst = Config::get('const.adminOrderStatus');
        $audioStatusConst = Config::get('const.audioStatus');
        $paymentTypeConst = Config::get('const.paymentType');
        $paymentStatusConst = Config::get('const.paymentStatus');
        $staffs = Admin::where('role', 2)->get();
        $staffsArr = $staffs->toArray();
        $orders = Order::with('user')->with('admin')->with('audios')->orderBy('created_at', 'DESC');
        $orders = $orders->whereRaw('CASE WHEN `plan` = 1 THEN `status` != 0 ELSE `status` END')->skip(0)->take(2000)->get();
        $ordersAudio = [];
        $count = 1;
        foreach ($orders as $order) {
            if ($count > 2000) break;
            foreach ($order->audios as $audio){
                if ($count > 2000) break;
                if ($order->plan == 1) {
                    $orderStatus = @$audioStatusConst[$order->status];
                } else {
                    $orderStatus = @$adminOrderStatusConst[$order->status];
                }
                $allPrice = $order->total_price;
                if ($order->payment_type == 2) {
                    $allPrice += VOITRA_POSTPAID_FEE;
                }
                if ($order->service_id) {
                    $allPrice += 300;
                }
                $staffEstimateArr = array_filter($staffsArr, function ($var) use ($order){
                   return $var['id'] == $order->estimate_staff;
                });
                $staffEditArr = array_filter($staffsArr, function ($var) use ($order){
                    return $var['id'] == $order->edit_staff;
                });
                $staffEstimateName = count($staffEstimateArr) > 0 ? array_values($staffEstimateArr)[0]['name'] : '';
                $staffEditName = count($staffEditArr) > 0 ? array_values($staffEditArr)[0]['name'] : '';
                $userEstimate = '';
                $rate = null;
                $comment = null;
                $ordersWithAudio = $audio->orders;
                foreach ($ordersWithAudio as $e) {
                    if ($e->id == $order->id){
                        $userEstimate = $e->pivot->user_estimate;
                        $rate = $e->pivot->rate;
                        $comment = $e->pivot->comment;
                    }
                }
                $ordersAudio[] = [
                    'order_id' => $order->id,
                    'order_created_at' => $order->created_at,
                    'audio_id' => $audio->id,
                    'customer_name' => $order->user->name,
                    'plan' => $order->plan,
                    'order_status' => $orderStatus,
                    'payment_type' => @$paymentTypeConst[$order->payment_type],
                    'payment_status' => @$paymentStatusConst[$order->payment_status],
                    'all_price' => $allPrice,
                    'postpaid_fee' => $order->payment_type == 2 ? VOITRA_POSTPAID_FEE : '',
                    'diarization' => $audio->orders[0]->pivot->diarization != 1 ? 'なし' : 'あり',
                    'num_speaker' => $audio->orders[0]->pivot->num_speaker ?: '',
                    'staff_estimate_name' => $staffEstimateName,
                    'staff_edit_name' => $staffEditName,
                    'user_estimate' => $userEstimate,
                    'deadline' => $order->deadline,
                    'rate' => $rate,
                    'comment' => $comment
                ];
                $count++;
            }
        }

        $uniqueid = uniqid();
        $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.csv';
        $path = Storage::path('data/' . $filename);
        $this->writeFormatDownloadToCsv($ordersAudio, $path);
        return response()->json(['success' => true, 'filename' => $filename, 'url' => Storage::url('data/' . $filename)]);

    }

//    public function download(Request $request)
//    {
//        $status = $request->status;
//        $user_id = $request->user_id;
//        $staff_id = $request->staff_id;
//        $staff_estimate_id = $request->staff_estimate_id;
//        $staff_edit_id = $request->staff_edit_id;
//        $order_id = $request->order_id;
//        $audio_id = $request->audio_id;
//        $plan = $request->plan;
//        $staffAssign = $request->staffAssign;
//        $orders = Order::with('user')->with('admin')->with('audios')->orderBy('created_at', 'DESC');
//        $admin = Auth::guard('admin')->user();
//        if ($admin->role != 1) {
//            $orders = $orders->where(function ($q) use ($admin) {
//                $q->where('estimate_staff', $admin->id)->orWhere('edit_staff', $admin->id);
//            });
//        }
//        if ($staff_id) {
//            $orders = $orders->where(function ($q) use ($staff_id) {
//                $q->where('estimate_staff', $staff_id)->orWhere('edit_staff', $staff_id);
//            });
//        }
//        if (isset($staff_estimate_id)) {
//            $orders = $orders->where('estimate_staff', $staff_estimate_id);
//        }
//        if (isset($staff_edit_id)) {
//            $orders = $orders->where('edit_staff', $staff_edit_id);
//        }
//        if (isset($status)) {
//            if ($status == 20) {
//                $orders = $orders->where('plan', 1)->where('status', 2);
//            } else {
//                $orders = $orders->where('status', $status);
//            }
//        }
//        if ($order_id) {
//            $orders = $orders->where('id', $order_id);
//        }
//        if ($audio_id) {
//            $orders = $orders->whereHas('audios', function ($q) use ($audio_id) {
//                $q->where('audio_id', '=', $audio_id);
//            });
//        }
//        if ($user_id) {
//            $orders = $orders->where('user_id', $user_id);
//        }
//        if ($plan) {
//            $orders = $orders->where('plan', $plan);
//        }
//        if ($staffAssign) {
//            if ($staffAssign == 1) {
//                $orders = $orders->where('estimate_staff', $admin->id);
//            } elseif ($staffAssign == 2) {
//                $orders = $orders->where('edit_staff', $admin->id);
//            } else {
//                $orders = $orders->where('edit_staff', $admin->id)->where('estimate_staff', $admin->id);
//            }
//        }
//        $orders = $orders->whereRaw('CASE WHEN `plan` = 1 THEN `status` != 0 ELSE `status` END')->skip(0)->take(2000)->get();
//        $uniqueid = uniqid();
//        $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.csv';
//        $path = Storage::path('data/' . $filename);
//        $this->writeFormatDownloadToCsv($orders, $path);
//        return response()->json(['success' => true, 'filename' => $filename, 'url' => Storage::url('data/' . $filename)]);
//
//    }

    public function saveMemo(Request $request, $id)
    {
        $order = Order::find($id);
        $order->memo = $request->memo;
        $order->save();
        return redirect('/admin/orders/' . $order->id . '/edit')->with('success', 'メモを保存しました。');
    }

    public function assignEstimate(Request $request, $id)
    {
        $request->validate([
            'estimate_staff' => 'required'
        ], [
            'estimate_staff.required' => '納期確認スタッフ項目は空きです。'
        ]);
        $order = Order::find($id);
        $order->estimate_staff = $request->estimate_staff;
        $order->status = 4;
        $order->save();
        $staffMail = Admin::find($order->estimate_staff)->email;
        \Mail::to($staffMail)->send(new SendMail(['user' => $order->user, 'order' => $order, 'audios' => $order->audios], '【voitra Staff対応】 納品予定日見積りタスクが入りました', 'emails.assign_estimate'));
        return redirect('/admin/orders/' . $order->id . '/edit')->with('success', 'スタッフをアサインしました。');
    }

    public function sendEstimate(Request $request, $id)
    {
        $order = Order::find($id);
        $request->validate([
            'deadline' => 'required'
        ], [
            'deadline.required' => '納期予定日項目は空きです。'
        ]);
        $order->deadline = $request->deadline;
        $order->status = 2;
        $order->save();
        \Mail::to($order->user->email)->send(new SendMail(['user' => $order->user, 'order' => $order->id, 'audios' => $order->audios], '【voitra】ブラッシュアッププラン 納品予定日のお知らせ', 'emails.estimated'));
        return redirect('/admin/orders/' . $order->id . '/edit')->with('success', '納期・見積もりをお客様に送信しました。');
    }

    public function sendAdminEstimate(Request $request, $id)
    {
        $request->validate([
            'deadline' => 'required'
        ], [
            'deadline.required' => '納期予定日項目は空きです。'
        ]);
        $order = Order::find($id);
        $order->deadline = $request->deadline;
        $order->status = 5;
        $order->save();
        \Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $order->user, 'order' => $order, 'audios' => $order->audios], '【voitra 管理者対応】納品予定日確認タスクが入りました', 'emails.confirm_estimate'));
        return redirect('/admin/orders/' . $order->id . '/edit')->with('success', '管理者に送信しました。');
    }

    public function assignEdit(Request $request, $id)
    {
        $request->validate([
            'edit_staff' => 'required'
        ], [
            'edit_staff.required' => '編集スタッフ項目は空きです。',
        ]);
        $order = Order::find($id);
        $order->edit_staff = $request->edit_staff;
        $order->status = 11;
        $order->save();
        $staffMail = Admin::find($order->edit_staff)->email;
        \Mail::to($staffMail)->send(new SendMail(['user' => $order->user, 'order' => $order, 'audios' => $order->audios], '【voitra Staff対応】 編集タスクが入りました', 'emails.assign_edit'));
        return redirect('/admin/orders/' . $order->id . '/edit')->with('success', 'スタッフをアサインしました。');
    }

    public function sendAdminEdit(Request $request, $id)
    {
        $order = Order::find($id);
        $audios = $order->audios;
        foreach ($audios as $audio) {
            if (!$audio->edited_result || trim($audio->edited_result) == '' || trim($audio->edited_result) == '[]') {
                Session::flash('message', 'ブラッシュアップ結果は空きです。');
                return redirect()->back();
            }
        }
        $order->status = 12;
        $order->save();
        \Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $order->user, 'order' => $order, 'audios' => $order->audios], '【voitra 管理者対応】編集結果確認タスクが入りました', 'emails.confirm_edit'));
        return redirect('/admin/orders/' . $order->id . '/edit')->with('success', '管理者に送信しました。');
    }

    public function sendEdit(Request $request, $id)
    {
        $order = Order::find($id);
        $audios = $order->audios;
        foreach ($audios as $audio) {
            if (!$audio->edited_result || trim($audio->edited_result) == '' || trim($audio->edited_result) == '[]') {
                Session::flash('message', 'ブラッシュアップ結果は空きです。');
                return redirect()->back();
            }
        }
        $order->status = 6;
        $order->save();
        \Mail::to($order->user->email)->send(new SendMail(['order' => $order], '【voitra】ブラッシュアッププラン ブラッシュアップ完了', 'emails.plan_2_result'));
        return redirect('/admin/orders/' . $order->id . '/edit')->with('success', 'ブラッシュアップ結果をお客様に送信しました。');
    }

    public function markAllAsRead(Request $request)
    {
        auth()->guard('admin')->user()->unreadNotifications->markAsRead();

        return response()->noContent();
    }

    public function markAsRead(Request $request)
    {
        auth()
            ->guard('admin')->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->json([
            'success' => true
        ]);
    }

    public function ajaxMarkAsRead(Request $request)
    {
        auth()
            ->guard('admin')->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->json([
            'unread_left' => auth()->guard('admin')->user()->unreadNotifications()->count(),
            'success' => true
        ]);
    }

    public function ajaxMarkContactAsRead(Request $request)
    {
        auth()
            ->guard('admin')->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('reference_id', $request->input('id'));
            })
            ->markAsRead();

        return response()->json([
            'success' => true
        ]);
    }
}
