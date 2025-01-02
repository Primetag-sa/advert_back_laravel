<?php

namespace App\Http\Controllers;

use App\Models\AgencyAdmin;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::with('user')->get();
        return response()->json([
            'message' => 'User details retrieved successfully!',
            'data' => $agencies
        ], 200);
    }

    public function show($id)
    {
        $agency = Agency::with('user')->find($id);
        if (!$agency) {
            return response()->json(['message' => 'Agency not found'], 404);
        }
        return response()->json([
            'message' => 'User details retrieved successfully!',
            'data' => $agency
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
            'snapchat_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'x_url' => 'nullable|url',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'agency',
            'is_activated' => true, // Mark as active
            'activated_at' => now(),
        ]);

        $agency = Agency::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'address' => $validated['address']??null,
            'phone' => $validated['phone']??null,
            'snapchat_url' => $validated['snapchat_url']??null,
            'instagram_url' => $validated['instagram_url']??null,
            'tiktok_url' => $validated['tiktok_url']??null,
            'facebook_url' => $validated['facebook_url']??null,
            'x_url' => $validated['x_url']??null,
        ]);

        return response()->json(['message' => 'Agency created successfully!', 'data' => $agency], 201);
    }

    public function update(Request $request, $id)
    {
        $agency = Agency::find($id);
        if (!$agency) {
            return response()->json(['message' => 'Agency not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $agency->user_id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'snapchat_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'x_url' => 'nullable|url',
        ]);

        $agency->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],

        ]);

        $agency->update([
            'name' => $validated['name']?? $agency->name,
            'address' => $validated['address']?? $agency->address,
            'snapchat_url' => $validated['snapchat_url']?? $agency->snapchat_url,
            'instagram_url' => $validated['instagram_url']?? $agency->instagram_url,
            'tiktok_url' => $validated['tiktok_url']?? $agency->tiktok_url,
            'facebook_url' => $validated['facebook_url']?? $agency->facebook_url,
            'x_url' => $validated['x_url']?? $agency->x_url,
            'phone' => $validated['phone']?? $agency->phone,
        ]);

        return response()->json(['message' => 'Agency updated successfully!', 'data' => $agency], 200);
    }

    public function destroy($id)
    {
        $agency = Agency::find($id);
        if (!$agency) {
            return response()->json(['message' => 'Agency not found'], 404);
        }

        $agency->user->delete(); // Delete associated user
        $agency->delete(); // Delete agency

        return response()->json(['message' => 'Agency deleted successfully!'], 200);
    }



    public function addAdmin(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'agency') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'permissions' => 'required|array',
            'permissions.*' => 'string',
            'users' => 'nullable|array',
            'users.*' => [
                'exists:users,id',
                function ($attribute, $value, $fail) use ($user) {
                    // Check if the user exists and is created by the current authenticated user
                    $exists = \App\Models\User::where('id', $value)
                        ->where('role', 'user')
                        ->where('created_by_id', $user->id)
                        ->exists();

                    if (!$exists) {
                        $fail("The selected user ($value) is invalid or does not belong to you.");
                    }
                },
            ],
        ]);

        $agency = Agency::query()->where('user_id', $user->id)->first();

        $newUser = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin_agency',
            'is_activated' => true,
            'activated_at' => now(),
        ]);

        $admin = AgencyAdmin::create([
            'agency_id' => $agency->id,
            'user_id' => $newUser->id,
            'name' => $validated['name'],
            'permissions' => $validated['permissions'],
        ]);

        if (!empty($validated['users'])) {
            $admin->users()->sync($validated['users']);
        }

        return response()->json([
            'message' => 'Admin added successfully!',
            'data' => [
                'admin' => $admin->load('user'),
                'user' => $newUser,
            ],
        ], 201);
    }


    public function getAdmins()
    {
        $user = Auth::user();
        $agency = Agency::query()->where('user_id', $user->id)->first();
        if (!$agency) {
            return response()->json(['message' => 'Agency not found'], 404);
        }
        $admins = $agency->agencyAdmins()->with('user')->get();
        return response()->json(['data' => $admins], 200);
    }


}
