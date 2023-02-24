<?php

namespace App\Notifications;

use App\Channels\RealTimeNoticeChannel;
use App\Notifications\DatabaseNotification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class RealTimeNotification extends Notification implements ShouldBroadcast
{
    public $notification;

    public function __construct(array $notification)
    {
        $this->notification = $notification;
        $this->setReferenceTypeBySubType();
    }

    public function via($notifiable)
    {
        return [
            RealTimeNoticeChannel::class,
            'broadcast' // always stand behind `RealTimeNoticeChannel::class` for store data to Database first.
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $notice = DatabaseNotification::find($this->id);
        $data   = $notice->toArray();

        $data['created_at'] = $notice->created_at->toDateTimeString();
        $data['updated_at'] = $notice->updated_at->toDateTimeString();

        return new BroadcastMessage($data);
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message'        => $this->notification['message']        ??  '',
            'sub_type'       => $this->notification['sub_type']       ??  0 ,
            'reference_type' => $this->notification['reference_type'] ??  '',
            'reference_id'   => $this->notification['reference_id']   ??  0 ,
            'label'          => $this->notification['label']          ??  0 ,
        ];
    }

    public function setReferenceTypeBySubType()
    {
        switch ($this->notification['sub_type']) {
            case  1: // service_canceled
            case  2: // membership_canceled
            case  3: // contact
            case 10: // postpaid_service_1_ok
            case 14: // postpaid_service_1_ng
            case 18: // postpaid_service_1_hr
                $this->notification['reference_type'] = 'App\Models\User';
                break;

            case  4: // user_est_requested
            case  5: // staff_estimated
            case  6: // user_edit_requested
            case  7: // staff_edited
            case  8: // postpaid_plan_1_ok
            case  9: // postpaid_plan_2_ok
            case 11: // postpaid_plan_1_plus_ok
            case 12: // postpaid_plan_1_ng
            case 13: // postpaid_plan_2_ng
            case 15: // postpaid_plan_1_plus_ng
            case 16: // postpaid_plan_1_hr
            case 17: // postpaid_plan_2_hr
            case 19: // postpaid_plan_1_plus_hr
            case 20: // admin_est_requested
            case 21: // admin_edit_requested
            case 22: // admin_message_created
            case 23: // staff_message_created
                $this->notification['reference_type'] = 'App\Models\Order';
                break;

            default:
                $this->notification['reference_type'] = '';
                break;
        }
    }
}
