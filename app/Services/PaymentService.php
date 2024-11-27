<?php

namespace App\Services;

use App\Models\PaymentMethod;
use App\Models\Plan;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class PaymentService
{

    public function generateLink($user, $plan)
    {
        $tapUrl = config('tap-payment.api_url').'/'.config('tap-payment.api_version').'/charges';
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. config('tap-payment.secret_key'),
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ])->post($tapUrl,[
            'amount' => $plan->price,
            'currency' => 'SAR',
            'customer_initiated' => true,
            "description" => "New Subscription",
            'save_card' => true,
            'receipt' => [
                'email' => true,
            ],
            'metadata' => [
                'udf1' =>$plan->id
            ],
            'customer' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ],
            'source' => [
                'id' => 'src_all'
            ],
            'redirect' => [
                'url' => route('payment.redirect'),
            ],
            'post' => [
                // 'url' => route('payment.callback'),
                'url' => "https://webhook.site/2a46d466-17a4-47ea-8cb8-181ba4e8cc13"
            ]
        ]);

        if($response->status() == 200){
            return $response->json('transaction.url');
        } else {
            Throw new Exception('Error generating payment link');
        }
    }

    public function callback($request)
    {
        $this->verifySignature($request);
        if($request->status == 'CAPTURED'){
            $user = User::where('email', $request->customer['email'])->first();
            $plan = Plan::find($request->metadata['udf1']);
            $subscriptionService = new SubscriptionService();
            $subscription = $subscriptionService->subscribe($user, $plan);
            $this->storeTransaction([
                'ref' => $request->id,
                'user_id' => $user->id,
                'status' => $request->status,
                'amount' => $request->amount,
                'currency' => $request->currency,
                'description' => $request->description
            ], $subscription);

            $this->storeUserCard([
                'card_id' => $request->card['id'],
                'customer_id' => $request->customer['id'],
                'payment_agreement_id' => $request->payment_agreement['id']
            ], $user);
        }
    }

    public function verifySignature($request)
    {
        $data = $request->all();
        $id = $data['id'];
        $amount = $data['amount'];
        $currency = $data['currency'];
        $gateway_reference = $data['reference']['gateway'];
        $payment_reference = $data['reference']['payment'];
        $status = $data['status'];
        $created = $data['transaction']['created'];

        $SecretAPIKey = config('tap-payment.secret_key');

        $toBeHashedString = 'x_id'.$id.'x_amount'.$amount.'x_currency'.$currency.'x_gateway_reference'.$gateway_reference.'x_payment_reference'.$payment_reference.'x_status'.$status.'x_created'.$created.'';

        $myHashString = hash_hmac('sha256', $toBeHashedString, $SecretAPIKey);
        $postedHashString = $request->header('hashstring');
        if($myHashString != $postedHashString){
            Throw ValidationException::withMessages(['Invalid Signature']);
        }
    }

    public function storeTransaction($data, $subscription)
    {
        $subscription->paymentTransactions()->create($data);
    }

    public function storeUserCard($data, $user)
    {
        PaymentMethod::updateOrCreate(['user_id'=> $user->id], $data);
    }
}
