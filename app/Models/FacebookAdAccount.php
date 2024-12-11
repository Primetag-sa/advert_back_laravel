<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookAdAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'name',
        'currency',
        'account_status',
        'user_id',
    ];
}
