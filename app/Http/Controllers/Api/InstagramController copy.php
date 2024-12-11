<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InstagramAccount;
use App\Models\InstagramAd;
use App\Models\InstagramAdAccount;
use App\Models\InstagramAdSet;
use App\Models\InstagramCampaign;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class InstagramController extends Controller
{


    // Step 1: Redirect to Snapchat for authorization

    public function redirectToInstagram(Request $request)
    {
        return Socialite::driver('instagram-business')->redirect();
    }

    // Step 2: Handle the callback from Snapchat
    public function handleCallback(Request $request)
    {
        try{
            $user = Socialite::driver('instagram-business')->user();
            dd($user);
        }catch (\Exception $exception){
            dd('error');
        }
    }

    public function saveDataOrgInstagram($userId)
    {
        $user = User::find($userId);
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/v17.0/',
            'timeout'  => 10.0,
        ]);

        try {
            // Fetch Ad Accounts
            $adAccountsResponse = $client->get('me/adaccounts', [
                'query' => ['access_token' => $user->facebook_token],
            ]);
            $adAccounts = json_decode($adAccountsResponse->getBody()->getContents(), true)['data'];

            foreach ($adAccounts as $adAccount) {
                $adAccountModel = InstagramAdAccount::updateOrCreate(
                    ['account_id' => $adAccount['id']],
                    [
                        'name' => $adAccount['name'] ?? null,
                        'currency' => $adAccount['currency'] ?? null,
                        'account_status' => $adAccount['account_status'] ?? null,
                        'user_id' => $user->id,
                    ]
                );

                // Fetch Instagram Accounts Linked to Ad Account
                $instagramAccountsResponse = $client->get("{$adAccount['id']}/connected_instagram_accounts", [
                    'query' => ['access_token' => $user->facebook_token],
                ]);
                $instagramAccounts = json_decode($instagramAccountsResponse->getBody()->getContents(), true)['data'];

                foreach ($instagramAccounts as $instagramAccount) {
                    $instagramAccountModel = InstagramAccount::updateOrCreate(
                        ['account_id' => $instagramAccount['id']],
                        [
                            'username' => $instagramAccount['username'] ?? null,
                            'name' => $instagramAccount['name'] ?? null,
                            'profile_picture_url' => $instagramAccount['profile_picture_url'] ?? null,
                            'instagram_ad_account_id' => $adAccountModel->id,
                        ]
                    );

                    // Fetch Instagram Ads
                    $adsResponse = $client->get("{$adAccount['id']}/ads", [
                        'query' => [
                            'fields' => 'id,name,status,creative,adset_id,campaign_id',
                            'access_token' => $user->facebook_token,
                        ],
                    ]);
                    $ads = json_decode($adsResponse->getBody()->getContents(), true)['data'];

                    foreach ($ads as $ad) {
                        // Check if the ad is related to Instagram (optional filter based on placement)
                        if ($ad['creative']['effective_instagram_story_id'] ?? false || $ad['creative']['effective_instagram_post_id'] ?? false) {
                            InstagramAdAccount::updateOrCreate(
                                ['ad_id' => $ad['id']],
                                [
                                    'name' => $ad['name'] ?? null,
                                    'status' => $ad['status'] ?? null,
                                    'creative' => json_encode($ad['creative']) ?? null,
                                    'instagram_ad_account_id' => $adAccountModel->id,
                                ]
                            );
                        }
                    }
                }

                // Fetch Instagram Campaigns and Ad Sets (Optional)
                $campaignsResponse = $client->get("{$adAccount['id']}/campaigns", [
                    'query' => ['access_token' => $user->facebook_token],
                ]);
                $campaigns = json_decode($campaignsResponse->getBody()->getContents(), true)['data'];

                foreach ($campaigns as $campaign) {
                    $campaignModel = InstagramCampaign::updateOrCreate(
                        ['campaign_id' => $campaign['id']],
                        [
                            'name' => $campaign['name'] ?? null,
                            'status' => $campaign['status'] ?? null,
                            'objective' => $campaign['objective'] ?? null,
                            'instagram_ad_account_id' => $adAccountModel->id,
                        ]
                    );

                    // Fetch Ad Sets
                    $adSetsResponse = $client->get("{$campaign['id']}/adsets", [
                        'query' => ['access_token' => $user->facebook_token],
                    ]);
                    $adSets = json_decode($adSetsResponse->getBody()->getContents(), true)['data'];

                    foreach ($adSets as $adSet) {
                        $adSetModel = InstagramAdSet::updateOrCreate(
                            ['ad_set_id' => $adSet['id']],
                            [
                                'name' => $adSet['name'] ?? null,
                                'status' => $adSet['status'] ?? null,
                                'budget' => $adSet['daily_budget'] ?? null,
                                'instagram_campaign_id' => $campaignModel->id,
                            ]
                        );

                        // Fetch Ads in the Ad Set
                        $adsResponse = $client->get("{$adSet['id']}/ads", [
                            'query' => ['access_token' => $user->facebook_token],
                        ]);
                        $ads = json_decode($adsResponse->getBody()->getContents(), true)['data'];

                        foreach ($ads as $ad) {
                            InstagramAd::updateOrCreate(
                                ['ad_id' => $ad['id']],
                                [
                                    'name' => $ad['name'] ?? null,
                                    'status' => $ad['status'] ?? null,
                                    'creative' => json_encode($ad['creative']) ?? null,
                                    'instagram_ad_set_id' => $adSetModel->id,
                                ]
                            );
                        }
                    }
                }
            }

            return response()->json(['message' => 'Instagram data successfully saved.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }


}
