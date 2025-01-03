<?php

namespace App\Models;

use App\Enum\NotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'title',
    //     'message',
    //     'value',
    //     'sender_id',
    //     'received_id',
    // ];

    /**
     * Get the user that sent the notification.
     */
    // public function sender()
    // {
    //     return $this->belongsTo(User::class, 'sender_id');
    // }

    /**
     * Get the user that received the notification.
     */
    // public function receiver()
    // {
    //     return $this->belongsTo(User::class, 'received_id');
    // }

    protected $fillable = ['type', 'notifiable_id', 'notifiable_type', 'message','title'];

    protected $casts = [
        'type' => NotificationType::class,
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }


    public function readNotificaions(){
        return $this->hasMany(ReadNotifications::class);
    }
}
