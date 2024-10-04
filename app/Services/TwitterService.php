<?php

// app/Services/TwitterService.php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TwitterService
{
    protected $client;
    protected $apiUrl = 'https://api.twitter.com/2/'; // Base URL for Twitter API

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getUserTweets($accessToken, $userId)
    {
        try {
            $response = $this->client->request('GET', $this->apiUrl . 'users/' . $userId . '/tweets', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            // Handle error
            return ['error' => $e->getMessage()];
        }
    }
}

