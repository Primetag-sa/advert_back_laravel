<?php



use App\Http\Controllers\Api\SnapchatController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Auth\Api\TwitterAuthController;

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


// Step 1: Show the welcome page with a button to start operations
Route::get('/', function () {
})->name('welcome');
