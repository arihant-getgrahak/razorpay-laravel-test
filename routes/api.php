<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'user'], function () {

    Route::post('arihant/razorpay/public/payment/create-order', [PaymentController::class, 'razorpay']);
    Route::post('arihant/razorpay/public/payment/fail', [PaymentController::class, 'handlePaymentFail']);
});

Route::post('arihant/razorpay/public/payment/razorpay', [PaymentController::class, 'razorpay'])->name('paymentRazorpay');

Route::post('arihant/razorpay/public/razorpay/webhook', [PaymentController::class, 'webhookSignatureVerify']);
Route::post('arihant/razorpay/public/order/cancel', [PaymentController::class, 'orderCancel']);
Route::post('arihant/razorpay/public/order/status', [PaymentController::class, 'sendStatus']);
