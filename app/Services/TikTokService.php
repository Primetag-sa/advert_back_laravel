<?php

namespace App\Services;

use GuzzleHttp\Client;

class TikTokService
{
    protected $client;
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;

    public function __construct()
    {
        $this->client = new Client();
        $this->clientId = config('services.tiktok.client_id');
        $this->clientSecret = config('services.tiktok.client_secret');
        $this->redirectUri = config('services.tiktok.redirect');
    }

    public function getAccessToken($code)
    {
        try {
            $response = $this->client->post('https://open.tiktokapis.com/v2/oauth/token/', [
                'form_params' => [
                    'client_key' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'code' => $code,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $this->redirectUri,
                ],
            ]);
        }catch (\Exception $exception){
            dd($exception);
        }


        return json_decode((string) $response->getBody(), true);
    }

    public function getUserInfo($accessToken)
    {

        try {
            $response = $this->client->get('https://open.tiktokapis.com/v2/user/info/?fields=open_id,union_id,avatar_url', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]);
        }catch (\Exception $exception){
            dd($exception);
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
            throw new \Exception('Failed to refresh access token: ' . $e->getMessage());
        }
    }
}
