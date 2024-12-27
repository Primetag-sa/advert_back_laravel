<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReadNotifications extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'notification_id',

      ];
    public function user()
    {
        return $this->belongsToMany(User::class,'user_id');
    }

    public function notifications()
    {
        return $this->belongsToMany(Notification::class);
    }
}
