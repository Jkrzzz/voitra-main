<?php

namespace App\Models;

use App;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'user_services', 'user_id', 'service_id')->withPivot('status','register_at','remove_at', 'payment_type', 'payment_status', 'payment_id', 'order_id', 'updated_at', 'payid', 'payment_description');
    }
    public function paymentHistories()
    {
        return $this->hasMany(PaymentHistory::class);
    }

    public function locations()
    {
        return $this->hasMany(UserLocation::class);
    }
}
