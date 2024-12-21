<?php
namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Feature;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return Plan::with('features')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'period_type' => 'required|in:daily,monthly,yearly',
            'base_price' => 'required|numeric|min:0',
            'min_users' => 'required|integer|min:1',
            'max_users' => 'required|integer|min:1',
            'user_cost' => 'required|integer',
            'feature_ids' => 'array',
            'feature_ids.*' => 'exists:features,id',
        ]);

        $plan = Plan::create($validated);
        if (!empty($validated['feature_ids'])) {
            $plan->features()->sync($validated['feature_ids']);
        }

        // Calculate total price
        $totalFeaturePrice = Feature::whereIn('id', $validated['feature_ids'])
            ->sum('price');
        $plan->total_price = $plan->base_price + $totalFeaturePrice;
        $plan->save();

        return response()->json([
            'message' => 'Plan created successfully!',
            'data' => $plan->load('features')
        ], 201);
    }


    public function show($id)
    {
        $plan = Plan::with('features')->findOrFail($id);
        return response()->json($plan);
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'period_type' => 'sometimes|in:daily,monthly,yearly',
            'base_price' => 'sometimes|numeric|min:0',
            'min_users' => 'sometimes|integer|min:1',
            'max_users' => 'sometimes|integer|min:1',
            'user_cost' => 'sometimes|integer',
            'feature_ids' => 'array',
            'feature_ids.*' => 'exists:features,id',
        ]);

        $plan->update($validated);

        if (isset($validated['feature_ids'])) {
            $plan->features()->sync($validated['feature_ids']);
        }

        // Update total price
        $totalFeaturePrice = Feature::whereIn('id', $validated['feature_ids'] ?? [])
            ->where('is_include', true)
            ->sum('price');
        $plan->total_price = $plan->base_price + $totalFeaturePrice;
        $plan->save();

        return response()->json($plan->load('features'));
    }

    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();

        return response()->json(['message' => 'Plan deleted successfully']);
    }


}
