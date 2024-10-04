<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\SnapchatAd; // Assume you have an SnapchatAd model for saving data

class SnapchatService
{
    // Redirect to Snapchat for authorization
    public function redirectToSnapchat()
    {
        $url = 'https://ads.snapchat.com/oauth/authorize?client_id=' . config('services.snapchat.client_id') .
               '&redirect_uri=' . config('services.snapchat.redirect_uri') .
               '&response_type=code';
        return redirect($url);
    }

    // Handle the callback from Snapchat
    public function handleCallback($request)
    {
        $code = $request->query('code');
        $tokenResponse = $this->exchangeCodeForAccessToken($code);

        if (isset($tokenResponse['access_token'])) {
            $adData = $this->getAdDataFromSnapchat($tokenResponse['access_token']);
            $this->saveAdData($adData);
        }

        return $adData; // Return the ad data if needed
    }

    // Exchange the code for an access token
    private function exchangeCodeForAccessToken($code)
    {
        $response = Http::asForm()->post('https://ads.snapchat.com/oauth/access_token', [
            'client_id' => config('services.snapchat.client_id'),
            'client_secret' => config('services.snapchat.client_secret'),
            'grant_type' => 'authorization_code',
            'redirect_uri' => config('services.snapchat.redirect_uri'),
            'code' => $code,
        ]);

        return $response->json();
    }

    // Retrieve advertisement data from Snapchat
    private function getAdDataFromSnapchat($accessToken)
    {
        $response = Http::withToken($accessToken)->get('https://adsapi.snapchat.com/v1/adaccounts/ad_data');
        return $response->json();
    }

    // Save advertisement data to the database
    private function saveAdData($adData)
    {
        foreach ($adData['data'] as $data) {
            SnapchatAd::create([
                'ad_name' => $data['ad_name'],
                'impressions' => $data['impressions'],
                'click_through_rate' => $data['click_through_rate'],
                'conversion_rate' => $data['conversion_rate'],
                'engagements' => $data['engagements'],
                'reach' => $data['reach'],
                'revenue' => $data['revenue'],
                'cost' => $data['cost'],
                // Add other fields as necessary
            ]);
        }
    }

    // Fetch ad data for display
    public function getAdData()
    {
        return SnapchatAd::all(); // Fetch all ad data from the database
    }
}
