<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    protected $api;
    public function __construct()
    {
        $api = new Api(env("RAZORPAY_KEY"), env("RAZORPAY_SECRET"));
        $this->api = $api;
    }
    public function razorpay(Request $request)
    {
        $api = $this->api;
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

    function verify(Request $request)
    {
        $success = true;
        $error = "Payment Failed!";

        if (empty($request->razorpay_payment_id) === false) {
            $api = $this->api;
            try {
                $attributes = [
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ];
                $api->utility->verifyPaymentSignature($attributes);
            } catch (SignatureVerificationError $e) {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }

        if ($success === true) {
            return redirect('/')->with('success', $success);
        } else {
            return redirect('/')->with('error', $error);
        }
    }
}
