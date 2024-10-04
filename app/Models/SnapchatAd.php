<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapchatAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'ad_name',
        'impressions',
        'clicks',
        'cost',
        'revenue',
        'promo_code',
    ];
}
