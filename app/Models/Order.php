<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'plan', 'status', 'payment_type', 'payment_status', 'payid', 'service_id', 'payment_id'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function audios(){
        return $this->belongsToMany(Audio::class, 'orders_audio', 'order_id', 'audio_id')->withPivot('price', 'status', 'user_estimate', 'admin_estimate', 'diarization', 'num_speaker', 'is_seen', 'rate', 'comment', 'rate_at', 'comment_at','estimated_processing_time', 'actual_processing_time');
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
