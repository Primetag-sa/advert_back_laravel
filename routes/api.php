<?php

use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\TweetController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\Api\AuthController;
use App\Http\Controllers\Auth\Api\TwitterAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SnapchatController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('auth/snapchat', [SnapchatController::class, 'redirectToSnapchat']);
Route::get('auth/snapchat/callback', [SnapchatController::class, 'handleSnapchatCallback']);
Route::get('/snapchat/ad-data', [SnapchatController::class, 'getAdData']);
Route::get('/snapchat/ads', [SnapchatController::class, 'retrieveAds']);
Route::get('/save-data/{id}',[SnapchatController::class, 'saveData'])->name('saveData');
Route::get('/get-data/{id}',[SnapchatController::class, 'getData'])->name('getData');

// Route::get('/get-ads', function () {

// })->name('get.snapchat.ads');

// 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/twitter/tweets', [TweetController::class, 'getUserTweets']);

Route::apiResource('users', UserController::class);
Route::get('agency/agents', [UserController::class, 'agencyAgents']);
Route::patch('users/{id}/change/status', [UserController::class, 'changeStatus']);

Route::apiResource('notifications', NotificationController::class);

/* Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/user/{userId}', [NotificationController::class, 'userNotifications']);
Route::post('notifications', [NotificationController::class, 'store']);
Route::get('notifications/{id}', [NotificationController::class, 'show']);
Route::put('notifications/{id}', [NotificationController::class, 'update']);
Route::delete('notifications/{id}', [NotificationController::class, 'destroy']); */

// Authentication routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/profile/edit', [AuthController::class, 'editProfile']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/auth/twitter', [TwitterAuthController::class, 'redirectToTwitter']);
Route::get('/auth/twitter/callback', [TwitterAuthController::class, 'handleTwitterCallback'])->name('twitter.callback');


// Routes that require authentication
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });


});

