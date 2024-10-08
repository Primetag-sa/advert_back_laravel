<?php

namespace App\Http\Controllers;

use App\Services\SnapchatService;
use Illuminate\Http\Request;

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
        return $this->snapchatService->redirectToSnapchat();
    }

    // Step 2: Handle the callback from Snapchat
    public function handleCallback(Request $request)
    {
        $adData = $this->snapchatService->handleCallback($request);
        return redirect()->route('snapchat.adData')->with('success', 'Data retrieved and saved successfully!');
    }

    // Step 3: Show Advertisement Data
    public function showAdData()
    {
        $adData = $this->snapchatService->getAdData(); // Fetch ad data using the service
        return view('snapchat.ad_data', compact('adData')); // Return view with ad data
    }
}
