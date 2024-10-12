<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TikTokService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;

class TiktokController extends Controller
{


    public function getUserInfo(Request $request,TikTokService $tikTokService)
    {

        $token = $request->query('token');
        $url = $request->query('url');
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
        $newTokenData = $tikTokService->refreshAccessToken($user->tiktok_token);

        if (isset($newTokenData['access_token'])) {
            // Update tokens
            $user->tiktok_token = $newTokenData['refresh_token'];
            $user->save();
        } else {
            return response()->json(['error' => 'Unable to refresh access token'], 400);
        }
        $userInfo = $tikTokService->getUserInfo($newTokenData['access_token']);

        return json_encode($userInfo['data']['user']);
    }
}
