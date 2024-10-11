<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    public function razorpay(Request $request)
    {
        $api = new Api(env("RAZORPAY_KEY"), env("RAZORPAY_SECRET"));
        $orderData = $api->order->create([
            'receipt' => '111',
            'amount' => $request->amount * 100,
            'currency' => 'INR'
        ]);

        $data = [
            "key" => env("RAZORPAY_KEY"),
            "amount" => $request->amount * 100,
            "order_id" => $orderData['id'],
        ];
        return response()->json($data, 200);
    }
}
