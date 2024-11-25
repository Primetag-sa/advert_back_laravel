<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
}
