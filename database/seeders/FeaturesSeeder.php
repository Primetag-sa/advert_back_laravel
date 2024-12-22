<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeaturesSeeder extends Seeder
{
    public function run()
    {
        $features = [
            ['name' => 'Feature A', 'price' => 10.00],
            ['name' => 'Feature B', 'price' => 15.00],
            ['name' => 'Feature C', 'price' => 20.00],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
}
