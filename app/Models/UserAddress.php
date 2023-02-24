<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'type', 'user_id', 'full_name', 'full_kana_name', 'company_name', 'department_name', 'tel', 'mobile', 'zipcode', 'address1', 'address2', 'address3', 'email', 'details', 'default', 'public'
    ];
    
    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
