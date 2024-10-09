<?php



use App\Http\Controllers\Api\SnapchatController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Auth\Api\TwitterAuthController;

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Str;

Route::get('/auth/snapchat', [SnapchatController::class, 'redirectToSnapchat'])->name('snapchat.redirect');
Route::get('/auth/snapchat/callback', [SnapchatController::class, 'handleCallback'])->name('snapchat.redirect');
// Route::get('auth/snapchat', function () {
//     return Socialite::driver('snapchat')->stateless()->redirect(); // No need to manage state manually
// });
// Route::get('auth/snapchat/callback', function () {
//     $user = Socialite::driver('snapchat')->stateless()->user();
//     return response()->json($user);
// });

// Step 1: Show the welcome page with a button to start operations
Route::get('/', function () {
})->name('welcome');
