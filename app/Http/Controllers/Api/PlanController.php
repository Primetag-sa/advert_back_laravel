<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::orderBy('sort_order', 'ASC')->get();
        return PlanResource::collection($plans);
    }

    public function show(Plan $plan)
    {
        return new PlanResource($plan);
    }
}
