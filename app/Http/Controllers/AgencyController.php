<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;

class AgencyController extends Controller
{
    public function index()
    {
        $agencies = Agency::all();
        return response()->json($agencies, 200);
    }

    public function show($id)
    {
        $agency = Agency::find($id);
        if (!$agency) {
            return response()->json(['message' => 'Agency not found'], 404);
        }
        return response()->json($agency, 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'snapchat_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'x_url' => 'nullable|url',
            'user_id' => 'required|exists:users,id',
        ]);

        $agency = Agency::create($validated);

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
            'address' => 'nullable|string',
            'snapchat_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            'facebook_url' => 'nullable|url',
            'x_url' => 'nullable|url',
        ]);

        $agency->update($validated);

        return response()->json(['message' => 'Agency updated successfully!', 'data' => $agency], 200);
    }

    public function destroy($id)
    {
        $agency = Agency::find($id);
        if (!$agency) {
            return response()->json(['message' => 'Agency not found'], 404);
        }

        $agency->delete();

        return response()->json(['message' => 'Agency deleted successfully!'], 200);
    }
}
