<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\TikTokService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicktokAuthController extends Controller
{


    public function signOutTiktok()
    {

        $user = Auth::user();

        $user->update([
            'tiktok_id' => null,
            'tiktok_token' => null,
            'tiktok_state' => false
        ]);

        return response()->json($user, 200);
    }
    public function redirectToTikTok(Request $request)
    {

        $url = $request->query('url');
        $user = Auth::user();

        $appId = config('services.tiktok.app_id');
        $redirectUri = config('services.tiktok.redirect');
        $state = [
            'url' => $url,
            'user_id' => $user->id,
        ];
        $url = 'https://business-api.tiktok.com/portal/auth?app_id='.$appId.'&redirect_uri='.urlencode($redirectUri).'&state='.json_encode($state);

        return redirect()->away($url);
    }

    public function handleTikTokCallback(Request $request, TikTokService $tiktokService)
    {

        $state = json_decode($request->input('state'), true);
        $url = $state['url'] ?? null;
        $user_id = $state['user_id'] ?? null;

        $user = User::find($user_id);

        try {

            if (! $user) {

                // Rediriger avec une erreur sur l'URL
                $redirectUrl = config('app.url_frontend').$url.'?status=failure';

                return redirect($redirectUrl);
            }

            $code = $request->input('auth_code');

            if (! $code) {
                return response()->json(['error' => 'Authorization code not provided'], 400);
            }

            $accessTokenData = $tiktokService->getAccessToken($code);
            $accessTokenDataArray=json_decode(json_encode($accessTokenData), true);

            if (isset($accessTokenDataArray['data'])) {
                if (isset($accessTokenDataArray['data']['access_token'])) {

                    $user->tiktok_token = $accessTokenDataArray['data']['access_token'];
                    $user->tiktok_state = true;
                    $user->save();

                    // Rediriger vers Angular avec un message de succès
                    $redirectUrl = config('app.url_frontend').$url.'?status=success';

                    return redirect($redirectUrl);
                }
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
