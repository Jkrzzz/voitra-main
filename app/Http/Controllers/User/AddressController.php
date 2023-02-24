<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use App\Models\PaymentHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Services\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use App\Models\UserAddress;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\Log;

class AddressController extends Controller
{

  function __construct()
  {
    $this->order_status = Config::get('const', 'default');
  }

  public function index()
  {
    $addresses = UserAddress::where('user_id', Auth::id())->where('public', true)->get();
    $userType = Config::get('const.userType');
    return view('user.postpaid.index', ['userType' => $userType, 'addresses' => $addresses]);
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

  public function register(Request $request)
  {
//    $selectType = null;
//    if ($request->selectType) {
//      $selectType = intval($request->selectType);
//    }
    $prefectures = Config::get('const.prefectures');
    $userType = Config::get('const.userType');
    $contactType = Config::get('const.contactType');
    return view('user.postpaid.register', ['userType' => $userType, 'contactType' => $contactType, 'prefectures' => $prefectures]);
  }


  public function addAddress(Request $request)
  {

    $type = $request->type;
    $full_name = $request->name;
    $tel = $request->tel;
    $mobile = $request->mobile;
    $email = $request->email;
    $zipcode = $request->zipcode;
    $address1 = $request->address1;
    $address2 = $request->address2;
    $address3 = $request->address3;
    $company_name = $request->company_name;
    $department_name = $request->department_name;
    $total = UserAddress::where('user_id', Auth::id())->where('public', true)->count();
    $default = false;
    if ($total == 0) {
      $default = true;
      UserAddress::where('user_id', Auth::id())->update(['default' => 0]);
    }
    $location = UserAddress::create([
      'type' => $type,
      'full_name' => $full_name,
      'tel' => $tel,
      'mobile' => $mobile,
      'email' => $email,
      'zipcode' => $zipcode,
      'address1' => $address1,
      'address2' => $address2,
      'address3' => $address3,
      'company_name' => $company_name,
      'department_name' => $department_name,
      'user_id' => Auth::id(),
      'public' => true,
      'default' => $default,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
    ]);
    return redirect()->route('addressConfirm', ['type' => 0]);
  }

  public function changeAddress($type, $order_id = null, Request $request)
  {
    $order_id = $order_id;
    $type = $type;
    $address_id = $request->address_id;
    $addresses = UserAddress::where('user_id', Auth::id())->where('public', true)->get();
    $userType = Config::get('const.userType');
    $prefectures = Config::get('const.prefectures');
    $coupon_id = $request->coupon_id;
    $coupon = Coupon::find($coupon_id);
    if (empty($addresses)) {
      return view('user.payment.postpaid_register', ['order_id' => $order_id, 'prefectures' => $prefectures, 'service_type' => $type, 'coupon' => $coupon]);
    }
    return view('user.postpaid.list', [
      'type' => $type,
      'userType' => $userType,
      'order_id' => $order_id,
      'addresses' => $addresses,
      'current_address' => $address_id,
      'coupon' => $coupon
    ]);
  }


  public function fixAddress($type, $order_id = null, Request $request)
  {
    $userType = Config::get('const.userType');
    $prefectures = Config::get('const.prefectures');
//    $selectType = null;
//    if ($request->selectType) {
//      $selectType = intval($request->selectType);
//    }
    $user = User::find(Auth::id());
    if ($type == 3) {
      $service = Service::all()->first();
      $service = $user->services()->find($service->id);
      $payid = $service->pivot->payid;
    } else {
      $order = Order::find($order_id);
      $payid = $order->payid;
    }
    $address = UserAddress::find($payid);
    $selectType = $address->type;

    return view('user.payment.postpaid_update', [
      'service_type' => $type,
      'order' => @$order ? $order : $service->pivot,
      'userType' => $userType,
      'prefectures' => $prefectures,
//      'selectType' => $selectType,
      'address' => $address,
    ]);
  }


  public function editAddress($address_id, Request $request)
  {
    $address = UserAddress::find($address_id);
    $userType = Config::get('const.userType');
//    $selectType = null;
//    if ($request->selectType) {
//      $selectType = $request->selectType;
//    } else {
//      $selectType = $address->type;
//    }
    $prefectures = Config::get('const.prefectures');

    if (!isset($address)) {
      return view('user.postpaid.register', ['address' => $address, 'prefectures' => $prefectures, 'userType' => $userType]);
    }
    return view('user.postpaid.edit', [
      'userType' => $userType,
      'address' => $address,
      'prefectures' => $prefectures
    ]);
  }

  public function updateAddress($address_id, Request $request)
  {
//    $total = UserAddress::where('user_id', Auth::id())->where('public', true)->count();

    $type = $request->type;
    $full_name = $request->name;
    $tel = $request->tel;
    $mobile = $request->mobile;
    $email = $request->email;
    $zipcode = $request->zipcode;
    $address1 = $request->address1;
    $address2 = $request->address2;
    $address3 = $request->address3;
    if ($type == 1) {
        $company_name = $request->company_name;
        $department_name = $request->department_name;
    } else {
        $company_name = null;
        $department_name = null;
    }

//    $default = $request->default ? true : false;
//
//    if ($total == 0) {
//      $default = true;
//      UserAddress::where('user_id', Auth::id())->update(['default' => 0]);
//    }
    $address = UserAddress::where('id', $address_id)->update([
      'type' => $type,
      'full_name' => $full_name,
      'tel' => $tel,
      'mobile' => $mobile,
      'email' => $email,
      'zipcode' => $zipcode,
      'address1' => $address1,
      'address2' => $address2,
      'address3' => $address3,
      'company_name' => $company_name,
      'department_name' => $department_name,
      'user_id' => Auth::id(),
//      'default' => $default,
      'updated_at' => Carbon::now()
    ]);
    $address = UserAddress::where('id', $address_id)->first();
    // $addresses = UserAddress::where('user_id', Auth::id())->where('public', true)->get();
    // $userType = Config::get('const.userType');
    // return view('user.postpaid.index', ['userType' => $userType, 'addresses' => $addresses]);
    return redirect()->route('addressConfirm', ['type' => 1]);
  }

  public function delete(Request $request)
  {
    $address = UserAddress::find($request->address_id);
    $address->public = false;
    $address->save();
    // dd($address);

    if (!isset($address)) {
      return response()->json(['success' => false]);
    }
    return response()->json(['success' => true]);
  }


  public function registerPayment($type, $order_id = null, Request $request)
  {
    $userType = Config::get('const.userType');
    $prefectures = Config::get('const.prefectures');
    $coupon = Coupon::find($request->coupon_id);
//    $selectType = null;
//    if ($request->selectType) {
//      $selectType = intval($request->selectType);
//   ;
    return view('user.payment.postpaid_register', [
      'service_type' => $type,
      'order_id' => $order_id,
      'userType' => $userType,
      'prefectures' => $prefectures,
        'coupon' => $coupon
//      'selectType' => $selectType
    ]);
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

  public function success(Request $request)
  {
    $type = $request->type;
    return view('user.postpaid.success', ['type' => @$type]);
  }

  public function fixAndPay(Request $request)
  {

    $type = $request->type;
    $address_id = $request->address_id;
    $service_type = $request->service_type;
    $full_name = $request->name;
    $tel = $request->tel;
    $mobile = $request->mobile;
    $email = $request->email;
    $zipcode = $request->zipcode;
    $address1 = $request->address1;
    $address2 = $request->address2;
    $address3 = $request->address3;
    if ($type == 1) {
        $company_name = $request->company_name;
        $department_name = $request->department_name;
    } else {
        $company_name = null;
        $department_name = null;
    }


    $address = UserAddress::find($address_id);
    $address->update([
      'type' => $type,
      'full_name' => $full_name,
      'tel' => $tel,
      'mobile' => $mobile,
      'email' => $email,
      'zipcode' => $zipcode,
      'address1' => $address1,
      'address2' => $address2,
      'address3' => $address3,
      'company_name' => $company_name,
      'department_name' => $department_name,
      'user_id' => Auth::id(),
      'updated_at' => Carbon::now()
    ]);

    $user = User::find(Auth::id());
    $service = Service::all()->first();
    $ref = $user->services()->find($service->id);
    if ($type == 3 && $ref && $ref->pivot->order_id) {
      $order_id = $ref->pivot->order_id;
    } else {
      $order_id = $request->order_id;
    }

    $orderInfo = Order::find($order_id);
    $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
    $userType = Config::get('const.userType');
    // dd($address);

    if ($service_type == BRUSHUP_TYPE) {
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
      return view('user.payment.postpaid_brushup_confirm', [
        'payment_method' => 2,
        'data' => $orderInfo,
        'audios' => $audios,
        'address' => $address,
        'account_id' => $account_id,
        'order_id' => $order_id,
        'user_type' => $userType,
        'fix' => 1
      ]);
    } else if ($service_type == ORDER_SERVICE_TYPE || ($type == SERVICE_TYPE && $order_id) || ($type == ORDER_TYPE && $orderInfo && $orderInfo->service_id)) {
      $service = Service::all()->first();
      $datefrom = Carbon::now();
      $dateto = Carbon::now()->addDays(30);
      return view('user.payment.postpaid_confirm_service', [
        'payment_method' => 2,
        'data' => $orderInfo,
        'address' => $address,
        'account_id' => $account_id,
        'order_id' => $order_id,
        'user_type' => $userType,
        'service' => $service,
        'date_from' => $datefrom->format('Y年m月d日'),
        'date_to' => $dateto->format('Y年m月d日'),
        'fix' => 1

      ]);
    } else if ($service_type == SERVICE_TYPE) {
      $service = Service::all()->first();
      $datefrom = Carbon::now();
      $dateto = Carbon::now()->addDays(30);
      return view('user.payment.postpaid_service_confirm', [
        'date_from' => $datefrom->format('Y年m月d日'),
        'date_to' => $dateto->format('Y年m月d日'),
        'payment_method' => 2,
        'address' => $address,
        'account_id' => $account_id,
        'order_id' => $order_id ? $order_id : $service->id,
        'user_type' => $userType,
        'service' => $service,
        'fix' => 1

      ]);
    } else {
      return view('user.payment.postpaid_confirm', [
        'payment_method' => 2,
        'data' => $orderInfo,
        'address' => $address,
        'account_id' => $account_id,
        'order_id' => $order_id,
        'user_type' => $userType,
        'fix' => 1

      ]);
    }
  }

  public function registerPay(Request $request)
  {
    $type = $request->type;
    $service_type = $request->service_type;
    $full_name = $request->name;
    $tel = $request->tel;
    $mobile = $request->mobile;
    $email = $request->email;
    $zipcode = $request->zipcode;
    $address1 = $request->address1;
    $address2 = $request->address2;
    $address3 = $request->address3;
    $company_name = $request->company_name;
    $department_name = $request->department_name;
    $public = $request->public;

    if ($public == 'on') {
      $public = true;
    } else {
      $public = false;
    }
    $order_id = $request->order_id;
    $total = UserAddress::where('user_id', Auth::id())->where('public', true)->count();
    $default = false;
    if ($total == 0) {
      $default = true;
      UserAddress::where('user_id', Auth::id())->update(['default' => 0]);
    }
    $address = UserAddress::create([
      'type' => $type,
      'full_name' => $full_name,
      'tel' => $tel,
      'mobile' => $mobile,
      'email' => $email,
      'zipcode' => $zipcode,
      'address1' => $address1,
      'address2' => $address2,
      'address3' => $address3,
      'company_name' => $company_name,
      'department_name' => $department_name,
      'user_id' => Auth::id(),
      'public' => $public,
      'default' => $default,
      'created_at' => Carbon::now(),
      'updated_at' => Carbon::now()
    ]);
    $service = NULL;
    if ($service_type == SERVICE_TYPE || $service_type == ORDER_SERVICE_TYPE) {
      $service = Service::all()->first();
    }
    $orderInfo = Order::find($order_id);
    $account_id = MEMBER_GROUP_ID . '_' . str_pad(Auth::id(), 5, "0", STR_PAD_LEFT);
    $userType = Config::get('const.userType');
    $coupon = Coupon::find($request->coupon_id);
    $total_price = PaymentController::getTotalPrice($service_type, PAYMENT_POSTPAID, $orderInfo, $coupon, $service);
    $discountedMoneyTotal = (new UserController())->getDiscountedTotal($coupon, $total_price);

    if ($service_type == BRUSHUP_TYPE) {
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
        'payment_method' => 2,
        'data' => $orderInfo,
        'audios' => $audios,
        'address' => $address,
        'account_id' => $account_id,
        'order_id' => $order_id,
        'user_type' => $userType,
        'coupon' => $coupon,
        'discountedMoneyTotal' => $discountedMoneyTotal
      ]);
    } else if ($service_type == SERVICE_TYPE) {
      $service = Service::all()->first();
      $datefrom = Carbon::now();
      $dateto = Carbon::now()->addDays(30);
      return view('user.payment.postpaid_service_confirm', [
        'date_from' => $datefrom->format('Y年m月d日'),
        'date_to' => $dateto->format('Y年m月d日'),
        'payment_method' => 2,
        'address' => $address,
        'account_id' => $account_id,
        'order_id' => $order_id ? $order_id : $service->id,
        'user_type' => $userType,
        'service' => $service
      ]);
    } else if ($service_type == ORDER_SERVICE_TYPE) {
      $service = Service::all()->first();
      $datefrom = Carbon::now();
      $dateto = Carbon::now()->addDays(30);
      return view('user.payment.postpaid_confirm_service', [
        'payment_method' => 2,
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
      return view('user.payment.postpaid_confirm', [
        'payment_method' => 2,
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

  public function changeDefault(Request $request)
  {
    $address = UserAddress::find($request->address_id);
    if (!isset($address)) {
      return response()->json(['success' => false]);
    }
    UserAddress::where('user_id', Auth::id())->update(['default' => 0]);
    $address->default = true;
    $address->save();
    return response()->json(['success' => true]);
  }
}
