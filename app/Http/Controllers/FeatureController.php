<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::all();

        return response()->json([
            'message' => 'Features retrieved successfully!',
            'data' => $features
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_include' => 'nullable|boolean',
        ]);

        $feature = Feature::create($validated);

        return response()->json([
            'message' => 'Feature created successfully!',
            'data' => $feature
        ], 201);
    }


    public function show($id)
    {
        $feature = Feature::findOrFail($id);
        return response()->json($feature);
    }

    public function update(Request $request, $id)
    {
        $feature = Feature::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'is_include' => 'sometimes|boolean',
        ]);

        $feature->update($validated);

        return response()->json([
            'message' => 'Feature updated successfully!',
            'data' => $feature
        ], 201);
    }

    public function destroy($id)
    {
        $feature = Feature::findOrFail($id);
        $feature->delete();

        return response()->json(['message' => 'Feature deleted successfully']);
    }
}
