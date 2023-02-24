<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Audio extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'url', 'status', 'name', 'duration', 'language', 'price', 'token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class, 'orders_audio', 'audio_id', 'order_id')->withPivot('price', 'status', 'user_estimate', 'admin_estimate', 'diarization', 'num_speaker',  'is_seen', 'rate', 'comment', 'rate_at', 'comment_at', 'estimated_processing_time', 'actual_processing_time');
    }

}
