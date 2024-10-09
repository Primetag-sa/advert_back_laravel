<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TwitterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class TweetController extends Controller
{
    protected $twitterService;

    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function getUserTweets(Request $request)
    {

        $user = null;
        if ($request->query('token')) {
            $user = PersonalAccessToken::findToken($request->query('token'))->tokenable;
        }

        return response()->json($this->twitterService->getUserTweets($user->twitter_access_token, $user->twitter_access_token_secret));
    }
}
