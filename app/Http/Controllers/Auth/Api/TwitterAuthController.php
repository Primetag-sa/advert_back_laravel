<?php

namespace App\Http\Controllers\Auth\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\TwitterState;

class TwitterAuthController extends Controller
{

    public function redirectToTwitter(): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {

        $connection = new TwitterOAuth(
            config('services.twitter.api_key'),
            config('services.twitter.api_secret')
        );

        $state = Str::random(40);

        $request_token = $connection->oauth('oauth/request_token', [
            'oauth_callback' => route('twitter.callback').'?state='.$state,
        ]);

        if (! isset($request_token['oauth_token']) || ! isset($request_token['oauth_token_secret'])) {
            return response()->json(['error' => 'Impossible d\'obtenir le jeton de requête Twitter.'], 400);
        }

        TwitterState::create([
            'state' => $state,
            'oauth_token' => $request_token['oauth_token'],
            'oauth_token_secret' => $request_token['oauth_token_secret'],
        ]);

        $url = $connection->url('oauth/authorize', ['oauth_token' => $request_token['oauth_token']]);

        return redirect($url);
    }

    public function handleTwitterCallback(): \Illuminate\Http\JsonResponse
    {

        $state = request('state');
        $twitterState = TwitterState::where('state', $state)->first();

        if (! $twitterState) {
            return response()->json(['error' => 'État invalide.'], 400);
        }

        $connection = new TwitterOAuth(
            config('services.twitter.api_key'),
            config('services.twitter.api_secret'),
            $twitterState->oauth_token,
            $twitterState->oauth_token_secret
        );

        $access_token = $connection->oauth('oauth/access_token', [
            'oauth_verifier' => request('oauth_verifier'),
        ]);

        if (! isset($access_token['oauth_token']) || ! isset($access_token['oauth_token_secret'])) {
            return response()->json(['error' => 'Impossible d\'obtenir le jeton d\'accès Twitter.'], 400);
        }

        $user = Auth::user();
        dd($user, $access_token);
        $user->twitter_account_id = $access_token['user_id'];
        $user->twitter_access_token = $access_token['oauth_token'];
        $user->twitter_access_token_secret = $access_token['oauth_token_secret'];
        $user->save();

        $twitterState->delete();

        return response()->json(['message' => 'Authentification Twitter réussie!']);
    }
}
