<?php

namespace App\Http\Controllers\Auth\Api;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Http\Controllers\Controller;
use App\Models\TwitterState;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TwitterAuthController extends Controller
{
    public function signOutTweeter()
    {

        $user = Auth::user();

        $user->update([
            'twitter_account_id' => null,
            'twitter_access_token' => null,
            'twitter_access_token_secret' => null,
        ]);

        return response()->json($user, 200);
    }

    public function redirectToTwitter(Request $request)
    {
        if (! Auth::check()) {
            return redirect($request->query('url').'?status=failure&error=not_authenticated');
        }

        $user = Auth::user();
        $connection = new TwitterOAuth(
            config('services.twitter.api_key'),
            config('services.twitter.api_secret')
        );

        // Generate state token and store it securely
        $state = Str::random(40);
        $request_token = $connection->oauth('oauth/request_token', [
            'oauth_callback' => route('twitter.callback').'?state='.$state.'&url='.$request->query('url'),
        ]);

        // Check if the request token is successfully received
        if (! isset($request_token['oauth_token']) || ! isset($request_token['oauth_token_secret'])) {
            return redirect(config('app.url_frontend').$request->query('url').'?status=failure&step=auth');
        }

        // Store state and tokens in the database
        TwitterState::create([
            'state' => $state,
            'oauth_token' => $request_token['oauth_token'],
            'oauth_token_secret' => $request_token['oauth_token_secret'],
            'user_id' => $user->id,
        ]);

        // Redirect to Twitter authorization page
        return redirect($connection->url('oauth/authorize', ['oauth_token' => $request_token['oauth_token']]));
    }

    public function handleTwitterCallback(Request $request)
    {
        // Validate state parameter to prevent CSRF attacks
        $state = $request->query('state');
        $url = $request->query('url');
        $twitterState = TwitterState::where('state', $state)->first();

        if (! $twitterState) {
            return redirect(config('app.url_frontend').$url.'?status=failure&error=invalid_state');
        }

        // Retrieve the user associated with the state
        $user = User::find($twitterState->user_id);
        if (! $user) {
            return redirect(config('app.url_frontend').$url.'?status=failure&error=user_not_found');
        }

        // Authenticate and regenerate session

        // Create a new TwitterOAuth instance with stored tokens
        $connection = new TwitterOAuth(
            config('services.twitter.api_key'),
            config('services.twitter.api_secret'),
            $twitterState->oauth_token,
            $twitterState->oauth_token_secret
        );

        try {
            // Request the access token using oauth_verifier
            $access_token = $connection->oauth('oauth/access_token', [
                'oauth_verifier' => $request->query('oauth_verifier'),
            ]);
        } catch (\Exception $e) {
            Log::error('Twitter OAuth error: '.$e->getMessage());

            return redirect(config('app.url_frontend').$url.'?status=failure&error=twitter_auth');
        }

        // Check if the access token is valid
        if (! isset($access_token['oauth_token'])) {
            return redirect(config('app.url_frontend').$url.'?status=failure&error=no_access_token');
        }

        // Set API version to 2 for further Twitter interactions
        $connection->setApiVersion('2');

        try {
            // Verify the connection status and update user information
            if ($connection->getLastHttpCode() == 200) {
                $user->update([
                    'twitter_account_id' => $access_token['user_id'],
                    'twitter_access_token' => $access_token['oauth_token'],
                    'twitter_access_token_secret' => $access_token['oauth_token_secret'],
                ]);

                // Clean up TwitterState entry
                $twitterState->delete();

                // Redirect with success
                return redirect()->away(config('app.url_frontend').$url.'?status=success');
            } else {
                return redirect(config('app.url_frontend').$url.'?status=failure&error=twitter_api');
            }
        } catch (\Exception $e) {
            Log::error('Unexpected Twitter API error: '.$e->getMessage());

            return redirect(config('app.url_frontend').$url.'?status=failure&error=unexpected');
        }
    }
}
