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
            'features' => 'array',
            'features.*.name' => 'required|string|max:255',
            'features.*.price' => 'required|numeric|min:0'
        ]);

        $plan = Plan::create($validated);
        $totalFeaturePrice = 0;

        if (!empty($validated['features'])) {
            foreach ($validated['features'] as $featureData) {
                $feature = new Feature($featureData);
                $plan->features()->save($feature);
                $totalFeaturePrice += $feature->price;
            }
        }

        $plan->total_price = $plan->base_price + $totalFeaturePrice;
        $plan->save();

        return response()->json($plan->load('features'), 201);
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
            'features' => 'array',
            'features.*.name' => 'required|string|max:255',
            'features.*.price' => 'required|numeric|min:0'
        ]);

        $plan->update($validated);

        if (isset($validated['features'])) {
            $plan->features()->delete();
            $totalFeaturePrice = 0;
            foreach ($validated['features'] as $featureData) {
                $feature = new Feature($featureData);
                $plan->features()->save($feature);
                $totalFeaturePrice += $feature->price;
            }
            $plan->total_price = $plan->base_price + $totalFeaturePrice;
        }

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
