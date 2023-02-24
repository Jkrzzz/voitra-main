<?php

namespace App\Http\Controllers\Admin;

use App\Events\Backend\Messages\MessagePosted;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Message;
use App\Models\Order;
use App\Traits\NotificationTrait;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use NotificationTrait;

    public function index (Request $request)
    {
        $messages = Message::with([
            'sender_id',
            'receiver_id'
        ])
        ->where('room_id', $request->query('room_id', ''))
        ->orderBy('created_at', 'asc')->get();

        return $messages;
    }

    public function store (Request $request)
    {
        $sender             = Auth::guard('admin')->user();
        $message            = new Message();
        $message->sender_id = $sender->role == 1 ? 0 : $sender->id;
        $message->content   = $request->input('content', '');

        if ($sender->role == 1) {
            $order = Order::where('id', $request->input('room_id'))->where(function ($query) use ($request) {
                $query->where('edit_staff', (int) $request->input('receiver_id'))
                      ->orWhere('estimate_staff', (int) $request->input('receiver_id'));
            })->first();
            if (!$order) {
                return response()->json([
                    'status'  => 'error',
                    'message' => '送信できません。'
                ]);
            }
        }

        if ($request->has('receiver_id') && $request->input('receiver_id')) {
            $receiver_id          = (int) $request->input('receiver_id');
            $message->receiver_id = $receiver_id;
            $message->room_id     = $request->input('room_id');
        } else {
            $receiver_id      = 0;
            $message->receiver_id = $receiver_id;
            $message->room_id = $request->input('room_id');
        }

        $message->save();

        broadcast(new MessagePosted($message->load('sender')))->toOthers(); // send to others EXCEPT user who sent this message
        $notice_type = $sender->role == 1 ? 'admin_message_created' : 'staff_message_created';
        // $this->broadcastMessageNotice($notice_type, $message->room_id, $message->sender_id, $receiver_id);
        $this->broadcastMessageNotice($notice_type, $message->room_id, $sender->id, $receiver_id);

        return response()->json(['status'  => 'success', 'message' => $message->load('sender')]);
    }

    public function ajaxMarkAsRead(Request $request)
    {
        $message = Message::find($request->input('message_id'));
        $message->receiver_read_at = Carbon::now()->format('Y-m-d H:i:s');
        // $message->save();

        return response()->json([
            'success' => true
        ]);
    }

    public function ajaxMarkAllAsRead(Request $request)
    {
        $sender_id = 0;
        if ($request->has('sender_id') && $request->has('sender_id') != $sender_id) {
            $sender_id = $request->input('sender_id');
            $sender = Admin::find($sender_id);
            if ($sender->role == 1) {
                $sender_id = 0;
            }
        }

        $receiver_id = 0;
        if ($request->has('receiver_id') && $request->has('receiver_id') != $receiver_id) {
            $receiver_id = $request->input('receiver_id');
            $receiver = Admin::find($receiver_id);
            if ($receiver->role == 1) {
                $receiver_id = 0;
            }
        }

        Message::where('sender_id', $sender_id)
            ->where('receiver_id', $receiver_id)
            ->whereNull('receiver_read_at')
            ->update(['receiver_read_at' => Carbon::now()->format('Y-m-d H:i:s')]);

        return response()->json([
            'success' => true
        ]);
    }

    public function test (Request $request, $sender_id, $room_id)
    {
        $message            = new Message();
        $message->sender_id = $sender_id;
        $message->content   = 'ンを解約しましたさんが話者分離オプショ。';
        $message->room_id   = $room_id;
        $receiver_id        = 0;
        $message->save();
        broadcast(new MessagePosted($message))->toOthers(); // send to others EXCEPT user who sent this message
        $this->broadcastMessageNotice('staff_message_created', $message->room_id, $message->sender_id, $receiver_id);
        dd($message->toArray());
    }
}
