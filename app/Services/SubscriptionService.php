<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SubscriptionService
{
    public function subscribe($user, $planId)
    {
        return $user->newPlanSubscription('main', $planId);
    }

    public function renewSubscription($subscription)
    {
        $plan = $subscription->plan;
        $user = $subscription->subscriber;
        $cardToken = $this->generateCardToken($user);

        $tapUrl = config('tap-payment.api_url').'/'.config('tap-payment.api_version').'/charges';
        Http::withHeaders([
            'Authorization' => 'Bearer '. config('tap-payment.secret_key'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($tapUrl,[
            'amount' => $plan->price,
            'currency' => 'SAR',
            'customer_initiated' => false,
            "description" => "renew subscription",
            'save_card' => false,
            "payment_agreement"=> [
                "id" => $user->paymentMethod->payment_agreement_id
            ],
            'receipt' => [
                'email' => true,
            ],
            'metadata' => [
                'udf1' =>$plan->id,
                'udf2' => $subscription->id
            ],
            'customer' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'id' => $user->paymentMethod->customer_id
            ],
            'source' => [
                'id' => $cardToken
            ],
            'post' => [
                // 'url' => route('payment.callback'),
                'url' => "https://webhook.site/2a46d466-17a4-47ea-8cb8-181ba4e8cc13"
            ]
        ]);
    }

    public function generateCardToken($user)
    {
        $tapUrl = config('tap-payment.api_url').'/'.config('tap-payment.api_version').'/tokens';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. config('tap-payment.secret_key'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($tapUrl,[
            'saved_card' => [
                'card_id' => $user->paymentMethod->card_id,
                'customer_id' => $user->paymentMethod->customer_id,
            ]
        ]);
        if($response->status() == 200){
            return $response->json('id');
        } else {
            Log::error("Error generating card token", $response->json());
        }
    }
}
