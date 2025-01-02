<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'snapchat_url',
        'instagram_url',
        'tiktok_url',
        'facebook_url',
        'x_url',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
    public function agencyAdmins()
    {
        return $this->hasMany(AgencyAdmin::class);
    }

}
