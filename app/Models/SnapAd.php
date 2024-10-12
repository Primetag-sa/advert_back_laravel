<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapAd extends Model
{
    use HasFactory;

    protected $fillable = [
        'snap_id',
        'snap_created_at',
        'snap_name',
        'snap_creative_id',
        'snap_status',
        'snap_type',
        'snapchat_adsquad_id',
        //
        'stats_id',
        'stats_type',
        'stats_granularity',
        'stats_impressions',
        'stats_swipes',
        'stats_spend',
        'stats_quartile_1',
        'stats_quartile_2',
        'stats_quartile_3',
        'stats_view_completion',
        'stats_screen_time_millis',
        //
    ];

    // Define the relationship with Adsquad
    public function adsquad()
    {
        return $this->belongsTo(SnapchatAdsquad::class, 'snapchat_adsquad_id');
    }
}
