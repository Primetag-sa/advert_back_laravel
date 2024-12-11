<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SnapchatAccount;
use App\Models\SnapchatCampaign;
use App\Models\SnapchatAdsquad;
use App\Models\SnapAd;

class SnapchatSeeder extends Seeder
{
    public function run()
    {
        // Sample Snapchat Accounts
        $accounts = [
            [
                'snap_adaccount_id' => '123456',
                'snap_adaccount_created_at' => now(),
                'snap_adaccount_name' => 'Sample Account 1',
                'snap_adaccount_type' => 'ADVERTISER',
                'snap_adaccount_status' => 'ACTIVE',
                'snap_adaccount_organization_id' => 'org_1',
                'snap_adaccount_currency' => 'USD',
                'snap_adaccount_timezone' => 'America/New_York',
                'snap_adaccount_advertiser_organization_id' => 'adv_org_1',
                'snap_adaccount_advertiser_billing_type' => 'PREPAID',
                // 'snap_adaccount_agency_representing_client' => null,
                'snap_adaccount_client_paying_invoices' => true,
                'user_id' => 1, // assuming a user with ID 1 exists
            ],
            [
                'snap_adaccount_id' => '654321',
                'snap_adaccount_created_at' => now(),
                'snap_adaccount_name' => 'Sample Account 2',
                'snap_adaccount_type' => 'AGENCY',
                'snap_adaccount_status' => 'ACTIVE',
                'snap_adaccount_organization_id' => 'org_2',
                'snap_adaccount_currency' => 'EUR',
                'snap_adaccount_timezone' => 'Europe/Berlin',
                'snap_adaccount_advertiser_organization_id' => 'adv_org_2',
                'snap_adaccount_advertiser_billing_type' => 'POSTPAID',
                // 'snap_adaccount_agency_representing_client' => 'Agency 1',
                'snap_adaccount_client_paying_invoices' => false,
                'user_id' => 2, // assuming a user with ID 2 exists
            ],
        ];

        foreach ($accounts as $account) {
            $snapchatAccount = SnapchatAccount::updateOrCreate(
                ['snap_adaccount_id' => $account['snap_adaccount_id']],
                $account
            );

            // Sample Campaigns for each Account
            $campaigns = [
                [
                    'snap_id' => 'campaign_1',
                    'snap_created_at' => now(),
                    'snap_name' => 'Campaign 1',
                    'snap_daily_budget_micro' => 5000000, // 5 USD
                    'snap_status' => 'ACTIVE',
                    'snap_start_time' => now()->toISOString(),
                    'snap_end_time' => now()->addDays(30)->toISOString(),
                    'snapchat_account_id' => $snapchatAccount->id,
                    // 'snap_objective' => 'SWIPES',
                    // 'snap_optimization_goal' => 'LINK_CLICKS',
                    // 'snap_type' => 'STANDARD',
                ],
                [
                    'snap_id' => 'campaign_2',
                    'snap_created_at' => now(),
                    'snap_name' => 'Campaign 2',
                    'snap_daily_budget_micro' => 10000000, // 10 USD
                    'snap_status' => 'ACTIVE',
                    'snap_start_time' => now()->toISOString(),
                    'snap_end_time' => now()->addDays(30)->toISOString(),
                    'snapchat_account_id' => $snapchatAccount->id,
                    // 'snap_objective' => 'VIDEO_VIEWS',
                    // 'snap_optimization_goal' => 'VIDEO_VIEWS',
                    // 'snap_type' => 'STANDARD',
                ],
            ];

            foreach ($campaigns as $campaign) {
                $snapchatCampaign = SnapchatCampaign::updateOrCreate(
                    ['snap_id' => $campaign['snap_id']],
                    $campaign
                );

                // Sample Ad Squads for each Campaign
                $adsquads = [
                    [
                        'snap_id' => 'adsquad_1',
                        'snap_created_at' => now(),
                        'snap_name' => 'Ad Squad 1',
                        'snap_status' => 'ACTIVE',
                        'snap_type' => 'STANDARD',
                        'snap_billing_event' => 'IMPRESSIONS',
                        'snap_auto_bid' => true,
                        'snap_target_bid' => 1000, // Target bid in micro-units
                        'snap_bid_strategy' => 'MANUAL',
                        'snap_daily_budget_micro' => 2000000, // 2 USD
                        'snap_start_time' => now()->toISOString(),
                        'snap_optimization_goal' => 'SWIPES',
                        'snapchat_campaign_id' => $snapchatCampaign->id,
                    ],
                    [
                        'snap_id' => 'adsquad_2',
                        'snap_created_at' => now(),
                        'snap_name' => 'Ad Squad 2',
                        'snap_status' => 'ACTIVE',
                        'snap_type' => 'STANDARD',
                        'snap_billing_event' => 'LINK_CLICKS',
                        'snap_auto_bid' => false,
                        'snap_target_bid' => 500, // Target bid in micro-units
                        'snap_bid_strategy' => 'AUTOMATIC',
                        'snap_daily_budget_micro' => 3000000, // 3 USD
                        'snap_start_time' => now()->toISOString(),
                        'snap_optimization_goal' => 'LINK_CLICKS',
                        'snapchat_campaign_id' => $snapchatCampaign->id,
                    ],
                ];

                foreach ($adsquads as $adsquad) {
                    $snapchatAdsquad = SnapchatAdsquad::updateOrCreate(
                        ['snap_id' => $adsquad['snap_id']],
                        $adsquad
                    );

                    // Sample Ads for each Ad Squad
                    $ads = [
                        [
                            'snap_id' => 'ad_1',
                            'snap_created_at' => now(),
                            'snap_name' => 'Ad 1',
                            'snap_creative_id' => 'creative_1',
                            'snap_status' => 'ACTIVE',
                            'snap_type' => 'IMAGE',
                            // 'snap_adaccount_id' => $snapchatAccount->id,
                            'snapchat_adsquad_id' => $snapchatAdsquad->id,
                            // 'snap_preview_url' => 'https://example.com/ad1_preview.jpg',
                            // 'snap_target_url' => 'https://example.com/ad1_target',
                            // 'snap_clicks' => 0,
                            'stats_id' => 'stat_1',
                            'stats_type' => 'ad',
                            'stats_granularity' => 'hourly',
                            'start_time' => now()->toISOString(),
                            'end_time' => now()->toISOString(), // Current time
                            'stats_impressions' => 100,
                            'stats_swipes' => 20,
                            'stats_conversion_purchases' => 5,
                            'stats_conversion_save' => 10,
                            'stats_conversion_start_checkout' => 3,
                            'stats_conversion_add_cart' => 7,
                            'stats_conversion_view_content' => 15,
                            'stats_conversion_add_billing' => 2,
                            'stats_conversion_sign_ups' => 1,
                            'stats_conversion_searches' => 4,
                            'stats_conversion_level_completes' => 8,
                            'stats_conversion_app_opens' => 25,
                            'stats_conversion_page_views' => 50,
                        ],
                        [
                            'snap_id' => 'ad_2',
                            'snap_created_at' => now(),
                            'snap_name' => 'Ad 2',
                            'snap_creative_id' => 'creative_2',
                            'snap_status' => 'ACTIVE',
                            'snap_type' => 'VIDEO',
                            // 'snap_adaccount_id' => $snapchatAccount->id,
                            'snapchat_adsquad_id' => $snapchatAdsquad->id,
                            // 'snap_preview_url' => 'https://example.com/ad2_preview.mp4',
                            // 'snap_target_url' => 'https://example.com/ad2_target',
                            // 'snap_impressions' => 0,
                            // 'snap_clicks' => 0,
                            'stats_id' => 'stat_2',
                            'stats_type' => 'ad',
                            'stats_granularity' => 'daily',
                            'start_time' => now()->toISOString(),
                            'end_time' => now()->toISOString(), // Current time
                            'stats_impressions' => 150,
                            'stats_swipes' => 30,
                            'stats_conversion_purchases' => 10,
                            'stats_conversion_save' => 12,
                            'stats_conversion_start_checkout' => 5,
                            'stats_conversion_add_cart' => 9,
                            'stats_conversion_view_content' => 20,
                            'stats_conversion_add_billing' => 3,
                            'stats_conversion_sign_ups' => 2,
                            'stats_conversion_searches' => 5,
                            'stats_conversion_level_completes' => 10,
                            'stats_conversion_app_opens' => 30,
                            'stats_conversion_page_views' => 60,
                        ],
                    ];

                    foreach ($ads as $ad) {
                        SnapAd::updateOrCreate(
                            ['snap_id' => $ad['snap_id']],
                            $ad
                        );
                    }
                }
            }
        }
    }
}
