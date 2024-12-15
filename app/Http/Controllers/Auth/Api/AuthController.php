<?php

namespace App\Http\Controllers\Auth\Api;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->is_confirmed) {
                $request->session()->regenerate();
                $token = $user->createToken('advert')->plainTextToken;
                $user->token = $token;
                return response()->json($user, 200);
            } else {
                return response()->json(['message' => 'الحساب غير مفعل', 'type' => 'not_confirmed'], 401);
            }

        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function editProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($request->user_id),
            ],
            'password' => 'nullable|min:6|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => 'حدث خطا ما', 'errors' => $validator->errors()]);
        }
        $user = User::find($request->user_id);
        if (! $user) {
            return response()->json(['status' => 'error', 'message' => 'حدث خطا ما']);
        }

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($user->image) {
                Storage::delete($user->image);
            }

            // Store the new image and save the path
            $path = $request->file('image')->store('images', 'public');
            $user->image = $path;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        return response()->json(['status' => 'success', 'data' => $user, 'message' => 'تم التحديث بنجاح']);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('advert')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_confirmed' => false,
            'role' => 'agency',
        ]);

        $agency = Agency::create([
            'name' => $user->agencyName,
            'user_id' => $user->id,
            'tiktok_url' => '',
            'facebook_url' => '',
            'instagram_url' => '',
            'snapchat_url' => '',
            'x_url' => '',
        ]);

        $token = $user->createToken('advert')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function logout(Request $request)
    {

        // For token-based authentication (like Passport or Sanctum)
        if (Auth::check()) {

            // Déconnecter l'utilisateur de la session (SPA)
            Auth::guard('web')->logout();

            // Invalider la session de l'utilisateur
            $request->session()->invalidate();

            // Regénérer le token CSRF pour éviter les attaques CSRF après déconnexion
            $request->session()->regenerateToken();
        }

        return response()->json(['message' => 'Successfully logged out'], 201);
        // Return a response
    }

    public function userAuth(Request $request): JsonResponse
    {
        $user = Auth::user();
        $state = false;
        if ($user) {
            $state = true;
        }

        return response()->json(['state' => $state, 'user' => $request->user()]);
    }
}
