<?php

use App\Http\Controllers\SnapchatController;
use Illuminate\Support\Facades\Route;

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
