<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\SnapAd;
use App\Models\VisitorEvent;
use Carbon\Carbon;
use Facebook\Facebook;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Visitor;

class TrackingsController extends Controller
{

    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $userId = $user->id;

        $type = $request->query('type', 'DAY'); // Default to 'day'

        $startDate = $request->query('start_date', Carbon::now()->subMonth()->startOfDay()->toIso8601String());
        $endDate = $request->query('end_date', Carbon::now()->addDay()->toIso8601String());

        // Build the query
        $query = VisitorEvent::whereHas('visitor', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });

        

        // Filter by date range
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $visitorEvents = $query->with('visitor')->get();

        // Process data for the chart
        
        $hours = [];
        $engagements = [];
        $impressions = [];

        foreach ($visitorEvents as $event) {
            // Group by hour or day based on the 'type' parameter
            $groupBy = $type === 'DAY' ? $event->created_at->format('Y-m-d') : $event->created_at->format('Y-m-d H:00');

            if (!isset($hours[$groupBy])) {
                $hours[$groupBy] = [
                    'engagements' => 0,
                    'impressions' => 0,
                ];
            }

            $hours[$groupBy]['engagements'] += $event->click_count;
            $hours[$groupBy]['impressions']++;
        }

        $labels = array_keys($hours);
        foreach ($hours as $hourData) {
            $engagements[] = $hourData['engagements'];
            $impressions[] = $hourData['impressions'];
        }

        return response()->json(data: [
            'request' => $request->all(),
            'visitorEvents' => $visitorEvents,
            'nbVisitor' => $user->getWeeklyVisitorsCount(),//count($visitorEvents),
            'line' => [
                'visitors' => $engagements,
                'interactions' => $impressions,
                'hours' => $labels,
            ],
        ]);
    }

    public function trackEvent(Request $request)
    {
        // return 1;
        $clientId = $request->input('client_id');
        $eventData = $request->all(); // Get all the incoming event data
        
        // Find the user by client ID
        $user = User::where('tracking_client_id', $clientId)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        
        // Check if visitor exists or create a new one
        $visitor = Visitor::updateOrCreate(
            ['ip_address' => $request->ip(),'user_id'=>$user->id],  // Identify visitor by IP
            [
                'website' => $user?->tracking_website,
                'user_id' => $user?->id,
            ]
        );

        // Capture the event details
        VisitorEvent::create([
            'url' => $eventData['url'],
            'title' => $eventData['title']??'غير معرف',
            'event_type' => $eventData['event_type'] ?? 'page_view',  // Default to 'page_view'
            'time_spent' => $eventData['time_spent'] ?? 0,  // Default to 0 if not provided
            'click_count' => $eventData['click_count'] ?? 0,  // Default to 0 if not provided
            'visitor_id' => $visitor->id,
            'created_at' => now(), // Capture the current timestamp
        ]);

        return response()->json([
            'message' => 'Event tracked successfully',
            'data'=> $user
        ], 200);
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
        $quit = $request?->quit;
        $user = Auth()->user();

        if($quit==true){
            $user->update([
                'tracking_website' => null,
                'tracking_client_id' => null
            ]);

            $data = [
                'trackingCode'=>'',
                'trackingKey'=>'',
                'website'=>'',
            ];
            
            return response()->json(['data' => $data]);
        }
        // Generate a unique tracking client ID
        $trackingClientId = Str::random(24);

        $user->update([
            'tracking_website' => $website,
            'tracking_client_id' => $trackingClientId
        ]);

        $javascriptCode = "
        <script>
        (function() {
            var clientId = '".$trackingClientId."';
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
        
        return response()->json(['data' => $data]);
    }

}
