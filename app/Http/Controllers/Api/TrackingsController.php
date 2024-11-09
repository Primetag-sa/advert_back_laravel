<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\SnapAd;
use App\Models\VisitorEvent;
use Facebook\Facebook;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SnapchatAccount;
use App\Models\SnapchatAdsquad;
use App\Models\SnapchatCampaign;
use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;


class TrackingsController extends Controller
{

    public function index(Request $request)
    {
        // Validate the request to ensure the email is provided
        $request->validate([
            // 'email' => 'required|email',
        ]);

        $user = Auth()->user();

        // Get the user based on the provided email
        // $user = User::where('email', $request->email)->first();

        // If the user is not found, return an appropriate response
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Fetch VisitorEvents for the user using their ID
        $visitorEvents = VisitorEvent::with('visitor')
            ->whereHas('visitor', function ($query) use ($user) {
                $query->where('user_id', $user->id); 
            })
            ->get();

        return response()->json($visitorEvents);
    }

    public function trackEvent(Request $request)
    {
        $clientId = $request->input('client_id');
        $eventData = $request->all(); // Get all the incoming event data

        // Find the user by client ID
        $user = User::where('client_id', $clientId)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check if visitor exists or create a new one
        $visitor = Visitor::firstOrCreate(
            ['ip_address' => $request->ip()],  // Identify visitor by IP
            [
                'website' => $user->tracking_website,
                'user_id' => $user->id,
            ]
        );

        // Capture the event details
        VisitorEvent::create([
            'url' => $eventData['url'],
            'title' => $eventData['title'],
            'event_type' => $eventData['event_type'] ?? 'page_view',  // Default to 'page_view'
            'time_spent' => $eventData['time_spent'] ?? 0,  // Default to 0 if not provided
            'click_count' => $eventData['click_count'] ?? 0,  // Default to 0 if not provided
            'visitor_id' => $visitor->id,
            'created_at' => now(), // Capture the current timestamp
        ]);

        return response()->json(['message' => 'Event tracked successfully'], 200);
    }



    
    public function trackingPost(Request $request)
    {
        // Validate the website input
        $request->validate([
            'website' => 'required|url',
            'email' => ''
        ]);

        // Get the website from the request
        $website = $request->website;

        // Generate a unique tracking client ID
        $trackingClientId = Str::random(24);

        // Assuming authenticated user, you can get the user like this
        // $user = auth()->user();
        
        $user = Auth()->user();


        // Save the tracking website and tracking_client_id in the user's record
        $user->update([
            'tracking_website' => $website,
            'tracking_client_id' => $trackingClientId
        ]);

        // Prepare the JavaScript snippet with the tracking client ID
        $javascriptCode = "
<script>
(function() {
    var clientId = ',".$trackingClientId."';
    var trackingUrl = '".route('trackEvent')."';
    
    console.log('Tracking Script Loaded', { clientId, trackingUrl });

    function collectData(extraData = {}) {
        return {
            client_id: clientId,
            url: window.location.href,
            title: document.title,
            referrer: document.referrer,
            user_agent: navigator.userAgent,
            screen_width: window.screen.width,
            screen_height: window.screen.height,
            timestamp: new Date().toISOString(),
            ...extraData
        };
    }

    function sendTrackingData(data) {
        console.log('Sending Tracking Data:', data);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', trackingUrl, true);
        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                console.log('Tracking data sent successfully:', data);
            } else {
                console.error('Failed to send tracking data:', xhr.status, xhr.responseText);
            }
        };

        xhr.onerror = function() {
            console.error('Network error while sending tracking data:', data);
        };

        xhr.send(JSON.stringify(data));
    }

    function handleClick(event) {
        var target = event.target;
        var data = collectData({
            clicked_element: target.tagName,
            clicked_text: target.innerText.trim()
        });
        sendTrackingData(data);
    }

    function debounce(func, delay) {
        let timeoutId;
        return function(...args) {
            if (timeoutId) {
                clearTimeout(timeoutId);
            }
            timeoutId = setTimeout(() => {
                func.apply(this, args);
            }, delay);
        };
    }

    document.addEventListener('click', debounce(handleClick, 300));

    window.addEventListener('beforeunload', function() {
        var data = collectData();
        setTimeout(() => sendTrackingData(data), 100);
    });

    setTimeout(() => {
        var data = collectData();
        sendTrackingData(data);
    }, 100);
})();
</script>";



        $data = [
            'trackingCode'=>$javascriptCode,
            'trackingKey'=>$trackingClientId,
            'website'=>$website,
        ];
        // Return the JavaScript snippet as the response
        return response()->json(['data' => $data]);
    }

}
