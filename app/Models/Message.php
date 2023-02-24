<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;
use App\Models\Order;
use DateTimeInterface;

class Message extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'messages';

    protected $fillable = [
        'room_id',
        'sender_id',
        'receiver_id',
        'content'
    ];

    public $timestamps = true;

    /**
     * Constructor of Model.
     *
     * @param array $attributes
     */
    public function __construct()
    {
    }

    public function sender () {
        return $this->belongsTo(Admin::class, 'sender_id');
    }

    public function receiver () {
        return $this->belongsTo(Admin::class, 'receiver_id');
    }

    public function room () {
        return $this->belongsTo(Order::class, 'room_id');
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
