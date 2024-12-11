<?php
namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoogleAdsAuthController extends Controller
{
    private $client;


    public function __construct()
    {
        $this->client = new Client();
    }


    public function signOutGoogleAds()
    {
        $user = Auth::user();
        $user->update([
            'google_token' => null,
            'google_refresh_token' => null,
            'google_expire' => null,
            'customers_google' => null,
            'google_state' => false,
        ]);

        return response()->json($user, 200);
    }

    public function redirectToGoogle(Request $request)
    {

        $url = $request->query('url');
        $user = Auth::user();

        $state = json_encode([
            'redirect_url' => $url,
            'user_id' => $user->id,
        ]);

        $queryParams = http_build_query([
            'client_id' => env('GOOGLE_ADS_CLIENT_ID'),
            'redirect_uri' => route('google-ads.callback'),
            'response_type' => 'code',
            'scope' => 'https://www.googleapis.com/auth/adwords',
            'access_type' => 'offline',
            'state' => $state,
            'prompt' => 'consent',
        ]);

        $authUrl = "https://accounts.google.com/o/oauth2/v2/auth?{$queryParams}";

        return redirect($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $state = json_decode($request->query('state'));

            if (!$state || !isset($state->redirect_url, $state->user_id)) {
                return $this->redirectWithError($state->redirect_url ?? '/');
            }

            $user = User::findOrFail($state->user_id);

            if (!$request->has('code')) {
                return $this->redirectWithError($state->redirect_url);
            }

            $tokenResponse = $this->client->post('https://oauth2.googleapis.com/token', [
                'form_params' => [
                    'client_id' => env('GOOGLE_ADS_CLIENT_ID'),
                    'client_secret' => env('GOOGLE_ADS_CLIENT_SECRET'),
                    'code' => $request->input('code'),
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => route('google-ads.callback'),
                ]
            ]);

            $tokens = json_decode($tokenResponse->getBody(), true);

            if (empty($tokens['refresh_token'])) {
                return $this->redirectWithError($state->redirect_url);
            }

            $user->update([
                'google_token' => $tokens['access_token'],
                'google_refresh_token' => $tokens['refresh_token'],
                'google_expire' => now()->addSeconds($tokens['expires_in']),
                'google_state' => true
            ]);

            return redirect(config('app.url_frontend') . $state->redirect_url . '?status=success');

        } catch (\Exception $e) {
            Log::error('Google Ads Auth Error: ' . $e->getMessage());
            return $this->redirectWithError($state->redirect_url ?? '/');
        }
    }

    private function redirectWithError($redirectUrl)
    {
        return redirect(config('app.url_frontend') . $redirectUrl . '?status=failure');
    }
}
