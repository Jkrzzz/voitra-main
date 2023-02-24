<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class RealTimeNoticeChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id'             => $notification->id,
            'type'           => get_class($notification),
            'data'           => $data['message'],
            'sub_type'       => $data['sub_type'],
            'label'          => $data['label'],
            'reference_type' => $data['reference_type'],
            'reference_id'   => $data['reference_id'],
            'read_at'        => null,
        ]);
    }
}
