<?php

namespace App\Services;

use GuzzleHttp\Client;

class SnapchatAdService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Retrieve the ad accounts associated with a Snapchat user.
     */
    public function getAdAccounts($accessToken)
    {
        $response = $this->client->request('GET', 'https://adsapi.snapchat.com/v1/me/adaccounts', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Retrieve advertisement metrics (impressions, CTR, etc.)
     */
    public function getAdMetrics($adAccountId, $accessToken)
    {
        $response = $this->client->request('GET', 'https://adsapi.snapchat.com/v1/adaccounts/' . $adAccountId . '/ads', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'query' => [
                'fields' => 'impressions,ctr,conversions,engagements,reach,revenue,cost',
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Retrieve campaign metrics (spend, impressions, etc.)
     */
    public function getCampaignMetrics($adAccountId, $accessToken)
    {
        $response = $this->client->request('GET', 'https://adsapi.snapchat.com/v1/adaccounts/' . $adAccountId . '/campaigns', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'query' => [
                'fields' => 'impressions,spend,ctr,cpm,cpc',
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Retrieve advertisement creative details.
     */
    public function getAdCreativeDetails($adAccountId, $accessToken)
    {
        $response = $this->client->request('GET', 'https://adsapi.snapchat.com/v1/adaccounts/' . $adAccountId . '/ads', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'query' => [
                'fields' => 'creative_body,creative_thumb_url,creative_type',
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
