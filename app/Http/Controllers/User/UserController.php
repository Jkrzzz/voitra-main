<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\PaymentController;
use App\Mail\ChangePasswordSuccessMail;
use App\Http\Services\SendMail;
use App\Mail\RegisterVerifyMail;
use App\Mail\RemoveMemberAdminMail;
use App\Mail\RemoveMemberMail;
use App\Mail\SendAdminContact;
use App\Mail\SendContactMail;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use FFMpeg\Format\Audio\Flac;
use Google\Cloud\Speech\V1\SpeechClient;
use GPBMetadata\Google\Cloud\Speech\V1\CloudSpeech;
use Illuminate\Http\Request;
use App\Http\Services\RecognitionService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Audio;
use App\Models\UserAddress;
use App\Models\PaymentHistory;
use App\Models\SettingParam;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Traits\NotificationTrait;

class UserController extends Controller
{
    use NotificationTrait;

    function __construct()
    {
        $this->order_status = Config::get('const', 'default');
    }

    public function index()
    {
        return view('user.index');
    }

    public function upload()
    {
        $trail = SettingParam::where('key', 'diarization_trail')->first();
        return view('user.upload_audio', ['trail' => $trail]);
    }

    public function uploadAudio()
    {
        return view('user.upload.upload');
    }

    public function uploadDetail(Request $request)
    {
        $order_id = $request->query('order_id');
        $orderInfo = Order::findOrFail($order_id);
        $trail = SettingParam::where('key', 'diarization_trail')->first();
        return view('user.upload.upload', ['data' => $orderInfo, 'order_id' => $order_id, 'trail' => $trail]);
    }

    public function getCardDefault($cardInfos, $card_id)
    {
        if (count($cardInfos) == 1) {
            $cardInfo = $cardInfos[0];
            return $cardInfo;
        }
        foreach ((array)$cardInfos as $cardInfo) {
            if (!is_null($card_id) && $card_id == $cardInfo->getCardId()) {
                return $cardInfo;
            } else if (is_null($card_id) && $cardInfo->getDefaultCard() == 1) {
                return $cardInfo;
            }
        }
        return null;
    }

    public function uploadWithService(Request $request)
    {
        $order_id = $request->query('order_id');
        $trail = SettingParam::where('key', 'diarization_trail')->first();
        $orderInfo = Order::findOrFail($order_id);
        $payment_method = $request->method;
        $paynowOption = true;
        if ($payment_method == 2) {
            return view('user.upload.upload', ['data' => $orderInfo, 'order_id' => $order_id, 'trail' => $trail, 'paynowOption' => $paynowOption]);
        } else {
            $service = Service::all()->first();
            $datefrom = Carbon::now();
            $dateto = Carbon::now()->addDays(30);
            $request_data = new \CardInfoGetRequestDto();
            $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);

            $request_data->setAccountId($account_id);
            $card_id = $request->card_id;
            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);

            if (!isset($response_data)) {
                return view('user.payment.service_paynow', [
                    'api_token' => config('veritrans.api_token'),
                    'api_url' => config('veritrans.api_url'),
                    'order_id' => $order_id,
                    'payment_id' => TARGET_GROUP_ID . '_' . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . '_' . str_pad($service->id, 3, "0", STR_PAD_LEFT)
                ]);
            } else {
                $txn_result_code = $response_data->getVResultCode();
                $error_message = $response_data->getMerrMsg();
                $pay_now_id_res = $response_data->getPayNowIdResponse();

                if (isset($pay_now_id_res)) {
                    $account = $pay_now_id_res->getAccount();

                    if (isset($account)) {
                        $cardInfos = $account->getCardInfo();
                        if ($cardInfos) {
                            $defaultCard = $this->getCardDefault($cardInfos, $card_id);
                            if ($defaultCard) {
                                return view('user.payment.service_confirm', [
                                    'date_from' => $datefrom->format('Y年m月d日'),
                                    'date_to' => $dateto->format('Y年m月d日'),
                                    'service' => $service,
                                    'token' => $defaultCard->getCardId(),
                                    'card_number' => $defaultCard->getCardNumber(),
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    'card_expire' => $defaultCard->getCardExpire(),
                                    'order_id' => $order_id,
                                    'card_id' => $defaultCard->getCardId()
                                ]);
                            }
                        }
                    }
                }
            }
            return view('user.payment.service_paynow', [
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'order_id' => $order_id,
                'payment_id' => TARGET_GROUP_ID . '_' . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . '_' . str_pad($service->id, 3, "0", STR_PAD_LEFT)
            ]);
        }
    }

    public function order(Request $request)
    {
        $price = 30;
        $order_id = $request->query('order_id');
        $paynowOption = $request->query('paynow_option');
        $couponCode = $request->coupon_code;
        $isUseCoupon = $request->has('coupon_code');
        $coupon = Coupon::with('orders')->where(DB::raw('BINARY `code`'), $couponCode)->where('status', 1)->where('start_at', '<=', date('Y-m-d'))->first();
        if ($isUseCoupon && $coupon && isset($coupon->quantity) && $coupon->used_quantity >= $coupon->quantity) {
            $coupon = null;
        }
        if ($isUseCoupon && $coupon && $coupon->is_limited && count($coupon->orders) > 0) {
            foreach ($coupon->orders as $ordered) {
                if ($ordered->user_id == Auth::id()) {
                    $coupon = null;
                    break;
                }
            }
        }
        $orderInfo = Order::findOrFail($order_id);
        $total_time = 0;
        $total_price = 0;
        foreach ($orderInfo->audios as $audio) {
            $time = 0;
            $total_time += $audio->duration;
            $total_price += ceil($audio->duration / 60 * $price);
            if ($audio->pivot->diarization) {
                if ($audio->pivot->num_speaker > 0) {
                    $estimated_processing_time = 0.2699 * $audio->duration - 0.2044	;
                } else {
                    $estimated_processing_time =  0.232 * $audio->duration + 0.5065;
                }
            } else {
                $estimated_processing_time = $audio->duration * 0.1908  - 1.1848;
            }
            $audio->pivot->estimated_processing_time = $estimated_processing_time;
            $audio->pivot->save();
        }
        $orderInfo->total_time = $total_time;
        $orderInfo->total_price = $total_price;
        Order::where('id', $order_id)->update(['total_time' => $total_time, 'total_price' => $total_price]);
        $discountedMoneyTotal = null;
        if ($isUseCoupon) {
            $discountedMoneyTotal = $this->getDiscountedTotal($coupon, $orderInfo->total_price);
        }
        if ($paynowOption) {
            $service = Service::all()->first();
            $datefrom = Carbon::now();
            $dateto = Carbon::now()->addDays(30);
            return view('user.upload.orderservice', [
                'paynowOption' => $paynowOption,
                'data' => $orderInfo,
                'service' => $service,
                'date_from' => $datefrom->format('Y年m月d日'),
                'date_to' => $dateto->format('Y年m月d日'),
                'isUseCoupon' => $isUseCoupon,
                'coupon' => $coupon,
                'discountedMoneyTotal' => $discountedMoneyTotal
            ]);
        } else {
            return view('user.upload.order', [
                'data' => $orderInfo,
                'isUseCoupon' => $isUseCoupon,
                'coupon' => $coupon,
                'paynowOption' => $paynowOption,
                'discountedMoneyTotal' => $discountedMoneyTotal
            ]);
        }
    }

    public function payment(Request $request)
    {
        $order_id = $request->order_id;
        $orderInfo = Order::findOrFail($order_id);
        $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));

        return view('user.upload.payment', [
            'order_id' => $orderInfo->id,
            'api_token' => config('veritrans.api_token'),
            'api_url' => config('veritrans.api_url'),
            'payment_id' => $payment_id
        ]);
    }

    public function confirm(Request $request)
    {
        $order_id = $request->order_id;
        $token = $request->token;
        $req_card_number = $request->req_card_number;
        $username = $request->username;
        $expdate = $request->expdate;
        $payment_id = $request->payment_id;
        $orderInfo = Order::findOrFail($order_id);
        $coupon = Coupon::find($request->coupon_id);
        $discountedMoneyTotal = $this->getDiscountedTotal($coupon, $orderInfo->total_price);
        return view('user.upload.confirm', [
            'data' => $orderInfo,
            'token' => $token,
            'req_card_number' => $req_card_number,
            'username' => $username,
            'expdate' => $expdate,
            'payment_id' => $payment_id,
            'coupon' => $coupon,
            'discountedMoneyTotal' => $discountedMoneyTotal
        ]);
    }

    public function complete(Request $request, RecognitionService $regservice)
    {
        // DB::beginTransaction();
        $order_id = $request->order_id;
        $orderInfo = Order::findOrFail($order_id);
        $withService = $request->withService;
        $coupon = Coupon::find($request->coupon_id);
        $history = PaymentHistory::where('payment_id', $order_id)->first();
        $orderInfo = Order::find($order_id);
        $user = User::find(Auth::id());
        $audios_id = array();

        if ($history) {
            return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
        }
        $paymentMethod = $request->method ?  $request->method : 1;
        $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
        $total_price = PaymentController::getTotalPrice(ORDER_TYPE, $paymentMethod, $orderInfo, $coupon, null);
        if ($total_price == 0) {
            foreach ($orderInfo->audios as $audio) {
                $token = bin2hex(random_bytes(32));
                $url = url('/api/webhook/' . $orderInfo->id . '/' . $audio->id . '/' . $token);
                try {
                    $response = $regservice->recognize($audio->id, $audio->url, $audio->language, $audio->pivot->diarization, $audio->pivot->num_speaker, $url, 0);
                    if ($response->success) {
                        $audio->token = $token;
                        $audio->save();
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = 1;
                        $rel->pivot->save();
                    } else {
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = 3;
                        $rel->pivot->save();
                    }
                    array_push($audios_id, $audio->id);
                } catch (\Exception $e) {
                    $audio->token = $token;
                    $audio->save();
                    $rel = $orderInfo->audios()->find($audio->id);
                    $rel->pivot->status = 3;
                    $rel->pivot->save();
                    Log::error($e->getMessage());
                }
            }
            $title = $orderInfo->plan == 1 ? 'AI文字起こしプラン（' . join(", ", $audios_id) .  '）' : 'ブラッシュアッププラン（' . join(", ", $audios_id) .  '）';
            $history = PaymentHistory::create([
                'title' => $title,
                'user_id' => Auth::id(),
                'payment_id' => $order_id,
                'payment_type' => $paymentMethod,
                'total_price' => $total_price,
                'type' => 1,
                'payid' => $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            if ($coupon) {
                $orderInfo->coupon_id = $coupon->id;
                $coupon->used_quantity = $coupon->used_quantity + 1;
                $coupon->save();
            }
            $orderInfo->payment_id = $payment_id;
            $orderInfo->payment_type = $paymentMethod;
            $orderInfo->payment_status = $paymentMethod == PAYMENT_CREDIT ? PAYMENT_DONE : PAYMENT_VERIFIED;
            $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
            $orderInfo->status = ORDER_PROCESSING;
            $orderInfo->save();
            Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】AI文字起こしプラン お申し込み完了', 'emails.order_done'));

            // DB::commit();
            return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
        }

        if ($paymentMethod == PAYMENT_POSTPAID) {
            $address = UserAddress::findOrFail($request->address_id);

            $request_data = $request->fix ? new \ScoreatpayCorrectAuthRequestDto() : new \ScoreatpayAuthorizeRequestDto();
            $buyerContact = new \ScoreatpayContactDto();
            $delivery = new \ScoreatpayDeliveryDto();
            $detail1 = new \ScoreatpayDetailDto();
            $detail2 = new \ScoreatpayDetailDto();

            $buyerContact->setFullName($address->full_name);
            $buyerContact->getFullKanaName($address->full_kana_name);
            $buyerContact->setTel($address->tel);
            $buyerContact->setMobile($address->mobile);
            $buyerContact->setEmail($address->email);
            $buyerContact->setZipCode($address->zipcode);
            $buyerContact->setAddress1($address->address1);
            $buyerContact->setAddress2($address->address2);
            $buyerContact->setAddress3($address->address3);
            $buyerContact->setCompanyName($address->company_name);
            $buyerContact->setDepartmentName($address->department_name);

            $detail1->setDetailName('ORDER' . $order_id);
            $detail1->setDetailPrice($total_price);
            $detail1->setDetailQuantity(1);

            $delivery->setDeliveryId(DELIVERY_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 3, "0", STR_PAD_LEFT));
            $delivery->setContact($buyerContact);
            $delivery->setDetails([$detail1, $detail2]);

            $request_data->setOrderId($payment_id);
            $request_data->setAmount($total_price);
            $request_data->setAccountId($request->account_id);
            $request_data->setPaymentType(2);
            $request_data->setBuyerContact($buyerContact);
            $request_data->setShopOrderDate(Carbon::now()->format('Y/m/d'));
            $request_data->setDelivery($delivery);

            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
        } else {
            $request_data = new \CardAuthorizeRequestDto();
            $request_data->setToken($request->token);
            $request_data->setOrderId($payment_id);
            $request_data->setAmount($total_price);
            $request_data->setAccountId($request->account_id);
            $request_data->setCardId($request->card_id);
            $request_data->setDefaultCard(0);
            $request_data->setWithCapture(true);

            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
        }

        if (isset($response_data)) {

            $result_order_id = $response_data->getOrderId();
            $txn_status = 'pending';
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();
            if (TXN_SUCCESS_CODE === $txn_status || TXN_PENDING_CODE === $txn_status) {

                if ($paymentMethod == PAYMENT_POSTPAID) {
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 1], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 1], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
                } else {
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】AI文字起こしプラン お申し込み完了', 'emails.order_done'));
                }
                foreach ($orderInfo->audios as $audio) {
                    $token = bin2hex(random_bytes(32));
                    $url = url('/api/webhook/' . $orderInfo->id . '/' . $audio->id . '/' . $token);
                    try {
                        $response = $regservice->recognize($audio->id, $audio->url, $audio->language, $audio->pivot->diarization, $audio->pivot->num_speaker, $url, 0);
                        if ($response->success) {
                            $audio->token = $token;
                            $audio->save();
                            $rel = $orderInfo->audios()->find($audio->id);
                            $rel->pivot->status = 1;
                            $rel->pivot->save();
                        } else {
                            $rel = $orderInfo->audios()->find($audio->id);
                            $rel->pivot->status = 3;
                            $rel->pivot->save();
                        }
                        array_push($audios_id, $audio->id);
                    } catch (\Exception $e) {
                        $audio->token = $token;
                        $audio->save();
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = 3;
                        $rel->pivot->save();
                        Log::error($e->getMessage());
                    }
                }
                $title = $orderInfo->plan == 1 ? 'AI文字起こしプラン（' . join(", ", $audios_id) .  '）' : 'ブラッシュアッププラン（' . join(", ", $audios_id) .  '）';
                $history = PaymentHistory::create([
                    'title' => $title,
                    'user_id' => Auth::id(),
                    'payment_id' => $order_id,
                    'payment_type' => $paymentMethod,
                    'total_price' => $total_price,
                    'type' => 1,
                    'payid' => $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                if ($coupon) {
                    $orderInfo->coupon_id = $coupon->id;
                    $coupon->used_quantity = $coupon->used_quantity + 1;
                    $coupon->save();
                }
                $orderInfo->payment_id = $payment_id;
                $orderInfo->payment_type = $paymentMethod;
                $orderInfo->payment_status = $paymentMethod == PAYMENT_CREDIT ? PAYMENT_DONE : PAYMENT_VERIFIED;
                $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                $orderInfo->status = ORDER_PROCESSING;
                $orderInfo->save();
                // dd("AAAAAAAAAAAAAAA");
                // DB::commit();
                return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
            } else {
                // dd($response_data);
                Log::error($response_data);
                foreach ($orderInfo->audios as $audio) {
                    $rel = $orderInfo->audios()->find($audio->id);
                    $rel->pivot->status = ORDER_DISABLE;
                    $rel->pivot->save();
                }
                $orderInfo->payment_id = $payment_id;
                $orderInfo->payment_type = $paymentMethod;
                $orderInfo->payment_status = PAYMENT_NG;
                $orderInfo->payment_description = 2;
                $orderInfo->status = 7;
                $orderInfo->save();
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 1], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 1], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
                    return view('user.payment.complete_ng', ['success' => false, 'order' => $orderInfo, 'merrMsg' => $error_message, 'type' => ORDER_TYPE]);
                }
                return view('user.payment.payment', [
                    'error' => true,
                    'order_id' => $orderInfo->id,
                    'api_token' => config('veritrans.api_token'),
                    'api_url' => config('veritrans.api_url'),
                    'payment_id' => $payment_id
                ]);
            }
        } else {
            return view('user.payment.payment', [
                'error' => true,
                'order_id' => $orderInfo->id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => $payment_id
            ]);
        }
        dd("OOOOOOOOOOOOO");
        return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
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

    public function audioManager(Request $request)
    {
        $orders = Order::where('user_id', '=', Auth::id())->where('status', '!=', 0)->orderBy('id', 'DESC')->get();
        $audio_p1 = array();
        $audio_p2 = array();
        foreach ($orders as $order) {
            if ($order->plan == 1) {
                foreach ($order->audios as $audio) {
                    if (!($audio->orders()->where('plan', 2)->where('orders.status', '!=', 0)->first()) && $order->audios()->find($audio->id)->pivot->status != 4) {
                        $audio->order_status = $order->status;
                        $audio->deadline = $order->deadline;
                        $audio->order_id = $order->id;
                        $audio->status = $order->audios()->find($audio->id)->pivot->status;
                        array_push($audio_p1, $audio);
                        $now = Carbon::now();
                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->addDays(31);
                        $audio->is_deleted = $now > $date;
                        $audio->estimated_processing_time = $order->audios()->find($audio->id)->pivot->estimated_processing_time;
                        $audio->payment_status = $order->payment_status;
                    }
                }
            } else if ($order->plan == 2) {
                foreach ($order->audios as $audio) {
                    if ($order->audios()->find($audio->id)->pivot->status != 4) {
                        $audio->order_status = $order->status;
                        $audio->deadline = $order->deadline;
                        $audio->order_id = $order->id;
                        $audio->expected = $order->audios()->find($audio->id)->pivot->user_estimate;
                        $audio->length = $this->getInfor($audio)['length'];
                        $audio->status = $order->audios()->find($audio->id)->pivot->status;
                        array_push($audio_p2, $audio);
                        $now = Carbon::now();
                        $date = Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->addDays(31);
                        $audio->is_deleted = $now > $date;
                        $audio->payment_status = $order->payment_status;
                    }
                }
            }
        }
        return view('user.audio_manager', ['data' => [
            'audio_p1' => $audio_p1,
            'audio_p2' => $audio_p2
        ]]);
    }

    public function audioView($id)
    {
        $audio = Audio::find($id);
        return view('user.audio.view', ['data' => $audio]);
    }

    public function audioEdit($id)
    {
        $audio = Audio::find($id);
        return view('user.audio.edit', ['data' => $audio]);
    }

    public function removeAudio(Request $request)
    {
        try {
            $audio_id = $request->audio_id;
            $order_id = $request->order_id;
            $order = Order::findOrFail($order_id);
            $audio = Audio::findOrFail($audio_id);
            $size = Storage::size('audios/' . basename($audio->url));
            $order->audios()->detach($audio_id);
            $order->save();
            return response()->json(['error' => 0, 'id' => $audio_id, 'filesize' => $size]);
        } catch (\Exception $e) {
            return response()->json(['error' => 1]);
        }
    }


    public function uploadAudioProcess(Request $request)
    {
        $trail = SettingParam::where('key', 'diarization_trail')->first();
        if ($request->hasFile('files')) {
            $audios = array();
            $userId = Auth::id();
            $files = $request->file('files');
            $languageCode = $request->language;
            try {
                foreach ($files as $file) {
                    $sampleRateHertz = 16000;
                    $uniqueid = uniqid();
                    $extension = $file->getClientOriginalExtension();
                    $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
                    $file->storeAs('audios', $filename);
                    $audioPath = Storage::disk('local')->path('audios/' . $filename);
                    $ffmpeg = FFMpeg::create([
                        'ffmpeg.binaries' => 'C:\ffmpeg\bin\ffmpeg.exe',
                        'ffprobe.binaries' => 'C:\ffmpeg\bin\ffprobe.exe'
                    ]);
                    $name = $file->getClientOriginalName();
                    $audioFormat = $ffmpeg->open($audioPath);
                    $format = new Flac();
                    $format->setAudioKiloBitrate($sampleRateHertz);
                    $format->setAudioChannels(1);
                    $filenameFormat = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.flac';
                    $audioFormatPath = Storage::disk('local')->path('audios/' . $filenameFormat);
                    $audioFormat->save($format, $audioFormatPath);
                    $duration = ceil($ffmpeg->getFFProbe()->format($audioPath)->get('duration'));
                    Storage::delete('audios/' . $filename);
                    $audio = [
                        'language' => $languageCode,
                        'name' => $name,
                        'url' => Storage::url('audios/' . $filenameFormat),
                        'status' => 1,
                        'duration' => $duration,
                        'user_id' => $userId,
                        'price' => ceil($duration / 60 * 30)
                    ];
                    array_push($audios, $audio);
                }
            } catch (\Exception $e) {
                return $e->getMessage();
                return view('user.upload_audio', ['error' => true, 'trail' => $trail]);
            }
            try {
                DB::beginTransaction();
                $orderInfo = Order::create([
                    'plan' => 1,
                    'status' => 0,
                    'user_id' => $userId
                ]);
                $total_price = 0;
                $total_time = 0;
                foreach ($audios as $audio) {
                    $audioInfo = Audio::create($audio);
                    $orderInfo->audios()->attach([$audioInfo->id => ['price' => ceil($audio['price']), 'status' => 1]]);
                    $orderInfo->audios->push($audioInfo->id);
                    $total_price += ceil($audio['price']);
                    $total_time += $audio['duration'];
                }
                $orderInfo->total_price = $total_price;
                $orderInfo->total_time = $total_time;
                $orderInfo->save();
                DB::commit();
                return view('user.upload.upload', ['data' => $orderInfo, 'trail' => $trail]);
            } catch (\Exception $e) {
                DB::rollBack();
                $message = 'Error: ' . $e->getMessage();
                return $message;
            }
        }
    }

    public function addAudio(Request $request)
    {
        if ($request->hasFile('files')) {
            $audios = array();
            $userId = Auth::id();
            $files = $request->file('files');
            $languageCode = $request->language;
            $order_id = $request->order_id;
            try {
                foreach ($files as $file) {
                    $sampleRateHertz = 16000;
                    $uniqueid = uniqid();
                    $extension = $file->getClientOriginalExtension();
                    $filename = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.' . $extension;
                    $file->storeAs('audios', $filename);
                    $audioPath = Storage::disk('local')->path('audios/' . $filename);
                    $ffmpeg = FFMpeg::create([
                        'ffmpeg.binaries' => 'C:\ffmpeg\bin\ffmpeg.exe',
                        'ffprobe.binaries' => 'C:\ffmpeg\bin\ffprobe.exe'
                    ]);
                    $name = $file->getClientOriginalName();
                    $audioFormat = $ffmpeg->open($audioPath);
                    $format = new Flac();
                    $format->setAudioKiloBitrate($sampleRateHertz);
                    $format->setAudioChannels(1);
                    $filenameFormat = Carbon::now()->format('Ymd') . '_' . $uniqueid . '.flac';
                    $audioFormatPath = Storage::disk('local')->path('audios/' . $filenameFormat);
                    $duration = ceil($ffmpeg->getFFProbe()->format($audioPath)->get('duration'));
                    $audioFormat->save($format, $audioFormatPath);
                    Storage::delete('audios/' . $filename);
                    $audio = [
                        'language' => $languageCode,
                        'name' => $name,
                        'url' => Storage::url('audios/' . $filenameFormat),
                        'status' => 1,
                        'duration' => $duration,
                        'user_id' => $userId,
                        'price' => ceil($duration / 60 * 30)
                    ];
                    array_push($audios, $audio);
                }
            } catch (\Exception $e) {
                return $e->getMessage();
                return response()->json(['error' => true, 'data' => $e->getMessage()]);
            }
            try {
                DB::beginTransaction();
                $audioList = array();
                $audioData = array();
                $orderInfo = Order::findOrFail($order_id);

                foreach ($audios as $audio) {
                    $audioInfo = Audio::create($audio);
                    array_push($audioList, $audioInfo->id);
                    array_push($audioData, $audioInfo);
                    $orderInfo->audios()->attach([$audioInfo->id => ['price' => ceil($audio['price']), 'status' => 1]]);
                    $orderInfo->audios->push($audioInfo->id);
                }
                $orderInfo->save();
                $isRegisterOption = DB::table('user_services')->where('user_id', $userId)->where('status', 1)->first() != null;
                DB::commit();
                return response()->json(['data' => $audioData, 'error' => false, 'isRegisterOption' => $isRegisterOption]);
            } catch (\Exception $e) {
                DB::rollBack();
                $message = 'Error: ' . $e->getMessage();
                return response()->json(['error' => true, 'data' => $message]);
            }
        }
    }

    public function uploadAudioOperations($name)
    {
        $speechClient = new SpeechClient();
        CloudSpeech::initOnce();
        $operation = $speechClient->getOperationsClient()->getOperation($name);
        $isDone = $operation->getDone();
        try {
            if (!$isDone) {
                $metaData = json_decode($operation->getMetadata()->serializeToJsonString(), true);
                return response()->json(['isComplete' => false, 'metaData' => $metaData]);
            } else {
                $response = json_decode($operation->getResponse()->serializeToJsonString(), true);
                $words = [];
                foreach ($response['results'] as $result) {
                    $alternatives = $result['alternatives'];
                    $mostLikely = $alternatives[0];
                    $words = array_merge($words, $mostLikely['words']);
                }
                return response()->json(['isComplete' => true, 'words' => $words]);
            }
        } catch (\Exception $e) {
            return response()->json($e, 400);
        }
    }

    public function information()
    {
        $user = User::find(Auth::id());
        $isRegisterService = count(DB::table('user_services')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->get()) >= 1;
        $languageConst = Config::get('const.language');
        $genderConst = Config::get('const.gender');
        $industryConst = Config::get('const.industry');
        return view('user.information.information', ['user' => $user, 'languageConst' => $languageConst, 'genderConst' => $genderConst, 'industryConst' => $industryConst, 'isRegisterService' => $isRegisterService]);
    }

    public function editInformation()
    {
        $user = User::find(Auth::id());
        $languageConst = Config::get('const.language');
        $genderConst = Config::get('const.gender');
        $industryConst = Config::get('const.industry');

        return view('user.information.edit', ['user' => $user, 'languageConst' => $languageConst, 'genderConst' => $genderConst, 'industryConst' => $industryConst]);
    }

    public function editInformationProcess(Request $request)
    {
        $user = User::find(Auth::id());
        if ($user->type == 1) {
            $request->validate([
                'phone_number' => 'nullable|regex:/\A0[0-9]{9,10}\z/',
                'company_phone_number' => 'nullable|regex:/\A0[0-9]{9,10}\z/',
                'company_name' => 'required',
                'name' => 'required',
                'date_of_birth' => 'nullable|date'
            ], [
                'company_name.required' => '入力してください',
                'name.required' => '入力してください',
                'phone_number.regex' => '電話番号の形式が間違っています。',
                'company_phone_number.regex' => '電話番号の形式が間違っています。'
            ]);
        } else {
            $request->validate([
                'phone_number' => 'nullable|regex:/\A0[0-9]{9,10}\z/',
                'company_phone_number' => 'nullable|regex:/\A0[0-9]{9,10}\z/',
                'name' => 'required',
                'date_of_birth' => 'nullable|date'
            ], [
                'name.required' => '入力してください',
                'phone_number.regex' => '電話番号の形式が間違っています。',
                'company_phone_number.regex' => '電話番号の形式が間違っています。'
            ]);
        }

        $user->phone_number = $request->phone_number;
        $user->company_phone_number = $request->company_phone_number;
        $user->furigana_name = $request->furigana_name;
        $user->language = $request->language;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->name = $request->name;
        $user->company_name = $request->company_name;
        $user->industry = $request->industry;
        $user->address = $request->address;
        $user->department = $request->department;

        $user->save();
        return redirect('/info');
    }

    public function changePassword()
    {
        return view('user.information.change_password');
    }

    public function changePasswordProcess(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*#?&]{8,}$/',
            'confirm_password' => 'required|same:new_password',
        ], [
            'current_password.required' => '入力してください。',
            'new_password.required' => '入力してください。',
            'confirm_password.required' => '入力してください。',
            'new_password.regex' => '英数字混合の8文字以上で登録してください。',
            'confirm_password.same' => 'パスワードが一致しません。',
        ]);
        $user = User::find(Auth::id());
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with(['error' => ['現在のパスワードが間違っています。']]);
        }
        $user->password = bcrypt($request->new_password);
        $user->save();
        \Mail::to($user->email)->send(new ChangePasswordSuccessMail($user));
        return redirect('/info');
    }

    public function removeMember()
    {
        return view('user.information.remove_member');
    }

    public function removeService()
    {
        $services = Service::get();
        return view('user.information.survey_service', ['services' => $services]);
    }

    public function removeMemberSurvey()
    {
        return view('user.information.survey');
    }

    public function removeMemberProcess(Request $request)
    {
        $survey = $request->survey;
        $survey_content = $request->survey_content;
        $user = User::find(Auth::id());
        DB::beginTransaction();
        try {
            $audios = Audio::where('user_id', $user->id)->get();
            foreach ($audios as $audio) {
                foreach ($audio->orders as $order) {
                    $audio->orders()->updateExistingPivot($order->id, ['status' => 4]);
                }
                $array = explode('/', $audio->url);
                Storage::delete('audios/' . end($array));
                $audio->url = '';
                $audio->api_result = null;
                $audio->result = null;
                $audio->edited_result = null;
                $audio->save();
            }
            DB::table('user_services')->where('user_id', $user->id)->update(['status' => 0, 'remove_at' => Carbon::now()]);
            $email = $user->email;
            $user->removed_email = $email;
            $user->email = str_pad($user->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999)) . '@voitradump.jp';
            // $user->password = '';
            // $user->phone_number = '';
            // $user->payment_id = null;
            // $user->date_of_birth = null;
            // $user->company_phone_number = null;
            $user->status = 0;
            $user->save();
            $this->broadcastNoticeToAllAdminUsers('membership_canceled', $user->id, $user->name);
            DB::commit();
            Mail::to(config('mail.admin_email'))->send(new RemoveMemberAdminMail($user, $survey, $survey_content));
            Mail::to($email)->send(new RemoveMemberMail($user));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false], 400);
        }
    }

    public function removeServiceProcess(Request $request)
    {
        $survey = $request->survey;
        $survey_content = $request->survey_content;
        $service_id = $request->service_id;
        $user = Auth::user();
        $service = Service::where('id', $service_id)->first();
        try {
            DB::table('user_services')->where('user_id', $user->id)
                ->where('service_id', $service_id)
                ->update([
                    'status' => 0,
                    'remove_at' => Carbon::now()
                ]);

            $this->broadcastNoticeToAllAdminUsers('service_canceled', $user->id, $user->name);

            Mail::to(config('mail.admin_email'))
                ->send(new SendMail([
                    'user' => $user,
                    'survey' => [
                        'survey' => $survey,
                        'survey_content' => $survey_content
                    ]
                ], '【voitra アンケート】オプション解除のアンケート', 'emails.remove_service_admin'));

            Mail::to($user->email)->send(new SendMail([
                'user' => $user,
                'service' => $service
            ], '【voitra】' . $service->name . '解除手続きの完了通知', 'emails.remove_service'));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::error($e);

            return response()->json(['success' => false], 400);
        }
    }

    public function getDiscountedTotal($coupon, $totalPrice)
    {
        if ($coupon) {
            $totalPriceTax = ceil($totalPrice / 1.1);
            return $totalPriceTax > $coupon->discount_amount ? floor(($totalPriceTax - $coupon->discount_amount) * 1.1) : 0;
        }
        return $totalPrice;
    }
}
