<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'plan', 'status'
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_services', 'user_id', 'service_id', 'updated_at', 'created_at', 'payid');
    }
}
