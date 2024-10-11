<?php

namespace App\Http\Controllers\Auth\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use App\Models\TwitterState;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TwitterAdsAuthController extends Controller
{

// Fonction pour générer un nonce
    function generateNonce($length = 32)
    {
        return bin2hex(random_bytes($length / 2));
    }

// Fonction pour générer la signature OAuth
    function buildOAuthSignature($method, $url, $params, $consumerSecret, $tokenSecret)
    {
        $baseString = $this->buildBaseString($method, $url, $params);
        $signingKey = rawurlencode($consumerSecret) . '&' . rawurlencode($tokenSecret);
        return base64_encode(hash_hmac('sha1', $baseString, $signingKey, true));
    }

// Fonction pour générer la base string pour OAuth
    function buildBaseString($method, $url, $params)
    {
        ksort($params); // Trier les paramètres par clé
        $paramsString = [];
        foreach ($params as $key => $value) {
            $paramsString[] = rawurlencode($key) . '=' . rawurlencode($value);
        }
        return strtoupper($method) . '&' . rawurlencode($url) . '&' . rawurlencode(implode('&', $paramsString));
    }

// Fonction pour construire les en-têtes OAuth
    function buildOAuthHeader($oauthParams)
    {
        $header = 'OAuth ';
        $values = [];
        foreach ($oauthParams as $key => $value) {
            $values[] = rawurlencode($key) . '="' . rawurlencode($value) . '"';
        }
        $header .= implode(', ', $values);
        return $header;
    }

    public function redirectToTwitter(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {

        $connection = new TwitterOAuth(
            config('services.twitter.api_key'),
            config('services.twitter.api_secret')
        );

        $state = Str::random(40);

        $request_token = $connection->oauth('oauth/request_token', [
            'oauth_callback' => route('twitter.ads.callback').'?state='.$state.'&token='.$request->query('token').'&url='.$request->query('url'),
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
        /*$user = null;
        if ($token) {
            $personalAccessToken = PersonalAccessToken::findToken($token);
            if ($personalAccessToken) {
                $user = $personalAccessToken->tokenable;
            } else {
                // Rediriger avec une erreur sur l'URL
                $redirectUrl = config('app.url_frontend').$url.'?status=failure';

                return redirect($redirectUrl);
            }
        }*/

        // Vérifier l'état Twitter
        $twitterState = TwitterState::where('state', $state)->first();

        if (! $twitterState) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }



        // URL de l'API Twitter Ads
        $url = 'https://ads-api-sandbox.twitter.com/12/accounts';


        // Paramètres OAuth de base
        $oauthParams = [
            'oauth_consumer_key' => config('services.twitter.api_key'),
            'oauth_token' =>  config('services.twitter.token'),
            'oauth_nonce' => $this->generateNonce(),
            'oauth_timestamp' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_version' => '1.0',
        ];

        // Générer la signature OAuth
        $oauthParams['oauth_signature'] = $this->buildOAuthSignature('GET', $url, $oauthParams, config('services.twitter.api_secret'),   config('services.twitter.token_secret'),);

        // Créer les en-têtes OAuth
        $oauthHeader = $this->buildOAuthHeader($oauthParams);


        // Utiliser Guzzle pour envoyer la requête avec les en-têtes OAuth
        $client = new Client();

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => $oauthHeader,
                ],

            ]);

            // Afficher la réponse
            $responseBody = $response->getBody()->getContents();
            $data=json_decode($responseBody)->data;
            dd($data);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête

            dd($e);

        }


        // Connexion à Twitter avec les tokens
        $connection = new TwitterOAuth(
            config('services.twitter.api_key'),
            config('services.twitter.api_secret'),
            $twitterState->oauth_token,
            $twitterState->oauth_token_secret
        );


        $connection->host = 'https://ads-api.twitter.com';
        $response = $connection->get('11/accounts');

        if ($connection->getLastHttpCode() == 200 && !empty($response->data)) {
            // Comptes publicitaires récupérés avec succès
            dd($response->data);
        } elseif ($connection->getLastHttpCode() == 200 && empty($response->data)) {
            // Pas de comptes publicitaires associés à cet utilisateur
            dd('Aucun compte publicitaire trouvé.');
        } else {
            // Une erreur s'est produite
            dd($connection->getLastHttpCode(), $response);
        }






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

        return redirect($redirectUrl);
    }
}
