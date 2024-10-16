<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('arihant/razorpay/public/pay/verify', [PaymentController::class, 'verify']);

Route::get('arihant/razorpay/public/razorpay', function () {
    return view('razorpaypayment');
});

Route::get('arihant/razorpay/public/order-confirm', function () {
    return view('orderconfirm');
});
Route::get('arihant/razorpay/public/pay', function () {
    return view('payscreen');
});

Route::view('arihant/razorpay/public/pay/razorpay', 'razorpay');
