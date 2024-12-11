<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InstagramAd;
use App\Models\InstagramAdAccount;
use App\Models\InstagramMedia;
use App\Models\InstagramInsight;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class InstagramController extends Controller
{
    // Step 1: Redirect to Instagram for authorization
    public function redirectToInstagram(Request $request)
    {
        return Socialite::driver('facebook') // Instagram is under Facebook's API
            ->scopes(['instagram_basic', 'ads_management', 'instagram_manage_insights'])
            ->redirect();
    }

    // Private method to fetch data from Instagram (via Facebook Graph API)
    private function fetchFromInstagram($endpoint, $accessToken)
    {
        $client = new Client([
            'base_uri' => 'https://graph.instagram.com/',
            'timeout'  => 10.0,
        ]);

        try {
            $response = $client->get($endpoint, [
                'query' => ['access_token' => $accessToken],
            ]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception("Error fetching data from Instagram API: " . $e->getMessage());
        }
    }

    // Save Instagram Ad Data (Instagram Ads is part of Facebook Ads API)
    public function saveInstagramData($userId)
    {
        $user = User::find($userId);

        try {
            // Fetch Instagram Business Accounts
            $instagramAccounts = $this->fetchFromInstagram('me/accounts', $user->facebook_token)['data'];

            foreach ($instagramAccounts as $instagramAccount) {
                $instagramAccountModel = InstagramAdAccount::updateOrCreate(
                    ['account_id' => $instagramAccount['id']],
                    [
                        'name' => $instagramAccount['name'] ?? null,
                        'instagram_account_id' => $instagramAccount['id'],
                        'user_id' => $user->id,
                    ]
                );

                // Fetch Instagram Media (Posts, Stories, etc.)
                $media = $this->fetchFromInstagram("{$instagramAccount['id']}/media", $user->facebook_token)['data'];

                foreach ($media as $mediaItem) {
                    InstagramMedia::updateOrCreate(
                        ['media_id' => $mediaItem['id']],
                        [
                            'media_type' => $mediaItem['media_type'] ?? null,
                            'caption' => $mediaItem['caption'] ?? null,
                            'media_url' => $mediaItem['media_url'] ?? null,
                            'instagram_ad_account_id' => $instagramAccountModel->id,
                        ]
                    );

                    // Fetch and Save Media Insights (likes, comments, etc.)
                    $insights = $this->fetchFromInstagram("{$mediaItem['id']}/insights", $user->facebook_token)['data'];

                    foreach ($insights as $insight) {
                        InstagramInsight::updateOrCreate(
                            ['insight_id' => $insight['id']],
                            [
                                'name' => $insight['name'] ?? null,
                                'values' => json_encode($insight['values']) ?? null,
                                'media_id' => $mediaItem['id'],
                            ]
                        );
                    }
                }
            }

            return response()->json(['message' => 'Instagram data successfully saved.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // Handle Instagram Callback (after authorization)
    public function handleInstagramCallback(Request $request)
    {
        try {
            $instagramUser = Socialite::driver('facebook')->user(); // Instagram user is fetched through Facebook driver
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }

        $user = auth()->user();
        $user->update([
            'instagram_name' => $instagramUser->user['name'],
            'instagram_email' => $instagramUser->user['email'],
            'instagram_avatar' => $instagramUser->avatar,
            'instagram_id' => $instagramUser->id,
            'facebook_token' => $instagramUser->token, // Facebook token for Instagram API
            'facebook_refresh_token' => $instagramUser->refreshToken,
        ]);

        $this->saveInstagramData($user->id);
        return redirect()->to('https:/advert.sa/instagram');
    }
}
