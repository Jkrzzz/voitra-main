<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\SettingParam;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index(Request $request) {
        $serviceType = $request->serviceType;
        $serviceTypeConst = [
            1 => 'AI文字起こしプラン',
            2 => 'ブラッシュアッププラン',
            3 => '話者分離オプション'
        ];
        $paymentHistories = PaymentHistory::with('user');
        if ($serviceType){
            $paymentHistories = $paymentHistories->where('title', 'like', $serviceTypeConst[$serviceType] . '%' );
        }
        $paymentHistories = $paymentHistories->orderBy('created_at', 'DESC')->paginate(10)->appends($request->only('serviceType'));
        foreach ($paymentHistories as $key => $paymentHistory){
            if ($paymentHistory->type == 1) {
                $order = Order::find($paymentHistory->payment_id);
                $paymentHistory->service_type = $order->plan;
            } else {
                $paymentHistory->service_type = 3;
            }
        }
        if (count($request->query())) {
            $downloadUrl = str_replace('?', '/download?', $request->getRequestUri());
        } else {
            $downloadUrl = '/admin/payments/download';
        }
        return view('admin.payment.index', [
            'paymentHistories' => $paymentHistories,
            'serviceTypeConst' => $serviceTypeConst,
            'serviceType' => $serviceType,
            'downloadUrl' => $downloadUrl
        ]);

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
    public function writeFormatDownloadToCsv($payments, $path)
    {
        $serviceTypeConst = [
            1 => 'AI文字起こしプラン',
            2 => 'ブラッシュアッププラン',
            3 => '話者分離オプション'
        ];
        $csv = fopen($path, 'w');
        fputcsv($csv, [
            mb_convert_encoding('決済ID', "SJIS-win", "UTF-8"),
            mb_convert_encoding('申し込みID', "SJIS-win", "UTF-8"),
            mb_convert_encoding('顧客名', "SJIS-win", "UTF-8"),
            mb_convert_encoding('決済金額', "SJIS-win", "UTF-8"),
            mb_convert_encoding('決済項目', "SJIS-win", "UTF-8"),
            mb_convert_encoding('決済時間', "SJIS-win", "UTF-8"),
        ], ",", '"');
        if (!is_null($payments)) {
            foreach ($payments as $payment) {
                fputcsv($csv, [
                    mb_convert_encoding($payment->id, "SJIS-win", "UTF-8"),
                    mb_convert_encoding($payment->type == 1 ? $payment->payment_id : '', "SJIS-win", "UTF-8"),
                    mb_convert_encoding(@$payment->user->name, "SJIS-win", "UTF-8"),
                    mb_convert_encoding($payment->total_price, "SJIS-win", "UTF-8"),
                    mb_convert_encoding(@$serviceTypeConst[$payment->service_type], "SJIS-win", "UTF-8"),
                    mb_convert_encoding($payment->created_at, "SJIS-win", "UTF-8"),
                ], ",", '"');
            }
        }
        fclose($csv);
    }
    public function download(Request $request) {
        $serviceType = $request->serviceType;
        $serviceTypeConst = [
            1 => 'AI文字起こしプラン',
            2 => 'ブラッシュアッププラン',
            3 => '話者分離オプション'
        ];
        $paymentHistories = PaymentHistory::with('user');
        if ($serviceType){
            $paymentHistories = $paymentHistories->where('title', 'like', $serviceTypeConst[$serviceType] . '%' );
        }
        $paymentHistories = $paymentHistories->orderBy('created_at', 'DESC')->skip(0)->take(2000)->get();
        foreach ($paymentHistories as $key => $paymentHistory){
            if ($paymentHistory->type == 1) {
                $order = Order::find($paymentHistory->payment_id);
                $paymentHistory->service_type = $order->plan;
            } else {
                $paymentHistory->service_type = 3;
            }

        }
        $uniqueid = uniqid();
        $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.csv';
        $path = Storage::path('data/' . $filename);
        $this->writeFormatDownloadToCsv($paymentHistories, $path);
        return response()->json(['success' => true, 'filename' => $filename, 'url' => Storage::url('data/' . $filename)]);
    }

    public function cancelOrder($id, Request $request)
    {
        $orders = Order::where('payment_id', $id)->get();
        $user = User::find(Auth::id());
        foreach ($orders as $order) {
            $request_data = new \ScoreatpayCancelRequestDto();
            $request_data->setOrderId($order->payment_id);
            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
            \Log::info($response_data);
        }
        return 'success';
    }
}
