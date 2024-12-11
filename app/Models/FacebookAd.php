<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookAd extends Model
{
    use HasFactory;
    protected $fillable = [
        'ad_id',
        'name',
        'status',
        'creative',
        'facebook_ad_set_id',
        'facebook_ad_account_id',
        'facebook_campaign_id',
    ];
}
