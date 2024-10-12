<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapchatCampaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'snap_id',
        'snap_created_at',
        'snap_name',
        'snap_daily_budget_micro',
        'snap_status',
        'snap_start_time',
        'snap_end_time',
        'snapchat_account_id',
    ];

    // Define the relationship with SnapchatAccount
    public function snapchatAccount()
    {
        return $this->belongsTo(SnapchatAccount::class);
    }

    public function snapchatAdsquads()
    {
        return $this->hasMany(SnapchatAdsquad::class,);
    }
}
