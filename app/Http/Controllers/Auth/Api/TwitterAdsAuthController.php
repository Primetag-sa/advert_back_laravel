<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\AccountsX;
use App\Models\AdXAnalytic;
use App\Services\TikTokService;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TwitterAdsAuthController extends Controller
{
    // Fonction pour générer un nonce
    public function generateNonce($length = 32)
    {
        return bin2hex(random_bytes($length / 2));
    }

    // Fonction pour générer la signature OAuth
    public function buildOAuthSignature($method, $url, $params, $consumerSecret, $tokenSecret)
    {
        $baseString = $this->buildBaseString($method, $url, $params);
        $signingKey = rawurlencode($consumerSecret).'&'.rawurlencode($tokenSecret);

        return base64_encode(hash_hmac('sha1', $baseString, $signingKey, true));
    }

    // Fonction pour générer la base string pour OAuth
    public function buildBaseString($method, $url, $params)
    {
        ksort($params); // Trier les paramètres par clé
        $paramsString = [];
        foreach ($params as $key => $value) {
            $paramsString[] = rawurlencode($key).'='.rawurlencode($value);
        }

        return strtoupper($method).'&'.rawurlencode($url).'&'.rawurlencode(implode('&', $paramsString));
    }

    // Fonction pour construire les en-têtes OAuth
    public function buildOAuthHeader($oauthParams)
    {
        $header = 'OAuth ';
        $values = [];
        foreach ($oauthParams as $key => $value) {
            $values[] = rawurlencode($key).'="'.rawurlencode($value).'"';
        }
        $header .= implode(', ', $values);

        return $header;
    }

    public function getAdsAccounts(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {

        $url = $request->query('url');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (! $user || ! $user->twitter_access_token || ! $user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $url = 'https://ads-api.x.com/12/accounts';

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
        $client = new Client;

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

    public function getCampains(Request $request, TikTokService $tikTokService)
    {

        $url = $request->query('url');
        $account_id = $request->query('account_id');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (! $user || ! $user->twitter_access_token || ! $user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $url = 'https://ads-api.x.com/12/accounts/'.$account_id.'/campaigns';

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
        $client = new Client;

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

    public function getConversionsPerOneThousandImpressions(Request $request, TikTokService $tikTokService)
    {

        $url = $request->query('url');
        $id = $request->query('account_id');
        $entity = $request->query('entity');
        $entity_ids = $request->query('entity_ids');
        $start_time = $request->query('start_time');
        $end_time = $request->query('end_time');
        $granularity = $request->query('granularity');
        $placement = $request->query('placement');
        $segmentation = $request->query('segmentation');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (! $user || ! $user->twitter_access_token || ! $user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $apiUrl = 'https://ads-api.x.com/12/stats/accounts/'.$id;
        $start=new \Datetime($start_time);
        $end=new \Datetime($end_time);
        $query = [
            "segmentation_type"=> $segmentation,
            'entity' => $entity,
            'entity_ids' => $entity_ids,
            'start_time' => $start->format('Y-m-d'),
            'end_time' => $end->format('Y-m-d'),
            'granularity' => $granularity,
            'placement' => $placement,
            'metric_groups' => 'ENGAGEMENT,BILLING',
        ];

        // Paramètres OAuth de base
        $oauthParams = [
            'oauth_consumer_key' => config('services.twitter.api_key'),
            'oauth_token' => $user->twitter_access_token, // Utiliser le token d'accès stocké
            'oauth_nonce' => $this->generateNonce(),
            'oauth_timestamp' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_version' => '1.0',
        ];

        // 1. Combiner et trier les paramètres pour la signature
        $signatureParams = array_merge($oauthParams, $query);
        ksort($signatureParams);

        // 2. Créer la base string pour la signature
        $baseString = 'GET&'.
            rawurlencode($apiUrl).'&'.
            rawurlencode(http_build_query($signatureParams));

        // 3. Créer la clé de signature
        $signingKey = rawurlencode(config('services.twitter.api_secret')).'&'.
            rawurlencode($user->twitter_access_token_secret);

        // 4. Générer la signature
        $oauthParams['oauth_signature'] = base64_encode(
            hash_hmac('sha1', $baseString, $signingKey, true)
        );

        // 5. Créer l'en-tête Authorization
        $authorizationHeader = 'OAuth ';
        $authParams = [];
        foreach ($oauthParams as $key => $value) {
            $authParams[] = rawurlencode($key).'="'.rawurlencode($value).'"';
        }
        $authorizationHeader .= implode(', ', $authParams);

            // 6. Faire la requête avec Guzzle
            $client = new Client;
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => $authorizationHeader,
                    'Content-Type' => 'application/json',
                ],
                'query' => $query,
                'timeout' => 60,
            ]);

            return response()->json(
                json_decode($response->getBody()->getContents())
            );



    }

    public function getOneAccount(Request $request): \Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {

        $id_account = $request->query('id_account');
        $url = $request->query('url');
        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (! $user || ! $user->twitter_access_token || ! $user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $url = 'https://ads-api.x.com/12/stats/jobs/accounts/'.$id_account;

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
        $client = new Client;

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

    public function getActiveEntities(Request $request)
    {

        $url = $request->query('url');
        $accountId = $request->query('accountId');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();

        if (! $user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (! $user || ! $user->twitter_access_token || ! $user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $url = "https://ads-api.x.com/12/stats/accounts/$accountId/active_entities";

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
        $client = new Client;

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

    }

    public function fetchAndStoreAccounts(Request $request)
    {
        $url = $request->query('url');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();
        if (! $user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (! $user || ! $user->twitter_access_token || ! $user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $url = 'https://ads-api.x.com/12/accounts';

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
        $client = new Client;

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

            if (count($data) > 0) {

                foreach ($data as $accountData) {
                    $dateswitch = new \DateTime($accountData->timezone_switch_at);
                    AccountsX::updateOrCreate(
                        ['account_id' => $accountData->id],
                        [
                            'name' => $accountData->name,
                            'business_name' => $accountData->business_name,
                            'timezone' => $accountData->timezone,
                            'timezone_switch_at' => $dateswitch,
                            'business_id' => $accountData->business_id,
                            'approval_status' => $accountData->approval_status,
                            'deleted' => $accountData->deleted,
                            'user_id' => $user->id,
                        ]
                    );
                }
            }

            $accounts = AccountsX::where('user_id', $user->id)->orderBy('id', 'desc')->get();
            foreach ($accounts as $key => $account) {
                $active = AdXAnalytic::where('account_id', $account->account_id)->get();
                $accounts[$key]->countActive = count($active);
            }

            return response()->json($accounts, 200);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }

    }

    public function fetchData(Request $request)
    {

        $url = $request->query('url');
        $accountId = $request->query('id');
        $type = $request->query('type');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();

        if (! $user) {
            // Rediriger avec une erreur sur l'URL
            $redirectUrl = config('app.url_frontend').$url.'?status=failure';

            return redirect($redirectUrl);
        }

        // Vérifier si l'utilisateur a des tokens d'accès
        if (! $user || ! $user->twitter_access_token || ! $user->twitter_access_token_secret) {
            // Rediriger vers le processus d'autorisation si pas de tokens
            return redirect()->route('twitter.ads.redirect'); // ou l'URL appropriée
        }

        // URL de l'API Twitter Ads
        $url = "https://ads-api.x.com/12/accounts/$accountId/$type";

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
        $client = new Client;

        $response = $client->request('GET', $url, [
            'headers' => [
                'Authorization' => $oauthHeader,
            ],
            'timeout' => 60,
        ]);

        // Afficher la réponse
        $responseBody = $response->getBody()->getContents();
        $data = json_decode($responseBody)->data;

        return response()->json($data);

    }

    public function generateOAuthSignature($method, $url, $params, $consumerSecret, $tokenSecret)
    {
        $baseParams = [];
        ksort($params);

        foreach ($params as $key => $value) {
            $baseParams[] = rawurlencode($key).'='.rawurlencode($value);
        }

        $baseString = strtoupper($method).'&'.rawurlencode($url).'&'.rawurlencode(implode('&', $baseParams));
        $signingKey = rawurlencode($consumerSecret).'&'.rawurlencode($tokenSecret);

        return base64_encode(hash_hmac('sha1', $baseString, $signingKey, true));
    }

    public function getMetrics(Request $request)
    {
        $accountId = $request->query('id');
        $entityId = $request->query('entity_ids');
        $type = $request->query('type');
        $ds = $request->query('ds');
        $de = $request->query('de');
        $placement = $request->query('placement');
        $granularity = $request->query('granularity');
        $metric_groups = $request->query('metrics_group');
        $segmentation = $request->query('segmentation');
        $country = $request->query('country');
        $platform = $request->query('platform');

        // Vérifier si un token utilisateur est présent
        $user = Auth::user();

        if (! $user || ! $user->twitter_access_token || ! $user->twitter_access_token_secret) {
            return redirect()->route('twitter.ads.redirect');
        }

        // URL de l'API Twitter Ads
        $apiUrl = "https://ads-api.x.com/12/stats/accounts/$accountId";

        // Paramètres de la requête

        $queryParams = [
            'entity' => $type,
            'entity_ids' => $entityId,
            'start_time' => $ds ?? (new \DateTime('-7 days'))->format('Y-m-d\TH:00:00\Z'), // Arrondi à l'heure
            'end_time' => $de ?? (new \DateTime)->format('Y-m-d\TH:00:00\Z'), // Arrondi à l'heure
            'granularity' => $granularity,
            'placement' => $placement,
            'metric_groups' => $metric_groups ?? 'ENGAGEMENT',
            'segmentation_type' => $segmentation ?? null,
            'platform' => $platform ?? null,
            'country' => $country ?? null,
        ];

        // Paramètres OAuth
        $oauthParams = [
            'oauth_consumer_key' => config('services.twitter.api_key'),
            'oauth_nonce' => $this->generateNonce(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_token' => $user->twitter_access_token,
            'oauth_version' => '1.0',
        ];

        // 1. Combiner et trier les paramètres pour la signature
        $signatureParams = array_merge($oauthParams, $queryParams);
        ksort($signatureParams);

        // 2. Créer la base string pour la signature
        $baseString = 'GET&'.
            rawurlencode($apiUrl).'&'.
            rawurlencode(http_build_query($signatureParams));

        // 3. Créer la clé de signature
        $signingKey = rawurlencode(config('services.twitter.api_secret')).'&'.
            rawurlencode($user->twitter_access_token_secret);

        // 4. Générer la signature
        $oauthParams['oauth_signature'] = base64_encode(
            hash_hmac('sha1', $baseString, $signingKey, true)
        );

        // 5. Créer l'en-tête Authorization
        $authorizationHeader = 'OAuth ';
        $authParams = [];
        foreach ($oauthParams as $key => $value) {
            $authParams[] = rawurlencode($key).'="'.rawurlencode($value).'"';
        }
        $authorizationHeader .= implode(', ', $authParams);

        try {
            // 6. Faire la requête avec Guzzle
            $client = new Client;
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => $authorizationHeader,
                    'Content-Type' => 'application/json',
                ],
                'query' => $queryParams,
                'timeout' => 60,
            ]);

            return response()->json(
                json_decode($response->getBody()->getContents())
            );

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Unable to fetch data from Twitter Ads API',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function fetchMetrics(Request $request)
    {

        $metrics = ['BILLING', 'ENGAGEMENT', 'MEDIA', 'VIDEO', 'WEB_CONVERSION'];
        $placements = ['ALL_ON_TWITTER', 'PUBLISHER_NETWORK'];
        $granularities = ['DAY', 'HOUR', 'TOTAL'];
        $today = Carbon::now()->toIso8601String();

        foreach (AccountsX::all() as $account) {
            foreach ($metrics as $metricGroup) {
                foreach ($placements as $placement) {
                    foreach ($granularities as $granularity) {
                        $startDate = Carbon::now()->subYear()->toIso8601String(); // par ex. date de début

                        // Construire les paramètres pour la requête
                        $params = [
                            'entity' => 'ACCOUNT',
                            'entity_ids' => $account->account_id,
                            'metric_groups' => $metricGroup,
                            'placement' => $placement,
                            'granularity' => $granularity,
                            'start_time' => $startDate,
                            'end_time' => $today,
                        ];

                        $response = Http::withToken($this->token)->get("{$this->base_url}/stats/accounts/{$account->account_id}", $params);

                        if ($response->successful()) {
                            $metricsData = $response->json();

                            AdsMetric::updateOrCreate(
                                [
                                    'account_id' => $account->id,
                                    'metric_group' => $metricGroup,
                                    'placement' => $placement,
                                    'granularity' => $granularity,
                                    'start_time' => $startDate,
                                    'end_time' => $today,
                                ],
                                [
                                    'metrics_data' => $metricsData,
                                    'last_fetched_at' => now(),
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}
