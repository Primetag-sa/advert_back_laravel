<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Services\TikTokService;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TicktokAuthController extends Controller
{
    public function redirectToTikTok(Request $request)
    {
        $token = $request->query('token');
        $url = $request->query('url');

        $clientId = config('services.tiktok.client_id');
        $redirectUri = config('services.tiktok.redirect');
        $state = [
            'token' => $token,
            'url' => $url,
        ];

        $url = 'https://www.tiktok.com/v2/auth/authorize?response_type=code&scope=user.info.basic&client_key='.$clientId.'&redirect_uri='.urlencode($redirectUri).'&state='.json_encode($state);

        return redirect()->away($url);
    }

    public function handleTikTokCallback(Request $request, TikTokService $tiktokService)
    {

        $state = json_decode($request->input('state'), true);
        $token = $state['token'] ?? null;
        $url = $state['url'] ?? null;

        try {

            // Vérifier si un token utilisateur est présent
            $user = null;
            if ($token) {
                $personalAccessToken = PersonalAccessToken::findToken($token);
                if ($personalAccessToken) {
                    $user = $personalAccessToken->tokenable;
                } else {
                    // Rediriger avec une erreur sur l'URL
                    $redirectUrl = config('app.url_frontend').$url.'?status=failure';

                    return redirect($redirectUrl);
                }
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
