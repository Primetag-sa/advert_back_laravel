<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\NotificationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', UserController::class);

Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/user/{userId}', [NotificationController::class, 'userNotifications']);
Route::post('notifications', [NotificationController::class, 'store']);
Route::get('notifications/{id}', [NotificationController::class, 'show']);
Route::put('notifications/{id}', [NotificationController::class, 'update']);
Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

// Routes that require authentication
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function(Request $request) {
        return $request->user();
    });
});


