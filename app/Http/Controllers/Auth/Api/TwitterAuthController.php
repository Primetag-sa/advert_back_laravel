<?php

namespace App\Http\Controllers\Auth\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use App\Models\TwitterState;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class TwitterAuthController extends Controller
{
    public function redirectToTwitter(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {

        $connection = new TwitterOAuth(
            config('services.twitter.api_key'),
            config('services.twitter.api_secret')
        );

        $state = Str::random(40);

        $request_token = $connection->oauth('oauth/request_token', [
            'oauth_callback' => route('twitter.callback').'?state='.$state.'&token='.$request->query('token').'&url='.$request->query('url'),
        ]);

        if (! isset($request_token['oauth_token']) || ! isset($request_token['oauth_token_secret'])) {
            $redirectUrl = config('app.url_frontend').$request->query('url').'?status=failure&step=auth';

            return redirect($redirectUrl);
        }

        TwitterState::create([
            'state' => $state,
            'oauth_token' => $request_token['oauth_token'],
            'oauth_token_secret' => $request_token['oauth_token_secret'],
        ]);

        $url = $connection->url('oauth/authorize', ['oauth_token' => $request_token['oauth_token']]);

        return redirect($url);
    }

    public function handleTwitterCallback(Request $request)
    {
        $state = $request->query('state');
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

        // Vérifier l'état Twitter
        $twitterState = TwitterState::where('state', $state)->first();

        if (! $twitterState) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Connexion à Twitter avec les tokens
        $connection = new TwitterOAuth(
            config('services.twitter.api_key'),
            config('services.twitter.api_secret'),
            $twitterState->oauth_token,
            $twitterState->oauth_token_secret
        );

        // Obtenir l'access token de Twitter
        try {
            $access_token = $connection->oauth('oauth/access_token', [
                'oauth_verifier' => $request->query('oauth_verifier'),
            ]);

        } catch (\Exception $e) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Vérifier si le token d'accès est bien récupéré
        if (! isset($access_token['oauth_token'])) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Mise à jour de la version de l'API pour utiliser la version 2
        $connection->setApiVersion('2');

        // Récupérer les informations utilisateur via l'API v2 de Twitter
        try {
            if ($connection->getLastHttpCode() == 200) {
                // Stocker les informations utilisateur dans votre base de données Laravel si nécessaire
                $user->twitter_account_id = $access_token['user_id'];
                $user->twitter_access_token = $access_token['oauth_token'];
                $user->twitter_access_token_secret = $access_token['oauth_token_secret'];
                $user->save();

                // Supprimer l'état temporaire Twitter
                $twitterState->delete();

                // Rediriger vers Angular avec un message de succès
                $redirectUrl = config('app.url_frontend').$url.'?status=success';

                return redirect($redirectUrl);

            } else {
                // Rediriger avec une erreur sur l'URL
                $redirectUrl = config('app.url_frontend').$url.'?status=failure';

                return redirect($redirectUrl);
            }

        } catch (\Exception $e) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }
    }
}
