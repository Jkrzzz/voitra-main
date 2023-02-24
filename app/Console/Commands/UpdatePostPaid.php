<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Http\Controllers\User\PaymentController;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\RecognitionService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\SendMail;
use App\Models\Coupon;
use App\Models\User;
use App\Models\PaymentHistory;
use phpDocumentor\Reflection\Types\Null_;

require_once app_path() . '/Vendors/tgMdk/3GPSMDK.php';

class UpdatePostPaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:postpaid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(RecognitionService $regservice)
    {
        $orders = Order::where('payment_status', PAYMENT_HOLD)->get();
        $postpaidErrorStatus = Config::get('const.postpaidErrorStatus');

        foreach ($orders as $order) {
            $request_data = new \ScoreatpayConfirmRequestDto();
            $request_data->setOrderId($order->payment_id);
            $delivery_id = DELIVERY_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($order->id, 3, "0", STR_PAD_LEFT);
            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
            $user = User::find($order->user_id);

            $type = ORDER_TYPE;
            if ($order->plan == 1) {
                if ($order->service_id) {
                    $type = ORDER_SERVICE_TYPE;
                }
            } else if ($order->plan == 2) {
                $type = BRUSHUP_TYPE;
            }
            $coupon = null;
            $service = null;
            if ($order->coupon_id) {
                $coupon = Coupon::find($order->coupon_id);
            }
            if (ORDER_SERVICE_TYPE == $type) {
                $service = DB::table('services')->where('id', $order->service_id)->first();;
            }
            $total_price = PaymentController::getTotalPrice($type, PAYMENT_POSTPAID, $order, $coupon, $service);

            $result_order_id = $response_data->getOrderId();
            $txn_status = $response_data->getMStatus();
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();
            $audios_id = array();

            $status = $response_data->getAuthorResult();

            if ($status == 'NG') {
                foreach ($order->audios as $audio) {
                    $rel = $order->audios()->find($audio->id);
                    $rel->pivot->status = ORDER_CANCEL;
                    $rel->pivot->save();
                }
                if ($order->plan == 2) {
                    $order->status = BRUSHUP_ERROR;
                } else {
                    $order->status = ORDER_CANCEL;
                }
                $order->payment_status = 1;
                if ($type == ORDER_SERVICE_TYPE) {
                    DB::table('user_services')->where('user_id', $order->user_id)->update(['status' => SERVICE_CANCEL, 'payment_status' => PAYMENT_NG]);
                }
                Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
                Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
            } else if ($status == 'HR') {
                try {
                    foreach ($order->audios as $audio) {
                        $rel = $order->audios()->find($audio->id);
                        $rel->pivot->status = ORDER_RESERVE;
                        $rel->pivot->save();
                    }
                    $reasons = $response_data->getHoldReasons();
                    // $reason =  $ddd[rand(1, 35)];
                    if (count($reasons) > 0) {
                        $reason = $reasons[0]->getReasonCode();
                        $order->payment_description = isset($postpaidErrorStatus[$reason]) ? $postpaidErrorStatus[$reason] : $reasons[0]->getReason();
                    }
                    $order->payment_status = PAYMENT_RESERVE;
                    if ($order->plan !== 2) {
                        $order->status = ORDER_RESERVE;
                    }
                    if ($type == ORDER_SERVICE_TYPE) {
                        DB::table('user_services')->where('user_id', $order->user_id)->update(['status' => SERVICE_RESERVE, 'payment_status' => PAYMENT_RESERVE]);
                    }
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type, 'reason' => $reason, 'payment_description' => $order->payment_description], '【voitra】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type, 'reason' => $reason, 'payment_description' => $order->payment_description], '【voitra通知】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold_admin'));
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            } else if ($status == 'OK') {
                $request_data = new \ScoreatpayCaptureRequestDto();
                $request_data->setOrderId($order->payment_id);
                $request_data->setPdCompanyCode(99);
                $request_data->setSlipNo(914712022);
                $request_data->setDeliveryId($delivery_id);
                $transaction = new \TGMDK_Transaction();
                $response_data = $transaction->execute($request_data);

                if ($order->plan == 1) {
                    foreach ($order->audios as $audio) {
                        $token = bin2hex(random_bytes(32));
                        $url = url('/api/webhook/' . $order->id . '/' . $audio->id . '/' . $token);
                        try {
                            $response = $regservice->recognize($audio->id, $audio->url, $audio->language, $audio->pivot->diarization, $audio->pivot->num_speaker, $url, 0);
                            if ($response->success) {
                                $audio->token = $token;
                                $audio->save();
                                $rel = $order->audios()->find($audio->id);
                                $rel->pivot->status = ORDER_PROCESSING;
                                $rel->pivot->save();
                            } else {
                                $rel = $order->audios()->find($audio->id);
                                $rel->pivot->status = ORDER_ERROR;
                                $rel->pivot->save();
                                Log::error($response);
                            }
                            array_push($audios_id, $audio->id);
                        } catch (\Exception $e) {
                            $audio->token = $token;
                            $audio->save();
                            $rel = $order->audios()->find($audio->id);
                            $rel->pivot->status = ORDER_ERROR;
                            $rel->pivot->save();
                            Log::error($e->getMessage());
                        }
                    }
                    if ($order->coupon_id) {
                        $coupon = Coupon::find($order->coupon_id);
                        if ($coupon) {
                            $coupon->status = $coupon->used_quantity + 1;
                            $coupon->save();
                        }
                    }
                    $order->status = ORDER_PROCESSING;
                } else {
                    foreach ($order->audios as $audio) {
                        $audio->edited_result = $audio->api_result;
                        $audio->save();
                        array_push($audios_id, $audio->id);
                    }
                }
                $order->payment_status = PAYMENT_VERIFIED;
                Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
                Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
                if ($type == ORDER_SERVICE_TYPE) {
                    $services = DB::table('user_services')->where('user_id', $order->user_id)->update(['status' => 1, 'payment_status' => PAYMENT_VERIFIED]);
                    $title = 'AI文字起こしプラン（' . join(", ", $audios_id) .  '）';
                    $order->status = 1;
                    $history = PaymentHistory::create([
                        'title' => $title,
                        'user_id' => $order->user_id,
                        'payment_id' => $order->id,
                        'payment_type' => PAYMENT_POSTPAID,
                        'total_price' => $order->total_price + VOITRA_POSTPAID_FEE + 300,
                        'type' => 1,
                        'service_id' => $order->service,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                } else if ($type == BRUSHUP_TYPE) {
                    $title = 'ブラッシュアッププラン（' . join(", ", $audios_id) .  '）';
                    $order->status = BRUSHUP_PAID;
                    $history = PaymentHistory::create([
                        'title' => $title,
                        'user_id' => $order->user_id,
                        'payment_id' => $order->id,
                        'payment_type' => PAYMENT_POSTPAID,
                        'total_price' => $order->total_price + VOITRA_POSTPAID_FEE,
                        'payid' => $order->payid,
                        'type' => 1,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order], '【voitra】ブラッシュアッププラン  お申し込み完了', 'emails.plan_2_success'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $order], '【voitra 対応】ブラッシュアッププラン お申し込みが入りました', 'emails.send_admin_payment_plan_2_success'));
                } else {
                    $title = 'AI文字起こしプラン（' . join(", ", $audios_id) .  '）';
                    $order->status = 1;
                    $history = PaymentHistory::create([
                        'title' => $title,
                        'user_id' => $order->user_id,
                        'payment_id' => $order->id,
                        'payment_type' => 2,
                        'total_price' => $order->total_price + VOITRA_POSTPAID_FEE,
                        'type' => 1,
                        'payid' =>  $order->payid,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order], '【voitra】AI文字起こしプラン お申し込み完了', 'emails.order_done'));
                }
            }
            $order->save();
            Log::info($response_data);
        }

        $services = DB::table('user_services')->where('payment_status', PAYMENT_HOLD)->get();
        foreach ($services as $service) {
            try {
                if (!$service->order_id) {
                    $request_data = new \ScoreatpayConfirmRequestDto();
                    $request_data->setOrderId($service->payment_id);

                    $transaction = new \TGMDK_Transaction();
                    $response_data = $transaction->execute($request_data);
                    $delivery_id = 'VOITRASV' . strval(rand(100, 999)) . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT);

                    $user = User::find($service->user_id);

                    $result_order_id = $response_data->getOrderId();
                    $txn_status =  $response_data->getMStatus();
                    $txn_result_code = $response_data->getVResultCode();
                    $error_message = $response_data->getMerrMsg();
                    $status = $response_data->getAuthorResult();

                    if ($status == 'NG') {
                        // $order->status = 7;
                        // $order->payment_status = 1;
                        DB::table('user_services')->where('id', $service->id)->update(['status' => SERVICE_CANCEL, 'payment_status' => PAYMENT_NG]);
                        Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => 3], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
                        Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => 3], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
                    } else if ($status == 'HR') {
                        try {
                            $reasons = $response_data->getHoldReasons();
                            $payment_description = '';
                            $reason = '';
                            if (count($reasons) > 0) {
                                $reason = $reasons[0]->getReasonCode();
                                $payment_description = isset($postpaidErrorStatus[$reason]) ? $postpaidErrorStatus[$reason] : $reasons[0]->getReason();
                            }
                            $type = 3;
                            DB::table('user_services')->where('id', $service->id)->update(['status' => 9, 'payment_status' => 5, 'payment_description' => $payment_description]);
                            Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => $type, 'reason' => $reason, 'payment_description' => $payment_description], '【voitra】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold'));
                            Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => $type, 'reason' => $reason, 'payment_description' => $payment_description], '【voitra通知】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold_admin'));
                        } catch (\Exception $e) {
                            Log::info($e->getMessage());
                        }
                    } else if ($status == 'OK') {
                        $service_tbl = DB::table('services')->where('id', $service->service_id)->first();

                        $request_data = new \ScoreatpayCaptureRequestDto();
                        $request_data->setOrderId($service->payment_id);
                        $request_data->setPdCompanyCode(99);
                        $request_data->setSlipNo(914712022);
                        $request_data->setDeliveryId($delivery_id);
                        $transaction = new \TGMDK_Transaction();
                        $response_data = $transaction->execute($request_data);

                        $history = PaymentHistory::create([
                            'title' => $service_tbl->name,
                            'user_id' => $service->user_id,
                            'payment_id' => $service->id,
                            'payment_type' => 2,
                            'total_price' => $service_tbl->price + VOITRA_POSTPAID_FEE,
                            'type' => 2,
                            // 'payid' => $request->address_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                          ]);
                        DB::table('user_services')->where('id', $service->id)->update(['status' => 1, 'payment_status' => PAYMENT_VERIFIED]);
                        Mail::to($user->email)->send(new SendMail([
                            'user' => $user,
                            'type' => 3
                        ], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
                        Mail::to(config('mail.admin_email'))->send(new SendMail([
                            'user' => $user, 'type' => 3
                        ], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
                        Mail::to($user->email)->send(new SendMail([
                            'user' => $user,
                            'option' => $service_tbl->name
                        ], '【voitra】' . $service_tbl->name . 'お申し込み手続きの完了通知', 'emails.register_option_success'));
                    }
                    // $order->save();
                    Log::info($response_data);
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                // dd($e->getMessage());
            }
        }

        return 0;
    }
}
