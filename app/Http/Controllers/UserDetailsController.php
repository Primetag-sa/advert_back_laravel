<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserDetailsController extends Controller
{
    public function index()
    {
        $userDetails = UserDetail::with('user')->get();
        return response()->json([
            'message' => 'User details retrieved successfully!',
            'data' => $userDetails
        ], 200);
    }

    public function show($id)
    {
        $userDetail = UserDetail::with('user')->find($id);
        if (!$userDetail) {
            return response()->json(['message' => 'User detail not found'], 404);
        }
        return response()->json([
            'message' => 'User detail retrieved successfully!',
            'data' => $userDetail
        ], 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable|string',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'snapchat_url' => 'nullable|url',
            'x_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'pack_id' => 'nullable|integer',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],

            'password' => Hash::make($validated['password']),
            'role' => 'user', // Default role
            'is_activated' => true, // Mark as active
            'activated_at' => now(),
            'created_by_id' => Auth::user()->id,
        ]);

        $userDetail = UserDetail::create([
            'user_id' => $user->id,
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'facebook_url' => $validated['facebook_url'],
            'tiktok_url' => $validated['tiktok_url'],
            'snapchat_url' => $validated['snapchat_url'],
            'x_url' => $validated['x_url'],
            'instagram_url' => $validated['instagram_url'],
            'pack_id' => $validated['pack_id'],
        ]);

        return response()->json(['message' => 'User detail created successfully!', 'data' => $userDetail], 201);
    }

    public function update(Request $request, $id)
    {
        $userDetail = UserDetail::find($id);
        if (!$userDetail) {
            return response()->json(['message' => 'User detail not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $userDetail->user_id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'snapchat_url' => 'nullable|url',
            'x_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'pack_id' => 'nullable|integer',
        ]);

        $userDetail->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Use old values if the field is not provided in the request
        $userDetail->update([
            'address' => $validated['address'] ?? $userDetail->address,
            'facebook_url' => $validated['facebook_url'] ?? $userDetail->facebook_url,
            'tiktok_url' => $validated['tiktok_url'] ?? $userDetail->tiktok_url,
            'snapchat_url' => $validated['snapchat_url'] ?? $userDetail->snapchat_url,
            'x_url' => $validated['x_url'] ?? $userDetail->x_url,
            'instagram_url' => $validated['instagram_url'] ?? $userDetail->instagram_url,
            'pack_id' => $validated['pack_id'] ?? $userDetail->pack_id,
            'phone' => $validated['phone'] ?? $userDetail->phone,
        ]);

        return response()->json(['message' => 'User detail updated successfully!', 'data' => $userDetail], 200);
    }


    public function destroy($id)
    {
        $userDetail = UserDetail::find($id);
        if (!$userDetail) {
            return response()->json(['message' => 'User detail not found'], 404);
        }

        $userDetail->user->delete(); // Delete associated user
        $userDetail->delete(); // Delete user detail

        return response()->json(['message' => 'User detail deleted successfully!'], 200);
    }
}
