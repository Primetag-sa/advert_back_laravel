<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AdXAnalyticsController;
use App\Http\Controllers\Api\FacebookController;
use App\Http\Controllers\Api\InstagramController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\RoleAccessController;
use App\Http\Controllers\Api\SnapchatController;
use App\Http\Controllers\Api\TiktokController;
use App\Http\Controllers\Api\TweetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Api\AuthController;
use App\Http\Controllers\Auth\Api\TicktokAuthController;
use App\Http\Controllers\Auth\Api\TwitterAdsAuthController;
use App\Http\Controllers\Auth\Api\TwitterAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/* Route::get('auth/facebook', function () {
    return Socialite::driver('facebook')->scopes(['ads_read', 'ads_management'])->redirect();
});

Route::get('auth/facebook/callback', function () {
    $user = Socialite::driver('facebook')->user();
    // Store user tokens, such as $user->token, for later API requests.
}); */

Route::get('/auth/facebook', [FacebookController::class, 'redirectToSnapchat'])->name('facebook.redirect');
Route::get('/auth/facebook/callback', [FacebookController::class, 'handleCallback'])->name('facebook.callback.redirect');

Route::get('/auth/instagram', [InstagramController::class, 'redirectToInstagram'])->name('instagram.redirect');
Route::get('/auth/instagram/callback', [InstagramController::class, 'handleCallback'])->name('instagram.callback.redirect');


// Route::middleware('auth:sanctum')->group(function () {
    Route::get('/ads/snapchat/accounts', [SnapchatController::class, 'getAdsAccounts']);
    Route::get('/ads/snapchat/campaigns/{accountId}', [SnapchatController::class, 'getAdsCampaigns']);
    Route::get('/ads/snapchat/squads/{campaignId}', [SnapchatController::class, 'getAdsQuads']);
// });
// dd('ss');
Route::get('/ads/snapchat/ads/account/{accountId}', [SnapchatController::class, 'fetchAdsByAccount']);
Route::get('/ads/snapchat/ads/campaign/{campaignId}', [SnapchatController::class, 'fetchAdsByCampaign']);
Route::get('/ads/snapchat/ads/squad/{squadId}', [SnapchatController::class, 'fetchAdsByAdSquad']);


Route::get('/auth/snapchat', [SnapchatController::class, 'redirectToSnapchat'])->name('snapchat.redirect');


/* Route::get('auth/snapchat', [SnapchatController::class, 'redirectToSnapchat']);
Route::get('auth/snapchat/callback', [SnapchatController::class, 'handleSnapchatCallback']); */
Route::get('/snapchat/ad-data', [SnapchatController::class, 'getAdData']);
Route::get('/snapchat/ads', [SnapchatController::class, 'retrieveAds']);
Route::get('/save-data/{id}', [SnapchatController::class, 'saveData'])->name('saveData');
Route::get('/get-data/{id}', [SnapchatController::class, 'getData'])->name('getData');
Route::get('/get-status/{id}', [SnapchatController::class, 'getAdStats'])->name('getAdStats');

// Route::get('/get-ads', function () {

// })->name('get.snapchat.ads');

//

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tiktok/user', [TiktokController::class, 'getUserInfo']);

Route::apiResource('users', UserController::class);
Route::get('agency/agents', [UserController::class, 'agencyAgents'])->middleware('auth:sanctum');;
Route::patch('users/{id}/change/status', [UserController::class, 'changeStatus']);

Route::apiResource('notifications', NotificationController::class);

/* Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/user/{userId}', [NotificationController::class, 'userNotifications']);
Route::post('notifications', [NotificationController::class, 'store']);
Route::get('notifications/{id}', [NotificationController::class, 'show']);
Route::put('notifications/{id}', [NotificationController::class, 'update']);
Route::delete('notifications/{id}', [NotificationController::class, 'destroy']); */
Route::get('/twitter/tweets', [TweetController::class, 'getUserTweets'])->middleware('auth:sanctum');
Route::get('/ads/accounts/twitter', [TwitterAdsAuthController::class, 'getAdsAccounts'])->middleware('auth:sanctum');
Route::get('/ads/account/twitter', [TwitterAdsAuthController::class, 'getOneAccount'])->middleware('auth:sanctum');
Route::get('/ads/account/active-entities', [TwitterAdsAuthController::class, 'getActiveEntities'])->middleware('auth:sanctum');
Route::get('/twitter/signOut', [TwitterAuthController::class, 'signOutTweeter'])->middleware('auth:sanctum');
Route::get('/twitter/accounts', [TwitterAdsAuthController::class, 'fetchAndStoreAccounts'])->middleware('auth:sanctum');

// Authentication routes

Route::post('/profile/edit', [AuthController::class, 'editProfile']);
Route::get('/auth/twitter', [TwitterAuthController::class, 'redirectToTwitter']);
Route::get('/auth/tiktok', [TicktokAuthController::class, 'redirectToTikTok']);
Route::get('/auth/tiktok/callback', [TicktokAuthController::class, 'handleTikTokCallback']);

Route::middleware(['web'])->group(function () {
    Route::get('/auth/snapchat/callback', [SnapchatController::class, 'handleCallback'])->name('snapchat.callback.redirect');
    Route::get('/auth/twitter/callback', [TwitterAuthController::class, 'handleTwitterCallback'])->name('twitter.callback');
    // Route::get('/auth/snapchat/callback', [SnapchatController::class, 'handleCallback'])->name('snapchat.callback.redirect');
});
// Routes that require authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/isAuthenticated', [AuthController::class, 'userAuth'])->middleware('auth:sanctum');

Route::apiResource('role_access', RoleAccessController::class)->middleware('auth:sanctum');
Route::apiResource('account', AccountController::class)->middleware('auth:sanctum');
Route::apiResource('active-entities', AdXAnalyticsController::class)->middleware('auth:sanctum');

// Routes that require authentication
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
