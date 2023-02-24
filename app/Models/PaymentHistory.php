<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $fillable = [
        'title', 'user_id', 'payment_id', 'payment_type', 'total_price', 'type', 'payment_status', 'payid', 'service_id'
    ];

    protected $table = 'payment_history';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
