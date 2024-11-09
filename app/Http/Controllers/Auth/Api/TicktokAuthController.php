<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TikTokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicktokAuthController extends Controller
{
    public function redirectToTikTok(Request $request)
    {

        $url = $request->query('url');
        $user=Auth::user();


        $clientId = config('services.tiktok.client_id');
        $redirectUri = config('services.tiktok.redirect');
        $state = [
            'url' => $url,
            'user_id' => $user->id,
        ];

        $url = 'https://www.tiktok.com/v2/auth/authorize?response_type=code&scope=user.info.basic&client_key='.$clientId.'&redirect_uri='.urlencode($redirectUri).'&state='.json_encode($state);

        return redirect()->away($url);
    }

    public function handleTikTokCallback(Request $request, TikTokService $tiktokService)
    {

        $state = json_decode($request->input('state'), true);
        $url = $state['url'] ?? null;
        $user_id = $state['user_id'] ?? null;

        $user = User::find($user_id);

        try {

            if (!$user) {

                // Rediriger avec une erreur sur l'URL
                $redirectUrl = config('app.url_frontend').$url.'?status=failure';

                return redirect($redirectUrl);
            }

            $code = $request->input('code');

            if (! $code) {
                return response()->json(['error' => 'Authorization code not provided'], 400);
            }

            $accessTokenData = $tiktokService->getAccessToken($code);

            if (isset($accessTokenData['access_token'])) {
                $userInfo = $tiktokService->getUserInfo($accessTokenData['access_token']);

                if ($userInfo) {
                    $user->tiktok_id = $accessTokenData['open_id'];
                    $user->tiktok_token = $accessTokenData['refresh_token'];
                    $user->save();
                }

                // Rediriger vers Angular avec un message de succès
                $redirectUrl = config('app.url_frontend').$url.'?status=success';

                return redirect($redirectUrl);
            }
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        } catch (\Exception $e) {

            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }
    }
}
