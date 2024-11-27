<?php

namespace App\Http\Controllers\Api;

use App\Models\Plan;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriptionResource;
use App\Models\Subscription;

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
                'message' => 'You already has an active Subscription',
                'status' => false,
            ], 400);
        }

        if($plan->isFree()){
            if(count($user->planSubscriptions)){
                return response()->json([
                    'message' => "You already subscribed before, Can't get the trial plan",
                    'status' => false,
                ], 400);
            }

            $user->newPlanSubscription('main', $plan);
            return response()->json([
                'message' => 'Congratulations, Now You Have '. $plan->invoice_period . ' '. $plan->invoice_interval . "/s as Trial Period" ,
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

    public function changePlan(Request $request)
    {
        $request->validate([
            'plan_id' => ['required', 'exists:plans,id'],
        ]);

        // $user = auth()->user();
        $user = User::first();

        if(count($user->activePlanSubscriptions()) == 0){
            return response()->json([
                'message' => "You Don't have any Subscription",
                'status' => false,
            ], 400);
        }

        $plan = Plan::find($request->plan_id);

        $userSubscription = $user->activePlanSubscriptions()->last();
        if($plan->id == $userSubscription->plan_id){
            return response()->json([
                'message' => "Can't Upgrade or Downgrade to the same Plan",
                'status' => false,
            ], 400);
        }

        $userSubscription->changePlan($plan);

        return response()->json([
            'message' => "Plan Changed Successfully",
            'status' => true,
        ]);
    }

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
                'message' => "Success, The Subscription has been canceled",
                'status' => true,
            ]);
        }
    }

    public function index()
    {
        // $user = auth()->user();
        $user = User::first();
        $subscriptions = $user->planSubscriptions;

        return SubscriptionResource::collection($subscriptions);
    }

    public function show($id)
    {
        $subscription = Subscription::findOrFail($id);
        return new SubscriptionResource($subscription);
    }
}
