<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function () {

    Route::post('payment/create-order', [PaymentController::class, 'razorpay']);
    Route::post('payment/fail', [PaymentController::class, 'handlePaymentFail']);
});

Route::post('razorpay/webhook', [PaymentController::class, 'webhookSignatureVerify']);
Route::get('razorpay/webhook', function () {
    return response()->json([
        'message' => 'Webhook is working',
    ]);
});
Route::post('order/cancel', [PaymentController::class, 'orderCancel']);
Route::post('order/status', [PaymentController::class, 'sendStatus']);
