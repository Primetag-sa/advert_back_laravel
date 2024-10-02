<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TwitterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{
    protected $twitterService;

    public function __construct(TwitterService $twitterService)
    {
        $this->twitterService = $twitterService;
    }

    public function getUserTweets()
    {
        $user = Auth::user();
        return response()->json($this->twitterService->getUserTweets($user->twitter_access_token, $user->twitter_account_id));
    }
}
