<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\Feature;

class PlansSeeder extends Seeder
{
    public function run()
    {
        $features = Feature::pluck('id')->toArray();

        $plans = [
            [
                'name' => 'Basic Plan',
                'description' => 'Basic subscription plan.',
                'period_type' => 'monthly',
                'base_price' => 50.00,
                'min_users' => 1,
                'max_users' => 10,
                'user_cost' => 5,
                'feature_ids' => [$features[0], $features[1]],
            ],
            [
                'name' => 'Premium Plan',
                'description' => 'Premium subscription plan.',
                'period_type' => 'yearly',
                'base_price' => 100.00,
                'min_users' => 1,
                'max_users' => 50,
                'user_cost' => 10,
                'feature_ids' => [$features[1], $features[2]],
            ],
        ];

        foreach ($plans as $planData) {
            $featureIds = $planData['feature_ids'];
            unset($planData['feature_ids']);

            $plan = Plan::create($planData);

            if (!empty($featureIds)) {
                $plan->features()->sync($featureIds);

                $totalFeaturePrice = Feature::whereIn('id', $featureIds)->sum('price');
                $plan->total_price = $plan->base_price + $totalFeaturePrice;
                $plan->save();
            }
        }
    }
}
