<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SnapchatService;
use App\Services\TwitterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Socialite\Facades\Socialite;

class SnapchatController extends Controller
{
    protected $snapchatService;

    public function __construct(SnapchatService $snapchatService)
    {
        $this->snapchatService = $snapchatService;
    }

    // Step 1: Redirect to Snapchat for authorization
    
    public function redirectToSnapchat()
    {
        return Socialite::driver('snapchat')->stateless()->redirect(); // No need to manage state manually
    }

    // Step 2: Handle the callback from Snapchat
    public function handleCallback(Request $request)
    {
        $user = Socialite::driver('snapchat')->stateless()->user();
        return response()->json($user);
    }

    // Step 3: Show Advertisement Data
    public function showAdData()
    {
        $adData = $this->snapchatService->getAdData(); // Fetch ad data using the service
        return view('snapchat.ad_data', compact('adData')); // Return view with ad data
    }
}
