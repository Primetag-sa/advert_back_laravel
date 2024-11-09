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

    public function getCampaignStats($campaignId, $startTime, $endTime, $type, $accessToken)
    {
        $url = "https://adsapi.snapchat.com/v1/campaigns/{$campaignId}/stats";

        // return [$campaignId, $startTime, $endTime, $type, $accessToken];
        // try {
            $response = $this->client->get($url, [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'granularity' => $type,
                    'fields' => 'impressions,swipes,conversion_purchases,conversion_save,conversion_start_checkout,conversion_add_cart,conversion_view_content,conversion_add_billing,conversion_sign_ups,conversion_searches,conversion_level_completes,conversion_app_opens,conversion_page_views',
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ],
            ]);

            return $response->json();//$this->processAccountStats($response->json());
        // } catch (\GuzzleHttp\Exception\ClientException $e) {
        //     // Log the error for further analysis
        //     \Log::error('Error fetching campaign stats: ' . $e->getMessage());
        //     return response()->json(['error' => 'Unauthorized access or invalid token.'], 401);
        // }
    }


    public function processCampaignStatsTests($data = null)
    {
        $clicks = [];
        $sales = [];
        $interactions = [];
        $visitors = [];
        $days = [];

        // Generate data for the last 7 days for testing
        for ($i = 7; $i > 0; $i--) {
            $day = \Carbon\Carbon::now()->subDays($i)->format('Y-m-d'); // Each day in the last week
            $days[] = $day;

            // Generate random data for each metric
            $clicks[] = rand(200, 500);         // Random number for clicks
            $sales[] = rand(50, 200);           // Random number for sales
            $interactions[] = rand(1000, 2000); // Random number for interactions
            $visitors[] = rand(500, 1500);      // Random number for visitors
        }

        // Calculate the total impressions and total engagements
        $totalImpressions = array_sum($visitors);      // Assuming visitors represent impressions
        $totalEngagements = array_sum($interactions);  // Assuming interactions represent engagements
        $totalClicks = array_sum($clicks);  // Assuming interactions represent engagements

        // Calculate engagement per impression
        // $engagementPeerImpressions = $totalImpressions > 0 ? ($totalEngagements / $totalImpressions) * 100 : 0;
        // $engagementPeerImpressions = round($engagementPeerImpressions, 2);
        $engagementPerImpressionPercentage =  round($totalImpressions > 0 ? ($totalEngagements / ($totalImpressions+$totalEngagements+$totalClicks)) * 100 : 0,2);


        // Return the processed data in JSON format
        return response()->json([
            'hourly' => [
                'hours' => $days,
                'clicks' => $clicks,
                'sales' => $sales,
            ],
            'doughnut' => [
                'interactions' => array_sum($interactions),
                'visitor_clicks' => array_sum($clicks),
                'visitor_interactions' => array_sum($interactions),
            ],
            'line' => [
                'hours' => $days,
                'visitors' => $visitors,
                'interactions' => $interactions,
            ],
            'engagementPeerImpressions' => $engagementPerImpressionPercentage,
        ]);
    }


    public function getAdStats($adId, $startTime, $endTime,$type, $accessToken)
    {
        $url = "https://adsapi.snapchat.com/v1/ads/{$adId}/stats";
        $response = $this->client->get($url, [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'granularity' => $type,
                'fields' => 'conversion_purchases,conversion_add_cart',
                'start_time' => $startTime,
                'end_time' => $endTime,
            ],
        ]);

        return $this->processAdStats($response->json());
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


    private function processAccountStats($data)
    {
        $clicks = [];
        $sales = [];
        $interactions = [];
        $visitors = [];
        $days = [];

        // Check if 'timeseries_stats' exists in the data
        if (isset($data['timeseries_stats'])) {
            foreach ($data['timeseries_stats'] as $stat) {
                if (isset($stat['timeseries_stat']['timeseries'])) {
                    foreach ($stat['timeseries_stat']['timeseries'] as $timeStat) {
                        // Extract the date from start_time
                        $day = \Carbon\Carbon::parse($timeStat['start_time'])->format('Y-m-d');
                        $days[] = $day;

                        // Populate the data arrays with fallback values if the field is missing
                        $clicks[] = $timeStat['stats']['swipes'] ?? 0; // Assuming swipes represent clicks
                        $sales[] = $timeStat['stats']['conversion_purchases'] ?? 0;
                        $interactions[] = $timeStat['stats']['impressions'] ?? 0;
                        $visitors[] = $timeStat['stats']['conversion_view_content'] ?? 0;
                    }
                }
            }
        }

        // Calculate the total impressions and total engagements
        $totalImpressions = array_sum($visitors);      // Assuming visitors represent impressions
        $totalEngagements = array_sum($interactions);  // Assuming interactions represent engagements

        // Calculate engagement per impression
        $engagementPeerImpressions = $totalImpressions > 0 ? ($totalEngagements / $totalImpressions) * 100 : 0;
        $engagementPeerImpressions = round($engagementPeerImpressions, 2);

        // Return the processed data in JSON format
        return response()->json([
            'hourly' => [
                'days' => $days,
                'clicks' => $clicks,
                'sales' => $sales,
            ],
            'doughnut' => [
                'interactions' => array_sum($interactions),
                'visitor_clicks' => array_sum($clicks),
                'visitor_interactions' => array_sum($interactions),
            ],
            'line' => [
                'hourly' => $days,
                'visitors' => $visitors,
                'interactions' => $interactions,
            ],
            'engagementPeerImpressions' => $engagementPeerImpressions,
        ]);
    }

    /* ad squad */

    public function getAdSquadStats($adSquadId, $startTime, $endTime, $accessToken,$type)
{
    $url = "https://adsapi.snapchat.com/v1/adsquads/{$adSquadId}/stats";
    $response = $this->client->get($url, [
        'headers' => [
            'Authorization' => "Bearer {$accessToken}",
            'Content-Type' => 'application/json',
        ],
        'query' => [
            'granularity' => $type,
            'fields' => 'impressions,swipes,conversion_purchases,conversion_view_content',
            'start_time' => $startTime,
            'end_time' => $endTime,
        ],
    ]);

    return $this->processAdSquadStats($response->json());
}

private function processAdSquadStats($data)
{
    $clicks = [];
    $sales = [];
    $interactions = [];
    $visitors = [];
    $hours = [];

    // Check if 'total_stats' exists in the data
    if (isset($data['total_stats']) && isset($data['total_stats'][0]['total_stat']['stats'])) {
        $stats = $data['total_stats'][0]['total_stat']['stats'];

        // Extract values from the stats and assign them to the corresponding arrays
        $clicks[] = $stats['swipes'] ?? 0;
        $sales[] = $stats['conversion_purchases'] ?? 0;
        $interactions[] = $stats['impressions'] ?? 0;
        $visitors[] = $stats['conversion_view_content'] ?? 0;

        // For hourly stats, you can set up a static hour or modify as per requirements
        $hours[] = 'TOTAL'; // Using 'TOTAL' for simplicity in this example, you can adjust for granularity
    }

    // Calculate the total impressions and total engagements
    $totalImpressions = array_sum($visitors);      // Assuming visitors represent impressions
    $totalEngagements = array_sum($interactions);  // Assuming interactions represent engagements

    // Calculate engagement per impression
    $engagementPeerImpressions = $totalImpressions > 0 ? ($totalEngagements / $totalImpressions) * 100 : 0;
    $engagementPeerImpressions = round($engagementPeerImpressions, 2);

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
