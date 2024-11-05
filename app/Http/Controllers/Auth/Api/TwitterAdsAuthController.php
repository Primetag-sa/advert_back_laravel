<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\AccountsX;
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

    public function fetchDataAndMetrics()
    {
        // Récupérer et enregistrer les comptes, campagnes, line items, et tweets promus
        $this->fetchAndStoreAccounts();
        $this->fetchAndStoreCampaigns();
        $this->fetchAndStoreLineItems();
        $this->fetchAndStorePromotedTweets();

        // Boucler sur les enregistrements pour extraire les données de métriques
        $this->fetchMetricsForAllEntities();

        return response()->json(['message' => 'Les entités et les métriques ont été sauvegardées avec succès.']);
    }

    private function fetchAndStoreAccounts(Request $request)
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
            if ($data) {

                foreach ($data as $accountData) {
                    AccountsX::updateOrCreate(
                        ['account_id' => $accountData['id']],
                        [
                            'name' => $accountData['name'],
                            'business_name' => $accountData['business_name'],
                            'timezone' => $accountData['timezone'],
                            'timezone_switch_at' => $accountData['timezone_switch_at'],
                            'business_id' => $accountData['business_id'],
                            'approval_status' => $accountData['approval_status'],
                            'deleted' => $accountData['deleted'],
                        ]
                    );
                }
            }

            return response()->json($data, 200);
        } catch (RequestException $e) {
            // Gérer les erreurs de requête
            return response()->json(['error' => 'حدث خطأ أثناء استخراج البيانات'], 402);
        }

    }

    private function fetchAndStoreCampaigns()
    {
        $accounts = Account::all();

        foreach ($accounts as $account) {
            $response = Http::withToken($this->token)->get("{$this->base_url}/accounts/{$account->account_id}/campaigns");

            if ($response->successful()) {
                $campaigns = $response->json()['data'];

                foreach ($campaigns as $campaignData) {
                    Campaign::updateOrCreate(
                        ['campaign_id' => $campaignData['id']],
                        [
                            'account_id' => $account->id,
                            'name' => $campaignData['name'],
                            'budget_optimization' => $campaignData['budget_optimization'],
                            'reasons_not_servable' => $campaignData['reasons_not_servable'],
                            'servable' => $campaignData['servable'],
                            'effective_status' => $campaignData['effective_status'],
                            'daily_budget_amount_local_micro' => $campaignData['daily_budget_amount_local_micro'],
                            'funding_instrument_id' => $campaignData['funding_instrument_id'],
                            'entity_status' => $campaignData['entity_status'],
                            'currency' => $campaignData['currency'],
                            'deleted' => $campaignData['deleted'],
                        ]
                    );
                }
            }
        }
    }

    private function fetchAndStoreLineItems()
    {
        $campaigns = Campaign::all();

        foreach ($campaigns as $campaign) {
            $response = Http::withToken($this->token)->get("{$this->base_url}/accounts/{$campaign->account->account_id}/line_items");

            if ($response->successful()) {
                $lineItems = $response->json()['data'];

                foreach ($lineItems as $lineItemData) {
                    LineItem::updateOrCreate(
                        ['line_item_id' => $lineItemData['id']],
                        [
                            'campaign_id' => $campaign->id,
                            'name' => $lineItemData['name'],
                            'placements' => $lineItemData['placements'],
                            'start_time' => $lineItemData['start_time'],
                            'bid_amount_local_micro' => $lineItemData['bid_amount_local_micro'],
                            'goal' => $lineItemData['goal'],
                            'product_type' => $lineItemData['product_type'],
                            'objective' => $lineItemData['objective'],
                            'entity_status' => $lineItemData['entity_status'],
                            'currency' => $lineItemData['currency'],
                            'pay_by' => $lineItemData['pay_by'],
                            'creative_source' => $lineItemData['creative_source'],
                            'deleted' => $lineItemData['deleted'],
                        ]
                    );
                }
            }
        }
    }

    private function fetchAndStorePromotedTweets()
    {
        $lineItems = LineItem::all();

        foreach ($lineItems as $lineItem) {
            $response = Http::withToken($this->token)->get("{$this->base_url}/accounts/{$lineItem->campaign->account->account_id}/promoted_tweets");

            if ($response->successful()) {
                $promotedTweets = $response->json()['data'];

                foreach ($promotedTweets as $tweetData) {
                    PromotedTweet::updateOrCreate(
                        ['tweet_id' => $tweetData['id']],
                        [
                            'line_item_id' => $lineItem->id,
                            'entity_status' => $tweetData['entity_status'],
                            'approval_status' => $tweetData['approval_status'],
                            'deleted' => $tweetData['deleted'],
                        ]
                    );
                }
            }
        }
    }

    private function fetchMetricsForAllEntities()
    {
        $metrics = ['BILLING', 'ENGAGEMENT', 'MEDIA', 'VIDEO', 'WEB_CONVERSION'];
        $placements = ['ALL_ON_TWITTER', 'PUBLISHER_NETWORK'];
        $granularities = ['DAY', 'HOUR', 'TOTAL'];
        $today = Carbon::now()->toIso8601String();

        foreach (Account::all() as $account) {
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
