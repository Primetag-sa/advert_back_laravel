<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TikTokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiktokController extends Controller
{
    public function getUserInfo(Request $request, TikTokService $tikTokService)
    {

        $user = Auth::user();

        $url = $request->query('url');
        // Vérifier si un token utilisateur est présent

        if (! $user) {

            $redirectUrl = config('app.url_frontend').$url.'?status=failure';
            return redirect($redirectUrl);

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
