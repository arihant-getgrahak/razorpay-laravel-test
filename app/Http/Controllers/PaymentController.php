<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PaymentController extends Controller
{
    protected $api;

    public function __construct()
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $this->api = $api;
    }

    public function razorpay(Request $request)
    {
        $api = $this->api;
        $orderData = $api->order->create([
            'receipt' => '111',
            'amount' => $request->amount * 100,
            'currency' => 'INR',
        ]);

        $data = [
            'key' => env('RAZORPAY_KEY'),
            'amount' => $request->amount * 100,
            'order_id' => $orderData['id'],
        ];

        $dbData = [
            'razorpay_order_id' => $orderData['id'],
            'amount' => $request->amount * 100,
        ];

        Order::create($dbData);

        return response()->json($data, 200);
    }

    public function verify(Request $request)
    {
        $success = true;
        $error = 'Payment Failed!';

        if (empty($request->razorpay_payment_id) === false) {
            $api = $this->api;
            try {
                $attributes = [
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                ];
                $api->utility->verifyPaymentSignature($attributes);

                $dbData = [
                    'status' => 'confirm',
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature,
                ];

                Order::where('razorpay_order_id', $request->razorpay_order_id)->update($dbData);
            } catch (SignatureVerificationError $e) {
                $success = false;
                $error = 'Razorpay Error : '.$e->getMessage();
            }
        }

        if ($success === true) {
            return redirect('/')->with('success', $success);
        } else {
            return redirect('/')->with('error', $error);
        }
    }

    public function webhookSignatureVerify(Request $request)
    {
        $api = $this->api;

        try {
            $payload = $request->getContent();
            $signature = $request->header('X-Razorpay-Signature');
            $secret = env('RAZORPAY_WEBHOOK_SECRET');

            if (! $api->utility->verifyWebhookSignature($payload, $signature, $secret)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid signature 1',
                ], 400);
            }

            $data = json_decode($payload, true);
            $paymentEntity = $data['payload']['payment']['entity'] ?? [];
            $payment_id = $paymentEntity['id'] ?? null;
            $order_id = $paymentEntity['order_id'] ?? null;
            $payment_status = $data['event'] ?? null;

            if (! $payment_status || ! $order_id) {
                return response()->json([
                    'success' => false,
                    'error' => 'Invalid signature 2',
                ], 400);
            }

            $status = [
                'payment.captured' => 'captured',
                'payment.authorized' => 'authorized',
                'payment.failed' => 'failed',
            ];

            if (array_key_exists($payment_status, $status)) {
                $dbData = [
                    'status' => $status[$payment_status],
                    'razorpay_payment_id' => $payment_id,
                    'razorpay_signature' => $secret,
                ];

                Order::where('razorpay_order_id', $order_id)->update($dbData);

                return response()->json([
                    'success' => true,
                    'payment_status' => $status[$payment_status] === 'failed' ? 'Payment Failed' : $payment_status,
                ], 200);
            }

            return response()->json([
                'success' => false,
                'payment_status' => 'invalid status',
            ], 400);

        } catch (SignatureVerificationError $e) {
            return response()->json([
                'success' => false,
                'payment_status' => $e->getMessage(),
            ], 400);
        }
    }
}
