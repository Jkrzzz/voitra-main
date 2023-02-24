<?php
namespace App\Traits;

use App\Events\Backend\Notifications\NotificationCreated;
use App\Models\Admin;
use App\Models\Order;
// use App\Models\Notification;
use App\Notifications\RealTimeNotification;
use Illuminate\Support\Facades\Notification;

/**
 * Trait Notification.
 */
trait NotificationTrait
{
    public function createBroadcastNotification(string $type, int $recipientId, int $referenceId, string $referenceName)
    {
        // $contentTpl = config('app-notification.type.'.$type.'.content_tpl');

        // $notice = new Notification();
        // $notice->message = str_replace('%refname%', $referenceName, $contentTpl);
        // $notice->recipient_id = $recipientId;
        // $notice->reference_id = $referenceId;
        // $notice->type  = config('app-notification.type.'.$type.'.id');
        // $notice->label = config('app-notification.label.'.$type);
        // $notice->save();

        // $notice->broadcast();

        // return;
    }

    public function broadcastNoticeToAllAdminUsers(string $type, int $referenceId, string $referenceName)
    {
        $adminUsers = Admin::where('role', 1)->get();
        $contentTpl = config('app-notification.type.'.$type.'.content_tpl');
        $noticeData = [
            'message'      => str_replace('%refname%', $referenceName, $contentTpl),
            'sub_type'     => config('app-notification.type.'.$type.'.id'),
            'reference_id' => $referenceId,
            'label'        => config('app-notification.type.'.$type.'.label'),
        ];

        // foreach ($adminUsers as $adminUser) {
        //     // $this->createBroadcastNotification($type, $adminUser->id, $referenceId, $referenceName);
        //     $adminUser->notify(new RealTimeNotification($noticeData));
        // }

        Notification::send($adminUsers, new RealTimeNotification($noticeData));
    }

    public function broadcastNoticeToStaffUser(string $type, int $referenceId, string $referenceName, int $staffId)
    {
        $staffUser = Admin::find($staffId);

        if (!$staffUser) {
            \Log::error('broadcastNoticeToStaffUser: could not find staffUser: '.$staffId);

            return;
        }

        $contentTpl = config('app-notification.type.'.$type.'.content_tpl');
        $noticeData = [
            'message'      => str_replace('%refname%', $referenceName, $contentTpl),
            'sub_type'     => config('app-notification.type.'.$type.'.id'),
            'reference_id' => $referenceId,
            'label'        => config('app-notification.type.'.$type.'.label'),
        ];

        Notification::send($staffUser, new RealTimeNotification($noticeData));
    }

    public function broadcastMessageNotice(string $type, int $roomId, int $senderId, int $receiverId = 0)
    {
        $sender = Admin::find($senderId);

        if (!$sender) {
            \Log::error('broadcastMessageNotice: could not find sender: '.$senderId);

            return;
        }

        $contentTpl = config('app-notification.type.'.$type.'.content_tpl');
        $noticeData = [
            'message'      => str_replace('%refname%', $sender->name, $contentTpl),
            'sub_type'     => config('app-notification.type.'.$type.'.id'),
            'reference_id' => $roomId,
            'label'        => config('app-notification.type.'.$type.'.label'),
        ];

        if ($receiverId) {
            $receiver = Admin::find($receiverId);
            $receiver->notify(new RealTimeNotification($noticeData));
        }
        else {
            $joinedRoomUsers = Admin::where('role', 1)->where('id', '!=', $senderId)->get();

            foreach ($joinedRoomUsers as $user) {
                $user->notify(new RealTimeNotification($noticeData));
            }

            $order = Order::find($roomId);

            if ($order->estimate_staff && $order->estimate_staff != $senderId) {
                Admin::find($order->estimate_staff)->notify(new RealTimeNotification($noticeData));
            }

            if ($order->edit_staff && $order->estimate_staff != $senderId) {
                Admin::find($order->edit_staff)->notify(new RealTimeNotification($noticeData));
            }
        }
    }
}
