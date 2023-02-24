<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'name', 'start_at', 'end_at', 'code', 'quantity', 'used_quantity', 'discount_amount', 'is_limited', 'is_private', 'status'
    ];

    protected $table = 'coupons';

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
