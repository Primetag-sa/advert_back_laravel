<?php

// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Socialite;

class AuthController extends Controller
{
    // Redirect to Snapchat's OAuth page
    public function redirectToSnapchat()
    {
        return \Laravel\Socialite\Facades\Socialite::driver('snapchat')->redirect();
    }

    // Handle the callback from Snapchat
    public function handleSnapchatCallback()
    {
        try {
            $user = Socialite::driver('snapchat')->user();

            // Find or create the user in your database
            $authUser = $this->findOrCreateUser($user);

            // Log the user in (using Laravel's Auth facade)
            Auth::login($authUser, true);

            // Redirect to the frontend application
            return redirect()->to('http://your-angular-app-url.com/dashboard');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->to('http://your-angular-app-url.com/login');
        }
    }

    // Logout function
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    // Helper function to find or create a user
    protected function findOrCreateUser($snapchatUser)
    {
        $user = User::where('snapchat_id', $snapchatUser->getId())->first();

        if ($user) {
            return $user;
        }

        return User::create([
            'name'        => $snapchatUser->getName(),
            'email'       => $snapchatUser->getEmail(),
            'snapchat_id' => $snapchatUser->getId(),
            // Other user fields...
        ]);
    }
}
