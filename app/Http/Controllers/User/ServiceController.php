<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\PaymentController;
use App\Models\User;
use App\Models\SettingParam;
use App\Models\PaymentHistory;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Services\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Service;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Log;
use App\Traits\NotificationTrait;

class ServiceController extends Controller
{
  use NotificationTrait;

  function __construct()
  {
    $this->order_status = Config::get('const', 'default');
  }

  public function index($id = null)
  {
    $service = Service::all()->first();
    $datefrom = Carbon::now();
    $dateto = Carbon::now()->addDays(30);
    return view(
      'user.payment.service_payment',
      [
        'success' => true,
        'service' => $service,
        'date_from' => $datefrom->format('Y年m月d日'),
        'date_to' => $dateto->format('Y年m月d日'),
        'order_id' => $id
      ]
    );
  }

  public function registerWithOrder($id)
  {
    $service = Service::all()->first();
    $datefrom = Carbon::now();
    $dateto = Carbon::now()->addDays(30);
    return view(
      'user.payment.service_payment',
      [
        'success' => true,
        'service' => $service,
        'date_from' => $datefrom->format('Y年m月d日'),
        'date_to' => $dateto->format('Y年m月d日'),
        'order_id' => $id
      ]
    );
  }

  public function registerFree(Request $request)
  {
    try {
      $user = User::find(Auth::id());
      $service = Service::all()->first();
      if (count($user->services) <= 0) {
        $user->services()->attach($service->id, [
          'status' => 1,
          'register_at' => Carbon::now(),
          'created_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);
      } else {
        $user->services()->updateExistingPivot($service->id, [
          'status' => 1,
          'register_at' => Carbon::now(),
          'updated_at' => Carbon::now(),
        ]);;
      }
      $ref = $user->services()->find($service->id);
      $user->save();
      Mail::to($user->email)->send(new SendMail(['user' => $user, 'option' => $service->name], '【voitra】' . $service->name . 'お申し込み手続きの完了通知', 'emails.register_option_success'));
      return response()->json(['success' => true]);
    } catch (\Exception $e) {
      $message = 'Error: ' . $e->getMessage();
      return response()->json(['success' => false, 'mess' => $message]);
    }
  }

  public function register($var = null)
  {
    # code...
  }

  public function registerService(Request $request)
  {
    $user = User::find(Auth::id());
    $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
    $service = Service::all()->first();
    $order_id = $request->order_id;
    $paymentMethod = $request->method ? $request->method : 1;
    $coupon = Coupon::find($request->coupon_id);

    $isRegis = DB::table('user_services')->where('user_id', $user->id)->first();

    if ($isRegis && $isRegis->status == 1) {
      return view('user.payment.service_complete', ['success' => true, 'order_id' => $order_id]);
    }
    if (!$isRegis) {
      $user->services()->attach($service->id, [
        'status' => 0,
        'register_at' => Carbon::now(),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]);
    } else {
      $user->services()->updateExistingPivot($service->id, [
        'register_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
      ]);
    }
    $ref = $user->services()->find($service->id);
    $total_price = PaymentController::getTotalPrice(SERVICE_TYPE, $paymentMethod, $service, $coupon, $service);
    try {
      // DB::beginTransaction();
      $odid = 'VOITRASV' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT) . str_pad($ref->id, 4, "0", STR_PAD_LEFT) . str_pad(rand(100, 999), 3, "0", STR_PAD_LEFT);
      $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
      $userType = Config::get('const.userType');
      $delivery_id = 'VOITRASV' . strval(rand(100, 999)) . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT);

      if ($paymentMethod == PAYMENT_POSTPAID) {
        $address = UserAddress::findOrFail($request->address_id);

        $request_data = $request->fix ? new \ScoreatpayAuthorizeRequestDto() : new \ScoreatpayAuthorizeRequestDto();
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

        $detail1->setDetailName('VOITRASV' . strval(rand(100, 999)) . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT));
        $detail1->setDetailPrice($service->price);
        $detail1->setDetailQuantity(1);

        $detail2->setDetailName('VOITRAFEE' . str_pad(Auth::id(), 4, "0", STR_PAD_LEFT));
        $detail2->setDetailPrice(VOITRA_POSTPAID_FEE);
        $detail2->setDetailQuantity(1);

        $delivery->setDeliveryId($delivery_id);
        $delivery->setContact($buyerContact);
        $delivery->setDetails([$detail1, $detail2]);

        $request_data->setOrderId($odid);
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
        $request_data->setOrderId($odid);
        $request_data->setAmount($service->price);
        $request_data->setAccountId($request->account_id);
        $request_data->setCardId($request->card_id);
        $request_data->setWithCapture(true);

        $transaction = new \TGMDK_Transaction();
        $response_data = $transaction->execute($request_data);
      }
      // dd($response_data);

      if (isset($response_data)) {
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
          $request_data->setOrderId($odid);
          $request_data->setPdCompanyCode(99);
          $request_data->setSlipNo(914712022);
          $request_data->setDeliveryId($delivery_id);
          $transaction = new \TGMDK_Transaction();
          $response_data = $transaction->execute($request_data);
          $history = PaymentHistory::create([
            'title' => $service->name,
            'user_id' => Auth::id(),
            'payment_id' => $ref->id,
            'payment_type' => $paymentMethod,
            'total_price' => $total_price,
            'type' => 2,
            'payid' => $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
          ]);
          if ($paymentMethod == PAYMENT_CREDIT && $ref->pivot->order_id) {
            Order::where('id', $ref->pivot->order_id)->update(['service_id' => NULL]);
            $ref->pivot->order_id = NULL;
          }
          $ref->pivot->payment_id =  $odid;
          $ref->pivot->payment_type = $paymentMethod;
          $ref->pivot->payment_status = $paymentMethod == PAYMENT_CREDIT ? PAYMENT_DONE : PAYMENT_VERIFIED;
          $ref->pivot->status = 1;
          $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
          $ref->pivot->save();
          $user->save();
          if ($paymentMethod == PAYMENT_POSTPAID) {
            $this->broadcastNoticeToAllAdminUsers('postpaid_service_1_ok', $user->id, $user->name);
            Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => 3], '【voitra】後払い確定済通知', 'emails.postpaid.postpaid_success'));
            Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => 3], '【voitra 通知】後払い確定済通知', 'emails.postpaid.postpaid_success_admin'));
          }
          Mail::to($user->email)->send(new SendMail(['user' => $user, 'option' => $service->name], '【voitra】' . $service->name . 'お申し込み手続きの完了通知', 'emails.register_option_success'));
          return view('user.payment.service_complete', ['success' => false, 'order_id' => $order_id]);
        } else if ((isset($authorResult) && $authorResult == AUTH_CODE_HOLD)) {
          if ($paymentMethod == PAYMENT_POSTPAID) {
            $ref->pivot->payment_id =  $odid;
            $ref->pivot->payment_type = $paymentMethod;
            $ref->pivot->payment_status = 2;
            $ref->pivot->status = 8;
            $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
            if ($coupon) {
              $coupon->used_quantity = $coupon->used_quantity + 1;
              $coupon->save();
            }
            $ref->pivot->save();
            $this->broadcastNoticeToAllAdminUsers('postpaid_service_1_hr', $user->id, $user->name);
            // DB::commit();
            // Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => 3], '【voitra】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold'));
            // Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => 3], '【voitra通知】後払い決済情報修正のお願い', 'emails.postpaid.postpaid_hold_admin'));
            return view('user.payment.complete_hold', ['success' => false, 'merrMsg' => $error_message, 'type' => SERVICE_TYPE]);
          }
          return view('user.payment.service_complete', ['success' => false, 'order_id' => $order_id]);
        } else if ((isset($authorResult) && $authorResult == AUTH_CODE_NG)) {
          Log::error($response_data);
          if ($paymentMethod == PAYMENT_POSTPAID) {
            $ref->pivot->payment_id =  $odid;
            $ref->pivot->payment_type = $paymentMethod;
            $ref->pivot->payment_status = PAYMENT_NG;
            $ref->pivot->status = SERVICE_CANCEL;
            $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
            $ref->pivot->save();
            // DB::commit();
            $this->broadcastNoticeToAllAdminUsers('postpaid_service_1_ng', $user->id, $user->name);
            Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => 3], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
            Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => 3], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
            return view('user.payment.complete_ng', ['success' => false, 'merrMsg' => $error_message, 'type' => SERVICE_TYPE, 'order_id' => $odid]);
          }
          return view('user.payment.complete_ng', ['success' => false, 'merrMsg' => $error_message, 'type' => SERVICE_TYPE, 'order_id' => $odid]);
        } else {
          if ($paymentMethod == PAYMENT_POSTPAID) {
            $service = Service::all()->first();
            $datefrom = Carbon::now();
            $dateto = Carbon::now()->addDays(30);
            return view('user.payment.postpaid_service_confirm', [
              'error' => true,
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
          return view('user.payment.complete_ng', ['success' => false, 'merrMsg' => $error_message, 'type' => SERVICE_TYPE, 'order_id' => $odid]);
        }
      } else {
        Log::error($response_data);
        if ($paymentMethod == PAYMENT_POSTPAID) {
          $ref->pivot->payment_id =  $odid;
          $ref->pivot->payment_type = $paymentMethod;
          $ref->pivot->payment_status = 1;
          $ref->pivot->status = 0;
          $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
          $ref->save();
          // DB::commit();
          Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => 3], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
          Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => 3], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
          return view('user.payment.complete_ng', ['success' => false, 'merrMsg' => '', 'type' => SERVICE_TYPE, 'order_id' => $odid]);
        }
        return view('user.payment.complete_ng', ['success' => false, 'merrMsg' => '', 'type' => SERVICE_TYPE, 'order_id' => $odid]);
      }
    } catch (\Exception $e) {
      Log::error($response_data);
      if ($paymentMethod == PAYMENT_POSTPAID) {
        $ref->pivot->payment_id =  $odid;
        $ref->pivot->payment_type = $paymentMethod;
        $ref->pivot->payment_status = 1;
        $ref->pivot->status = 0;
        $ref->pivot->payid = $paymentMethod == PAYMENT_CREDIT ? $request->card_id : $request->address_id;
        $ref->save();
        Mail::to($user->email)->send(new SendMail(['user' => $user, 'type' => 3], '【voitra】後払い審査に関するお知らせ', 'emails.postpaid.postpaid_failed'));
        Mail::to(config('mail.admin_email'))->send(new SendMail(['user' => $user, 'type' => 3], '【voitra 通知】後払い失敗', 'emails.postpaid.postpaid_failed_admin'));
        return view('user.payment.complete_ng', ['success' => false, 'type' => SERVICE_TYPE, 'order_id' => $odid]);
      }
      return view('user.payment.complete_ng', ['success' => false, 'type' => SERVICE_TYPE, 'order_id' => $odid]);
    }
  }
}
