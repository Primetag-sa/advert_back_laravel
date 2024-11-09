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

    public function getAdStats($adId, $startTime, $endTime, $accessToken)
    {
        $url = "https://adsapi.snapchat.com/v1/ads/{$adId}/stats";
        $response = $this->client->get($url, [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'granularity' => 'HOUR',
                'fields' => 'conversion_purchases,conversion_add_cart',
                'start_time' => $startTime,
                'end_time' => $endTime,
            ],
        ]);

        return $this->processAdStats($response->json());
        // return json_decode($response->getBody(), true);
    }
    public function processAdStatsTests($data = null)
    {
        $clicks = [];
        $sales = [];
        $interactions = [];
        $visitors = [];
        $hours = [];

        // Generate data for the last 24 hours for testing
        for ($i = 0; $i < 24; $i++) {
            $hour = \Carbon\Carbon::now()->subHours(24 - $i)->format('H:i'); // Each hour in the last day
            $hours[] = $hour;

            // Generate random data for each metric
            $clicks[] = rand(50, 150);         // Random number for clicks
            $sales[] = rand(10, 50);           // Random number for sales
            $interactions[] = rand( 50, 100);  // Random number for interactions
            $visitors[] = rand(100, 300);       // Random number for visitors
        }

        // Calculate the total impressions and total engagements
        $totalImpressions = array_sum($visitors);      // Assuming visitors represent impressions
        $totalEngagements = array_sum($interactions);  // Assuming interactions represent engagements

        // Calculate engagement per impression
        $engagementPeerImpressions = $totalImpressions > 0 ? ($totalEngagements / $totalImpressions) * 100 : 0;
        $engagementPeerImpressions = round($engagementPeerImpressions,2);
        // dump($totalImpressions);
        // dump($totalEngagements);
        // dd(round($engagementPeerImpressions,2) );
        

        return response()->json([
            'hourly' => [
                'hours' => $hours,
                'clicks' => $clicks,
                'sales' => $sales,
            ],
            'doughnut' => [
                'interactions' => array_sum($interactions),
                'visitor_clicks' => array_sum($clicks),
                'visitor_interactions' => array_sum($interactions),
            ],
            'line' => [
                'hours' => $hours,
                'visitors' => $visitors,
                'interactions' => $interactions,
            ],
            'engagementPeerImpressions' => $engagementPeerImpressions,
        ]);
    }

    private function processAdStats($data)
    {
        $clicks = [];
        $sales = [];
        $interactions = [];
        $visitors = [];
        $hours = [];

        // Check if 'timeseries_stats' exists in the data
        if (isset($data['timeseries_stats'])) {
            foreach ($data['timeseries_stats'] as $stat) {
                foreach ($stat['timeseries'] as $timeStat) {
                    // Extract the hour from start_time
                    $hour = \Carbon\Carbon::parse($timeStat['start_time'])->format('H:i');
                    $hours[] = $hour;

                    // Populate the data arrays with fallback values if the field is missing
                    $clicks[] = $timeStat['stats']['swipes'] ?? 0; // Assuming swipes represent clicks
                    $sales[] = $timeStat['stats']['conversion_purchases'] ?? 0;
                    $interactions[] = $timeStat['stats']['impressions'] ?? 0;
                    $visitors[] = $timeStat['stats']['conversion_view_content'] ?? 0;
                }
            }
        }

        // Calculate the total impressions and total engagements
        $totalImpressions = array_sum($visitors);      // Assuming visitors represent impressions
        $totalEngagements = array_sum($interactions);  // Assuming interactions represent engagements

        // Calculate engagement per impression
        $engagementPeerImpressions = $totalImpressions > 0 ? ($totalEngagements / $totalImpressions) * 100 : 0;
        $engagementPeerImpressions = round($engagementPeerImpressions,2);

        // Return the processed data in JSON format
        return response()->json([
            'hourly' => [
                'hours' => $hours,
                'clicks' => $clicks,
                'sales' => $sales,
            ],
            'doughnut' => [
                'interactions' => array_sum($interactions),
                'visitor_clicks' => array_sum($clicks),
                'visitor_interactions' => array_sum($interactions),
            ],
            'line' => [
                'hours' => $hours,
                'visitors' => $visitors,
                'interactions' => $interactions,
            ],
            'engagementPeerImpressions' => $engagementPeerImpressions,
        ]);
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
