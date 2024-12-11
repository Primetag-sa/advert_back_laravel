<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FacebookAd;
use App\Models\FacebookAdAccount;
use App\Models\FacebookAdSet;
use App\Models\FacebookCampaign;
use App\Models\User;
use App\Services\FacebookAdService;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class FacebookController extends Controller
{
    // Step 1: Redirect to Facebook for authorization
    public function redirectToFacebook(Request $request)
    {
        return Socialite::driver('facebook')
            ->scopes(['ads_management'])
            ->redirect();
    }

    // Private method to fetch data from Facebook
    private function fetchFromFacebook($endpoint, $accessToken)
    {
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/v17.0/',
            'timeout'  => 20.0,
        ]);

        try {
            $response = $client->get($endpoint, [
                'query' => ['access_token' => $accessToken],
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching data from Facebook API: " . $e->getMessage());
        }
    }

    public function saveDataOrg($userId)
    {
        $user = User::find($userId);

        try {
            // Fetch Ad Accounts
            $adAccounts = $this->fetchFromFacebook('me/adaccounts', $user->facebook_token)['data'];

            foreach ($adAccounts as $adAccount) {
                $adAccountModel = FacebookAdAccount::updateOrCreate(
                    ['account_id' => $adAccount['id']],
                    [
                        'name' => $adAccount['name'] ?? null,
                        'currency' => $adAccount['currency'] ?? null,
                        'account_status' => $adAccount['account_status'] ?? null,
                        'user_id' => $user->id,
                    ]
                );

                // Save Ads Directly from Ad Account (before campaigns and ad sets)
                $ads = $this->fetchFromFacebook("act_{$adAccount['id']}/ads", $user->facebook_token)['data'];

                foreach ($ads as $ad) {
                    FacebookAd::updateOrCreate(
                        ['ad_id' => $ad['id']],
                        [
                            'name' => $ad['name'] ?? null,
                            'status' => $ad['status'] ?? null,
                            'creative' => json_encode($ad['creative']) ?? null,
                            'facebook_ad_account_id' => $adAccountModel->id,
                        ]
                    );
                }

                // Process Campaigns
                $campaigns = $this->fetchFromFacebook("act_{$adAccount['id']}/campaigns", $user->facebook_token)['data'];

                foreach ($campaigns as $campaign) {
                    $campaignModel = FacebookCampaign::updateOrCreate(
                        ['campaign_id' => $campaign['id']],
                        [
                            'name' => $campaign['name'] ?? null,
                            'status' => $campaign['status'] ?? null,
                            'objective' => $campaign['objective'] ?? null,
                            'facebook_ad_account_id' => $adAccountModel->id,
                        ]
                    );

                    // Save Ads Directly from Ad Account (before campaigns and ad sets)
                    $ads = $this->fetchFromFacebook("{$campaign['id']}/ads", $user->facebook_token)['data'];

                    foreach ($ads as $ad) {
                        FacebookAd::updateOrCreate(
                            ['ad_id' => $ad['id']],
                            [
                                'name' => $ad['name'] ?? null,
                                'status' => $ad['status'] ?? null,
                                'creative' => json_encode($ad['creative']) ?? null,
                                'facebook_ad_account_id' => $adAccountModel->id,
                                'facebook_campaign_id' => $campaignModel->id,
                            ]
                        );
                    }

                    // Process Ad Sets
                    $adSets = $this->fetchFromFacebook("{$campaign['id']}/adsets", $user->facebook_token)['data'];

                    foreach ($adSets as $adSet) {
                        $adSetModel = FacebookAdSet::updateOrCreate(
                            ['ad_set_id' => $adSet['id']],
                            [
                                'name' => $adSet['name'] ?? null,
                                'status' => $adSet['status'] ?? null,
                                'budget' => $adSet['daily_budget'] ?? null,
                                'campaign_id' => $campaignModel->id,
                            ]
                        );

                        // Fetch and Save Ads Associated with the Ad Set
                        $ads = $this->fetchFromFacebook("{$adSet['id']}/ads", $user->facebook_token)['data'];

                        foreach ($ads as $ad) {
                            FacebookAd::updateOrCreate(
                                ['ad_id' => $ad['id']],
                                [
                                    'name' => $ad['name'] ?? null,
                                    'status' => $ad['status'] ?? null,
                                    'creative' => json_encode($ad['creative']) ?? null,
                                    'facebook_ad_set_id' => $adSetModel->id,
                                    'facebook_ad_account_id' => $adAccountModel->id,
                                    'facebook_campaign_id' => $campaignModel->id,
                                ]
                            );
                        }
                    }
                }
            }

            return response()->json(['message' => 'Ad data successfully saved.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function saveData()
    {

        $user = Auth()->user();

        try {
            // Fetch Ad Accounts
            $adAccounts = $this->fetchFromFacebook('me/adaccounts', $user->facebook_token)['data'];

            foreach ($adAccounts as $adAccount) {
                $adAccountModel = FacebookAdAccount::updateOrCreate(
                    ['account_id' => $adAccount['id']],
                    [
                        'name' => $adAccount['name'] ?? null,
                        'currency' => $adAccount['currency'] ?? null,
                        'account_status' => $adAccount['account_status'] ?? null,
                        'user_id' => $user->id,
                    ]
                );

                // Save Ads Directly from Ad Account (before campaigns and ad sets)
                $ads = $this->fetchFromFacebook("act_{$adAccount['id']}/ads", $user->facebook_token)['data'];

                foreach ($ads as $ad) {
                    FacebookAd::updateOrCreate(
                        ['ad_id' => $ad['id']],
                        [
                            'name' => $ad['name'] ?? null,
                            'status' => $ad['status'] ?? null,
                            'creative' => json_encode($ad['creative']) ?? null,
                            'facebook_ad_account_id' => $adAccountModel->id,
                        ]
                    );
                }

                // Process Campaigns
                $campaigns = $this->fetchFromFacebook("act_{$adAccount['id']}/campaigns", $user->facebook_token)['data'];

                foreach ($campaigns as $campaign) {
                    $campaignModel = FacebookCampaign::updateOrCreate(
                        ['campaign_id' => $campaign['id']],
                        [
                            'name' => $campaign['name'] ?? null,
                            'status' => $campaign['status'] ?? null,
                            'objective' => $campaign['objective'] ?? null,
                            'facebook_ad_account_id' => $adAccountModel->id,
                        ]
                    );

                    // Save Ads Directly from Ad Account (before campaigns and ad sets)
                    $ads = $this->fetchFromFacebook("{$campaign['id']}/ads", $user->facebook_token)['data'];

                    foreach ($ads as $ad) {
                        FacebookAd::updateOrCreate(
                            ['ad_id' => $ad['id']],
                            [
                                'name' => $ad['name'] ?? null,
                                'status' => $ad['status'] ?? null,
                                'creative' => json_encode($ad['creative']) ?? null,
                                'facebook_ad_account_id' => $adAccountModel->id,
                                'facebook_campaign_id' => $campaignModel->id,
                            ]
                        );
                    }

                    // Process Ad Sets
                    $adSets = $this->fetchFromFacebook("{$campaign['id']}/adsets", $user->facebook_token)['data'];

                    foreach ($adSets as $adSet) {
                        $adSetModel = FacebookAdSet::updateOrCreate(
                            ['ad_set_id' => $adSet['id']],
                            [
                                'name' => $adSet['name'] ?? null,
                                'status' => $adSet['status'] ?? null,
                                'budget' => $adSet['daily_budget'] ?? null,
                                'campaign_id' => $campaignModel->id,
                            ]
                        );

                        // Fetch and Save Ads Associated with the Ad Set
                        $ads = $this->fetchFromFacebook("{$adSet['id']}/ads", $user->facebook_token)['data'];

                        foreach ($ads as $ad) {
                            FacebookAd::updateOrCreate(
                                ['ad_id' => $ad['id']],
                                [
                                    'name' => $ad['name'] ?? null,
                                    'status' => $ad['status'] ?? null,
                                    'creative' => json_encode($ad['creative']) ?? null,
                                    'facebook_ad_set_id' => $adSetModel->id,
                                    'facebook_ad_account_id' => $adAccountModel->id,
                                    'facebook_campaign_id' => $campaignModel->id,
                                ]
                            );
                        }
                    }
                }
            }

            return response()->json(['message' => 'Ad data successfully saved.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function handleCallback(Request $request)
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        $user = auth()->user();
        $user->update([
            'facebook_name' => $facebookUser->user['name'],
            'facebook_email' => $facebookUser->user['email'],
            'facebook_avatar' => $facebookUser->avatar,
            'facebook_id' => $facebookUser->id,
            'facebook_token' => $facebookUser->token,
            'facebook_refresh_token' => $facebookUser->refreshToken,
        ]);

        // $this->saveDataOrg($user->id);
        return redirect()->to('https:/advert.sa/facebook');
    }

    /* code snapchat */
    protected $facebookService;
    protected $client;

    public function __construct(FacebookAdService $facebookService)
    {
        $this->client = new Client();
        $this->facebookService = $facebookService;
    }

    public function getAdStats($adId, Request $request)
    {
        // Default date range
        $startTime = $request->query('startDate', Carbon::now()->subMonth()->startOfDay()->toIso8601String());
        $endTime = $request->query('endDate', Carbon::now()->toIso8601String());
        $breakdown = $request->query('breakdown', 'day'); // e.g., daily breakdown

        // Fetch authenticated user
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated user'], 401);
        }

        $accessToken = $user->facebook_access_token;
        if (!$accessToken) {
            return response()->json(['error' => 'Access token not found for the user.'], 401);
        }

        // Validate the Ad ID
        $ad = FacebookAd::find($adId);
        if (!$ad) {
            return response()->json(['error' => 'Ad not found.'], 404);
        }

        // Fetch ad stats using the service
        try {
            $stats = $this->facebookService->getAdStats($ad->facebook_ad_id, $startTime, $endTime, $breakdown, $accessToken);
        } catch (\Exception $e) {
            // Handle token refresh and retry if needed
            if ($e->getCode() === 401) {
                $refreshResponse = $this->refreshFacebookAccessToken($user);

                if ($refreshResponse['success']) {
                    $stats = $this->facebookService->getAdStats($ad->facebook_ad_id, $startTime, $endTime, $breakdown, $user->facebook_access_token);
                    return response()->json($stats);
                } else {
                    return response()->json(['error' => 'Failed to refresh access token.', 'details' => $refreshResponse['details']], 401);
                }
            }

            return response()->json(['error' => 'Failed to fetch ad stats.', 'details' => $e->getMessage()], 500);
        }

        return response()->json($stats);
    }

    private function refreshFacebookAccessToken($user)
    {
        // Facebook OAuth token refresh endpoint
        $url = 'https://graph.facebook.com/oauth/access_token';

        try {
            // Make the POST request to refresh the access token
            $response = $this->client->post($url, [
                'form_params' => [
                    'grant_type' => 'fb_exchange_token', // Grant type for token exchange
                    'client_id' => config('services.facebook.client_id'), // Facebook App ID
                    'client_secret' => config('services.facebook.client_secret'), // Facebook App Secret
                    'fb_exchange_token' => $user->facebook_refresh_token, // The long-lived access token
                ],
            ]);

            // Parse the response
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the response contains the access token
            if (isset($data['access_token'])) {
                // Update the user's access token
                $user->facebook_access_token = $data['access_token'];
                $user->save();

                // Return success response
                return ['success' => true];
            }

            return ['success' => false, 'details' => 'Access token refresh failed.'];
        } catch (\Exception $e) {
            return ['success' => false, 'details' => $e->getMessage()];
        }
    }

    public function getAdSquadStats($adSquadId, Request $request)
    {
        // Set default start and end dates if not provided in the request
        $startTime = $request->query('startDate', Carbon::now()->subMonth()->startOfDay()->toIso8601String());
        $endTime = $request->query('endDate', Carbon::now()->toIso8601String());
        $granularity = $request->query('type', 'day'); // Default granularity to 'day'

        // Get the authenticated user and their Facebook access token
        $user = Auth::user();
        $accessToken = $user->facebook_access_token;

        // Find the ad squad in your database
        $adSquad = FacebookAdSet::find($adSquadId);

        if (!$adSquad) {
            return response()->json(['error' => 'Ad squad not found.'], 404);
        }

        // Call the service method to fetch stats
        try {
            $stats = $this->facebookService->getAdSquadStats($adSquad->fb_id, $startTime, $endTime, $accessToken, $granularity);
            return response()->json($stats, 200);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function getCampaignStats($campaignId, Request $request)
    {
        $startTime = $request->query('startDate', Carbon::now()->subMonth()->startOfDay()->toIso8601String());
        $endTime = $request->query('endDate', Carbon::now()->toIso8601String());
        $breakdown = $request->query('breakdown', 'day');

        $user = Auth::user();
        $accessToken = $user->facebook_access_token;

        $campaign = FacebookCampaign::find($campaignId);
        if (!$campaign) {
            return response()->json(['error' => 'Campaign not found.'], 404);
        }

        $stats = $this->facebookService->getCampaignStats($campaign->facebook_campaign_id, $startTime, $endTime, $breakdown, $accessToken);

        return response()->json($stats);
    }

    public function getAdsetStats($adsetId, Request $request)
    {
        $startTime = $request->query('startDate', Carbon::now()->subMonth()->startOfDay()->toIso8601String());
        $endTime = $request->query('endDate', Carbon::now()->toIso8601String());
        $breakdown = $request->query('breakdown', 'day');

        $user = Auth::user();
        $accessToken = $user->facebook_access_token;

        $adset = FacebookAdset::find($adsetId);
        if (!$adset) {
            return response()->json(['error' => 'Adset not found.'], 404);
        }

        $stats = $this->facebookService->getAdsetStats($adset->facebook_adset_id, $startTime, $endTime, $breakdown, $accessToken);

        return response()->json($stats);
    }

    public function getAdsCampaigns($accountId)
{
    // Get campaigns for the specified Facebook account
    $campaigns = FacebookCampaign::where('facebook_account_id', $accountId)->get();

    return response()->json($campaigns);
}

public function getAdsQuads($campaignId)
{
    // Get ad sets (ad squads) for the specified Facebook campaign
    $adSets = FacebookAdSet::where('facebook_campaign_id', $campaignId)->get();

    return response()->json($adSets);
}

public function fetchAdsByAccount(Request $request, $accountId)
{
    // Get ads for the specified Facebook account
    $ads = FacebookAd::where('facebook_account_id', $accountId)->get();

    return response()->json($ads);
}

public function fetchAdsByCampaign(Request $request, $campaignId)
{
    // Get ads for the specified Facebook campaign
    $ads = FacebookAd::where('facebook_campaign_id', $campaignId)->get();

    return response()->json($ads);
}

public function fetchAdsByAdSquad(Request $request, $squadId)
{
    // Get ads for the specified Facebook ad set (ad squad)
    $ads = FacebookAd::where('facebook_adset_id', $squadId)->get();

    return response()->json($ads);
}

public function getData()
{
    // Load all related data for the authenticated user
    $user = Auth::user()->load([
        'facebookAccounts.facebookCampaigns.facebookAdSets.facebookAds',
    ]);

    // Check if user exists
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Flatten the data for the response
    $accounts = $user->facebookAccounts;

    $campaigns = $accounts->flatMap(function ($account) {
        return $account->facebookCampaigns;
    });

    $adSets = $campaigns->flatMap(function ($campaign) {
        return $campaign->facebookAdSets;
    });

    $ads = $adSets->flatMap(function ($adSet) {
        return $adSet->facebookAds;
    });

    // Return the related data in the response
    return response()->json([
        'accounts' => $accounts,
        'campaigns' => $campaigns,
        'adsquads' => $adSets,
        'ads' => $ads,
    ], 200);
}




    
}
