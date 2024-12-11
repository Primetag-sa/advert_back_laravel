<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapchatAdsquad extends Model
{
    use HasFactory;

    protected $fillable = [
        'snap_id',
        'snap_created_at',
        'snap_name',
        'snap_status',
        'snap_type',
        'snap_billing_event',
        'snap_auto_bid',
        'snap_target_bid',
        'snap_bid_strategy',
        'snap_daily_budget_micro',
        'snap_start_time',
        'snap_optimization_goal',
        'snapchat_campaign_id',
    ];

    // Define the relationship with Campaign
    public function campaign()
    {
        return $this->belongsTo(SnapchatCampaign::class, 'snapchat_campaign_id');
    }

    public function snapAds()
    {
        return $this->hasMany(SnapAd::class,);
    }
}
