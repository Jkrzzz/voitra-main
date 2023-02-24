<?php
namespace App\Notifications;

use App\Notifications\Traits\NotificationAttribute;
use Illuminate\Notifications\DatabaseNotification as BaseDBNotification;

class DatabaseNotification extends BaseDBNotification
{
    use NotificationAttribute;

    /**
     * @var array
     */
    protected $appends = [
        'label_class',
        'label_title',
        'reference_url',
        'status_class',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'read_at'    => 'datetime:Y/m/d H:i:s',
        'created_at' => 'datetime:Y/m/d H:i:s',
        'updated_at' => 'datetime:Y/m/d H:i:s',
    ];
}
