<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agency extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
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
}
