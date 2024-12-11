<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SnapAd;
use App\Models\SnapchatAccount;
use App\Models\SnapchatAdsquad;
use App\Models\SnapchatCampaign;
use App\Models\User;
use App\Services\SnapchatAdService;
use App\Services\SnapchatService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class SnapchatController extends Controller
{
    protected $snapchatService;
    protected $client;


    public function __construct(SnapchatAdService $snapchatService)
    {
        $this->snapchatService = $snapchatService;
        $this->client = new Client();
    }

    // Step 1: Redirect to Snapchat for authorization

    public function redirectToSnapchat(Request $request)
    {
        $user = Auth()->user();
        if(!$user){
            return back();
        }

        $user->snapchatAccounts()->delete();
        // قم بتحديد الأذونات المطلوبة
        $scopes = ['snapchat-marketing-api'];

        return Socialite::driver('snapchat_marketing_api')
            ->scopes($scopes) // إضافة الأذونات هنا
            ->redirect();
    }

    // Step 2: Handle the callback from Snapchat
    public function handleCallback(Request $request)
    {
        $snapchatUser = Socialite::driver('snapchat_marketing_api')->user();

        $user = Auth()->user();

        if(!$user){
            return back();
        }

        $accessToken = $snapchatUser->token;
        $organization_id = $snapchatUser->user['me']['organization_id'];


        $data = [
            'snapchat_name' => $snapchatUser->name,
            'snapchat_email' => $snapchatUser->email,
            'snapchat_id' => $snapchatUser->id,
            'snapchat_organization_id' => $organization_id,
            'snapchat_display_name' => $snapchatUser->user['me']['display_name'],
            'snapchat_username' => $snapchatUser->user['me']['snapchat_username'],
            'snapchat_member_status' => $snapchatUser->user['me']['member_status'],
            'snapchat_access_token' => $accessToken,
            'snapchat_refresh_token' => $snapchatUser->refreshToken,// إضافة الوقت المناسب
            'snapchat_token_expires_at' => now()->addSeconds($snapchatUser->expiresIn),
        ];
        // update or create user in your database
        $user->update( $data);
        $this->saveDataOrg($user->id);
        return redirect()->to('https:/advert.sa/snapchat');
        // return response()->json($user);
    }

    public function saveDataOrg($id)
    {

        $user = User::find($id);
        $accessToken = $user->snapchat_access_token;
        $organization_id = $user->snapchat_organization_id;

        // save accounts
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->get("https://adsapi.snapchat.com/v1/organizations/$organization_id/adaccounts");

        $results = $response->json();
        if (isset($results['adaccounts']) && is_array($results['adaccounts'])) {
            foreach ($results['adaccounts'] as $item) {
                if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                    $account = [
                        'snap_adaccount_id' => $item['adaccount']['id'] ?? '',
                        'snap_adaccount_created_at' => $item['adaccount']['created_at'] ?? '',
                        'snap_adaccount_name' => $item['adaccount']['name'] ?? '',
                        'snap_adaccount_type' => $item['adaccount']['type'] ?? '',
                        'snap_adaccount_status' => $item['adaccount']['status'] ?? '',
                        'snap_adaccount_organization_id' => $item['adaccount']['organization_id'] ?? '',
                        'snap_adaccount_currency' => $item['adaccount']['currency'] ?? '',
                        'snap_adaccount_timezone' => $item['adaccount']['timezone'] ?? '',
                        'snap_adaccount_advertiser_organization_id' => $item['adaccount']['advertiser_organization_id'] ?? '',
                        'snap_adaccount_advertiser_billing_type' => $item['adaccount']['billing_type'] ?? '',
                        'snap_adaccount_agency_representing_client' => $item['adaccount']['agency_representing_client'] ?? '',
                        'snap_adaccount_client_paying_invoices' => $item['adaccount']['client_paying_invoices'] ?? '',
                        'user_id' => $user->id,
                    ];

                    $snapchatAccount = SnapchatAccount::updateOrCreate(['snap_adaccount_id' => $item['adaccount']['id'] ?? ''], $account);
                    $ad_account_id = $snapchatAccount->snap_adaccount_id;

                    // Get All Ads under an Acouunt
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ])->get("https://adsapi.snapchat.com/v1/adaccounts/{$ad_account_id}/ads");

                    $results = $response->json();
                    if (isset($results['ads']) && is_array($results['ads'])) {
                        foreach ($results['ads'] as $item) {
                            if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                $ad = [
                                    'snap_id' => $item['ad']['id'] ?? '',
                                    'snap_created_at' => $item['ad']['created_at'] ?? '',
                                    'snap_name' => $item['ad']['name'] ?? '',
                                    'snap_creative_id' => $item['ad']['creative_id'] ?? '',
                                    'snap_status' => $item['ad']['status'] ?? '',
                                    'snap_type' => $item['ad']['type'] ?? '',
                                    //'snap_render_type' => $item['ad']['render_type'] ?? '',
                                    //'snap_approval_type' => $item['ad']['approval_type'] ?? '',
                                    //'snap_delivery_status' => $item['ad']['delivery_status'] ?? '',
                                    'snapchat_account_id' => $snapchatAccount->id,
                                    'snapchat_adsquad_id_code' => $item['ad']['ad_squad_id'] ?? '',
                                ];

                                $snapAd = SnapAd::updateOrCreate(['snap_id' => $item['ad']['id'] ?? ''], $ad);
                            }

                        }
                    }

                    // add snapchat_account_id to ads
                    // render_type,
                    // snapchat_campaign_id

                    // Get All Campaigns
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ])->get("https://adsapi.snapchat.com/v1/adaccounts/$ad_account_id/campaigns");

                    $results = $response->json();
                    if (isset($results['campaigns']) && is_array($results['campaigns'])) {
                        foreach ($results['campaigns'] as $item) {
                            if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                $campaign = [
                                    'snap_id' => $item['campaign']['id'] ?? '',
                                    'snap_created_at' => $item['campaign']['created_at'] ?? '',
                                    'snap_name' => $item['campaign']['name'] ?? '',
                                    'snap_daily_budget_micro' => $item['campaign']['daily_budget_micro'] ?? '',
                                    'snap_status' => $item['campaign']['status'] ?? '',
                                    'snap_start_time' => $item['campaign']['start_time'] ?? '',
                                    'snap_end_time' => $item['campaign']['end_time'] ?? '',
                                    'snapchat_account_id' => $snapchatAccount->id,
                                ];

                                $snapchatCampaign = SnapchatCampaign::updateOrCreate(['snap_id' => $item['campaign']['id'] ?? ''], $campaign);
                                $campaign_id = $snapchatCampaign->id;

                                // Get All Ads under an campaign
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $accessToken,
                                    'Content-Type' => 'application/json',
                                ])->get("https://adsapi.snapchat.com/v1/campaigns/{$ad_account_id}/ads");

                                $results = $response->json();
                                if (isset($results['ads']) && is_array($results['ads'])) {
                                    foreach ($results['ads'] as $item) {
                                        if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                            $ad = [
                                                'snap_id' => $item['ad']['id'] ?? '',
                                                'snap_created_at' => $item['ad']['created_at'] ?? '',
                                                'snap_name' => $item['ad']['name'] ?? '',
                                                'snap_creative_id' => $item['ad']['creative_id'] ?? '',
                                                'snap_status' => $item['ad']['status'] ?? '',
                                                'snap_type' => $item['ad']['type'] ?? '',
                                                //'snap_render_type' => $item['ad']['render_type'] ?? '',
                                                //'snap_approval_type' => $item['ad']['approval_type'] ?? '',
                                                //'snap_delivery_status' => $item['ad']['delivery_status'] ?? '',
                                                'snapchat_campaign_id' => $campaign_id,
                                                'snapchat_adsquad_id_code' => $item['ad']['ad_squad_id'] ?? '',
                                            ];

                                            $snapAd = SnapAd::updateOrCreate(['snap_id' => $item['ad']['id'] ?? ''], $ad);
                                        }

                                    }
                                }

                                // Get All Ad Squads under a Campaign
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $accessToken,
                                    'Content-Type' => 'application/json',
                                ])->get("https://adsapi.snapchat.com/v1/campaigns/{$campaign_id}/adsquads");

                                $results = $response->json();
                                if (isset($results['adsquads']) && is_array($results['adsquads'])) {
                                    foreach ($results['adsquads'] as $item) {
                                        if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                            $adsquad = [
                                                'snap_id' => $item['adsquad']['id'] ?? '',
                                                'snap_created_at' => $item['adsquad']['created_at'] ?? '',
                                                'snap_name' => $item['adsquad']['name'] ?? '',
                                                'snap_status' => $item['adsquad']['status'] ?? '',
                                                'snap_type' => $item['adsquad']['type'] ?? '',
                                                'snap_billing_event' => $item['adsquad']['billing_event'] ?? '',
                                                'snap_auto_bid' => $item['adsquad']['auto_bid'] ?? '',
                                                'snap_target_bid' => $item['adsquad']['target_bid'] ?? '',
                                                'snap_bid_strategy' => $item['adsquad']['bid_strategy'] ?? '',
                                                'snap_daily_budget_micro' => $item['adsquad']['budget_micro'] ?? '',
                                                'snap_start_time' => $item['adsquad']['start_time'] ?? '',
                                                'snap_optimization_goal' => $item['adsquad']['optimization_goal'] ?? '',
                                                'snapchat_campaign_id' => $snapchatCampaign->id,
                                            ];

                                            $snapchatAdsquad = SnapchatAdsquad::updateOrCreate(['snap_id' => $item['adsquad']['id'] ?? ''], $adsquad);

                                            // Get All Ads under an Ad Squad
                                            $response = Http::withHeaders([
                                                'Authorization' => 'Bearer ' . $accessToken,
                                                'Content-Type' => 'application/json',
                                            ])->get("https://adsapi.snapchat.com/v1/adsquads/{$snapchatAdsquad->id}/ads");

                                            $results = $response->json();
                                            if (isset($results['ads']) && is_array($results['ads'])) {
                                                foreach ($results['ads'] as $item) {
                                                    if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                                        $ad = [
                                                            'snap_id' => $item['ad']['id'] ?? '',
                                                            'snap_created_at' => $item['ad']['created_at'] ?? '',
                                                            'snap_name' => $item['ad']['name'] ?? '',
                                                            'snap_creative_id' => $item['ad']['creative_id'] ?? '',
                                                            'snap_status' => $item['ad']['status'] ?? '',
                                                            'snap_type' => $item['ad']['type'] ?? '',
                                                            'snapchat_adsquad_id' => $snapchatAdsquad->id,
                                                        ];

                                                        $snapAd = SnapAd::updateOrCreate(['snap_id' => $item['ad']['id'] ?? ''], $ad);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            'success'=>true,
        ]);
    }

    public function saveData()
    {

        $user = Auth()->user();
        $accessToken = $user->snapchat_access_token;
        $organization_id = $user->snapchat_organization_id;

        // save accounts
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->get("https://adsapi.snapchat.com/v1/organizations/$organization_id/adaccounts");

        $results = $response->json();
        if (isset($results['adaccounts']) && is_array($results['adaccounts'])) {
            foreach ($results['adaccounts'] as $item) {
                if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                    $account = [
                        'snap_adaccount_id' => $item['adaccount']['id'] ?? '',
                        'snap_adaccount_created_at' => $item['adaccount']['created_at'] ?? '',
                        'snap_adaccount_name' => $item['adaccount']['name'] ?? '',
                        'snap_adaccount_type' => $item['adaccount']['type'] ?? '',
                        'snap_adaccount_status' => $item['adaccount']['status'] ?? '',
                        'snap_adaccount_organization_id' => $item['adaccount']['organization_id'] ?? '',
                        'snap_adaccount_currency' => $item['adaccount']['currency'] ?? '',
                        'snap_adaccount_timezone' => $item['adaccount']['timezone'] ?? '',
                        'snap_adaccount_advertiser_organization_id' => $item['adaccount']['advertiser_organization_id'] ?? '',
                        'snap_adaccount_advertiser_billing_type' => $item['adaccount']['billing_type'] ?? '',
                        'snap_adaccount_agency_representing_client' => $item['adaccount']['agency_representing_client'] ?? '',
                        'snap_adaccount_client_paying_invoices' => $item['adaccount']['client_paying_invoices'] ?? '',
                        'user_id' => $user->id,
                    ];

                    $snapchatAccount = SnapchatAccount::updateOrCreate(['snap_adaccount_id' => $item['adaccount']['id'] ?? ''], $account);
                    $ad_account_id = $snapchatAccount->snap_adaccount_id;

                    // Get All Ads under an Acouunt
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ])->get("https://adsapi.snapchat.com/v1/adaccounts/{$ad_account_id}/ads");

                    $results = $response->json();
                    if (isset($results['ads']) && is_array($results['ads'])) {
                        foreach ($results['ads'] as $item) {
                            if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                $ad = [
                                    'snap_id' => $item['ad']['id'] ?? '',
                                    'snap_created_at' => $item['ad']['created_at'] ?? '',
                                    'snap_name' => $item['ad']['name'] ?? '',
                                    'snap_creative_id' => $item['ad']['creative_id'] ?? '',
                                    'snap_status' => $item['ad']['status'] ?? '',
                                    'snap_type' => $item['ad']['type'] ?? '',
                                    //'snap_render_type' => $item['ad']['render_type'] ?? '',
                                    //'snap_approval_type' => $item['ad']['approval_type'] ?? '',
                                    //'snap_delivery_status' => $item['ad']['delivery_status'] ?? '',
                                    'snapchat_account_id' => $snapchatAccount->id,
                                    'snapchat_adsquad_id_code' => $item['ad']['ad_squad_id'] ?? '',
                                ];

                                $snapAd = SnapAd::updateOrCreate(['snap_id' => $item['ad']['id'] ?? ''], $ad);
                            }

                        }
                    }

                    // add snapchat_account_id to ads
                    // render_type,
                    // snapchat_campaign_id

                    // Get All Campaigns
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ])->get("https://adsapi.snapchat.com/v1/adaccounts/$ad_account_id/campaigns");

                    $results = $response->json();
                    if (isset($results['campaigns']) && is_array($results['campaigns'])) {
                        foreach ($results['campaigns'] as $item) {
                            if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                $campaign = [
                                    'snap_id' => $item['campaign']['id'] ?? '',
                                    'snap_created_at' => $item['campaign']['created_at'] ?? '',
                                    'snap_name' => $item['campaign']['name'] ?? '',
                                    'snap_daily_budget_micro' => $item['campaign']['daily_budget_micro'] ?? '',
                                    'snap_status' => $item['campaign']['status'] ?? '',
                                    'snap_start_time' => $item['campaign']['start_time'] ?? '',
                                    'snap_end_time' => $item['campaign']['end_time'] ?? '',
                                    'snapchat_account_id' => $snapchatAccount->id,
                                ];

                                $snapchatCampaign = SnapchatCampaign::updateOrCreate(['snap_id' => $item['campaign']['id'] ?? ''], $campaign);
                                $campaign_id = $snapchatCampaign->id;
                                $campaignId = $item['campaign']['id'] ?? '';

                                // Get All Ads under an campaign
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $accessToken,
                                    'Content-Type' => 'application/json',
                                ])->get("https://adsapi.snapchat.com/v1/campaigns/{$campaignId}/ads");

                                $results = $response->json();

                                // return $results;

                                if (isset($results['ads']) && is_array($results['ads'])) {
                                    foreach ($results['ads'] as $item) {
                                        if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                            $ad = [
                                                'snap_id' => $item['ad']['id'] ?? '',
                                                'snap_created_at' => $item['ad']['created_at'] ?? '',
                                                'snap_name' => $item['ad']['name'] ?? '',
                                                'snap_creative_id' => $item['ad']['creative_id'] ?? '',
                                                'snap_status' => $item['ad']['status'] ?? '',
                                                'snap_type' => $item['ad']['type'] ?? '',
                                                //'snap_render_type' => $item['ad']['render_type'] ?? '',
                                                //'snap_approval_type' => $item['ad']['approval_type'] ?? '',
                                                //'snap_delivery_status' => $item['ad']['delivery_status'] ?? '',
                                                'snapchat_campaign_id' => $campaign_id,
                                                'snapchat_adsquad_id_code' => $item['ad']['ad_squad_id'] ?? '',
                                            ];

                                            $snapAd = SnapAd::updateOrCreate(['snap_id' => $item['ad']['id'] ?? ''], $ad);
                                            // return $snapAd;
                                        }

                                    }
                                }

                                // Get All Ad Squads under a Campaign
                                $response = Http::withHeaders([
                                    'Authorization' => 'Bearer ' . $accessToken,
                                    'Content-Type' => 'application/json',
                                ])->get("https://adsapi.snapchat.com/v1/campaigns/{$campaignId}/adsquads");

                                $results = $response->json();
                                if (isset($results['adsquads']) && is_array($results['adsquads'])) {
                                    foreach ($results['adsquads'] as $item) {
                                        if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                            $adsquad = [
                                                'snap_id' => $item['adsquad']['id'] ?? '',
                                                'snap_created_at' => $item['adsquad']['created_at'] ?? '',
                                                'snap_name' => $item['adsquad']['name'] ?? '',
                                                'snap_status' => $item['adsquad']['status'] ?? '',
                                                'snap_type' => $item['adsquad']['type'] ?? '',
                                                'snap_billing_event' => $item['adsquad']['billing_event'] ?? '',
                                                'snap_auto_bid' => $item['adsquad']['auto_bid'] ?? '',
                                                'snap_target_bid' => $item['adsquad']['target_bid'] ?? '',
                                                'snap_bid_strategy' => $item['adsquad']['bid_strategy'] ?? '',
                                                'snap_daily_budget_micro' => $item['adsquad']['budget_micro'] ?? '',
                                                'snap_start_time' => $item['adsquad']['start_time'] ?? '',
                                                'snap_optimization_goal' => $item['adsquad']['optimization_goal'] ?? '',
                                                'snapchat_campaign_id' => $snapchatCampaign->id,
                                            ];

                                            $snapchatAdsquad = SnapchatAdsquad::updateOrCreate(['snap_id' => $item['adsquad']['id'] ?? ''], $adsquad);
                                            $idAqSnap = $item['adsquad']['id']??'';
                                            // Get All Ads under an Ad Squad
                                            $response = Http::withHeaders([
                                                'Authorization' => 'Bearer ' . $accessToken,
                                                'Content-Type' => 'application/json',
                                            ])->get("https://adsapi.snapchat.com/v1/adsquads/{$idAqSnap}/ads");

                                            $results = $response->json();
                                            if (isset($results['ads']) && is_array($results['ads'])) {
                                                foreach ($results['ads'] as $item) {
                                                    if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                                        $ad = [
                                                            'snap_id' => $item['ad']['id'] ?? '',
                                                            'snap_created_at' => $item['ad']['created_at'] ?? '',
                                                            'snap_name' => $item['ad']['name'] ?? '',
                                                            'snap_creative_id' => $item['ad']['creative_id'] ?? '',
                                                            'snap_status' => $item['ad']['status'] ?? '',
                                                            'snap_type' => $item['ad']['type'] ?? '',
                                                            'snapchat_adsquad_id' => $snapchatAdsquad->id,
                                                        ];

                                                        $snapAd = SnapAd::updateOrCreate(['snap_id' => $item['ad']['id'] ?? ''], $ad);

                                                        // Get Ad Stats
                                                        /* $response = Http::withHeaders([
                                                            'Authorization' => 'Bearer ' . $accessToken,
                                                            'Content-Type' => 'application/json',
                                                        ])->get(
                                                            "https://adsapi.snapchat.com/v1/ads/{$snapAd->snap_id}/stats?granularity=HOUR&fields=impressions,swipes,conversion_purchases,conversion_save,conversion_start_checkout,conversion_add_cart,conversion_view_content,conversion_add_billing,conversion_sign_ups,conversion_searches,conversion_level_completes,conversion_app_opens,conversion_page_views&start_time=2017-04-30T07:00:00.000-00:00&end_time=" . now()->toISOString()
                                                        );

                                                        $results = $response->json();
                                                        if (isset($results['timeseries_stats']) && is_array($results['timeseries_stats'])) {
                                                            foreach ($results['timeseries_stats'] as $item) {
                                                                if (in_array($item['sub_request_status'] ?? '', ['success', 'SUCCESS'])) {
                                                                    foreach ($item['timeseries'] as $stats) {
                                                                        $data = [
                                                                            'stats_id' => $item['timeseries_stat']['id'] ?? '',
                                                                            'stats_type' => $item['timeseries_stat']['type'] ?? '',
                                                                            'stats_granularity' => $item['timeseries_stat']['granularity'] ?? '',
                                                                            'start_time' => $stats['start_time'] ?? '', // Start time of the current data
                                                                            'end_time' => now()->toISOString(), // Current time
                                                                            'stats_impressions' => $stats['stats']['impressions'] ?? '',
                                                                            'stats_swipes' => $stats['stats']['swipes'] ?? '',
                                                                            'stats_conversion_purchases' => $stats['stats']['conversion_purchases'] ?? '',
                                                                            'stats_conversion_save' => $stats['stats']['conversion_save'] ?? '',
                                                                            'stats_conversion_start_checkout' => $stats['stats']['conversion_start_checkout'] ?? '',
                                                                            'stats_conversion_add_cart' => $stats['stats']['conversion_add_cart'] ?? '',
                                                                            'stats_conversion_view_content' => $stats['stats']['conversion_view_content'] ?? '',
                                                                            'stats_conversion_add_billing' => $stats['stats']['conversion_add_billing'] ?? '',
                                                                            'stats_conversion_sign_ups' => $stats['stats']['conversion_sign_ups'] ?? '',
                                                                            'stats_conversion_searches' => $stats['stats']['conversion_searches'] ?? '',
                                                                            'stats_conversion_level_completes' => $stats['stats']['conversion_level_completes'] ?? '',
                                                                            'stats_conversion_app_opens' => $stats['stats']['conversion_app_opens'] ?? '',
                                                                            'stats_conversion_page_views' => $stats['stats']['conversion_page_views'] ?? '',
                                                                        ];

                                                                        // Save the data to your model
                                                                        $snapAd::update($data);
                                                                    }
                                                                }
                                                            }
                                                        } */

                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return response()->json([
            'success'=>true,
        ]);
    }

    public function getAdStats($adId, Request $request)
    {
        // Set default date range: one month ago to today
        $startTime = $request->query('startDate', Carbon::now()->subMonth()->startOfDay()->toIso8601String());
        $endTime = $request->query('endDate', Carbon::now()->toIso8601String());


        $type = $request->query('type', 'DAY'); // Default to 'DAY'

        // Fetch the authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated user'], 401);
        }

        // Check for user's Snapchat access token
        $accessToken = $user->snapchat_access_token;
        if (!$accessToken) {
            return response()->json(['error' => 'Access token not found for the user.'], 401);
        }

        // Validate the provided Ad ID
        $snap = SnapAd::find($adId);
        if (!$snap) {
            return response()->json(['error' => 'Ad not found.'], 404);
        }

        // Fetch ad stats from Snapchat service
        try {
            // Call the Snapchat service to fetch ad stats
            $stats = $this->snapchatService->getAdStats($snap->snap_id, $startTime, $endTime, $type, $accessToken);
        } catch (\Exception $e) {
            // If 401 Unauthorized error (expired token), refresh the token and retry
            if ($e->getCode() === 401) {
                // Try refreshing the access token
                $refreshResponse = $this->refreshSnapchatAccessToken($user);

                if ($refreshResponse['success']) {
                    // Retry fetching the ad stats with the new access token
                    $stats = $this->snapchatService->getAdStats($snap->snap_id, $startTime, $endTime, $type, $user->snapchat_access_token);
                    return response()->json($stats);
                } else {
                    return response()->json(['error' => 'Failed to refresh access token.', 'details' => $refreshResponse['details']], 401);
                }
            }

            // For other exceptions, return an error response
            return response()->json(['error' => 'Failed to fetch ad stats.', 'details' => $e->getMessage()], 500);
        }

        // Return stats in a JSON response
        return response()->json($stats);
    }


    private function refreshSnapchatAccessToken($user)
    {
        // Prepare the URL to refresh the access token
        $url = 'https://accounts.snapchat.com/login/oauth2/access_token';

        try {
            // Make the POST request to refresh the access token
            $response = $this->client->post($url, [
                'form_params' => [
                    'refresh_token' => $user->snapchat_refresh_token, // Refresh token
                    'client_id' => 'b48d23b3-5c26-4921-93a5-2d41d1488577', // Client ID (from .env or config)
                    'client_secret' => 'd3dc2b4467137ff9e6ac', // Client Secret (from .env or config)
                    'grant_type' => 'refresh_token', // Grant type
                ]
            ]);


            // Parse the response
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the response contains the access token
            if (isset($data['access_token'])) {
                // Update the user's access token
                $user->snapchat_access_token = $data['access_token'];
                $user->save();

                // Optionally, update the refresh token if it's returned
                if (isset($data['refresh_token'])) {
                    $user->snapchat_refresh_token = $data['refresh_token'];
                    $user->save();
                }

                return ['success' => true];
            }

            return ['success' => false, 'details' => 'Refresh token request failed.'];
        } catch (\Exception $e) {
            return ['success' => false, 'details' => $e->getMessage()];
        }
    }


    public function getAdSquadStats($adSquad, Request $request)
    {
        // return $this->snapchatService->processCampaignStatsTests();

        $startTime = $request->query('startDate', Carbon::now()->subMonth()->startOfDay()->toIso8601String());
        $endTime = $request->query('endDate', Carbon::now()->toIso8601String());
        $type = $request->query('type', "DAY");

        $user = Auth::user();
        $accessToken = $user->snapchat_access_token;


        $squad = SnapchatAdsquad::find($adSquad);

        // Call the service method to get stats
        $stats = $this->snapchatService->getAdSquadStats($squad->snap_id, $startTime, $endTime, $accessToken,$type);

        // Return the stats directly since it's already a JSON response from the service
        return $stats;
    }

    public function getCampaignStats($adCampaign, Request $request)
    {
        // return $this->snapchatService->processCampaignStatsTests();

        $startTime = $request->query('startDate', Carbon::now()->subMonth()->startOfDay()->toIso8601String());
        $endTime = $request->query('endDate', Carbon::now()->toIso8601String());
        $type = $request->query('type', 'DAY');

        // Fetch user access token
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthetification user'], 401);
        }

        $accessToken = $user->snapchat_access_token;

        // Check if access token is available
        if (!$accessToken) {
            return response()->json(['error' => 'Access token not found for the user.'], 401);
        }

        $campaign = SnapchatCampaign::find($adCampaign);

        // Call the service method to get stats
        $stats = $this->snapchatService->getCampaignStats($campaign->snap_id, $startTime, $endTime,$type, $accessToken);

        // Return the stats directly since it's already a JSON response from the service
        return $stats;
    }

    public function getAdsAccounts()
    {
        $user = Auth::user();
        // Get the accounts for the authenticated user
        $accounts = SnapchatAccount::where('user_id', Auth::id())->get();

        return response()->json($accounts);
    }

    public function getAdsCampaigns($accountId)
    {
        // Get campaigns for the specified account
        $campaigns = SnapchatCampaign::where('snapchat_account_id', $accountId)->get();

        return response()->json($campaigns);
    }

    public function getAdsQuads($campaignId)
    {
        // Get ad squads for the specified campaign
        $adSquads = SnapchatAdsquad::where('snapchat_campaign_id', $campaignId)->get();

        return response()->json($adSquads);
    }

    public function fetchAdsByAccount(Request $request, $accountId)
    {
        $ads = SnapAd::where('snapchat_account_id', $accountId)->get();
        return response()->json($ads);
    }

    public function fetchAdsByCampaign(Request $request, $campaignId)
    {
        $ads = SnapAd::where('snapchat_campaign_id', $campaignId)->get();
        return response()->json($ads);
    }

    public function fetchAdsByAdSquad(Request $request, $squadId)
    {
        $ads = SnapAd::where('snapchat_adsquad_id', $squadId)->get();
        return response()->json($ads);
    }


    public function getData()
    {
        $user = Auth::user()->load([
            'snapchatAccounts.snapchatCampaigns.snapchatAdsquads.snapAds',
        ]);

        // Check if user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Flatten the data for the response
        $accounts = $user->snapchatAccounts;

        $campaigns = $accounts->flatMap(function ($account) {
            return $account->snapchatCampaigns;
        });

        $adsquads = $campaigns->flatMap(function ($campaign) {
            return $campaign->snapchatAdsquads;
        });

        $ads = $adsquads->flatMap(function ($adsquad) {
            return $adsquad->snapAds;
        });

        // Return the related data in the response
        return response()->json([
            'accounts' => $accounts,
            'campaigns' => $campaigns,
            'adsquads' => $adsquads,
            'ads' => $ads,
        ], 200);
    }

}
