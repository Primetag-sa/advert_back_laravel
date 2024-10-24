<?php

namespace App\Http\Controllers\Auth\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use App\Models\TwitterState;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

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

    public function getAdsAccounts(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {

        $url = $request->query('url');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (!$user) {
                // Rediriger avec une erreur sur l'URL
                $redirectUrl = config('app.url_frontend').$url.'?status=failure';
                return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (!$user || !$user->twitter_access_token || !$user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $url = 'https://ads-api-sandbox.twitter.com/12/accounts';

        // Paramètres OAuth de base
        $oauthParams = [
            'oauth_consumer_key' => config('services.twitter.api_key'),
            'oauth_token' => $user->twitter_access_token, // Utiliser le token d'accès stocké
            'oauth_nonce' => $this->generateNonce(),
            'oauth_timestamp' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_version' => '1.0',
        ];

        // Générer la signature OAuth
        $oauthParams['oauth_signature'] = $this->buildOAuthSignature('GET', $url, $oauthParams, config('services.twitter.api_secret'), $user->twitter_access_token_secret);

        // Créer les en-têtes OAuth
        $oauthHeader = $this->buildOAuthHeader($oauthParams);

        // Utiliser Guzzle pour envoyer la requête avec les en-têtes OAuth
        $client = new Client();

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => $oauthHeader,
                ],
                'timeout' => 60,
            ]);

            // Afficher la réponse
            $responseBody = $response->getBody()->getContents();
            $data = json_decode($responseBody)->data;
            return response()->json($data, 200);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }
    }

    public function getOneAccount(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {

        $id_account = $request->query('id_account');
        $url = $request->query('url');
        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (!$user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';
            return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (!$user || !$user->twitter_access_token || !$user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $url = 'https://ads-api-sandbox.twitter.com/12/stats/jobs/accounts/'.$id_account;

        // Paramètres OAuth de base
        $oauthParams = [
            'oauth_consumer_key' => config('services.twitter.api_key'),
            'oauth_token' => $user->twitter_access_token, // Utiliser le token d'accès stocké
            'oauth_nonce' => $this->generateNonce(),
            'oauth_timestamp' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_version' => '1.0',
        ];
        // Générer la signature OAuth
        $oauthParams['oauth_signature'] = $this->buildOAuthSignature('GET', $url, $oauthParams, config('services.twitter.api_secret'), $user->twitter_access_token_secret);

        // Créer les en-têtes OAuth
        $oauthHeader = $this->buildOAuthHeader($oauthParams);

        // Utiliser Guzzle pour envoyer la requête avec les en-têtes OAuth
        $client = new Client();

        try {
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Authorization' => $oauthHeader,
                ],
                'timeout' => 60,
            ]);

            // Afficher la réponse
            $responseBody = $response->getBody()->getContents();
            $data = json_decode($responseBody)->data;
            return response()->json($data, 200);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }
    }

}
