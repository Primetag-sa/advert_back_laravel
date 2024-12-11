<?php

namespace App\Services;

use GuzzleHttp\Client;

class TikTokService
{
    protected $client;

    protected $appId;

    protected $appSecret;

    protected $redirectUri;

    public function __construct()
    {
        $this->client = new Client;
        $this->appId = config('services.tiktok.app_id');
        $this->appSecret = config('services.tiktok.app_secret');
        $this->redirectUri = config('services.tiktok.redirect');
    }

    public function getAccessToken($code)
    {
        try {
            $response = $this->client->post('https://business-api.tiktok.com/open_api/v1.3/oauth2/access_token/', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'app_id' => $this->appId,
                    'secret' => $this->appSecret,
                    'auth_code' => $code,
                    'redirect_uri' => $this->redirectUri,
                ],
            ]);
            $tiktokAuth = json_decode($response->getBody()->getContents());

            return json_decode(json_encode($tiktokAuth, true));
        } catch (\Exception $exception) {
            return json_decode(json_encode($exception, true));
        }

    }

    public function getCampaigns($accessToken, $advertiserId)
    {

        try {
            $response = $this->client->request('GET', 'https://business-api.tiktok.com/open_api/v1.3/campaign/get/', [
                'headers' => [
                    'Access-Token' => $accessToken,
                ],
                'query' => [
                    'advertiser_id' => $advertiserId,
                ],
            ]);

        } catch (\Exception $exception) {
            return json_decode($exception, true);
        }

        return json_decode((string) $response->getBody(), true);
    }

    public function getAdGroup($accessToken, $advertiserId,$campaign_ids)
    {

        try {
            $response = $this->client->request('GET', 'https://business-api.tiktok.com/open_api/v1.3/adgroup/get/', [
                'headers' => [
                    'Access-Token' => $accessToken,
                ],
                'query' => [
                    'advertiser_id' => $advertiserId,
                    'campaign_ids' => $campaign_ids,
                ],
            ]);

        } catch (\Exception $exception) {
            return json_decode($exception, true);
        }

        return json_decode((string) $response->getBody(), true);
    }
    public function getAd($accessToken, $advertiserId,$campaign_ids,$adGroup_ids)
    {

        try {
            $response = $this->client->request('GET', 'https://business-api.tiktok.com/open_api/v1.3/ad/get/', [
                'headers' => [
                    'Access-Token' => $accessToken,
                ],
                'query' => [
                    'advertiser_id' => $advertiserId,
                    'campaign_ids' => $campaign_ids,
                    'adgroup_ids' => $adGroup_ids,
                ],
            ]);

        } catch (\Exception $exception) {
            return json_decode($exception, true);
        }

        return json_decode((string) $response->getBody(), true);
    }
    //Get Accounts
    public function getAdvertiserGet($accessToken)
    {
        try {
            $response = $this->client->request('GET', 'https://business-api.tiktok.com/open_api/v1.3/oauth2/advertiser/get/', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'Access-Token' => $accessToken,
                ],
                'query' => [
                    'app_id' => $this->appId,
                    'secret' => $this->appSecret,
                ],
            ]);

        } catch (\Exception $exception) {
            return json_decode($exception, true);
        }

        return json_decode((string) $response->getBody(), true);
    }

    public function getConversionsPerOneThousandImpressions($accessToken, $advertiser_id, $data_level, $start_date, $end_date, $other)
    {
        $query = [
            'advertiser_id' => $advertiser_id,
            'service_type' => 'AUCTION',
            'report_type' => 'BASIC',
            'metrics' => json_encode(['conversion_rate', 'conversion', 'impressions']),
            'data_level' => $data_level,
            'enable_total_metrics' => true,
            'start_date' => (new \DateTime($start_date))->format('Y-m-d'),
            'end_date' => (new \DateTime($end_date))->format('Y-m-d'),
        ];
        if (json_decode($other)) {
            foreach (json_decode($other) as $item => $value) {
                $arr = (array)  $value;
                $keys = array_keys($arr);
                $query[$keys[0]]=$arr[$keys[0]];

            }
        }

        try {
            $response = $this->client->request('GET', 'https://business-api.tiktok.com/open_api/v1.3/report/integrated/get/', [
                'headers' => [
                    'Access-Token' => $accessToken,
                ],
                'query' => $query,
            ]);

        } catch (\Exception $exception) {
            return json_decode($exception, true);
        }

        return json_decode((string) $response->getBody(), true);
    }

    public function getConversionsPerImpressions($accessToken, $advertiser_id, $data_level, $start_date, $end_date,$other)
    {

        $query = [
            'advertiser_id' => $advertiser_id,
            'service_type' => 'AUCTION',
            'report_type' => 'BASIC',
            'metrics' => json_encode(['conversion_rate', 'conversion', 'impressions','purchase']),
            'data_level' => $data_level,
            'enable_total_metrics' => true,
            'start_date' => (new \DateTime($start_date))->format('Y-m-d'),
            'end_date' => (new \DateTime($end_date))->format('Y-m-d'),
        ];
        if (json_decode($other)) {
            foreach (json_decode($other) as $item => $value) {
                $arr = (array)  $value;
                $keys = array_keys($arr);
                $query[$keys[0]]=$arr[$keys[0]];

            }
        }
        try {
            $response = $this->client->request('GET', 'https://business-api.tiktok.com/open_api/v1.3/report/integrated/get/', [
                'headers' => [
                    'Access-Token' => $accessToken,
                ],
                'query' => $query
            ]);

        } catch (\Exception $exception) {
            return json_decode($exception, true);
        }

        return json_decode((string) $response->getBody(), true);
    }

    public function getImpressionsPerAudiance($accessToken, $advertiser_id, $data_level, $start_date, $end_date,$other)
    {
        $query = [
            'advertiser_id' => $advertiser_id,
            'service_type' => 'AUCTION',
            'report_type' => 'AUDIENCE',
            'metrics' => json_encode(['impressions']),
            'data_level' => $data_level,
            'start_date' => (new \DateTime($start_date))->format('Y-m-d'),
            'end_date' => (new \DateTime($end_date))->format('Y-m-d'),
        ];
        if (json_decode($other)) {
            foreach (json_decode($other) as $item => $value) {
                $arr = (array)  $value;
                $keys = array_keys($arr);
                $query[$keys[0]]=$arr[$keys[0]];

            }
        }
        try {
            $response = $this->client->request('GET', 'https://business-api.tiktok.com/open_api/v1.3/report/integrated/get/', [
                'headers' => [
                    'Access-Token' => $accessToken,
                ],
                'query' =>$query
            ]);

        } catch (\Exception $exception) {
            return json_decode($exception, true);
        }

        return json_decode((string) $response->getBody(), true);
    }

    public function getConversionsPerRevenue($accessToken, $advertiser_id, $data_level, $start_date, $end_date,$other)
    {
        $query = [
            'advertiser_id' => $advertiser_id,
            'service_type' => 'AUCTION',
            'report_type' => 'BASIC',
            'metrics' => json_encode([
                'purchase',
                'total_purchase_value',
                'value_per_total_purchase',
                'conversion_rate',
                'cost_per_conversion',
                'spend',
            ]),

            'data_level' => $data_level,
            'enable_total_metrics' => true,
            'start_date' => (new \DateTime($start_date))->format('Y-m-d'),
            'end_date' => (new \DateTime($end_date))->format('Y-m-d'),
        ];
        if (json_decode($other)) {
            foreach (json_decode($other) as $item => $value) {
                $arr = (array)  $value;
                $keys = array_keys($arr);
                $query[$keys[0]]=$arr[$keys[0]];

            }
        }
        try {
            $response = $this->client->request('GET', 'https://business-api.tiktok.com/open_api/v1.3/report/integrated/get/', [
                'headers' => [
                    'Access-Token' => $accessToken,
                ],
                'query' => $query
            ]);

        } catch (\Exception $exception) {
            return json_decode($exception, true);
        }

        return json_decode((string) $response->getBody(), true);
    }

    public function refreshAccessToken($refreshToken)
    {
        try {
            // Make the POST request to refresh the access token
            $response = $this->client->post('https://open.tiktokapis.com/v2/oauth/token/', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Cache-Control' => 'no-cache',
                ],
                'form_params' => [
                    'client_key' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $refreshToken,
                ],
            ]);

            // Parse the response body to get the new tokens and other details
            $data = json_decode((string) $response->getBody(), true);

            // Make sure to use the new refresh token if it's different from the one you sent
            if (isset($data['refresh_token'])) {
                $newRefreshToken = $data['refresh_token'];
            } else {
                throw new \Exception('Failed to retrieve a valid refresh token');
            }

            // You will likely need to update the access token, refresh token, etc. in your database
            return [
                'access_token' => $data['access_token'],
                'refresh_token' => $newRefreshToken,
                'expires_in' => $data['expires_in'], // Expiration time for the access token
                'refresh_expires_in' => $data['refresh_expires_in'], // Expiration time for the refresh token
                'open_id' => $data['open_id'], // User identifier
                'scope' => $data['scope'], // Authorized scopes
                'token_type' => $data['token_type'], // Typically "Bearer"
            ];

        } catch (\Exception $e) {
            throw new \Exception('Failed to refresh access token: '.$e->getMessage());
        }
    }
}
