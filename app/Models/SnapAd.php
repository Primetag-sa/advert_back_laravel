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
        'start_time',
        'end_time',
        'stats_impressions',
        'stats_swipes',
        'stats_conversion_purchases',
        'stats_conversion_save',
        'stats_conversion_start_checkout',
        'stats_conversion_add_cart',
        'stats_conversion_view_content',
        'stats_conversion_add_billing',
        'stats_conversion_sign_ups',
        'stats_conversion_searches',
        'stats_conversion_level_completes',
        'stats_conversion_app_opens',
        'stats_conversion_page_views',

        //new fiels
        'snapchat_account_id',
        'snapchat_campaign_id',
        'snapchat_adsquad_id_code',
        //
    ];

    // Define the relationship with Adsquad
    public function adsquad()
    {
        return $this->belongsTo(SnapchatAdsquad::class, 'snapchat_adsquad_id');
    }

    public function snapchat_campaign()
    {
        return $this->belongsTo(SnapchatCampaign::class, 'snapchat_campaign_id');
    }

    public function snapchat_account()
    {
        return $this->belongsTo(SnapchatAccount::class, 'snapchat_account_id');
    }
}
