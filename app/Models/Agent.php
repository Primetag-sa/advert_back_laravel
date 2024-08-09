<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        //new
        'address',
        'permissions',
        'pack_id',
        'facebook_url',
        'tiktok_url',
        'snapchat_url',
        'instagram_url',

    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
