<?php

namespace App\Services;

use GuzzleHttp\Client;

class FacebookAdService
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
        $url = 'https://graph.facebook.com/v17.0/me/adaccounts';

        try {
            $response = $this->client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error('Error fetching Facebook ad accounts: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getCampaignStats($campaignId, $startDate, $endDate, $accessToken)
    {
        $url = "https://graph.facebook.com/v17.0/{$campaignId}/insights";

        try {
            $response = $this->client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'query' => [
                    'time_range' => json_encode([
                        'since' => $startDate,
                        'until' => $endDate,
                    ]),
                    'fields' => 'impressions,clicks,spend,actions',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error('Error fetching Facebook campaign stats: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getAdStats($adId, $startTime, $endTime, $accessToken)
    {
        $url = "https://graph.facebook.com/v15.0/{$adId}/insights";

        try {
            $response = $this->client->get($url, [
                'headers' => [
                    'Authorization' => "Bearer {$accessToken}",
                ],
                'query' => [
                    'time_range' => [
                        'since' => $startTime,
                        'until' => $endTime,
                    ],
                    'fields' => 'impressions,clicks,spend,actions',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            \Log::error('Error fetching Facebook Ad stats: ' . $e->getMessage());
            throw $e;
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

    // Check if 'data' exists and is an array
    if (!empty($data['data']) && is_array($data['data'])) {
        foreach ($data['data'] as $stat) {
            // Extract time label based on granularity
            $timeLabel = $granularity === 'HOUR'
                ? \Carbon\Carbon::parse($stat['date_start'])->format('H:i') // Hourly granularity
                : \Carbon\Carbon::parse($stat['date_start'])->format('Y-m-d'); // Daily granularity
            $hours[] = $timeLabel;

            // Populate the data arrays with fallback values
            $clicks[] = $stat['clicks'] ?? 0;
            $sales[] = $stat['actions'] ? $this->getActionCount($stat['actions'], 'offsite_conversion.fb_pixel_purchase') : 0;
            $interactions[] = $stat['impressions'] ?? 0;
            $visitors[] = $stat['actions'] ? $this->getActionCount($stat['actions'], 'post_engagement') : 0;
        }
    }

    // Calculate totals
    $totalVisitors = array_sum($visitors); // Total visitors (e.g., post engagements)
    $totalInteractions = array_sum($interactions); // Total interactions (impressions)
    $totalClicks = array_sum($clicks); // Total clicks

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
            'visitor_clicks' => $totalClicks, // Total clicks
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

/**
 * Helper method to count specific action types.
 */
private function getActionCount($actions, $actionType)
{
    foreach ($actions as $action) {
        if ($action['action_type'] === $actionType) {
            return $action['value'];
        }
    }

    return 0;
}

/* public function getAdSquadStats($adSquadId, $startTime, $endTime, $accessToken, $type)
{
    $url = "https://graph.facebook.com/v17.0/{$adSquadId}/insights";

    try {
        $response = $this->client->get($url, [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'time_range' => [
                    'since' => $startTime,
                    'until' => $endTime,
                ],
                'level' => 'ad', // Adjust level as needed (campaign, adset, ad)
                'fields' => 'impressions,clicks,actions,spend',
                'time_increment' => $type, // DAILY, HOURLY, etc.
            ],
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        // Check if the response contains data
        if (empty($responseData['data'])) {
            throw new \Exception('No data returned from Facebook API');
        }

        return $this->processAdStats($responseData, $type);
    } catch (\Exception $e) {
        // Handle errors and exceptions
        throw new \Exception('Error fetching AdSquad stats: ' . $e->getMessage());
    }
} */
public function getAdSquadStats($adSquadId, $startTime, $endTime, $accessToken, $granularity)
{
    $url = "https://graph.facebook.com/v17.0/{$adSquadId}/insights";

    try {
        $response = $this->client->get($url, [
            'headers' => [
                'Authorization' => "Bearer {$accessToken}",
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'time_range' => [
                    'since' => $startTime,
                    'until' => $endTime,
                ],
                'fields' => 'impressions,clicks,spend,actions', // Add other fields as needed
                'level' => 'adset', // Specify granularity
            ],
        ]);

        $responseData = json_decode($response->getBody()->getContents(), true);

        if (isset($responseData['data'])) {
            return $responseData['data']; // Process or return data as needed
        }

        return ['error' => 'No data available.'];
    } catch (\Exception $e) {
        throw new \Exception('Error fetching ad squad stats: ' . $e->getMessage());
    }
}

}