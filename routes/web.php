<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('pay/verify', [PaymentController::class, 'verify']);

Route::get('razorpay', function () {
    return view('razorpaypayment');
});

Route::get('arihant/razorpay/public/order-confirm', function () {
    return view('orderconfirm');
});
Route::get('pay', function () {
    return view('payscreen');
});
