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

}
