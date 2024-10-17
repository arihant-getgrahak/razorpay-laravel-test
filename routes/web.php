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

Route::get('order-confirm', function () {
    return view('orderconfirm');
});
Route::get('pay', function () {
    return view('payscreen');
});

Route::get('order-cancel', function () {
    return view('ordercancel');
});
