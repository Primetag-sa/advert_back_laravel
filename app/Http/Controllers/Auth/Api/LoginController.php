<?php

// app/Http/Controllers/Auth/LoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('snapchat')->redirect();
    }

    public function handleProviderCallback()
    {
        $snapchatUser = Socialite::driver('snapchat')->user();

        // Save or update user in the database
        $authUser = User::firstOrCreate(
            ['snapchat_id' => $snapchatUser->id],
            [
                'name' => $snapchatUser->name,
                'email' => $snapchatUser->email,
                'snapchat_token' => $snapchatUser->token, // Store access token
            ]
        );

        // Log the user in
        Auth::login($authUser, true);

        return redirect()->route('dashboard'); // Redirect to the user's dashboard
    }
}
