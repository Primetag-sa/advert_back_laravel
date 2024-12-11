<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'name',
        'status',
        'objective',
        'ad_account_id',
    ];
}
