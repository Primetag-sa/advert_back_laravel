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

        try {
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

            // Decode the JSON response body
            // $responseData = json_decode($response->getBody()->getContents(), true);
            
            $responseData = json_decode($response->getBody()->getContents(), true);
            // return $responseData;
            // Check for successful response status
            if ($responseData['request_status'] !== 'SUCCESS') {
                throw new \Exception('API request failed: ' . $responseData['debug_message']);
            }

            return $this->processAdStats($responseData, $type);

            // return $responseData;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle error
            // Optionally log or throw the exception
            throw $e;
        }
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
            $clicks[] = rand(200, 500); // Random number for clicks
            $sales[] = rand(50, 200); // Random number for sales
            $interactions[] = rand(1000, 2000); // Random number for interactions
            $visitors[] = rand(500, 1500); // Random number for visitors
        }

        // Calculate the total impressions and total engagements
        $totalImpressions = array_sum($visitors); // Assuming visitors represent impressions
        $totalEngagements = array_sum($interactions); // Assuming interactions represent engagements
        $totalClicks = array_sum($clicks); // Assuming interactions represent engagements

        // Calculate engagement per impression
        // $engagementPeerImpressions = $totalImpressions > 0 ? ($totalEngagements / $totalImpressions) * 100 : 0;
        // $engagementPeerImpressions = round($engagementPeerImpressions, 2);
        $engagementPerImpressionPercentage = round($totalImpressions > 0 ? ($totalEngagements / ($totalImpressions + $totalEngagements + $totalClicks)) * 100 : 0, 2);

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

    public function getAdStats($adId, $startTime, $endTime, $type, $accessToken)
    {
        // Validate granularity type
        $validGranularity = ['HOUR', 'DAY'];
        if (!in_array($type, $validGranularity)) {
            throw new \InvalidArgumentException('Invalid granularity type. Must be either "HOUR" or "DAY".');
        }

        $url = "https://adsapi.snapchat.com/v1/ads/{$adId}/stats";

        try {
            // Make the request to Snapchat API
            $response = $this->client->get($url, [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                    'Content-Type' => 'application/json',
                ],
                'query' => [
                    'granularity' => $type,
                    'fields' => 'impressions,swipes,conversion_purchases,conversion_add_cart,conversion_view_content',
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    // 'report_dimension' =>'age'
                ],
            ]);

            // Check if response status is successful (200 OK)
            if ($response->getStatusCode() !== 200) {
                throw new \Exception("Failed to fetch ad stats. Status code: {$response->getStatusCode()}");
            }

            // Decode the JSON response body
            $responseData = json_decode($response->getBody()->getContents(), true);
            // return $responseData;
            // Check for successful response status
            if ($responseData['request_status'] !== 'SUCCESS') {
                throw new \Exception('API request failed: ' . $responseData['debug_message']);
            }

            return $this->processAdStats($responseData, $type);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Log the error and rethrow to be handled by controller
            \Log::error('Snapchat API ClientException: ' . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            // Log other exceptions
            \Log::error('Error fetching Snapchat ad stats: ' . $e->getMessage());
            throw $e;
        }
    }

    public function refreshSnapchatAccessToken($user)
    {
        // Prepare the POST request for refreshing the token
        $url = 'https://accounts.snapchat.com/oauth2/token';

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $user->snapchat_refresh_token,
                    'client_id' => 'YOUR_SNAPCHAT_CLIENT_ID',
                    'client_secret' => 'YOUR_SNAPCHAT_CLIENT_SECRET',
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the refresh was successful
            if (isset($data['access_token'])) {
                // Save the new access token in the user's record
                $user->snapchat_access_token = $data['access_token'];
                $user->save();

                return ['success' => true];
            }

            return ['success' => false, 'details' => 'Refresh token request failed.'];
        } catch (\Exception $e) {
            return ['success' => false, 'details' => $e->getMessage()];
        }
    }

    private function processAdStats($data, $granularity)
    {
        // Initialize data arrays
        $clicks = [];
        $sales = [];
        $interactions = [];
        $visitors = [];
        $hours = [];

        // Check if 'timeseries_stats' exists and is an array
        if (!empty($data['timeseries_stats']) && is_array($data['timeseries_stats'])) {
            foreach ($data['timeseries_stats'] as $stat) {

                if (!empty($stat['timeseries_stat']['timeseries']) && is_array($stat['timeseries_stat']['timeseries'])) {
                    foreach ($stat['timeseries_stat']['timeseries'] as $timeStat) {
                        // Extract time label based on granularity
                        $timeLabel = $granularity === 'HOUR'
                        ? \Carbon\Carbon::parse($timeStat['start_time'])->format('H:i')
                        : \Carbon\Carbon::parse($timeStat['start_time'])->format('Y-m-d');
                        $hours[] = $timeLabel;

                        // Populate the data arrays with fallback values
                        $clicks[] = $timeStat['stats']['swipes'] ?? 0; // Assuming 'swipes' means clicks
                        $sales[] = $timeStat['stats']['conversion_purchases'] ?? 0;
                        $interactions[] = $timeStat['stats']['impressions'] ?? 0;
                        $visitors[] = $timeStat['stats']['conversion_view_content'] ?? 0;
                    }
                }
            }
        }

        // Calculate totals
        $totalVisitors = array_sum($visitors); // Total visitors (e.g., view content)
        $totalInteractions = array_sum($interactions); // Total interactions (impressions)
        $totalClicks = array_sum($clicks); // Total clicks (swipes)

        // Define 'visitor_interactions' separately if needed
        $totalVisitorInteractions = $totalClicks; // Could include other stats if applicable

        // Calculate engagement per impression
        $engagementPerImpression = $totalInteractions > 0 ? ($totalClicks / $totalInteractions) * 100 : 0;
        $engagementPerImpression = round($engagementPerImpression, 2);

        // Prepare the response data
        $responseData = [
            'hourly' => [
                'hours' => $hours,
                'clicks' => $clicks,
                'sales' => $sales,
            ],
            'doughnut' => [
                'interactions' => $totalInteractions, // Total impressions
                'visitor_clicks' => $totalClicks, // Total swipes
                'visitor_interactions' => $totalVisitorInteractions, // Total visitor-specific interactions
            ],
            'line' => [
                'hours' => $hours,
                'visitors' => $visitors,
                'interactions' => $interactions,
            ],
            'engagementPerImpression' => $engagementPerImpression,
        ];

        // Return JSON response
        return $responseData;
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
        $totalImpressions = array_sum($visitors); // Assuming visitors represent impressions
        $totalEngagements = array_sum($interactions); // Assuming interactions represent engagements

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

    public function getAdSquadStats($adSquadId, $startTime, $endTime, $accessToken, $type)
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

        $responseData = json_decode($response->getBody()->getContents(), true);
        // return $responseData;
        // Check for successful response status
        if ($responseData['request_status'] !== 'SUCCESS') {
            throw new \Exception('API request failed: ' . $responseData['debug_message']);
        }

        return $this->processAdStats($responseData, $type);

        // return $this->processAdSquadStats($response->json());
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
        $totalImpressions = array_sum($visitors); // Assuming visitors represent impressions
        $totalEngagements = array_sum($interactions); // Assuming interactions represent engagements

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
            ],
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
            ],
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
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}