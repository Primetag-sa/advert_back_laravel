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
use App\Services\TwitterService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;

class SnapchatController extends Controller
{
    protected $snapchatService;

    public function __construct(SnapchatAdService $snapchatService)
    {
        $this->snapchatService = $snapchatService;
    }

    // Step 1: Redirect to Snapchat for authorization
    
    
    public function redirectToSnapchat(Request $request)
    {   
        session(['user_email' => $request->user_email]);
        
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

        $email = session('user_email');
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
            'snapchat_refresh_token' => $snapchatUser->refreshToken,
            'snapchat_token_expires_at' => now()->addSeconds($snapchatUser->expiresIn), // إضافة الوقت المناسب
        ];
         // update or create user in your database
         $user = User::updateOrCreate(['email'=>$email], $data);

        // Optionally, log the user in
        // Auth::login($user);
        
        return redirect()->route('saveData',['id'=>$user->id]);
        // return redirect()->to('http://localhost:4200/auth/snapchat/callback?user=' . urlencode(json_encode($user)));

        // return response()->json($user);
    }

    public function saveData($id)
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
            foreach($results['adaccounts'] as $item){
                
                if(in_array($item['sub_request_status'],haystack: ['success','SUCCESS'])){
                    $account = [
                        'snap_adaccount_id'=>$item['adaccount']['id'],
                        'snap_adaccount_created_at'=>$item['adaccount']['created_at'],
                        'snap_adaccount_name'=>$item['adaccount']['name'],
                        'snap_adaccount_type'=>$item['adaccount']['type'],
                        'snap_adaccount_status'=>$item['adaccount']['status'],
                        'snap_adaccount_organization_id'=>$item['adaccount']['organization_id'],
                        'snap_adaccount_currency'=>$item['adaccount']['currency'],
                        'snap_adaccount_timezone'=>$item['adaccount']['timezone'],
                        'snap_adaccount_advertiser_organization_id'=>$item['adaccount']['advertiser_organization_id'],
                        'snap_adaccount_advertiser_billing_type'=>$item['adaccount']['billing_type'],
                        'snap_adaccount_agency_representing_client'=>$item['adaccount']['agency_representing_client'],
                        'snap_adaccount_client_paying_invoices'=>$item['adaccount']['client_paying_invoices'],
                        'user_id'=>$user->id
                    ];

                    $snapchatAccount = SnapchatAccount::updateOrCreate(['snap_adaccount_id'=>$item['adaccount']['id']],$account);
                    
                    $ad_account_id = $snapchatAccount->snap_adaccount_id;
                    
                    // Get All Campaigns
                    // GET https://adsapi.snapchat.com/v1/adaccounts/{ad_account_id}/campaigns
                    $response = Http::withHeaders([
                        'Authorization' => 'Bearer ' . $accessToken,
                        'Content-Type' => 'application/json',
                    ])->get("https://adsapi.snapchat.com/v1/adaccounts/$ad_account_id/campaigns");

                    $results = $response->json();
                    // dd($results);
                    foreach($results['campaigns'] as $item){
                        if(in_array($item['sub_request_status'],haystack: ['success','SUCCESS'])){
                            $campaign = [
                                'snap_id'=>$item['campaign']['id'],
                                'snap_created_at'=>$item['campaign']['created_at'],
                                'snap_name'=>$item['campaign']['name'],
                                'snap_daily_budget_micro'=>$item['campaign']['daily_budget_micro'],
                                'snap_status'=>$item['campaign']['status'],
                                'snap_start_time'=>$item['campaign']['start_time'],
                                'snap_end_time'=>$item['campaign']['end_time'],
                                'snapchat_account_id' => $snapchatAccount->id,
                            ];

                            $snapchatCampaign  = SnapchatCampaign::updateOrCreate(['snap_id'=>$item['campaign']['id']],$campaign);
                            $campaign_id = $snapchatCampaign->id;

                            // Get All Ad Squads under a Campaign
                            // GET https://adsapi.snapchat.com/v1/campaigns/{campaign_id}/adsquads

                            $response = Http::withHeaders([
                                'Authorization' => 'Bearer ' . $accessToken,
                                'Content-Type' => 'application/json',
                            ])->get("https://adsapi.snapchat.com/v1/campaigns/{$campaign_id}/adsquads");

                            foreach($results['adsquads'] as $item){
                                if(in_array($item['sub_request_status'],haystack: ['success','SUCCESS'])){
                                    $adsquad = [
                                        'snap_id'=>$item['adsquad']['id'],
                                        'snap_created_at'=>$item['adsquad']['created_at'],
                                        'snap_name'=>$item['adsquad']['name'],
                                        'snap_status'=>$item['adsquad']['status'],
                                        'snap_type'=>$item['adsquad']['type'],
                                        'snap_billing_event'=>$item['adsquad']['billing_event'],
                                        'snap_auto_bid'=>$item['adsquad']['auto_bid'],
                                        'snap_target_bid'=>$item['adsquad']['target_bid'],
                                        'snap_bid_strategy'=>$item['adsquad']['bid_strategy'],
                                        'snap_daily_budget_micro'=>$item['adsquad']['budget_micro'],
                                        'snap_start_time'=>$item['adsquad']['start_time'],
                                        'snap_optimization_goal'=>$item['adsquad']['optimization_goal'],
                                        'snapchat_campaign_id' =>$snapchatCampaign->id
                                    ];

                                    $snapchatAdsquad=SnapchatAdsquad::updateOrCreate(['snap_id'=>$item['adsquad']['id']],$adsquad);

                                    // Get All Ads under an Ad Squad
                                    // GET https://adsapi.snapchat.com/v1/adsquads/{ad_squad_id}/ads
                                    $response = Http::withHeaders([
                                        'Authorization' => 'Bearer ' . $accessToken,
                                        'Content-Type' => 'application/json',
                                    ])->get("https://adsapi.snapchat.com/v1/adsquads/{$snapchatAdsquad->id}/ads");


                                    foreach($results['ads'] as $item){
                                        if(in_array($item['sub_request_status'],haystack: ['success','SUCCESS'])){
                                            $ad = [
                                                'snap_id'=>$item['ad']['id'],
                                                'snap_created_at'=>$item['ad']['created_at'],
                                                'snap_name'=>$item['ad']['name'],
                                                'snap_creative_id'=>$item['ad']['creative_id'],
                                                'snap_status'=>$item['ad']['status'],
                                                'snap_type'=>$item['ad']['type'],
                                                'snapchat_adsquad_id' =>$snapchatAdsquad->id
                                            ];

                                            $snapAd = SnapAd::updateOrCreate(['snap_id'=>$item['ad']['id']],$ad);

                                            // Get Ad Stats
                                            // "https://adsapi.snapchat.com/v1/ads/482fa116-95c1-43c9-8d17-5a6dc3330d41/stats?granularity=HOUR&fields=impressions,swipes,conversion_purchases,conversion_save,conversion_start_checkout,conversion_add_cart,conversion_view_content,conversion_add_billing,conversion_sign_ups,conversion_searches,conversion_level_completes,conversion_app_opens,conversion_page_views&start_time=2017-04-30T07:00:00.000-00:00&end_time=2017-04-30T10:00:00.000-00:00"
                                            // -org https://adsapi.snapchat.com/v1/ads/e8d6217f-32ab-400f-9e54-39a86a7963e4/stats?granularity=TOTAL&fields=impressions,swipes,screen_time_millis,quartile_1,quartile_2,quartile_3,view_completion,spend
                                            $response = Http::withHeaders([
                                                'Authorization' => 'Bearer ' . $accessToken,
                                                'Content-Type' => 'application/json',
                                            ])->get("https://adsapi.snapchat.com/v1/ads/{$snapAd->snap_id}/stats?granularity=HOUR&fields=impressions,swipes,conversion_purchases,conversion_save,conversion_start_checkout,conversion_add_cart,conversion_view_content,conversion_add_billing,conversion_sign_ups,conversion_searches,conversion_level_completes,conversion_app_opens,conversion_page_views&start_time=2017-04-30T07:00:00.000-00:00&end_time=2017-04-30T10:00:00.000-00:00");

                                            //normal website
                                            foreach($results['total_stats'] as $item){
                                                if(in_array($item['sub_request_status'],haystack: ['success','SUCCESS'])){
                                                    
                                                    $data = [
                                                        'stats_id' => $item['total_stat']['id'],
                                                        'stats_type' => $item['total_stat']['type'],
                                                        'stats_granularity' => $item['total_stat']['granularity'],
                                                        'stats_impressions' => $item['total_stat']['impressions'],
                                                        'stats_swipes' => $item['total_stat']['swipes'],
                                                        'stats_spend' => $item['total_stat']['spend'],
                                                        'stats_quartile_1' => $item['total_stat']['quartile_1'],
                                                        'stats_quartile_2' => $item['total_stat']['quartile_2'],
                                                        'stats_quartile_3' => $item['total_stat']['quartile_3'],
                                                        'stats_view_completion' => $item['total_stat']['view_completion'],
                                                        'stats_screen_time_millis' => $item['total_stat']['screen_time_millis'],
                                                    ];

                                                    $snapAd::update($data);
                                                }
                                            }
                                            //new website
                                            /*
                                            foreach($results['timeseries_stats'] as $item){
                                                if(in_array($item['sub_request_status'],haystack: ['success','SUCCESS'])){
                                                    
                                                    $data = [
                                                        'stats_id' => $item['timeseries_stat']['id'],
                                                        'stats_type' => $item['timeseries_stat']['type'],
                                                        'stats_granularity' => $item['timeseries_stat']['granularity'],

                                                        'stats_start_time' => $item['timeseries_stat']['start_time'],
                                                        'stats_end_time' => $item['timeseries_stat']['end_time'],
                                                        'stats_finalized_data_end_time' => $item['timeseries_stat']['finalized_data_end_time'],

                                                        
                                                        'stats_' => $item['timeseries_stat'][''],

                                                        'stats_impressions' => $item['total_stat']['impressions'],
                                                        'stats_swipes' => $item['total_stat']['swipes'],
                                                        'stats_spend' => $item['total_stat']['spend'],
                                                        'stats_quartile_1' => $item['total_stat']['quartile_1'],
                                                        'stats_quartile_2' => $item['total_stat']['quartile_2'],
                                                        'stats_quartile_3' => $item['total_stat']['quartile_3'],
                                                        'stats_' => $item['total_stat'][''],
                                                        'stats_view_completion' => $item['total_stat']['view_completion'],
                                                        'stats_screen_time_millis' => $item['total_stat']['screen_time_millis'],
                                                    ];

                                                    $snapAd::update($data);
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
        // dd($user?->snapchatAccounts->toArray());
        return redirect()->to('http://advert.sa/auth/snapchat/callback?user=' . urlencode(json_encode($user)));
        // return redirect()->to('https://advert.sa/auth/snapchat/callback?user=' . urlencode(json_encode($user)));

        // dd($response->json());

    }

    /* public function getData($id)
    {
        $user = User::with([
            'snapchatAccounts.snapchatCampaigns.snapchatAdsquads.snapAds'
        ])->find($id);
    
        // Check if user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        return response()->json([
            'accounts' => $user?->snapchatAccounts,
            'compangs'=>$user?->snapchatAccounts?->snapchatCampaigns,
            'adsquads'=>$user?->snapchatAccounts?->snapchatCampaigns?->snapchatAdsquads,
            'ads'=>$user?->snapchatAccounts?->snapchatCampaigns?->snapchatAdsquads?->ads
        ], 200);
    } */

    public function getData($id)
{
    // Eager load nested relationships
    $user = User::with([
        'snapchatAccounts.snapchatCampaigns.snapchatAdsquads.snapAds'
    ])->find($id);

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
