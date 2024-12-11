<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookAdSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_set_id',
        'name',
        'status',
        'budget',
        'facebook_campaign_id',
    ];

}
