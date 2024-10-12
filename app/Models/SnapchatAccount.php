<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SnapchatAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'snap_adaccount_id',
        'snap_adaccount_created_at',
        'snap_adaccount_name',
        'snap_adaccount_type',
        'snap_adaccount_status',
        'snap_adaccount_organization_id',
        'snap_adaccount_currency',
        'snap_adaccount_timezone',
        'snap_adaccount_advertiser_organization_id',
        'snap_adaccount_advertiser_billing_type',
        'snap_adaccount_agency_representing_client',
        'snap_adaccount_client_paying_invoices',
        'user_id',
    ];

    public function snapchatCampaigns()
    {
        return $this->hasMany(SnapchatCampaign::class,);
    }

    
}
