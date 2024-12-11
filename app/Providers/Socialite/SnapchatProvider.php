<?php

namespace App\Providers\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;

class SnapchatProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopes = ['snapchat:default'];

    protected function getAuthUrl($state)
    {
        return 'https://accounts.snapchat.com/accounts/oauth2/auth?' . http_build_query([
            'response_type' => 'code',
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUri,
            'state' => $state,
            'scope' => implode(' ', $this->scopes),
        ]);
    }

    protected function getTokenUrl()
    {
        return 'https://accounts.snapchat.com/accounts/oauth2/token';
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://app.snapchat.com/v1/me', [
            'headers' => ['Authorization' => 'Bearer ' . $token],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (object) [
            'id' => $user['data']['id'],
            'nickname' => null,
            'name' => $user['data']['display_name'],
            'email' => null,
            'avatar' => $user['data']['avatar'],
            'profileUrl' => null,
            'provider' => 'snapchat',
        ];
    }
}