<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwitterState extends Model
{
    use HasFactory;
    protected $fillable = [
        'state',
        'oauth_token',
        'oauth_token_secret',
        'user_id',
    ];
}
