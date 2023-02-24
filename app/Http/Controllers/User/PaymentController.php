<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentHistory;
use App\Models\User;
use App\Models\Service;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use CardInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use PhpOption\None;
use App\Http\Services\RecognitionService;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\SendMail;
use Illuminate\Support\Facades\Log;
use App\Models\SettingParam;
use App\Models\UserAddress;
use App\Traits\NotificationTrait;

class PaymentController extends Controller
{
    use NotificationTrait;

    function __construct()
    {
        $this->order_status = Config::get('const', 'default');
    }

    public function paymentHistory()
    {
        $user = User::with('paymentHistories')->find(Auth::id());
        $services = $user->services()->where('status', '!=', '0')->get();
        $paymentHistories = $user->paymentHistories()->orderBy('created_at', 'DESC')->get();
        $paymentTypeConst = Config::get('const.paymentType');
        $trail = SettingParam::where('key', 'diarization_trail')->first();
        $paymentStatus = Config::get('const.paymentStatus');
        $serviceStatus = Config::get('const.serviceStatus');
        $servicePaymentStatus = Config::get('const.servicePaymentStatus');

        return view('user.payment.payment_history', [
            'user' => $user,
            'services' => $services,
            'paymentHistories' => $paymentHistories,
            'paymentTypeConst' => $paymentTypeConst,
            'trail' => $trail,
            'paymentStatus' => $paymentStatus,
            'serviceStatus' => $serviceStatus,
            'servicePaymentStatus' => $servicePaymentStatus
        ]);
    }

    public function paymentHistoryDetail($id)
    {
        $user = User::with('paymentHistories')->find(Auth::id());
        $paymentHistory = PaymentHistory::find($id);
        $listItems = [];
        $order = Order::find($paymentHistory->payment_id);
        $totalLength = 0;
        $totalDuration = 0;
        $payment_info = null;
        if ($paymentHistory->payment_type == 2) {
            $payment_info = UserAddress::find($paymentHistory->payid);
        } else {
            $payment_info = $paymentHistory->payid;
        }

        $coupon = null;
        if ($paymentHistory->type == 2) {
            $paymentHistory->end_date =  Carbon::create($paymentHistory->created_at->toDateTimeString())->addDays(30)->format('Y/m/d');
            $listItems[] = $paymentHistory;
        } else {
            if ($paymentHistory->service_id) {
                $paymentHistory->end_date =  Carbon::create($paymentHistory->created_at->toDateTimeString())->addDays(30)->format('Y/m/d');
            }
            $audios = $order->audios;
            foreach ($audios as $audio) {
                $data = $this->getInfor($audio);
                $listItems[] = [
                    'name' => $audio->name,
                    'duration' => $audio->duration,
                    'price' => $audio->pivot->price,
                    'plan' => $order->plan,
                    'length' => $data['length'],
                ];
                $totalLength += $data['length'];
                $totalDuration += $audio->duration;
            }
            $coupon = Coupon::find($order->coupon_id);
        }
        $paymentTypeConst = Config::get('const.paymentType');
        $userType = Config::get('const.userType');
        return view('user.payment.payment_detail', [
            'order' => $order,
            'user' => $user,
            'paymentInfo' => $payment_info,
            'paymentHistory' => $paymentHistory,
            'listItems' => $listItems,
            'paymentTypeConst' => $paymentTypeConst,
            'totalLength' => $totalLength,
            'totalDuration' => $totalDuration,
            'userType' => $userType,
            'coupon' => $coupon
        ]);
    }


    public function invoice($id)
    {
        set_time_limit(210);
        $user = User::with('paymentHistories')->find(Auth::id());
        $paymentHistory = PaymentHistory::find($id);
        $listItems = [];
        $totalLength = 0;
        $totalDuration = 0;
        $payment_info = null;
        $coupon = null;
        if ($paymentHistory->payment_type == 2) {
            $payment_info = UserAddress::find($paymentHistory->payid);
        } else {
            $payment_info = $paymentHistory->payid;
        }
        $order = Order::find($paymentHistory->payment_id);
        if ($paymentHistory->type == 2) {
            $paymentHistory->end_date = Carbon::create($paymentHistory->created_at->toDateTimeString())->addDays(30)->format('Y/m/d');
            $listItems[] = $paymentHistory;
        } else {
            if ($paymentHistory->service_id) {
                $paymentHistory->end_date =  Carbon::create($paymentHistory->created_at->toDateTimeString())->addDays(30)->format('Y/m/d');
            }
            $audios = $order->audios;
            foreach ($audios as $audio) {
                $data = $this->getInfor($audio);
                $listItems[] = [
                    'name' => $audio->name,
                    'duration' => $audio->duration,
                    'price' => $audio->pivot->price,
                    'plan' => $order->plan,
                    'length' => $data['length'],
                ];
                $totalLength += $data['length'];
                $totalDuration += $audio->duration;
            }
            $coupon = Coupon::find($order->coupon_id);
        }
        $paymentTypeConst = Config::get('const.paymentType');
        $userType = Config::get('const.userType');

        $image = base64_encode(file_get_contents(public_path() . '/user/images/logo-history.png'));
        ini_set('max_execution_time', 500);
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isFontSubsettingEnabled ' => true])->loadView('user.payment.invoice_pdf', [
            'order' => $order,
            'user' => $user,
            'paymentInfo' => $payment_info,
            'paymentHistory' => $paymentHistory,
            'listItems' => $listItems,
            'paymentTypeConst' => $paymentTypeConst,
            'image' => $image,
            'totalLength' => $totalLength,
            'totalDuration' => $totalDuration,
            'userType' => $userType,
            'coupon' => $coupon
        ]);
        ini_restore('max_execution_time');
        return $pdf->download('history_invoice.pdf');

        //    return view('user.payment.invoice_pdf', [
        //        'order' => $order,
        //        'user' => $user,
        //        'paymentInfo' => $payment_info,
        //        'paymentHistory' => $paymentHistory,
        //        'listItems' => $listItems,
        //        'paymentTypeConst' => $paymentTypeConst,
        //        'image' => $image,
        //        'totalLength' => $totalLength,
        //        'totalDuration' => $totalDuration,
        //        'userType' => $userType
        //    ]);
    }

    public function registerMember($user)
    {
        $request_data = new \AccountAddRequestDto();
        $create_date = Carbon::now()->format('Ymd');
        $account_id = MEMBER_GROUP_ID . '_' . str_pad($user->id, 5, "0", STR_PAD_LEFT);
        $request_data->setAccountId($account_id);
        $request_data->setCreateDate($create_date);
        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        if (!isset($response_data)) {
            abort(400, ERROR_PAGE_TITLE);
        } else {
            $pay_now_id_res = $response_data->getPayNowIdResponse();
            $txn_result_code = $response_data->getVResultCode();

            if (isset($pay_now_id_res)) {
                $pay_now_id_status = $pay_now_id_res->getStatus();
            }
            $error_message = $response_data->getMerrMsg();
            if ($txn_result_code == 'XH11000000000000' || PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
                $user->payment_id = $account_id;
                $user->save();
                return;
            } else {
                abort(400, $error_message);
            }
        }
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

    public function payment(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user->payment_id) {
            $this->registerMember($user);
        }
        $order_id = $request->order_id;
        $card_id = $request->card_id;
        $address_id = $request->address_id;
        $coupon_id = $request->coupon_id;
        $coupon =  Coupon::find($coupon_id);
        $orderInfo = Order::findOrFail($order_id);
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);

        $userType = Config::get('const.userType');
        $paymentMethod = $request->method ?  $request->method : 1;
        $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
        $discountedMoneyTotal = (new UserController())->getDiscountedTotal($coupon, $orderInfo->total_price);
        if ($discountedMoneyTotal == 0) {
            return view('user.payment.confirm', [
                'data' => $orderInfo,
                'coupon' => $coupon,
                'order_id' => $order_id,
                'discountedMoneyTotal' => $discountedMoneyTotal
            ]);
        }
        if ($paymentMethod == '2') {
            if ($address_id) {
                $address = UserAddress::findOrFail($address_id);
                return view('user.payment.postpaid_confirm', [
                    'payment_method' => $paymentMethod,
                    'data' => $orderInfo,
                    'address' => $address,
                    'account_id' => $account_id,
                    'order_id' => $order_id,
                    'user_type' => $userType,
                    'coupon' => $coupon,
                    'discountedMoneyTotal' => $discountedMoneyTotal
                ]);
            } else {
                $addresses = UserAddress::where('user_id', Auth::id())->where('public', true)->get();
                $userType = Config::get('const.userType');
                $prefectures = Config::get('const.prefectures');
                $selectType = null;
                if ($request->selectType) {
                    $selectType = intval($request->selectType);
                }
                if (!count($addresses)) {
                    return view('user.payment.postpaid_register', [
                        'service_type' => 1,
                        'order_id' => $order_id,
                        'userType' => $userType,
                        'prefectures' => $prefectures,
                        'selectType' => $selectType,
                        'coupon' => $coupon
                    ]);
                } else {
                    $address = null;
                    foreach ($addresses as $item) {
                        if ($item->default == 1) {
                            $address = $item;
                            break;
                        }
                    }
                    if (!$address) {
                        $address = $addresses[0];
                    }
                    return view('user.payment.postpaid_confirm', [
                        'payment_method' => $paymentMethod,
                        'data' => $orderInfo,
                        'address' => $address,
                        'account_id' => $account_id,
                        'order_id' => $order_id,
                        'user_type' => $userType,
                        'coupon' => $coupon,
                        'discountedMoneyTotal' => $discountedMoneyTotal
                    ]);
                }
            }
            return view('user.card.management');
        } else {
            $request_data = new \CardInfoGetRequestDto();
            $request_data->setAccountId($account_id);

            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
            $cardList = array();
            //if (!isset($response_data)) {
              //  return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList]);
            //} else {
                $pay_now_id_res = $response_data->getPayNowIdResponse();
		
                //if (isset($pay_now_id_res)) {
                    //$account = $pay_now_id_res->getAccount();
                    //if (isset($account)) {
					
                        //$cardInfos = $account->getCardInfo();
                      //  if ($cardInfos) {
                        //    $cardDefault = $this->getCardDefault($cardInfos, $card_id);
                        //    if ($cardDefault) 
                                return view('user.payment.confirm', [
                                    'data' => $orderInfo,
                                    'coupon' => $coupon,
                                    'token' => NULL,
                                   // 'card_number' => $cardDefault->getCardNumber(),
 					'card_number' => "45555555555555",
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    //'card_expire' => $cardDefault->getCardExpire(),
				    'card_expire' => "0223",
                                    'order_id' => $order_id,
                                    //'card_id' => $cardDefault->getCardId(),
				    'card_id' => "123",
                                    'discountedMoneyTotal' => $discountedMoneyTotal
                                ]);
                            //}
                        //}
                   // }
                //}
            //}
            return view('user.payment.payment_now', [
                'order_id' => $orderInfo->id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => $payment_id,
                'coupon' => $coupon
            ]);
        }
    }

    public static function getTotalPrice($type, $payment_method, $orderInfo, $coupon, $service)
    {
        $total_price = 0;

        if ($type == ORDER_TYPE || $type == ORDER_SERVICE_TYPE) {
            foreach ($orderInfo->audios as $audio) {
                $total_price += ceil($audio->duration / 60 * 30);
            }
        } else if ($type == BRUSHUP_TYPE) {
            foreach ($orderInfo->audios as $audio) {
                $total_price += $orderInfo->audios()->find($audio->id)->pivot->price;
            }
        }
        if ($coupon) {
            $totalPriceTax = ceil($total_price / 1.1);
            $total_price = $totalPriceTax > $coupon->discount_amount ? floor(($totalPriceTax - $coupon->discount_amount) * 1.1) : 0;
        }
        if ($type == SERVICE_TYPE || $type == ORDER_SERVICE_TYPE) {
            $total_price = $total_price + $service->price;
        }
        if ($payment_method == PAYMENT_POSTPAID) {
            $total_price = $total_price + VOITRA_POSTPAID_FEE;
        }
        return $total_price;
    }


    public function brushupComplete(Request $request)
    {
        DB::beginTransaction();
        $request_data = new \CardAuthorizeRequestDto();
        $order_id = $request->order_id;
        $orderInfo = Order::find($order_id);
        $history = PaymentHistory::where('payment_id', $order_id)->first();
        $coupon = Coupon::find($request->coupon_id);
        $total_price = 0;
        if ($history) {
            return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
        }
        $total_price = $this->getTotalPrice(BRUSHUP_TYPE, PAYMENT_CREDIT, $orderInfo, $coupon, null);

        $request_data->setOrderId($request->payment_id);
        $request_data->setAmount(round($request->payment_amount));
        $request_data->setToken($request->token);
        if (isset($request->jpo)) {
            $request_data->setJpo($request->jpo);
        }
        $request_data->setWithCapture(true);
        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        $user = User::find(Auth::id());
        $audios_id = array();
        if (isset($response_data)) {
            $result_order_id = $response_data->getOrderId();
            $txn_status = $response_data->getMStatus();
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();
            Log::info($response_data);
            if (TXN_SUCCESS_CODE === $txn_status || TXN_PENDING_CODE === $txn_status) {
                foreach ($orderInfo->audios as $audio) {
                    $audio->edited_result = $audio->api_result;
                    $audio->save();
                    array_push($audios_id, $audio->id);
                }
                $title = $orderInfo->plan == 1 ? 'AI文字起こしプラン（' . join(", ", $audios_id) . '）' : 'ブラッシュアッププラン（' . join(", ", $audios_id) . '）';

                $history = PaymentHistory::create([
                    'title' => $title,
                    'user_id' => Auth::id(),
                    'payment_id' => $order_id,
                    'payment_type' => 1,
                    'total_price' => $orderInfo->total_price,
                    'type' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                if ($coupon) {
                    $orderInfo->coupon_id = $coupon->id;
                    $coupon->used_quantity = $coupon->used_quantity + 1;
                    $coupon->save();
                }
                $orderInfo->status = BRUSHUP_PAID;
                $orderInfo->save();
                Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】ブラッシュアッププラン  お申し込み完了', 'emails.plan_2_success'));
                Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra 対応】ブラッシュアッププラン お申し込みが入りました', 'emails.send_admin_request'));
                DB::commit();
                return view('user.upload.brushup_complete', ['success' => true, 'data' => $orderInfo]);
            } else {
                Log::error($response_data);
                return view('user.upload.brushup_payment', [
                    'error' => true,
                    'order_id' => $orderInfo->id,
                    'api_token' => config('veritrans.api_token'),
                    'api_url' => config('veritrans.api_url'),
                    'payment_id' => TARGET_GROUP_ID . '_' . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . '_' . str_pad($orderInfo->id, 3, "0", STR_PAD_LEFT)
                ]);
            }
        } else {
            $txn_status = $response_data->getMStatus();
            DB::rollBack();
            Log::error($response_data);
            return view('user.upload.payment', [
                'error' => true,
                'order_id' => $orderInfo->id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => TARGET_GROUP_ID . '_' . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . '_' . str_pad($orderInfo->id, 3, "0", STR_PAD_LEFT)
            ]);
        }
        return view('user.upload.brushup_complete', ['success' => true, 'data' => $orderInfo]);
    }


    public function pay(Request $request, RecognitionService $regservice)
    {
        // DB::beginTransaction();
        $order_id = $request->order_id;
        $orderInfo = Order::findOrFail($order_id);
        $coupon = Coupon::find($request->coupon_id);
        $history = PaymentHistory::where('payment_id', $order_id)->first();
        $discountedMoneyTotal = $request->discountedMoneyTotal;
        if ($history) {
            return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
        }
        $paymentMethod = $request->method ?  $request->method : 1;
        $orderInfo = Order::find($order_id);
        $user = User::find(Auth::id());
        $audios_id = array();
        $total_price = 0;
        $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $userType = Config::get('const.userType');
        $delivery_id = DELIVERY_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 3, "0", STR_PAD_LEFT);

        $total_price = $this->getTotalPrice(ORDER_TYPE, $paymentMethod, $orderInfo, $coupon, null);

        if($total_price <= 0) {
            foreach ($orderInfo->audios as $audio) {
                $token = bin2hex(random_bytes(32));
                $url = url('/api/webhook/' . $orderInfo->id . '/' . $audio->id . '/' . $token);
                try {
                    $response = $regservice->recognize($audio->id, $audio->url, $audio->language, $audio->pivot->diarization, $audio->pivot->num_speaker, $url, 0);
                    if ($response->success) {
                        $audio->token = $token;
                        $audio->save();
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = ORDER_PROCESSING;
                        $rel->pivot->save();
                    } else {
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = ORDER_ERROR;
                        $rel->pivot->save();
                    }
                    array_push($audios_id, $audio->id);
                } catch (\Exception $e) {
                    $audio->token = $token;
                    $audio->save();
                    $rel = $orderInfo->audios()->find($audio->id);
                    $rel->pivot->status = ORDER_ERROR;
                    $rel->pivot->save();
                    Log::error($e->getMessage());
                }
            }
            $title = $orderInfo->plan == 1 ? 'AI文字起こしプラン（' . join(", ", $audios_id) .  '）' : 'ブラッシュアッププラン（' . join(", ", $audios_id) .  '）';
            $history = PaymentHistory::create([
                'title' => $title,
                'user_id' => Auth::id(),
                'payment_id' => $order_id,
                'payment_type' => 0,
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
            $orderInfo->payment_type = null;
            $orderInfo->payment_status = null;
            $orderInfo->payid = null;
            $orderInfo->status = ORDER_PROCESSING;
            $orderInfo->save();
            Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】AI文字起こしプラン お申し込み完了', 'emails.order_done'));
            return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
        }

        if ($paymentMethod == PAYMENT_POSTPAID) {
            $address = UserAddress::findOrFail($request->address_id);

            $request_data = $request->fix ? new \ScoreatpayCorrectAuthRequestDto() : new \ScoreatpayAuthorizeRequestDto();
            $buyerContact = new \ScoreatpayContactDto();
            $delivery = new \ScoreatpayDeliveryDto();
            $detail1 = new \ScoreatpayDetailDto();

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

            $delivery->setDeliveryId($delivery_id);
            $delivery->setContact($buyerContact);
            $delivery->setDetails([$detail1]);

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
            if ($total_price > 0) {
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
        }

        if (isset($response_data)) {
            Log::info($response_data);
            $result_order_id = $response_data->getOrderId();
            $txn_status = $response_data->getMStatus();
            // $txn_status =  $response_data->getMStatus();
            // $txn_status = 'pending';
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();
            if ($paymentMethod == PAYMENT_POSTPAID) {
                $authorResult = $response_data->getAuthorResult();
            }
            if ((TXN_SUCCESS_CODE === $txn_status && !isset($authorResult)) || (isset($authorResult) && $authorResult == AUTH_CODE_OK)) {
                $request_data = new \ScoreatpayCaptureRequestDto();
                $request_data->setOrderId($payment_id);
                $request_data->setPdCompanyCode(99);
                $request_data->setSlipNo(914712022);
                $request_data->setDeliveryId($delivery_id);
                $transaction = new \TGMDK_Transaction();
                $response_data = $transaction->execute($request_data);
                Log::info($response_data);
                foreach ($orderInfo->audios as $audio) {
                    $token = bin2hex(random_bytes(32));
                    $url = url('/api/webhook/' . $orderInfo->id . '/' . $audio->id . '/' . $token);
                    try {
                        $response = $regservice->recognize($audio->id, $audio->url, $audio->language, $audio->pivot->diarization, $audio->pivot->num_speaker, $url, 0);
                        if ($response->success) {
                            $audio->token = $token;
                            $audio->save();
                            $rel = $orderInfo->audios()->find($audio->id);
                            $rel->pivot->status = ORDER_PROCESSING;
                            $rel->pivot->save();
                        } else {
                            $rel = $orderInfo->audios()->find($audio->id);
                            $rel->pivot->status = ORDER_ERROR;
                            $rel->pivot->save();
                        }
                        array_push($audios_id, $audio->id);
                    } catch (\Exception $e) {
                        $audio->token = $token;
                        $audio->save();
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = ORDER_ERROR;
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
                if ($paymentMethod == PAYMENT_CREDIT) {
                    $orderInfo->service_id = null;
                }
                $orderInfo->payment_id = $payment_id;
                $orderInfo->payment_type = $paymentMethod;
                $orderInfo->payment_status = $paymentMethod == PAYMENT_CREDIT ? PAYMENT_DONE : PAYMENT_VERIFIED;
                $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                $orderInfo->status = ORDER_PROCESSING;
                $orderInfo->save();
                // DB::commit();
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_1_ok', $orderInfo->id, $user->name);
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 1], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 1], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
                }
                Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】AI文字起こしプラン お申し込み完了', 'emails.order_done'));
                return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
            } else if ((isset($authorResult) && $authorResult == AUTH_CODE_HOLD)) {
                $orderInfo->payment_id = $payment_id;
                $orderInfo->payment_type = $paymentMethod;
                $orderInfo->payment_status = PAYMENT_HOLD;
                $orderInfo->status = ORDER_HOLD;
                $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                if ($coupon) {
                    $orderInfo->coupon_id = $coupon->id;
                    $coupon->used_quantity = $coupon->used_quantity + 1;
                    $coupon->save();
                }
                if ($coupon) {
                    $orderInfo->coupon_id = $coupon->id;
                }
                $orderInfo->save();
                foreach ($orderInfo->audios as $audio) {
                    $rel = $orderInfo->audios()->find($audio->id);
                    $rel->pivot->status = ORDER_HOLD;
                    $rel->pivot->save();
                }
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_1_hr', $orderInfo->id, $user->name);
                    // Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 1], '【voitra】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold'));
                    // Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 1], '【voitra通知】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold_admin'));
                    return view('user.payment.complete_hold', ['success' => false, 'order' => $orderInfo, 'merrMsg' => $error_message, 'type' => ORDER_TYPE]);
                }
                return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
            } else if ((isset($authorResult) && $authorResult == AUTH_CODE_NG)) {
                // dd($response_data);
                foreach ($orderInfo->audios as $audio) {
                    $rel = $orderInfo->audios()->find($audio->id);
                    $rel->pivot->status = ORDER_DISABLE;
                    $rel->pivot->save();
                }
                $orderInfo->payment_id = $payment_id;
                $orderInfo->payment_type = $paymentMethod;
                $orderInfo->payment_status = PAYMENT_NG;
                $orderInfo->payment_description = '_';
                $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                $orderInfo->status = ORDER_CANCEL;
                if ($coupon) {
                    $orderInfo->coupon_id = $coupon->id;
                }
                $orderInfo->save();
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_1_ng', $orderInfo->id, $user->name);
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => ORDER_TYPE], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => ORDER_TYPE], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
                    return view('user.payment.complete_ng', ['success' => false, 'order' => $orderInfo, 'merrMsg' => $error_message, 'type' => ORDER_TYPE]);
                }
                return view('user.payment.payment', [
                    'error' => true,
                    'order_id' => $orderInfo->id,
                    'api_token' => config('veritrans.api_token'),
                    'api_url' => config('veritrans.api_url'),
                    'payment_id' => $payment_id
                ]);
            } else {
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    return view('user.payment.postpaid_confirm', [
                        'error' => true,
                        'payment_method' => $paymentMethod,
                        'data' => $orderInfo,
                        'address' => $address,
                        'account_id' => $account_id,
                        'order_id' => $order_id,
                        'user_type' => $userType,
                        'coupon' => $coupon,
                        'discountedMoneyTotal' => $discountedMoneyTotal
                    ]);
                }
                return view('user.payment.payment', [
                    'error' => true,
                    'order_id' => $orderInfo->id,
                    'api_token' => config('veritrans.api_token'),
                    'api_url' => config('veritrans.api_url'),
                    'payment_id' => $payment_id,
                    'coupon' => $coupon,
                    'discountedMoneyTotal' => $discountedMoneyTotal
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
        return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
    }

    public function changePayCard($order_id, Request $request)
    {
        $order_id = $order_id;
        $orderInfo = Order::findOrFail($order_id);
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $request_data = new \CardInfoGetRequestDto();
        $request_data->setAccountId($account_id);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        $cardList = array();
        $card_number = NULL;
        $card_expire = NULL;
        $coupon_id = $request->coupon_id;
        $coupon = Coupon::find($coupon_id);
        if (!isset($response_data)) {
            return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList, 'coupon' => $coupon]);
        } else {
            $pay_now_id_res = $response_data->getPayNowIdResponse();
            if (isset($pay_now_id_res)) {
                $account = $pay_now_id_res->getAccount();

                if (isset($account)) {
                    $cardInfos = $account->getCardInfo();
                    foreach ((array)$cardInfos as $cardInfo) {
                        $map = array(
                            'card_id' => $cardInfo->getCardId(),
                            'card_number' => $cardInfo->getCardNumber(),
                            'card_expire' => $cardInfo->getCardExpire(),
                            'type' => $this->getCardBrand($cardInfo->getCardNumber()),
                            'default' => $cardInfo->getDefaultCard()
                        );
                        if ($cardInfo->getDefaultCard() == 1) {
                            $card_number = $cardInfo->getCardNumber();
                            $card_expire = $cardInfo->getCardExpire();
                        }
                        array_push($cardList, $map);
                    }
                }
            }
        }
        return view('user.payment.change_card_payment',  [
            'account_id' => $account_id,
            'order_id' => $order_id,
            'card_number' => $card_number,
            'card_expire' => $card_expire,
            'api_token' => config('veritrans.api_token'),
            'api_url' => config('veritrans.api_url'),
            'cards' => $cardList,
            'coupon' => $coupon
        ]);
    }

    public function changeBrushupPayCard($order_id, Request $request)
    {
        $order_id = $order_id;
        $orderInfo = Order::findOrFail($order_id);
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $request_data = new \CardInfoGetRequestDto();
        $request_data->setAccountId($account_id);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        $cardList = array();
        $card_number = NULL;
        $card_expire = NULL;
        $coupon_id = $request->coupon_id;
        $coupon = Coupon::find($coupon_id);
        if (!isset($response_data)) {
            return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList, 'coupon' => $coupon]);
        } else {
            $pay_now_id_res = $response_data->getPayNowIdResponse();
            if (isset($pay_now_id_res)) {
                $account = $pay_now_id_res->getAccount();

                if (isset($account)) {
                    $cardInfos = $account->getCardInfo();
                    foreach ((array)$cardInfos as $cardInfo) {
                        $map = array(
                            'card_id' => $cardInfo->getCardId(),
                            'card_number' => $cardInfo->getCardNumber(),
                            'card_expire' => $cardInfo->getCardExpire(),
                            'type' => $this->getCardBrand($cardInfo->getCardNumber()),
                            'default' => $cardInfo->getDefaultCard()
                        );
                        if ($cardInfo->getDefaultCard() == 1) {
                            $card_number = $cardInfo->getCardNumber();
                            $card_expire = $cardInfo->getCardExpire();
                        }
                        array_push($cardList, $map);
                    }
                }
            }
        }
        return view('user.payment.change_card_brushup', [
            'account_id' => $account_id,
            'order_id' => $order_id,
            'card_number' => $card_number,
            'card_expire' => $card_expire,
            'api_token' => config('veritrans.api_token'),
            'api_url' => config('veritrans.api_url'),
            'cards' => $cardList,
            'coupon' => $coupon
        ]);
    }

    public function changeServicePayCard($order_id = null, Request $request)
    {
        $order_id = $order_id;
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $request_data = new \CardInfoGetRequestDto();
        $request_data->setAccountId($account_id);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        $cardList = array();
        $card_number = NULL;
        $card_expire = NULL;
        if (!isset($response_data)) {
            return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList]);
        } else {
            $pay_now_id_res = $response_data->getPayNowIdResponse();
            if (isset($pay_now_id_res)) {
                $account = $pay_now_id_res->getAccount();

                if (isset($account)) {
                    $cardInfos = $account->getCardInfo();
                    foreach ((array)$cardInfos as $cardInfo) {
                        $map = array(
                            'card_id' => $cardInfo->getCardId(),
                            'card_number' => $cardInfo->getCardNumber(),
                            'card_expire' => $cardInfo->getCardExpire(),
                            'type' => $this->getCardBrand($cardInfo->getCardNumber()),
                            'default' => $cardInfo->getDefaultCard()
                        );
                        if ($cardInfo->getDefaultCard() == 1) {
                            $card_number = $cardInfo->getCardNumber();
                            $card_expire = $cardInfo->getCardExpire();
                        }
                        array_push($cardList, $map);
                    }
                }
            }
        }
        return view('user.payment.change_card_service', [
            'account_id' => $account_id,
            'order_id' => $order_id,
            'card_number' => $card_number,
            'card_expire' => $card_expire,
            'api_token' => config('veritrans.api_token'),
            'api_url' => config('veritrans.api_url'),
            'cards' => $cardList
        ]);
    }

    public static function getCardBrand($pan)
    {
        $pan = str_replace("*", "", $pan);
        $visa_regex = "/^4[0-9]{0,}$/";
        $mastercard_regex = "/^(5[1-5]|222[1-9]|22[3-9]|2[3-6]|27[01]|2720)[0-9]{0,}$/";
        $maestro_regex = "/^(5[06789]|6)[0-9]{0,}$/";

        $amex_regex = "/^3[47][0-9]{0,}$/";

        $diners_regex = "/^3(?:0[0-59]{1}|[689])[0-9]{0,}$/";

        $discover_regex = "/^(6011|65|64[4-9]|62212[6-9]|6221[3-9]|622[2-8]|6229[01]|62292[0-5])[0-9]{0,}$/";
        $jcb_regex = "/^(?:2131|1800|35)[0-9]{0,}$/";
        if (preg_match($jcb_regex, $pan)) {
            return "jbc";
        }

        if (preg_match($amex_regex, $pan)) {
            return "amexpress";
        }

        if (preg_match($diners_regex, $pan)) {
            return "diner";
        }

        if (preg_match($visa_regex, $pan)) {
            return "visa";
        }

        if (preg_match($mastercard_regex, $pan)) {
            return "master";
        }

        if (preg_match($discover_regex, $pan)) {
            return "discover";
        }

        if (preg_match($maestro_regex, $pan)) {
            if ($pan[0] == '5') {
                return "mastercard";
            }
            return "maestro";
        }
        return "unknown";
    }

    public function cardManagement(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user->payment_id) {
            $this->registerMember($user);
        }
        $account_id = MEMBER_GROUP_ID . '_' . str_pad($user->id, 5, "0", STR_PAD_LEFT);
        $request_data = new \CardInfoGetRequestDto();
        $request_data->setAccountId($account_id);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        $cardList = array();

        if (!isset($response_data)) {
             return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList]);
        } else {
            $pay_now_id_res = $response_data->getPayNowIdResponse();
            if (isset($pay_now_id_res)) {
                $account = $pay_now_id_res->getAccount();

                if (isset($account)) {
                    $cardInfos = $account->getCardInfo();
                    foreach ((array)$cardInfos as $cardInfo) {
                        $map = array(
                            'card_id' => $cardInfo->getCardId(),
                            'card_number' => $cardInfo->getCardNumber(),
                            'card_expire' => $cardInfo->getCardExpire(),
                            'type' => $this->getCardBrand($cardInfo->getCardNumber()),
                            'default' => $cardInfo->getDefaultCard()
                        );
                        array_push($cardList, $map);
                    }
                }
            }
        }

        $monthy_pay = DB::table('user_services')
            ->where('user_id', $user->id)
            ->whereNull('remove_at')
            ->get();

        return view('user.card.management', [
            'account_id' => $account_id,
            'cards' => $cardList,
            'has_monthy_pay' => count($monthy_pay)
        ]);
    }

    public function formNewCard(Request $request)
    {
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);

        return view('user.card.add', [
            'account_id' => $account_id,
            'api_token' => config('veritrans.api_token'),
            'api_url' => config('veritrans.api_url'),
        ]);
    }

    public function formAddCard(Request $request)
    {
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);

        return view('user.card.add', [
            'more' => true,
            'account_id' => $account_id,
            'api_token' => config('veritrans.api_token'),
            'api_url' => config('veritrans.api_url'),
        ]);
    }

    public function addCard(Request $request)
    {
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $token = $request->token;
        $default = $request->default;
        $default = $default == 'true' ? 1 : 0;

        $request_data = new \CardInfoAddRequestDto();
        $request_data->setAccountId($account_id);
        $request_data->setToken($token);
        $request_data->setDefaultCard($default);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);

        if (!isset($response_data)) {
            $page_title = ERROR_PAGE_TITLE;
            return response()->json(['success' => false]);
        } else {
            $page_title = NORMAL_PAGE_TITLE;
            $pay_now_id_res = $response_data->getPayNowIdResponse();

            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();

            $pay_now_id_status = PAY_NOW_ID_FAILURE_CODE;
            if (isset($pay_now_id_res)) {
                $process_id = $pay_now_id_res->getProcessId();
                $pay_now_id_status = $pay_now_id_res->getStatus();
            }

            if (PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'mess' => $error_message]);
            }
        }
        return response()->json(['success' => true]);
    }

    public function deleteCard(Request $request)
    {
        $result = ['success' => true];

        $account_id = $request->account_id;
        $card_id = $request->card_id;
        $is_def_card = $request->card_def;

        $request_data = new \CardInfoDeleteRequestDto();
        $request_data->setAccountId($account_id);
        $request_data->setCardId($card_id);
        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);

        if (!isset($response_data)) {
            $page_title = ERROR_PAGE_TITLE;
            $result['success'] = false;
        } else {
            $page_title = NORMAL_PAGE_TITLE;
            $pay_now_id_res = $response_data->getPayNowIdResponse();
            $pay_now_id_status = PAY_NOW_ID_FAILURE_CODE;

            if (isset($pay_now_id_res)) {
                $process_id = $pay_now_id_res->getProcessId();
                $pay_now_id_status = $pay_now_id_res->getStatus();
            }
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();

            if (PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
                if ($is_def_card) {
                    $is_added_card = $this->setDefaultCardIsFirstCard($account_id);
                }
            } else if (PAY_NOW_ID_PENDING_CODE === $pay_now_id_status) {
            } else if (PAY_NOW_ID_FAILURE_CODE === $pay_now_id_status) {
            } else {
                $page_title = ERROR_PAGE_TITLE;
            }
        }

        return response()->json($result);
    }

    protected function setDefaultCardIsFirstCard($accountId)
    {
        $result = [
            'success' => false,
            'txn_result_code' => '',
            'error_message' => 'No response data'
        ];

        $request_data = new \CardInfoGetRequestDto();
        $request_data->setAccountId($accountId);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);

        $firstCardId = null;

        if (isset($response_data)) {
            $pay_now_id_res = $response_data->getPayNowIdResponse();

            if (isset($pay_now_id_res)) {
                $account = $pay_now_id_res->getAccount();

                if (isset($account)) {
                    $cardInfos = $account->getCardInfo();

                    foreach ((array) $cardInfos as $cardInfo) {
                        $firstCardId = $cardInfo->getCardId();
                        break;
                    }
                }
            }
        }

        if ($firstCardId) {
            $result = $this->updateDefaultCardByAcountAndId($accountId, $firstCardId);
        }

        return $result;
    }

    protected function updateDefaultCardByAcountAndId($accountId, $cardId)
    {
        $result = [
            'success' => false,
            'txn_result_code' => '',
            'error_message' => 'No response data'
        ];

        $request_data = new \CardInfoUpdateRequestDto();
        $request_data->setAccountId($accountId);
        $request_data->setCardId($cardId);
        $request_data->setDefaultCard(1);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);

        if (isset($response_data)) {
            $pay_now_id_res = $response_data->getPayNowIdResponse();

            $pay_now_id_status = PAY_NOW_ID_FAILURE_CODE;
            if (isset($pay_now_id_res)) {
                $process_id = $pay_now_id_res->getProcessId();
                $pay_now_id_status = $pay_now_id_res->getStatus();
            }

            if (PAY_NOW_ID_SUCCESS_CODE === $pay_now_id_status) {
                $result['success'] = true;
            }
            else {
                $txn_result_code = $response_data->getVResultCode();
                $error_message = $response_data->getMerrMsg();

                $result['txn_result_code'] = $txn_result_code;
                $result['error_message'] = $error_message;
            }
        }

        return $result;
    }

    public function updateDefault(Request $request)
    {
        $result = $this->updateDefaultCardByAcountAndId($request->account_id, $request->card_id);

        $page_title = $result['success'] ? NORMAL_PAGE_TITLE : ERROR_PAGE_TITLE;

        return response()->json($result);
    }

    public function servicePayment($id = null, Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user->payment_id) {
            $this->registerMember($user);
        }
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $order_id = $id;
        $address_id = $request->address_id;
        $userType = Config::get('const.userType');
        $paymentMethod = $request->method ?  $request->method : 1;
        $service = Service::all()->first();
        $datefrom = Carbon::now();
        $dateto = Carbon::now()->addDays(30);

        if ($paymentMethod == '2') {
            if ($address_id) {
                $address = UserAddress::findOrFail($address_id);
                return view('user.payment.postpaid_service_confirm', [
                    'date_from' => $datefrom->format('Y年m月d日'),
                    'date_to' => $dateto->format('Y年m月d日'),
                    'payment_method' => $paymentMethod,
                    'address' => $address,
                    'account_id' => $account_id,
                    'order_id' => $order_id ? $order_id : $service->id,
                    'user_type' => $userType,
                    'service' => $service
                ]);
            } else {
                $addresses = UserAddress::where('user_id', Auth::id())->where('public', true)->get();
                $prefectures = Config::get('const.prefectures');
                $selectType = null;
                if ($request->selectType) {
                    $selectType = intval($request->selectType);
                }
                if (!count($addresses)) {
                    return view('user.payment.postpaid_register', [
                        'service_type' => 3,
                        'order_id' => $order_id ? $order_id : $service->id,
                        'userType' => $userType,
                        'prefectures' => $prefectures,
                        'selectType' => $selectType
                    ]);
                } else {
                    $address = null;
                    foreach ($addresses as $item) {
                        if ($item->default == 1) {
                            $address = $item;
                            break;
                        }
                    }
                    if (!$address) {
                        $address = $addresses[0];
                    }
                    return view('user.payment.postpaid_service_confirm', [
                        'date_from' => $datefrom->format('Y年m月d日'),
                        'date_to' => $dateto->format('Y年m月d日'),
                        'payment_method' => $paymentMethod,
                        'address' => $address,
                        'account_id' => $account_id,
                        'order_id' => $order_id ? $order_id : $service->id,
                        'user_type' => $userType,
                        'service' => $service
                    ]);
                }
            }
            return view('user.card.management');
        } else {
            $request_data = new \CardInfoGetRequestDto();
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

    public function getInfor($audioInfo)
    {
        $data =  json_decode($audioInfo->api_result);
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

    public function brushupConfirm(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user->payment_id) {
            $this->registerMember($user);
        }
        $order_id = $request->order_id;
        $card_id = $request->card_id;
        $orderInfo = Order::findOrFail($order_id);
        $address_id = $request->address_id;
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
        $audios = array();
        foreach ($orderInfo->audios as $audio) {
            $data = $this->getInfor($audio);
            $audio->expected = $audio->pivot->user_estimate;
            $audio->deadline = $audio->pivot->admin_estimate;
            $audio->length = $data['length'];
            $audio->price = $orderInfo->audios()->find($audio->id)->pivot->price;
            array_push($audios, $audio);
        }
        $userType = Config::get('const.userType');
        $coupon_id = $request->coupon_id;
        $coupon = Coupon::find($coupon_id);
        $discountedMoneyTotal = (new UserController())->getDiscountedTotal($coupon, $orderInfo->total_price);
        if ($discountedMoneyTotal == 0) {
            return view('user.payment.brushup_confirm', [
                'data' => $orderInfo,
                'order_id' => $order_id,
                'coupon' =>$coupon,
                'audios' => $audios,
                'discountedMoneyTotal' =>$discountedMoneyTotal
            ]);
        }
        $paymentMethod = $request->method ?  $request->method : 1;
        if ($paymentMethod == '2') {
            if ($address_id) {
                $address = UserAddress::findOrFail($address_id);
                return view('user.payment.postpaid_brushup_confirm', [
                    'payment_method' => $paymentMethod,
                    'data' => $orderInfo,
                    'audios' => $audios,
                    'address' => $address,
                    'account_id' => $account_id,
                    'order_id' => $order_id,
                    'user_type' => $userType,
                    'coupon' =>$coupon,
                    'discountedMoneyTotal' =>$discountedMoneyTotal
                ]);
            } else {
                $addresses = UserAddress::where('user_id', Auth::id())->where('public', true)->get();
                $userType = Config::get('const.userType');
                $prefectures = Config::get('const.prefectures');
                $selectType = null;
                if ($request->selectType) {
                    $selectType = intval($request->selectType);
                }
                if (!count($addresses)) {
                    return view('user.payment.postpaid_register', [
                        'service_type' => 1,
                        'order_id' => $order_id,
                        'userType' => $userType,
                        'prefectures' => $prefectures,
                        'selectType' => $selectType
                    ]);
                } else {
                    $address = null;
                    foreach ($addresses as $item) {
                        if ($item->default == 1) {
                            $address = $item;
                            break;
                        }
                    }
                    if (!$address) {
                        $address = $addresses[0];
                    }
                    return view('user.payment.postpaid_brushup_confirm', [
                        'payment_method' => $paymentMethod,
                        'data' => $orderInfo,
                        'address' => $address,
                        'audios' => $audios,
                        'account_id' => $account_id,
                        'order_id' => $order_id,
                        'user_type' => $userType,
                        'coupon' =>$coupon,
                        'discountedMoneyTotal' =>$discountedMoneyTotal
                    ]);
                }
            }
            return view('user.card.management');
        } else {

            $request_data = new \CardInfoGetRequestDto();
            $request_data->setAccountId($account_id);

            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
            $cardList = array();

            if (!isset($response_data)) {
                return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList, 'coupon']);
            } else {
                $txn_result_code = $response_data->getVResultCode();
                $pay_now_id_res = $response_data->getPayNowIdResponse();

                if (isset($pay_now_id_res)) {
                    $account = $pay_now_id_res->getAccount();

                    if (isset($account)) {
                        $cardInfos = $account->getCardInfo();
                        if ($cardInfos) {
                            $defaultCard = $this->getCardDefault($cardInfos, $card_id);
                            if ($defaultCard) {
                                return view('user.payment.brushup_confirm', [
                                    'data' => $orderInfo,
                                    'token' => $defaultCard->getCardId(),
                                    'card_number' => $defaultCard->getCardNumber(),
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    'card_expire' => $defaultCard->getCardExpire(),
                                    'order_id' => $order_id,
                                    'audios' => $audios,
                                    'card_id' => $defaultCard->getCardId(),
                                    'coupon' => $coupon,
                                    'discountedMoneyTotal' => $discountedMoneyTotal
                                ]);
                            }
                        }
                    }
                }
            }
            return view('user.payment.brushup_payment', [
                'order_id' => $orderInfo->id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => $payment_id,
                'coupon' =>$coupon
            ]);
        }
    }

    public function brushupPay(Request $request)
    {
        // DB::beginTransaction();
        $order_id = $request->order_id;
        $orderInfo = Order::findOrFail($order_id);
        $history = PaymentHistory::where('payment_id', $order_id)->first();
        $coupon = Coupon::find($request->coupon_id);
        if ($history) {
            return view('user.upload.brushup_complete', ['success' => true, 'order' => $orderInfo]);
        }
        $paymentMethod = $request->method ? $request->method : '1';
        $request_data = new \CardAuthorizeRequestDto();
        $total_time = 0;
        $total_price = 0;
        $orderInfo = Order::find($order_id);
        $user = User::find(Auth::id());
        $audios_id = array();
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $userType = Config::get('const.userType');

        // foreach ($orderInfo->audios as $audio) {
        //     $total_time += $audio->length;
        //     $total_price += $orderInfo->audios()->find($audio->id)->pivot->price;
        // }
        $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
        $delivery_id = DELIVERY_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 3, "0", STR_PAD_LEFT);
        $total_price = $this->getTotalPrice(BRUSHUP_TYPE, $paymentMethod, $orderInfo, $coupon, null);
        $discountedMoneyTotal = (new UserController())->getDiscountedTotal($coupon, $orderInfo->total_price);

        if ($total_price == 0) {
            foreach ($orderInfo->audios as $audio) {
                $audio->edited_result = $audio->api_result;
                $audio->status = ORDER_DONE;
                $audio->save();
                array_push($audios_id, $audio->id);
            }
            $title = $orderInfo->plan == 1 ? 'AI文字起こしプラン（' . join(", ", $audios_id) .  '）' : 'ブラッシュアッププラン（' . join(", ", $audios_id) .  '）';
            $history = PaymentHistory::create([
                'title' => $title,
                'user_id' => Auth::id(),
                'payment_id' => $order_id,
                'payment_type' => 0,
                'total_price' => $total_price,
                'payid' => $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id,
                'type' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $orderInfo->payment_id = $payment_id;
            $orderInfo->payment_type = null;
            $orderInfo->payment_status = null;
            $orderInfo->payid = null;
            $orderInfo->status = BRUSHUP_PAID;
            if ($coupon) {
                $orderInfo->coupon_id = $coupon->id;
                $coupon->used_quantity = $coupon->used_quantity + 1;
                $coupon->save();
            }
            $orderInfo->save();
            Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】ブラッシュアッププラン  お申し込み完了', 'emails.plan_2_success'));
            Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra 対応】ブラッシュアッププラン お申し込みが入りました', 'emails.send_admin_payment_plan_2_success'));
            return view('user.upload.brushup_complete', ['success' => true, 'data' => $orderInfo]);
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

            $delivery->setDeliveryId($delivery_id);
            $delivery->setContact($buyerContact);
            $delivery->setDetails([$detail1]);

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
            Log::info($response_data);
            $result_order_id = $response_data->getOrderId();
            // $txn_status = $request->address_id && ($request->address_id == 18 || $request->address_id == 20) ? 'pending' : $response_data->getMStatus();
            $txn_status =  $response_data->getMStatus();
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();

            if ($paymentMethod == PAYMENT_POSTPAID) {
                $authorResult = $response_data->getAuthorResult();
            }

            if ((TXN_SUCCESS_CODE === $txn_status && !isset($authorResult)) || (isset($authorResult) && $authorResult == AUTH_CODE_OK)) {
                foreach ($orderInfo->audios as $audio) {
                    $audio->edited_result = $audio->api_result;
                    $audio->status = ORDER_DONE;
                    $audio->save();
                    array_push($audios_id, $audio->id);

                    $audio->pivot->status = ORDER_DONE;
                    $audio->pivot->save();
                }
                $request_data = new \ScoreatpayCaptureRequestDto();
                $request_data->setOrderId($payment_id);
                $request_data->setPdCompanyCode(99);
                $request_data->setSlipNo(914712022);
                $request_data->setDeliveryId($delivery_id);
                $transaction = new \TGMDK_Transaction();
                $response_data = $transaction->execute($request_data);
                Log::info($response_data);
                $title = $orderInfo->plan == 1 ? 'AI文字起こしプラン（' . join(", ", $audios_id) .  '）' : 'ブラッシュアッププラン（' . join(", ", $audios_id) .  '）';
                $history = PaymentHistory::create([
                    'title' => $title,
                    'user_id' => Auth::id(),
                    'payment_id' => $order_id,
                    'payment_type' => $paymentMethod,
                    'total_price' => $total_price,
                    'payid' => $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id,
                    'type' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);

                $orderInfo->payment_id = $payment_id;
                $orderInfo->payment_type = $paymentMethod;
                $orderInfo->payment_status = $paymentMethod == PAYMENT_CREDIT ? PAYMENT_DONE : PAYMENT_VERIFIED;
                $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                $orderInfo->status = BRUSHUP_PAID;
                if ($coupon) {
                    $orderInfo->coupon_id = $coupon->id;
                    $coupon->used_quantity = $coupon->used_quantity + 1;
                    $coupon->save();
                }
                $orderInfo->save();
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_2_ok', $orderInfo->id, $user->name);
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 2], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 2], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
                }
                Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】ブラッシュアッププラン  お申し込み完了', 'emails.plan_2_success'));
                Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra 対応】ブラッシュアッププラン お申し込みが入りました', 'emails.send_admin_payment_plan_2_success'));
                // DB::commit();

                $this->broadcastNoticeToAllAdminUsers('user_edit_requested', $orderInfo->id, $user->name);

                return view('user.upload.brushup_complete', ['success' => true, 'data' => $orderInfo]);
            } else if ((isset($authorResult) && $authorResult == AUTH_CODE_HOLD)) {
                Log::error($response_data);
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $orderInfo->payment_id = $payment_id;
                    $orderInfo->payment_type = $paymentMethod;
                    $orderInfo->payment_status = PAYMENT_HOLD;
                    $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                    // $orderInfo->status = 3;
                    if ($coupon) {
                        $orderInfo->coupon_id = $coupon->id;
                        $coupon->used_quantity = $coupon->used_quantity + 1;
                        $coupon->save();
                    }
                    $orderInfo->save();
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_2_hr', $orderInfo->id, $user->name);
                    // dd($orderInfo);
                    // Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 2], '【voitra】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold'));
                    // Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 2], '【voitra通知】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold_admin'));
                    return view('user.payment.complete_hold', ['success' => false, 'order' => $orderInfo, 'merrMsg' => $error_message, 'type' => ORDER_TYPE]);
                }
                return view('user.upload.brushup_complete', ['success' => true, 'data' => $orderInfo]);
            } else if ((isset($authorResult) && $authorResult == AUTH_CODE_NG)) {
                Log::error($response_data);
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $orderInfo->payment_id = $payment_id;
                    $orderInfo->payment_type = $paymentMethod;
                    $orderInfo->payment_status = PAYMENT_NG;
                    $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                    $orderInfo->status = ORDER_HOLD;
                    if ($coupon) {
                        $orderInfo->coupon_id = $coupon->id;
                    }
                    $orderInfo->save();
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_2_ng', $orderInfo->id, $user->name);
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 2], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 2], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
                    return view('user.payment.complete_ng', ['success' => false, 'order' => $orderInfo, 'merrMsg' => $error_message, 'type' => 2]);
                }
                return view('user.payment.brushup_payment', [
                    'error' => true,
                    'order_id' => $orderInfo->id,
                    'api_token' => config('veritrans.api_token'),
                    'api_url' => config('veritrans.api_url'),
                    'payment_id' => $payment_id
                ]);
            } else {
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $audios = array();

                    foreach ($orderInfo->audios as $audio) {
                        $data = $this->getInfor($audio);
                        $audio->expected = $audio->pivot->user_estimate;
                        $audio->deadline = $audio->pivot->admin_estimate;
                        $audio->length = $data['length'];
                        $audio->price = $orderInfo->audios()->find($audio->id)->pivot->price;
                        array_push($audios, $audio);
                    }
                    return view('user.payment.postpaid_brushup_confirm', [
                        'error' => true,
                        'payment_method' => $paymentMethod,
                        'data' => $orderInfo,
                        'audios' => $audios,
                        'address' => $address,
                        'account_id' => $account_id,
                        'order_id' => $order_id,
                        'user_type' => $userType,
                        'coupon' =>$coupon,
                        'discountedMoneyTotal' =>$discountedMoneyTotal
                    ]);
                }
                return view('user.payment.brushup_payment', [
                    'error' => true,
                    'order_id' => $orderInfo->id,
                    'api_token' => config('veritrans.api_token'),
                    'api_url' => config('veritrans.api_url'),
                    'payment_id' => $payment_id
                ]);
            }
        } else {
            // $page_title = NORMAL_PAGE_TITLE;
            $result_order_id = $response_data->getOrderId();
            $txn_status =  $response_data->getMStatus();
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();
            DB::rollBack();
            return view('user.upload.payment', [
                'error' => true,
                'order_id' => $orderInfo->id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => $payment_id
            ]);
        }

        return view('user.upload.brushup_complete', ['success' => true, 'data' => $orderInfo]);
    }

    public function cancelRequest(Request $request)
    {
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $order_id = $request->order_id;
        $payment_id = $request->payment_id;
        $orderInfo = Order::find($order_id);
        $type = $request->type;
        $order_pay_id = $payment_id;
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);

        $request_data = new \ScoreatpayCancelRequestDto();
        $request_data->setOrderId($order_pay_id);
        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        if ($orderInfo) {
            $orderInfo->payment_status = 0;
            $orderInfo->save();
        }

        $request_data = new \CardInfoGetRequestDto();
        $request_data->setAccountId($account_id);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        $cardList = array();
        $service = Service::all()->first();
        $datefrom = Carbon::now();
        $dateto = Carbon::now()->addDays(30);

        if (!isset($response_data)) {
            return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList]);
        } else {
            $pay_now_id_res = $response_data->getPayNowIdResponse();
            if (isset($pay_now_id_res)) {
                $account = $pay_now_id_res->getAccount();
                if (isset($account)) {
                    $cardInfos = $account->getCardInfo();
                    if ($cardInfos) {
                        $cardDefault = $this->getCardDefault($cardInfos, null);
                        if ($cardDefault) {
                            if ($type != SERVICE_TYPE) {
                                return view('user.payment.confirm', [
                                    'data' => $orderInfo,
                                    'token' => NULL,
                                    'card_number' => $cardDefault->getCardNumber(),
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    'card_expire' => $cardDefault->getCardExpire(),
                                    'order_id' => $order_id,
                                    'card_id' => $cardDefault->getCardId(),
                                ]);
                            } else {
                                return view('user.payment.service_confirm', [
                                    'date_from' => $datefrom->format('Y年m月d日'),
                                    'date_to' => $dateto->format('Y年m月d日'),
                                    'service' => $service,
                                    'token' => $cardDefault->getCardId(),
                                    'card_number' => $cardDefault->getCardNumber(),
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    'card_expire' => $cardDefault->getCardExpire(),
                                    'order_id' => $order_id,
                                    'card_id' => $cardDefault->getCardId()
                                ]);
                            }
                        }
                    }
                }
            }
        }

        $userType = Config::get('const.userType');

        if ($type == ORDER_TYPE) {
            return view('user.payment.payment_now', [
                'order_id' => $order_id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => $payment_id
            ]);
        } else if ($type == BRUSHUP_TYPE) {
            return view('user.upload.brushup_payment', [
                'order_id' => $order_id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => $payment_id
            ]);
        } else if ($type == ORDER_SERVICE_TYPE) {
            $service = Service::all()->first();
            $datefrom = Carbon::now();
            $dateto = Carbon::now()->addDays(30);
            return view('user.payment.postpaid_confirm_service', [
                'payment_method' => 2,
                'data' => $orderInfo,
                'account_id' => $account_id,
                'order_id' => $order_id,
                'user_type' => $userType,
                'service' => $service,
                'date_from' => $datefrom->format('Y年m月d日'),
                'date_to' => $dateto->format('Y年m月d日'),
            ]);
        } else {
            return view(
                'user.payment.service_payment',
                [
                    'success' => true,
                    'service' => $service,
                    'date_from' => $datefrom->format('Y年m月d日'),
                    'date_to' => $dateto->format('Y年m月d日'),
                    'order_id' => $order_id
                ]
            );
        }
    }

    public function paymentWithService(Request $request)
    {
        $user = User::find(Auth::id());
        if (!$user->payment_id) {
            $this->registerMember($user);
        }
        $order_id = $request->order_id;
        $card_id = $request->card_id;
        $address_id = $request->address_id;
        $orderInfo = Order::findOrFail($order_id);
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $service = Service::all()->first();
        $datefrom = Carbon::now();
        $dateto = Carbon::now()->addDays(30);
        $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
        $coupon_id = $request->coupon_id;
        $coupon =  Coupon::find($coupon_id);
        $discountedMoneyTotal = (new UserController())->getDiscountedTotal($coupon, $orderInfo->total_price);
        $userType = Config::get('const.userType');
        $paymentMethod = $request->method ?  $request->method : 1;
        if ($paymentMethod == '2') {
            if ($address_id) {
                $address = UserAddress::findOrFail($address_id);
                return view('user.payment.postpaid_confirm_service', [
                    'payment_method' => $paymentMethod,
                    'data' => $orderInfo,
                    'address' => $address,
                    'account_id' => $account_id,
                    'order_id' => $order_id,
                    'user_type' => $userType,
                    'service' => $service,
                    'date_from' => $datefrom->format('Y年m月d日'),
                    'date_to' => $dateto->format('Y年m月d日'),
                    'coupon' => $coupon,
                    'discountedMoneyTotal' => $discountedMoneyTotal
                ]);
            } else {
                $addresses = UserAddress::where('user_id', Auth::id())->where('public', true)->get();
                $userType = Config::get('const.userType');
                $prefectures = Config::get('const.prefectures');
                $selectType = null;
                if ($request->selectType) {
                    $selectType = intval($request->selectType);
                }
                if (!count($addresses)) {
                    return view('user.payment.postpaid_register', [
                        'service_type' => 4,
                        'order_id' => $order_id,
                        'userType' => $userType,
                        'prefectures' => $prefectures,
                        'selectType' => $selectType,
                        'coupon' => $coupon
                    ]);
                } else {
                    $address = null;
                    foreach ($addresses as $item) {
                        if ($item->default == 1) {
                            $address = $item;
                            break;
                        }
                    }
                    if (!$address) {
                        $address = $addresses[0];
                    }
                    return view('user.payment.postpaid_confirm_service', [
                        'payment_method' => $paymentMethod,
                        'data' => $orderInfo,
                        'address' => $address,
                        'account_id' => $account_id,
                        'order_id' => $order_id,
                        'user_type' => $userType,
                        'service' => $service,
                        'date_from' => $datefrom->format('Y年m月d日'),
                        'date_to' => $dateto->format('Y年m月d日'),
                        'coupon' => $coupon,
                        'discountedMoneyTotal' => $discountedMoneyTotal
                    ]);
                }
            }
            return view('user.card.management');
        } else {
            $request_data = new \CardInfoGetRequestDto();
            $request_data->setAccountId($account_id);

            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
            $cardList = array();

            if (!isset($response_data)) {
                return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList]);
            } else {
                $pay_now_id_res = $response_data->getPayNowIdResponse();

                if (isset($pay_now_id_res)) {
                    $account = $pay_now_id_res->getAccount();
                    if (isset($account)) {
                        $cardInfos = $account->getCardInfo();
                        if ($cardInfos) {
                            $cardDefault = $this->getCardDefault($cardInfos, $card_id);
                            if ($cardDefault) {
                                return view('user.payment.confirm_service', [
                                    'data' => $orderInfo,
                                    'token' => NULL,
                                    'card_number' => $cardDefault->getCardNumber(),
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    'card_expire' => $cardDefault->getCardExpire(),
                                    'order_id' => $order_id,
                                    'card_id' => $cardDefault->getCardId(),
                                    'service' => $service,
                                    'date_from' => $datefrom->format('Y年m月d日'),
                                    'date_to' => $dateto->format('Y年m月d日'),
                                ]);
                            }
                        }
                    }
                }
            }
            return view('user.payment.payment_now', [
                'order_id' => $orderInfo->id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => $payment_id
            ]);
        }
    }

    public function payWithService(Request $request, RecognitionService $regservice)
    {
        // DB::beginTransaction();
        $order_id = $request->order_id;
        $orderInfo = Order::findOrFail($order_id);
        $history = PaymentHistory::where('payment_id', $order_id)->first();
        $coupon = Coupon::find($request->coupon_id);

        if ($history) {
            return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
        }
        $paymentMethod = $request->method ?  $request->method : 1;

        // $total_time = 0;
        // $total_price = 0;
        // $price = 30;
        // foreach ($orderInfo->audios as $audio) {
        //     $total_time += $audio->duration;
        //     $total_price += ceil($audio->duration / 60 * $price);
        // }
        $user = User::find(Auth::id());
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $service = Service::all()->first();
        $order_id = $request->order_id;
        $isRegis = DB::table('user_services')->where('user_id', $user->id)->first();

        if (!$isRegis) {
            $user->services()->attach($service->id, [
                'status' => 0,
                'register_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $user->services()->updateExistingPivot($service->id, [
                'status' => 0,
                'register_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        $ref = $user->services()->find($service->id);
        $odid = 'VOITRASV' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT) . str_pad($ref->id, 4, "0", STR_PAD_LEFT) . str_pad(rand(100, 999), 3, "0", STR_PAD_LEFT);

        $isRegis = DB::table('user_services')->where('user_id', $user->id)->where('status', 1)->first();

        $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $userType = Config::get('const.userType');
        $delivery_id = DELIVERY_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 3, "0", STR_PAD_LEFT);

        $total_price = $this->getTotalPrice(ORDER_SERVICE_TYPE, $paymentMethod, $orderInfo, $coupon, $service);

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
                        $rel->pivot->status = ORDER_PROCESSING;
                        $rel->pivot->save();
                    } else {
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = ORDER_ERROR;
                        $rel->pivot->save();
                    }
                    array_push($audios_id, $audio->id);
                } catch (\Exception $e) {
                    $audio->token = $token;
                    $audio->save();
                    $rel = $orderInfo->audios()->find($audio->id);
                    $rel->pivot->status = ORDER_ERROR;
                    $rel->pivot->save();
                    Log::error($e->getMessage());
                }
            }
            $title = $orderInfo->plan == 1 ? 'AI文字起こしプラン（' . join(", ", $audios_id) .  '）' : 'ブラッシュアッププラン（' . join(", ", $audios_id) .  '）';
            $history = PaymentHistory::create([
                'title' => $title,
                'user_id' => Auth::id(),
                'payment_id' => $order_id,
                'payment_type' => 0,
                'payid' => $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id,
                'total_price' => $total_price,
                'type' => 1,
                'service_id' => $service->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            $ref->pivot->payment_id =  $payment_id;
            $ref->pivot->payment_type = $paymentMethod;
            $ref->pivot->payment_status = $paymentMethod == PAYMENT_CREDIT ? PAYMENT_DONE : PAYMENT_VERIFIED;
            $ref->pivot->status = 1;
            $ref->pivot->order_id = $order_id;
            $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
            $ref->pivot->save();
            if ($coupon) {
                $orderInfo->coupon_id = $coupon->id;
                $coupon->used_quantity = $coupon->used_quantity + 1;
                $coupon->save();
            }
            $orderInfo->status = ORDER_PROCESSING;
            $orderInfo->service_id = $service->id;
            $orderInfo->payment_id = $payment_id;
            $orderInfo->payment_type = null;
            $orderInfo->payment_status = null;
            $orderInfo->payid = null;
            $orderInfo->save();
            Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】AI文字起こしプラン お申し込み完了', 'emails.order_done'));
            Mail::to($user->email)->send(new SendMail(['user' => $user, 'option' => $service->name], '【voitra】' . $service->name . 'お申し込み手続きの完了通知', 'emails.register_option_success'));
            return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
        }

        if ($paymentMethod == PAYMENT_POSTPAID) {
            $address = UserAddress::findOrFail($request->address_id);

            $request_data = $request->fix ? new \ScoreatpayCorrectAuthRequestDto() : new \ScoreatpayAuthorizeRequestDto();
            $buyerContact = new \ScoreatpayContactDto();
            $delivery = new \ScoreatpayDeliveryDto();
            $detail1 = new \ScoreatpayDetailDto();

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

            $delivery->setDeliveryId($delivery_id);
            $delivery->setContact($buyerContact);
            $delivery->setDetails([$detail1]);


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

        $orderInfo = Order::find($order_id);
        $user = User::find(Auth::id());
        $audios_id = array();

        if (isset($response_data)) {
            Log::info($response_data);
            $result_order_id = $response_data->getOrderId();
            $txn_status =  $response_data->getMStatus();
            // $txn_status = $request->address_id && ($request->address_id == 18 || $request->address_id == 20) ? 'pending' : $response_data->getMStatus();
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();
            if ($paymentMethod == PAYMENT_POSTPAID) {
                $authorResult = $response_data->getAuthorResult();
            }

            if ((TXN_SUCCESS_CODE === $txn_status && !isset($authorResult)) || (isset($authorResult) && $authorResult == AUTH_CODE_OK)) {
                $request_data = new \ScoreatpayCaptureRequestDto();
                $request_data->setOrderId($payment_id);
                $request_data->setPdCompanyCode(99);
                $request_data->setSlipNo(914712022);
                $request_data->setDeliveryId($delivery_id);
                $transaction = new \TGMDK_Transaction();
                $response_data = $transaction->execute($request_data);
                Log::info($response_data);
                foreach ($orderInfo->audios as $audio) {
                    $token = bin2hex(random_bytes(32));
                    $url = url('/api/webhook/' . $orderInfo->id . '/' . $audio->id . '/' . $token);
                    try {
                        $response = $regservice->recognize($audio->id, $audio->url, $audio->language, $audio->pivot->diarization, $audio->pivot->num_speaker, $url, 0);
                        if ($response->success) {
                            $audio->token = $token;
                            $audio->save();
                            $rel = $orderInfo->audios()->find($audio->id);
                            $rel->pivot->status = ORDER_PROCESSING;
                            $rel->pivot->save();
                        } else {
                            $rel = $orderInfo->audios()->find($audio->id);
                            $rel->pivot->status = ORDER_ERROR;
                            $rel->pivot->save();
                        }
                        array_push($audios_id, $audio->id);
                    } catch (\Exception $e) {
                        $audio->token = $token;
                        $audio->save();
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = ORDER_ERROR;
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
                    'payid' => $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id,
                    'total_price' => $total_price,
                    'type' => 1,
                    'service_id' => $service->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]);
                $ref->pivot->payment_id =  $payment_id;
                $ref->pivot->payment_type = $paymentMethod;
                $ref->pivot->payment_status = $paymentMethod == PAYMENT_CREDIT ? PAYMENT_DONE : PAYMENT_VERIFIED;
                $ref->pivot->status = 1;
                $ref->pivot->order_id = $order_id;
                $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                $ref->pivot->save();
                if ($coupon) {
                    $orderInfo->coupon_id = $coupon->id;
                    $coupon->used_quantity = $coupon->used_quantity + 1;
                    $coupon->save();
                }
                $orderInfo->status = ORDER_PROCESSING;
                $orderInfo->service_id = $service->id;
                $orderInfo->payment_id = $payment_id;
                $orderInfo->payment_type = $paymentMethod;
                $orderInfo->payment_status = $paymentMethod == PAYMENT_CREDIT ? PAYMENT_DONE : PAYMENT_VERIFIED;
                $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                $orderInfo->save();
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_1_plus_ok', $orderInfo->id, $user->name);
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 4], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 4], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
                }
                Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo], '【voitra】AI文字起こしプラン お申し込み完了', 'emails.order_done'));
                Mail::to($user->email)->send(new SendMail(['user' => $user, 'option' => $service->name], '【voitra】' . $service->name . 'お申し込み手続きの完了通知', 'emails.register_option_success'));

                return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
            } else if ((isset($authorResult) && $authorResult == AUTH_CODE_HOLD)) {
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    if (count($user->services) <= 0) {
                        $user->services()->attach($service->id, [
                            'status' => 0,
                            'payment_type' => $paymentMethod,
                            'payment_status' => PAYMENT_HOLD,
                            'register_at' => Carbon::now(),
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    } else {
                        $user->services()->updateExistingPivot($service->id, [
                            'status' => 0,
                            'payment_type' => $paymentMethod,
                            'payment_status' => PAYMENT_HOLD,
                            'register_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                    foreach ($orderInfo->audios as $audio) {
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = ORDER_HOLD;
                        $rel->pivot->save();
                    }
                    $ref->pivot->payment_id =  $payment_id;
                    $ref->pivot->payment_type = $paymentMethod;
                    $ref->pivot->payment_status = PAYMENT_HOLD;
                    $ref->pivot->status = ORDER_HOLD;
                    $ref->pivot->order_id = $order_id;
                    $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                    $ref->pivot->save();
                    $orderInfo->status = ORDER_HOLD;
                    $orderInfo->service_id = $service->id;
                    $orderInfo->payment_id = $payment_id;
                    $orderInfo->payment_type = $paymentMethod;
                    $orderInfo->payment_status = PAYMENT_HOLD;
                    $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                    if ($coupon) {
                        $orderInfo->coupon_id = $coupon->id;
                        $coupon->used_quantity = $coupon->used_quantity + 1;
                        $coupon->save();
                    }
                    $orderInfo->save();
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_1_plus_hr', $orderInfo->id, $user->name);
                    // Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 4], '【voitra】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold'));
                    // Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 4], '【voitra通知】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold_admin'));
                    return view('user.payment.complete_hold', ['success' => false, 'order' => $orderInfo, 'type' => 4]);
                }
                return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
            } else if ((isset($authorResult) && $authorResult == AUTH_CODE_NG)) {
                Log::error($response_data);
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    foreach ($orderInfo->audios as $audio) {
                        $rel = $orderInfo->audios()->find($audio->id);
                        $rel->pivot->status = ORDER_CANCEL;
                        $rel->pivot->save();
                    }
                    $ref->pivot->payment_id =  $payment_id;
                    $ref->pivot->payment_type = $paymentMethod;
                    $ref->pivot->payment_status = PAYMENT_NG;
                    $ref->pivot->status = SERVICE_CANCEL;
                    $ref->pivot->order_id = $order_id;
                    $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                    $ref->pivot->save();
                    $orderInfo->service_id = $service->id;
                    $orderInfo->payment_id = $payment_id;
                    $orderInfo->payment_type = $paymentMethod;
                    $orderInfo->payment_status = PAYMENT_NG;
                    $orderInfo->status = ORDER_CANCEL;
                    $orderInfo->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
                    if ($coupon) {
                        $orderInfo->coupon_id = $coupon->id;
                    }
                    $orderInfo->save();
                    $this->broadcastNoticeToAllAdminUsers('postpaid_plan_1_plus_ng', $orderInfo->id, $user->name);
                    Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 4], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
                    Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $orderInfo, 'type' => 4], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
                    return view('user.payment.complete_ng', ['success' => false, 'order' => $orderInfo, 'merrMsg' => $error_message, 'type' => 4]);
                }
                return view('user.payment.payment', [
                    'error' => true,
                    'order_id' => $orderInfo->id,
                    'api_token' => config('veritrans.api_token'),
                    'api_url' => config('veritrans.api_url'),
                    'payment_id' => $payment_id
                ]);
            } else {
                if ($paymentMethod == PAYMENT_POSTPAID) {
                    $service = Service::all()->first();
                    $datefrom = Carbon::now();
                    $dateto = Carbon::now()->addDays(30);
                    return view('user.payment.postpaid_confirm_service', [
                        'error' => true,
                        'payment_method' => PAYMENT_POSTPAID,
                        'data' => $orderInfo,
                        'account_id' => $account_id,
                        'address' => $address,
                        'order_id' => $order_id,
                        'user_type' => $userType,
                        'service' => $service,
                        'date_from' => $datefrom->format('Y年m月d日'),
                        'date_to' => $dateto->format('Y年m月d日'),
                    ]);
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
        return view('user.payment.complete', ['success' => true, 'order' => $orderInfo]);
    }

    public function repay($type, $order_id = null, Request $request)
    {
        $user = User::find(Auth::id());
        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
        $service = Service::all()->first();
        $datefrom = Carbon::now();
        $dateto = Carbon::now()->addDays(30);
        $ref = $user->services()->find($service->id);

        if ($type == SERVICE_TYPE && $ref && $ref->pivot->status == 1) {
            return redirect()->route('audioManager');
        } else {
            $history = PaymentHistory::where('payment_id', $order_id)->first();
            if ($history) {
                return redirect()->route('audioManager');
            }
        }
        if ($ref) {
            $payment_status = $ref->pivot->payment_status;
            $ref->pivot->payment_status = PAYMENT_CANCEL;
            $ref->pivot->status = SERVICE_CANCEL;
        }
        if ($type == SERVICE_TYPE && $ref && $ref->pivot->order_id) {
            $order_id = $ref->pivot->order_id;
        }
        $orderInfo = Order::find($order_id);
        if ($type == SERVICE_TYPE) {
            $payment_id = $ref->pivot->payment_id;
        } else {
            $payment_id = $request->payment_id ? $request->payment_id : $orderInfo->payment_id;
        }

        if ($orderInfo) {
            foreach ($orderInfo->audios as $audio) {
                $rel = $orderInfo->audios()->find($audio->id);
                $rel->pivot->status = ORDER_DISABLE;
                $rel->pivot->save();
            }

            $payment_status = $orderInfo->payment_status;

            if ($orderInfo->plan == 2) {
                $orderInfo->status = BRUSHUP_ERROR;
            } else {
                $orderInfo->status = ORDER_CANCEL;
            }

            $orderInfo->payment_status = PAYMENT_CANCEL;
            $payment_id = $orderInfo->payment_id ? $orderInfo->payment_id : TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
        }

        $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);

        if ($payment_status == PAYMENT_HOLD || $payment_status == PAYMENT_RESERVE) {
            $request_data = new \ScoreatpayCancelRequestDto();
            $request_data->setOrderId($payment_id);
            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
            Log::info("Cancel Request Data");
            Log::info($response_data);
            if ($response_data && $response_data->getMstatus() != TXN_SUCCESS_CODE) {
                if ($orderInfo) {
                    $payment_id = TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
                } else {
                    $payment_id = TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($ref->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
                }
            }
        }

        if ($type == SERVICE_TYPE || $type == ORDER_SERVICE_TYPE) {
            $ref->pivot->payment_id = $payment_id;
            $ref->pivot->save();
        }

        if ($orderInfo) {
            // Reset payment_id for next transaction.
            if ($orderInfo->payment_id == $payment_id) {
                $payment_id = TARGET_GROUP_ID . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . str_pad($orderInfo->id, 5, "0", STR_PAD_LEFT) . strval(rand(100, 999));
            }
            $orderInfo->payment_id = $payment_id;
            $orderInfo->save();
        }

        $request_data = new \CardInfoGetRequestDto();
        $request_data->setAccountId($account_id);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
        $cardList = array();

        $coupon = NULL;
        $discountedMoneyTotal = (new UserController())->getDiscountedTotal($coupon, $orderInfo->total_price);

        if (!isset($response_data)) {
            return view('user.card.management', ['account_id' => $account_id, 'cards' => $cardList, 'type' => $type, 'order_id' => $order_id]);
        } else {
            Log::info($response_data);
            $pay_now_id_res = $response_data->getPayNowIdResponse();
            if (isset($pay_now_id_res)) {
                $account = $pay_now_id_res->getAccount();
                if (isset($account)) {
                    $cardInfos = $account->getCardInfo();
                    if ($cardInfos) {
                        $cardDefault = $this->getCardDefault($cardInfos, null);
                        if ($cardDefault) {
                            if ($type == ORDER_SERVICE_TYPE || $type == SERVICE_TYPE || ($type == ORDER_TYPE && $orderInfo->service_id)) {
                                return view('user.payment.service_confirm', [
                                    'date_from' => $datefrom->format('Y年m月d日'),
                                    'date_to' => $dateto->format('Y年m月d日'),
                                    'service' => $service,
                                    'token' => $cardDefault->getCardId(),
                                    'card_number' => $cardDefault->getCardNumber(),
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    'card_expire' => $cardDefault->getCardExpire(),
                                    'order_id' => $order_id,
                                    'card_id' => $cardDefault->getCardId()
                                ]);
                            } else if ($type == BRUSHUP_TYPE) {
                                $audios = array();
                                $total_time = 0;
                                $total_price = 0;
                                foreach ($orderInfo->audios as $audio) {
                                    $data = $this->getInfor($audio);
                                    $audio->expected = $audio->pivot->user_estimate;
                                    $audio->deadline = $audio->pivot->admin_estimate;
                                    $audio->length = $data['length'];
                                    $audio->price = $orderInfo->audios()->find($audio->id)->pivot->price;
                                    $total_time += $audio->length;
                                    $total_price += $audio->price;
                                    array_push($audios, $audio);
                                }
                                $orderInfo->total_time = $total_time;
                                $orderInfo->total_price = $total_price;
                                return view('user.payment.brushup_confirm', [
                                    'data' => $orderInfo,
                                    'token' => $cardDefault->getCardId(),
                                    'card_number' => $cardDefault->getCardNumber(),
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    'card_expire' => $cardDefault->getCardExpire(),
                                    'order_id' => $order_id,
                                    'audios' => $audios,
                                    'card_id' => $cardDefault->getCardId()
                                ]);
                            } else {
                                return view('user.payment.confirm', [
                                    'data' => $orderInfo,
                                    'coupon' => $coupon,
                                    'token' => NULL,
                                    'card_number' => $cardDefault->getCardNumber(),
                                    'username' => NULL,
                                    'account_id' => $account_id,
                                    'card_expire' => $cardDefault->getCardExpire(),
                                    'order_id' => $order_id,
                                    'card_id' => $cardDefault->getCardId(),
                                    'discountedMoneyTotal' => $discountedMoneyTotal,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        if ($type == ORDER_SERVICE_TYPE || $type == SERVICE_TYPE) {
            return view('user.payment.service_paynow', [
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'order_id' => $order_id,
                'payment_id' => TARGET_GROUP_ID . '_' . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT) . '_' . str_pad($service->id, 3, "0", STR_PAD_LEFT)
            ]);
        } else {
            return view('user.payment.payment_now', [
                'order_id' => $orderInfo->id,
                'api_token' => config('veritrans.api_token'),
                'api_url' => config('veritrans.api_url'),
                'payment_id' => $payment_id
            ]);
        }
    }

    public function test(Request $request, RecognitionService $regservice)
    {
        $orders = Order::find();
        $postpaidErrorStatus = Config::get('const.postpaidErrorStatus');
        $user = User::find(Auth::id());

        foreach ($orders as $order) {
            $request_data = new \ScoreatpayCancelRequestDto();
            $request_data->setOrderId($order->payment_id);
            $transaction = new \TGMDK_Transaction();
            $response_data = $transaction->execute($request_data);
        }
        // foreach ($orders as $order) {
        //     $request_data = new \ScoreatpayConfirmRequestDto();
        //     $request_data->setOrderId($order->payment_id);

        //     $transaction = new \TGMDK_Transaction();
        //     $response_data = $transaction->execute($request_data);

        //     $type = 1;
        //     if ($order->plan == 1) {
        //         if ($order->service) {
        //             $type = 4;
        //         }
        //     } else if ($order->plan == 2) {
        //         $type = 2;
        //     }
        //     // if (isset($response_data)) {
        //     $result_order_id = $response_data->getOrderId();
        //     $txn_status = $response_data->getMStatus();
        //     $txn_result_code = $response_data->getVResultCode();
        //     $error_message = $response_data->getMerrMsg();
        //     // if ('success' === $txn_status) {
        //     $status = $response_data->getAuthorResult();
        //     $data = [
        //         1 => 'NG',
        //         2 => 'OK',
        //         3 => 'HR',
        //     ];
        //     $ddd = [1 => 'c10', 2 => 'c11', 3 => 'c12', 4 => 'c13', 5 => 'c14', 6 => 'c20', 7 => 'c21', 8 => 'c22', 9 => 'c33', 10 => 'c23', 11 => 'c24', 12 => 'c25', 13 => 'c31', 14 => 'c32', 15 => 'c26', 16 => 'c27', 17 => 'c36', 18 => 'c28', 19 => 'c29', 20 => 'c34', 21 => 'c35', 22 => 'c37', 23 => 'c38', 24 => 'c30', 25 => 'c40', 26 => 'c41', 27 => 'c39', 28 => 'c42', 29 => 'c43', 30 => 'c44', 31 => 'c50', 32 => 'c60', 33 => 'c65', 34 => 'c70', 35 => 'c80'];
        //     $status = $data[rand(1, 3)];
        //     if ($status == 'NG') {
        //         foreach ($order->audios as $audio) {
        //             $rel = $order->audios()->find($audio->id);
        //             $rel->pivot->status = 7;
        //             $rel->pivot->save();
        //         }
        //         $order->status = 7;
        //         $order->payment_status = 1;
        //         Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
        //         Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
        //     } else if ($status == 'HR') {
        //         foreach ($order->audios as $audio) {
        //             $rel = $order->audios()->find($audio->id);
        //             $rel->pivot->status = 9;
        //             $rel->pivot->save();
        //         }
        //         $reason = $response_data->getHoldReasons();
        //         $reason =  $ddd[rand(1, 35)];
        //         $order->payment_description = $postpaidErrorStatus[$reason];
        //         $order->payment_status = 5;

        //         $order->status = 9;
        //         Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold'));
        //         Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra通知】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold_admin'));
        //     } else if ($status == 'OK') {
        //         if ($order->plan == 1) {
        //             foreach ($order->audios as $audio) {
        //                 $token = bin2hex(random_bytes(32));
        //                 $url = url('/api/webhook/' . $order->id . '/' . $audio->id . '/' . $token);
        //                 try {
        //                     $response = $regservice->recognize($audio->id, $audio->url, $audio->language, $audio->pivot->diarization, $audio->pivot->num_speaker, $url, 0);
        //                     if ($response->success) {
        //                         $audio->token = $token;
        //                         $audio->save();
        //                         $rel = $order->audios()->find($audio->id);
        //                         $rel->pivot->status = 1;
        //                         $rel->pivot->save();
        //                     } else {
        //                         $rel = $order->audios()->find($audio->id);
        //                         $rel->pivot->status = 3;
        //                         $rel->pivot->save();
        //                     }
        //                     array_push($audios_id, $audio->id);
        //                 } catch (\Exception $e) {
        //                     $audio->token = $token;
        //                     $audio->save();
        //                     $rel = $order->audios()->find($audio->id);
        //                     $rel->pivot->status = 3;
        //                     $rel->pivot->save();
        //                     Log::error($e->getMessage());
        //                 }
        //             }
        //             $order->status = 1;
        //         } else {
        //             foreach ($order->audios as $audio) {
        //                 $audio->edited_result = $audio->api_result;
        //                 $audio->save();
        //                 array_push($audios_id, $audio->id);
        //             }
        //         }
        //         $order->payment_status = 4;
        //         $order->status = 3;
        //         Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
        //         Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $order, 'type' => $type], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
        //         if ($type == 2) {
        //             Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order], '【voitra】ブラッシュアッププラン  お申し込み完了', 'emails.plan_2_success'));
        //             Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'order' => $order], '【voitra 対応】ブラッシュアッププラン お申し込みが入りました', 'emails.send_admin_payment_plan_2_success'));
        //         } else {
        //             Mail::to($user->email)->send(new SendMail(['user' => $user, 'order' => $order], '【voitra】AI文字起こしプラン お申し込み完了', 'emails.order_done'));
        //         }
        //     }
        //     $order->save();
        //     // }
        //     // }
        //     Log::info($response_data);
        // }

        // $services = DB::table('user_services')->where('payment_status', 2)->get();
        // foreach ($services as $service) {
        //     // try {
        //     if (!$service->order_id) {
        //         $request_data = new \ScoreatpayConfirmRequestDto();
        //         $request_data->setOrderId($service->payment_id);

        //         $transaction = new \TGMDK_Transaction();
        //         $response_data = $transaction->execute($request_data);

        //         // if (isset($response_data)) {
        //         $result_order_id = $response_data->getOrderId();
        //         $txn_status =  $response_data->getMStatus();
        //         $txn_result_code = $response_data->getVResultCode();
        //         $error_message = $response_data->getMerrMsg();
        //         // if ('success' === $txn_status) {
        //         $status = $response_data->getAuthorResult();
        //         $data = [
        //             1 => 'NG',
        //             2 => 'OK',
        //             3 => 'HR',
        //         ];
        //         $ddd = [1 => 'c10', 2 => 'c11', 3 => 'c12', 4 => 'c13', 5 => 'c14', 6 => 'c20', 7 => 'c21', 8 => 'c22', 9 => 'c33', 10 => 'c23', 11 => 'c24', 12 => 'c25', 13 => 'c31', 14 => 'c32', 15 => 'c26', 16 => 'c27', 17 => 'c36', 18 => 'c28', 19 => 'c29', 20 => 'c34', 21 => 'c35', 22 => 'c37', 23 => 'c38', 24 => 'c30', 25 => 'c40', 26 => 'c41', 27 => 'c39', 28 => 'c42', 29 => 'c43', 30 => 'c44', 31 => 'c50', 32 => 'c60', 33 => 'c65', 34 => 'c70', 35 => 'c80'];
        //         $status = $data[rand(1, 3)];
        //         if ($status == 'NG') {
        //             // $order->status = 7;
        //             // $order->payment_status = 1;
        //             DB::table('user_services')->where('id', $service->id)->update(['status' => 0, 'payment_status' => 1]);
        //             Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => 3], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
        //             Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => 3], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
        //         } else if ($status == 'HR') {
        //             $reason = $response_data->getHoldReasons();
        //             $reason =  $ddd[rand(1, 35)];
        //             // $order->payment_description = $postpaidErrorStatus[$reason];
        //             // $order->payment_status = 5;
        //             $user = User::find(Auth::id());
        //             $type = 3;
        //             DB::table('user_services')->where('id', $service->id)->update(['status' => 9, 'payment_status' => 5, 'payment_description' => $postpaidErrorStatus[$reason]]);
        //             Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => $type], '【voitra】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold'));
        //             Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => $type], '【voitra通知】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold_admin'));
        //         } else if ($status == 'OK') {
        //             DB::table('user_services')->where('id', $service->id)->update(['status' => 1, 'payment_status' => 3]);
        //             Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => 3], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
        //             Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => 3], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
        //             Mail::to($user->email)->send(new SendMail(['user' => $user, 'option' => $service->name], '【voitra】' . $service->name . 'お申し込み手続きの完了通知', 'emails.register_option_success'));
        //         }
        //         // $order->save();
        //         Log::info($response_data);
        //     }
        //     // } catch (\Exception $e) {
        //     //     // Log::error($e->getMessage());
        //     //     dd($e->getMessage());
        //     // }
        // }
        return 0;
    }
}
