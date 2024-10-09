<?php

// app/Services/TwitterService.php

namespace App\Services;

use Abraham\TwitterOAuth\TwitterOAuth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TwitterService
{
    protected $client;

    protected $apiUrl = 'https://api.twitter.com/2/'; // Base URL for Twitter API

    public function __construct()
    {
        $this->client = new Client;
    }

    public function getUserTweets($accessToken, $secretToken)
    {
        try {
            $connection = new TwitterOAuth(
                config('services.twitter.api_key'),
                config('services.twitter.api_secret'),
                $accessToken,
                $secretToken
            );
            $twitterUser = $connection->get('users/by/username/yassineelmaarou');

            if (property_exists($twitterUser,'data')) {
                return $twitterUser->data;
            } elseif (property_exists($twitterUser,'status') && $twitterUser->status == 429) {
                return ['title' => $twitterUser->title];
            }

        } catch (RequestException $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
