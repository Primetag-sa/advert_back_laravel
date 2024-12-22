<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetail;

class UserDetailsController extends Controller
{
    public function index()
    {
        $userDetails = UserDetail::all();
        return response()->json($userDetails, 200);
    }

    public function show($id)
    {
        $userDetail = UserDetail::find($id);
        if (!$userDetail) {
            return response()->json(['message' => 'User detail not found'], 404);
        }
        return response()->json($userDetail, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'agency_id' => 'nullable|exists:agencies,id',
            'facebook_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'snapchat_url' => 'nullable|url',
            'x_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'pack_id' => 'nullable|integer',
        ]);

        $userDetail = UserDetail::create($validated);

        return response()->json(['message' => 'User detail created successfully!', 'data' => $userDetail], 201);
    }

    public function update(Request $request, $id)
    {
        $userDetail = UserDetail::find($id);
        if (!$userDetail) {
            return response()->json(['message' => 'User detail not found'], 404);
        }

        $validated = $request->validate([
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'agency_id' => 'nullable|exists:agencies,id',
            'facebook_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'snapchat_url' => 'nullable|url',
            'x_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'pack_id' => 'nullable|integer',
        ]);

        $userDetail->update($validated);

        return response()->json(['message' => 'User detail updated successfully!', 'data' => $userDetail], 200);
    }

    public function destroy($id)
    {
        $userDetail = UserDetail::find($id);
        if (!$userDetail) {
            return response()->json(['message' => 'User detail not found'], 404);
        }

        $userDetail->delete();

        return response()->json(['message' => 'User detail deleted successfully!'], 200);
    }
}
