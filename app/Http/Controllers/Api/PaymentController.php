<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\PaymentTransaction;
use App\Models\User;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function redirect(Request $request)
    {
        dd('redirect', $request);
    }

    public function callback(Request $request)
    {
        $paymentService = new PaymentService();
        $paymentService->callback($request);
        return response()->json([
            'message' => 'Payment callback received successfully',
        ]);
    }

    public function index()
    {
        // $user = auth()->user();
        $user = User::first();
        $transactions = $user->paymentTransactions;
        return TransactionResource::collection($transactions);
    }

    public function show($id)
    {
        $transaction = PaymentTransaction::findOrFail($id);
        return new TransactionResource($transaction);
    }
}
