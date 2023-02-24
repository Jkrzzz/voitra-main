<?php

namespace App\Console\Commands;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Services\SendMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Log;
use App\Models\PaymentHistory;

// define('MEMBER_GROUP_ID', 'VOITRA_MEMBER_TEST_');
require_once app_path() . '/Vendors/tgMdk/3GPSMDK.php';

class UpdateServices extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'update:service';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Update service';

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
  public function handle()
  {
    $services = DB::table('user_services')
      ->join('users', 'users.id', '=', 'user_services.user_id')
      ->where('users.status', 1)
      ->where('user_services.remove_at', null)
      ->get('user_services.*');
    $datefrom = Carbon::now();
    $dateto = Carbon::now()->addMonthsNoOverflow(1)->subDay();

    foreach ($services as $service) {
      try {
        DB::beginTransaction();

        $user = User::find($service->user_id);
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $service->updated_at)->addMonthsNoOverflow(1)->subDay();

        if ($date <= $datefrom) {
          Log::info('----- START uid('.$service->user_id.') sid('.$service->service_id.') -----');
          // $account_id = MEMBER_GROUP_ID . '_' . str_pad($service->user_id, 5, "0", STR_PAD_LEFT);
          // $service = Service::all()->first();

          $account_id = MEMBER_GROUP_ID . '_' . str_pad($service->user_id, 5, "0", STR_PAD_LEFT);
          $request_data = new \CardInfoGetRequestDto();
          $request_data->setAccountId($account_id);
          Log::info('ACCOUNT ID: '.$account_id);

          $transaction = new \TGMDK_Transaction();
          $response_data = $transaction->execute($request_data);
          $cardDefault = null;
          $pay_now_id_res = $response_data->getPayNowIdResponse();

          if (isset($pay_now_id_res)) {
            $account = $pay_now_id_res->getAccount();

            if (isset($account)) {
              $cardInfos = $account->getCardInfo();
              // Log::info($cardInfos);
              foreach ((array) $cardInfos as $cardInfo) {
                if ($cardInfo->getDefaultCard()) {
                  $cardDefault = $cardInfo->getCardId();
                }
              }
            }
          }
          // Log::info($cardDefault);

          // $isRegis = DB::table('user_services')->where('user_id', $user->id)->where('status', 1)->first();

          if (count($user->services) <= 0) {
            $user->services()->attach($service->service_id, [
              'status' => 1,
              'register_at' => Carbon::now(),
              'created_at' => Carbon::now(),
              'updated_at' => Carbon::now(),
            ]);
          }

          $ref = $user->services()->find($service->service_id);
          $rid = rand(100, 999);

          $odid = 'VOITRASV' . str_pad($user->id, 5, "0", STR_PAD_LEFT) . str_pad($ref->id, 4, "0", STR_PAD_LEFT) . str_pad($rid, 3, "0", STR_PAD_LEFT);
          Log::info('ORDER ID: '.$odid);
          $request_data = new \CardAuthorizeRequestDto();
          $request_data->setOrderId($odid);
          $request_data->setAmount($ref->price);
          $request_data->setAccountId($account_id);
          $request_data->setCardId($cardDefault);
          $request_data->setWithCapture(true);

          $transaction = new \TGMDK_Transaction();
          $response_data = $transaction->execute($request_data);
          if (isset($response_data)) {
            $result_order_id = $response_data->getOrderId();
            $txn_status = $response_data->getMStatus();
            $txn_result_code = $response_data->getVResultCode();
            $error_message = $response_data->getMerrMsg();
            if ('success' === $txn_status) {
              $history = PaymentHistory::create([
                'title' => $ref->name,
                'user_id' => $service->user_id,
                'payment_id' => $service->id,
                'payment_type' => 1,
                'total_price' => $ref->price,
                'type' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
              ]);
              // $user->save();
              $user->services()->updateExistingPivot($service->service_id, [
                'updated_at' => Carbon::now(),
              ]);
              Mail::to($user->email)->send(new SendMail([
                'user' => $user,
                'option' => $ref->name,
                'datefrom' => $datefrom->format('Y年m月d日'),
                'dateto' => $dateto->format('Y年m月d日')
              ], '【voitra】有効期限更新のお知らせ', 'emails.update_option_success'));
              Log::info('Payment success!');
            } else {
              $user->services()->updateExistingPivot($service->service_id, [
                'status' => 0,
                'updated_at' => Carbon::now(),
              ]);
              // var_dump($response_data);
              Log::info('Payment failed: transaction un-succeed!');
              Log::error($response_data);
              // DB::rollBack();
            }
          }
          else {
            $user->services()->updateExistingPivot($service->service_id, [
              'status' => 0,
              'updated_at' => Carbon::now(),
            ]);
            Log::info('Payment failed: not response data!');
          }
          Log::info('----- END -----');
        }

        DB::commit();
      } catch (\Exception $e) {
        Log::error($e);
        DB::rollBack();
      }
    }
  }
}
