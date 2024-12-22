<?php

use App\Http\Controllers\Api\AccountsXController;
use App\Http\Controllers\Api\AdXAnalyticsController;
use App\Http\Controllers\Api\FacebookController;
use App\Http\Controllers\Api\InstagramController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RoleAccessController;
use App\Http\Controllers\Api\SnapchatController;
use App\Http\Controllers\Api\TiktokController;
use App\Http\Controllers\Api\TrackingsController;
use App\Http\Controllers\Api\TweetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Api\AuthController;
use App\Http\Controllers\Auth\Api\GoogleAdsAuthController;
use App\Http\Controllers\Auth\Api\GoogleAdsController;
use App\Http\Controllers\Auth\Api\TicktokAuthController;
use App\Http\Controllers\Auth\Api\TwitterAdsAuthController;
use App\Http\Controllers\Auth\Api\TwitterAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\FeatureController;
use Abraham\TwitterOAuth\TwitterOAuth;


// Route::get('/auth/instagram', [InstagramController::class, 'redirectToInstagram'])->name('instagram.redirect');
Route::apiResource('plans', PlanController::class);
Route::apiResource('features', FeatureController::class);

// Route::get('/ads/snapchat/accounts', [SnapchatController::class, 'getAdsAccounts'])->middleware('auth:sanctum');
// Route::get('/ads/snapchat/campaigns/{accountId}', [SnapchatController::class, 'getAdsCampaigns']);
// Route::get('/ads/snapchat/squads/{campaignId}', [SnapchatController::class, 'getAdsQuads']);

// Route::get('/visitor-events', [TrackingsController::class, 'index']);
//change in auth
// Route::post('/tracking', [TrackingsController::class, 'trackingPost'])->name('trackingPost')->middleware('auth:sanctum');
// Route::post('/track-event', [TrackingsController::class, 'trackEvent'])->name('trackEvent');

// Route::get('/auth/snapchat', [SnapchatController::class, 'redirectToSnapchat'])->name('snapchat.redirect');
// Route::get('/auth/facebook', [FacebookController::class, 'redirectToFacebook'])->name('facebook.redirect');

/* new access */
// Route::get('/facebook/accounts/{id}/campaigns', [FacebookController::class, 'getAdsCampaigns']);
// Route::get('/facebook/campaigns/{id}/adsets', [FacebookController::class, 'getAdsQuads']);
// Route::get('/facebook/accounts/{id}/ads', [FacebookController::class, 'fetchAdsByAccount']);
// Route::get('/facebook/campaigns/{id}/ads', [FacebookController::class, 'fetchAdsByCampaign']);
// Route::get('/facebook/adsets/{id}/ads', [FacebookController::class, 'fetchAdsByAdSquad']);
// Route::get('/facebook/data', [FacebookController::class, 'getData']);

// Route::get('/ads/snapchat/ads/account/{accountId}', [SnapchatController::class, 'fetchAdsByAccount']);
// Route::get('/ads/snapchat/ads/campaign/{campaignId}', [SnapchatController::class, 'fetchAdsByCampaign']);
// Route::get('/ads/snapchat/ads/squad/{squadId}', [SnapchatController::class, 'fetchAdsByAdSquad']);

// Route::get('/snapchat/ad-data', [SnapchatController::class, 'saveData'])->middleware('auth:sanctum');
// Route::get('/facebook/ad-data', [FacebookController::class, 'saveData'])->middleware('auth:sanctum');
// Route::get('/snapchat/ads', [SnapchatController::class, 'retrieveAds']);
// Route::get('/save-data', [SnapchatController::class, 'saveData'])->name('saveData')->middleware('auth:sanctum');
// Route::get('/get-snap-data', [SnapchatController::class, 'getData'])->name('getData')->middleware('auth:sanctum');

/* status */
// Route::get('/get-status/{id}', [SnapchatController::class, 'getAdStats'])->name('getAdStats')->middleware('auth:sanctum');
// Route::get('/get-campaign-status/{id}', [SnapchatController::class, 'getCampaignStats'])->name('getCampaignStats')->middleware('auth:sanctum');
// Route::get('/get-ad-squad-status/{id}', [SnapchatController::class, 'getAdSquadStats'])->name('getAdSquadStats')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Route::get('agency/agents', [UserController::class, 'agencyAgents'])->middleware('auth:sanctum');
// Route::patch('users/{id}/change/status', [UserController::class, 'changeStatus']);

// Authentication routes
// Route::post('/profile/edit', [AuthController::class, 'editProfile']);
// Route::get('/auth/twitter', [TwitterAuthController::class, 'redirectToTwitter']);
// Route::get('/auth/tiktok', [TicktokAuthController::class, 'redirectToTikTok']);
// Route::get('/auth/google-ads', [GoogleAdsAuthController::class, 'redirectToGoogle']);

//twitter
// Route::get('/twitter/tweets', [TweetController::class, 'getUserTweets'])->middleware('auth:sanctum');
// Route::get('/ads/accounts/twitter', [TwitterAdsAuthController::class, 'getAdsAccounts'])->middleware('auth:sanctum');
// Route::get('/ads/account/twitter', [TwitterAdsAuthController::class, 'getOneAccount'])->middleware('auth:sanctum');
// Route::get('/ads/account/active-entities', [TwitterAdsAuthController::class, 'getActiveEntities'])->middleware('auth:sanctum');
// Route::get('/twitter/signOut', [TwitterAuthController::class, 'signOutTweeter'])->middleware('auth:sanctum');
// Route::get('/twitter/accounts', [TwitterAdsAuthController::class, 'fetchAndStoreAccounts'])->middleware('auth:sanctum');
// Route::get('/twitter/account/datas', [TwitterAdsAuthController::class, 'fetchData'])->middleware('auth:sanctum');
// Route::get('/twitter/metrics', [TwitterAdsAuthController::class, 'getMetrics'])->middleware('auth:sanctum');
// Route::get('/twitter/campaigns', [TwitterAdsAuthController::class, 'getCampains'])->middleware('auth:sanctum');
// Route::get('/twitter/conversionsperonethousandimpressions', [TwitterAdsAuthController::class, 'getConversionsPerOneThousandImpressions'])->middleware('auth:sanctum');
// Route::get('/twitter/conversionsperimpressions', [TwitterAdsAuthController::class, 'getConversionsPerOneThousandImpressions'])->middleware('auth:sanctum');
// Route::get('/twitter/impressionsperaudiance', [TwitterAdsAuthController::class, 'getConversionsPerOneThousandImpressions'])->middleware('auth:sanctum');
// Route::get('/twitter/conversionsperrevenue', [TwitterAdsAuthController::class, 'getConversionsPerOneThousandImpressions'])->middleware('auth:sanctum');


//tiktok
// Route::get('/tiktok/user', [TiktokController::class, 'getUserInfo'])->middleware('auth:sanctum');;
// Route::get('/tiktok/signOut', [TicktokAuthController::class, 'signOutTiktok'])->middleware('auth:sanctum');
// Route::get('/tiktok/accounts', [TiktokController::class, 'fetchAndStoreAccounts'])->middleware('auth:sanctum');
// Route::get('/tiktok/allAccounts', [TiktokController::class, 'accounts'])->middleware('auth:sanctum');
// Route::get('/tiktok/campaigns', [TiktokController::class, 'getCampains'])->middleware('auth:sanctum');
// Route::get('/tiktok/adgroup', [TiktokController::class, 'getAdGroup'])->middleware('auth:sanctum');
// Route::get('/tiktok/ad', [TiktokController::class, 'getAd'])->middleware('auth:sanctum');
// Route::get('/tiktok/conversionsperonethousandimpressions', [TiktokController::class, 'getConversionsPerOneThousandImpressions'])->middleware('auth:sanctum');
// Route::get('/tiktok/conversionsperimpressions', [TiktokController::class, 'getConversionsPerImpressions'])->middleware('auth:sanctum');
// Route::get('/tiktok/impressionsperaudiance', [TiktokController::class, 'getImpressionsPerAudiance'])->middleware('auth:sanctum');
// Route::get('/tiktok/conversionsperrevenue', [TiktokController::class, 'getConversionsPerRevenue'])->middleware('auth:sanctum');


//google
// Route::prefix('/google-ads')->group(function () {

// Route::get('/signOut', [GoogleAdsAuthController::class, 'signOutGoogleAds']);

// Customers
// Route::get('/customers', [GoogleAdsController::class, 'getCustomers']);

// Campagnes par customer
// Route::get('/customers/{customerId}/campaigns', [GoogleAdsController::class, 'getCampaigns']);

// Ad groups par campagne
// Route::get('/customers/{customerId}/campaigns/{campaignId}/ad-groups', [GoogleAdsController::class, 'getAdGroups']);

// Ads par ad group
// Route::get('/customers/{customerId}/ad-groups/{adGroupId}/ads', [GoogleAdsController::class, 'getAds']);

// Métriques par entité
// Route::get('/metrics/{entityType}/{entityId}', [GoogleAdsController::class, 'getEntityMetrics']);

// Recherche et filtrage
// Route::post('/search', [GoogleAdsController::class, 'searchEntities']);
// })->middleware('auth:sanctum');



//callback
// Route::middleware(['web'])->group(function () {
// Route::get('/auth/twitter/callback', [TwitterAuthController::class, 'handleTwitterCallback'])->name('twitter.callback');
// Route::get('/auth/snapchat/callback', [SnapchatController::class, 'handleCallback'])->name('snapchat.callback.redirect');
// Route::get('/auth/tiktok/callback', [TicktokAuthController::class, 'handleTikTokCallback']);
// Route::get('/auth/google-ads/callback', [GoogleAdsAuthController::class, 'handleGoogleCallback'])->name('google-ads.callback');
// Route::get('/auth/facebook/callback', [FacebookController::class, 'handleCallback'])->name('facebook.callback');
// Route::get('/auth/instagram/callback', [InstagramController::class, 'handleCallback'])->name('instagram.callback.redirect');
// });

// Routes that require authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/isAuthenticated', [AuthController::class, 'userAuth'])->middleware('auth:sanctum');

Route::apiResource('users', UserController::class)->middleware('auth:sanctum');

Route::controller(NotificationController::class)->group(function () {
    Route::get('/notifications', 'index');
    Route::post('/mark-read', 'markRead');
    Route::post('/notification', 'store');
    // Route::post('/mark-all-notifications-read', 'index');
})->middleware('auth:sanctum');


// Route::apiResource('notifications', NotificationController::class);
// Route::apiResource('role_access', RoleAccessController::class)->middleware('auth:sanctum');
// Route::apiResource('account', AccountsXController::class)->middleware('auth:sanctum');
// Route::apiResource('active-entities', AdXAnalyticsController::class)->middleware('auth:sanctum');

// Routes that require authentication
// Route::middleware('auth:api')->group(function () {
    // Route::get('/user', function (Request $request) {
        // return $request->user();
    // });

// });


// Route::get('/check-twitter-keys', function () {
    // $apiKey = env('TWITTER_API_KEY');
    // $apiSecret = env('TWITTER_API_SECRET');

    // try {
        // Create a new instance of the TwitterOAuth class
        // $twitter = new TwitterOAuth($apiKey, $apiSecret);

        // Request a bearer token to check if the keys are valid
        // $response = $twitter->oauth2('oauth2/token', ['grant_type' => 'client_credentials']);

        // if (isset($response->access_token)) {
            // return response()->json([
                // 'status' => 'success',
                // 'message' => 'Twitter API keys are valid!',
                // 'access_token' => $response->access_token,
            // ]);
        // }

        // return response()->json([
            // 'status' => 'error',
            // 'message' => 'Invalid Twitter API keys.',
        // ]);
    // } catch (\Exception $e) {
        // return response()->json([
            // 'status' => 'error',
            // 'message' => $e->getMessage(),
        // ]);
    // }
// });