<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\SnapchatController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// routes/web.php

Route::get('auth/snapchat', function () {
    
    $state = Str::random(40); // Génère une chaîne aléatoire pour l'état
    session(['snapchat_state' => $state]); // Stocke l'état dans la session

    return Socialite::driver('snapchat')->stateless()->redirect(); // Redirige vers Snapchat
});

/* 
https://accounts.snapchat.com/accounts/oauth2/auth?
client_id=25f97961-975e-4977-888d-1dcdf6d5f11d&redirect_uri=http%3A%2F%2F127.0.0.1%3A8000%2Fauth%2Fsnapchat%2Fcallback&scope=https%3A%2F%2Fauth.snapchat.com%2Foauth2%2Fapi%2Fuser.display_name+https%3A%2F%2Fauth.snapchat.com%2Foauth2%2Fapi%2Fuser.bitmoji.avatar&response_type=code

*/

Route::get('auth/snapchat/callback', function () {
    // Vérifiez que l'état correspond à celui stocké dans la session
    if (request('state') !== session('snapchat_state')) {
        abort(403, 'Invalid state'); // Si ça ne correspond pas, interrompez le processus
    }

    $user = Socialite::driver('snapchat')->user();

    // Gérer l'authentification de l'utilisateur (ex. : créer un utilisateur ou connecter un utilisateur existant)

    return $user; // Ou redirigez l'utilisateur vers une autre page
});

// Route::get('/auth/snapchat/redirect', [AuthController::class, 'redirectToSnapchat']);
// Route::get('/auth/snapchat/callback', [AuthController::class, 'handleSnapchatCallback']);
// Route::post('/auth/logout', [AuthController::class, 'logout']);


// Step 1: Show the welcome page with a button to start operations
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Step 2: Redirect to Snapchat for authorization
Route::get('/snapchat/redirect', [SnapchatController::class, 'redirectToSnapchat'])->name('snapchat.redirect');

// Step 3: Handle the callback from Snapchat
Route::get('/snapchat/callback', [SnapchatController::class, 'handleCallback'])->name('snapchat.callback');

// Step 4: Show Advertisement Data
Route::get('/snapchat/ad-data', [SnapchatController::class, 'showAdData'])->name('snapchat.adData');



// Route::get('/', [HomeController::class, 'index'])->name('home');
