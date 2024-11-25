<?php

namespace App\Http\Controllers\Api;

use App\Models\Plan;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);
        // $user = auth()->user();

        $plan = Plan::find($request->plan_id);
        $user = User::first();

        if(count($user->activePlanSubscriptions())){
            return response()->json([
                'message' => 'You already have a Subscription',
                'status' => false,
            ], 400);
        }

        if($plan->hasTrial() && !$user->planSubscriptions()->exists()){
            $user->newPlanSubscription('main', $plan);
            return response()->json([
                'message' => 'Congratulations, Now You Have '. $plan->trial_period . ' '. $plan->trial_interval . "/s as Trial Period" ,
                'status' => true,
            ]);
        } else {
            $paymentService = new PaymentService();
            $paymentLink = $paymentService->generateLink($user, $plan);
            return response()->json([
                'payment_link' => $paymentLink,
                'status' => true,
            ]);
        }
    }

    // public function changePlan(Request $request)
    // {
    //     // TODO: implement change plan logic
    //     $request->validate([
    //         'plan_id' => ['required', 'exists:plans,id'],
    //     ]);
    //     // $user = auth()->user();
    //     $user = User::first();
    //     $plan = Plan::find($request->plan_id);

    //     if(count($user->activePlanSubscriptions()) == 0){
    //         return response()->json([
    //             'message' => "You Don't have any Subscription",
    //             'status' => false,
    //         ], 400);
    //     }
    // }

    public function cancel()
    {
        // $user = auth()->user();

        $user = User::first();
        if(count($user->activePlanSubscriptions()) == 0){
            return response()->json([
                'message' => "You Don't have any subscription",
                'status' => false,
            ], 400);
        } else {
            $subscriptions = $user->activePlanSubscriptions();
            foreach ($subscriptions as $subscription) {
                $subscription->cancel();
            }
            return response()->json([
                'message' => "Subscription Cancelled",
                'status' => true,
            ]);
        }
    }
}
