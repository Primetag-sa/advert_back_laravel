<?php

use App\Http\Controllers\Api\AccountsXController;
use App\Http\Controllers\Api\AdXAnalyticsController;
use App\Http\Controllers\Api\FacebookController;
use App\Http\Controllers\Api\InstagramController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\RoleAccessController;
use App\Http\Controllers\Api\SnapchatController;
use App\Http\Controllers\Api\TiktokController;
use App\Http\Controllers\Api\TrackingsController;
use App\Http\Controllers\Api\TweetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Api\AuthController;
use App\Http\Controllers\Auth\Api\TicktokAuthController;
use App\Http\Controllers\Auth\Api\TwitterAdsAuthController;
use App\Http\Controllers\Auth\Api\TwitterAuthController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/facebook', [FacebookController::class, 'redirectToSnapchat'])->name('facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookController::class, 'handleCallback'])->name('facebook.callback.redirect');

Route::get('/auth/instagram', [InstagramController::class, 'redirectToInstagram'])->name('instagram.redirect');
Route::get('/auth/instagram/callback', [InstagramController::class, 'handleCallback'])->name('instagram.callback.redirect');

Route::get('/ads/snapchat/accounts', [SnapchatController::class, 'getAdsAccounts'])->middleware('auth:sanctum');
Route::get('/ads/snapchat/campaigns/{accountId}', [SnapchatController::class, 'getAdsCampaigns']);
Route::get('/ads/snapchat/squads/{campaignId}', [SnapchatController::class, 'getAdsQuads']);

Route::get('/visitor-events', [TrackingsController::class, 'index']);
Route::post('/tracking', [TrackingsController::class, 'trackingPost'])->name('trackingPost');
Route::post('/track-event', [TrackingsController::class, 'trackEvent'])->name('trackEvent');

Route::get('/auth/snapchat', [SnapchatController::class, 'redirectToSnapchat'])->name('snapchat.redirect');

Route::get('/ads/snapchat/ads/account/{accountId}', [SnapchatController::class, 'fetchAdsByAccount']);
Route::get('/ads/snapchat/ads/campaign/{campaignId}', [SnapchatController::class, 'fetchAdsByCampaign']);
Route::get('/ads/snapchat/ads/squad/{squadId}', [SnapchatController::class, 'fetchAdsByAdSquad']);

Route::get('/snapchat/ad-data', [SnapchatController::class, 'saveData'])->middleware('auth:sanctum');
Route::get('/snapchat/ads', [SnapchatController::class, 'retrieveAds']);
Route::get('/save-data', [SnapchatController::class, 'saveData'])->name('saveData')->middleware('auth:sanctum');
Route::get('/get-snap-data', [SnapchatController::class, 'getData'])->name('getData')->middleware('auth:sanctum');

/* status */
Route::get('/get-status/{id}', [SnapchatController::class, 'getAdStats'])->name('getAdStats')->middleware('auth:sanctum');
Route::get('/get-campaign-status/{id}', [SnapchatController::class, 'getCampaignStats'])->name('getCampaignStats')->middleware('auth:sanctum');
Route::get('/get-ad-squad-status/{id}', [SnapchatController::class, 'getAdSquadStats'])->name('getAdSquadStats')->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tiktok/user', [TiktokController::class, 'getUserInfo']);


Route::get('agency/agents', [UserController::class, 'agencyAgents'])->middleware('auth:sanctum');;
Route::patch('users/{id}/change/status', [UserController::class, 'changeStatus']);

// Authentication routes
Route::post('/profile/edit', [AuthController::class, 'editProfile']);
Route::get('/auth/twitter', [TwitterAuthController::class, 'redirectToTwitter']);
Route::get('/auth/tiktok', [TicktokAuthController::class, 'redirectToTikTok']);

//twitter
Route::get('/twitter/tweets', [TweetController::class, 'getUserTweets'])->middleware('auth:sanctum');
Route::get('/ads/accounts/twitter', [TwitterAdsAuthController::class, 'getAdsAccounts'])->middleware('auth:sanctum');
Route::get('/ads/account/twitter', [TwitterAdsAuthController::class, 'getOneAccount'])->middleware('auth:sanctum');
Route::get('/ads/account/active-entities', [TwitterAdsAuthController::class, 'getActiveEntities'])->middleware('auth:sanctum');
Route::get('/twitter/signOut', [TwitterAuthController::class, 'signOutTweeter'])->middleware('auth:sanctum');
Route::get('/twitter/accounts', [TwitterAdsAuthController::class, 'fetchAndStoreAccounts'])->middleware('auth:sanctum');
Route::get('/twitter/account/datas', [TwitterAdsAuthController::class, 'fetchData'])->middleware('auth:sanctum');
Route::get('/twitter/metrics', [TwitterAdsAuthController::class, 'getMetrics'])->middleware('auth:sanctum');

//callback
Route::middleware(['web'])->group(function () {
    Route::get('/auth/twitter/callback', [TwitterAuthController::class, 'handleTwitterCallback'])->name('twitter.callback');
    Route::get('/auth/snapchat/callback', [SnapchatController::class, 'handleCallback'])->name('snapchat.callback.redirect');
    Route::get('/auth/tiktok/callback', [TicktokAuthController::class, 'handleTikTokCallback']);
});

// Routes that require authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/isAuthenticated', [AuthController::class, 'userAuth'])->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);
Route::apiResource('notifications', NotificationController::class);
Route::apiResource('role_access', RoleAccessController::class)->middleware('auth:sanctum');
Route::apiResource('account', AccountsXController::class)->middleware('auth:sanctum');
Route::apiResource('active-entities', AdXAnalyticsController::class)->middleware('auth:sanctum');

// Routes that require authentication
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});

Route::apiResource('plans', PlanController::class, [
    'only' => ['index', 'show']
]);

Route::prefix('subscription')->controller(SubscriptionController::class)->group(function () {
    Route::post('/subscribe', 'subscribe');
    Route::middleware('subscribed')->group(function(){
        Route::get('/cancel', 'cancel');
        Route::post('/change-plan', 'changePlan');
        Route::get('/subscriptions', 'index');
        Route::get('/subscriptions/{id}', 'show');
    });
});

Route::prefix('payment')->controller(PaymentController::class)->group(function(){
    Route::get('/redirect', 'redirect')->name('payment.redirect');
    Route::post('/callback', 'callback')->name('payment.callback');
    Route::get('transactions', 'index');
    Route::get('transactions/{id}', 'show');
});


