<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SnapAd;
use App\Models\SnapchatAccount;
use App\Models\SnapchatAdsquad;
use App\Models\SnapchatCampaign;
use App\Models\User;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{

    // Step 1: Redirect to Snapchat for authorization

    public function redirectToSnapchat(Request $request)
    {
        return Socialite::driver('facebook')
            ->scopes(['ads_read', 'ads_management', 'business_management'])
            ->redirect();
        
        
        // return Socialite::driver('facebook')
        // ->scopes(['instagram_basic', 'instagram_manage_insights', 'ads_read', 'ads_management'])
        // ->redirect();
        
    }

    // Step 2: Handle the callback from Snapchat
    public function handleCallback(Request $request)
    {
        try{
            $facebookUser = Socialite::driver('facebook')->user();
        }catch(\Exception $exception){
            dd('error : get information error');
        }
        
        dd($facebookUser);
        $accessToken = $facebookUser->token;

        

        // Initialize the Facebook SDK
        $fb = new Facebook([
            'app_id' => env('FACEBOOK_CLIENT_ID'),
            'app_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'default_graph_version' => 'v17.0',
        ]);

        try {
            // Get user's ad accounts
            $response = $fb->get('/me/adaccounts', $accessToken);
            $adAccounts = $response->getDecodedBody(); // Returns ad account data

            // Get ad information from a specific ad account
            $adAccountId = $adAccounts['data'][0]['id']; // Example: the first ad account
            $adsResponse = $fb->get("/$adAccountId/ads", $accessToken);
            $ads = $adsResponse->getDecodedBody(); // Returns ad data

            // Now you can use the ad information
            return $ads;

        } catch (FacebookResponseException $e) {
            return 'Graph API returned an error: ' . $e->getMessage();
        } catch (FacebookSDKException $e) {
            return 'Facebook SDK returned an error: ' . $e->getMessage();
        }
    }

    // Facebook\Exceptions\FacebookResponseException
    // Facebook\Exceptions\

    // Instagram from facebook

    public function redirectToProvider() {
        return Socialite::driver('facebook')
            ->scopes(['instagram_basic', 'instagram_manage_insights', 'ads_read', 'ads_management'])
            ->redirect();
    }

    public function handleProviderCallback() {
        $user = Socialite::driver('facebook')->user();
        
        // استرجاع معرف حساب Instagram Business
        $instagramBusinessAccountId = $user->facebook_page->instagram_business_account;
        
        // قم بإرسال طلب إلى Facebook Graph API لاسترجاع بيانات إعلانات Instagram
        $ads = Http::get("https://graph.facebook.com/{$instagramBusinessAccountId}/ads", [
            'access_token' => $user->token,
            'fields' => 'impressions,clicks,spend'
        ]);
        
        
        return $ads->json();
    }


}
