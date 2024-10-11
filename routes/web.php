<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/pay/verify', [PaymentController::class, 'verify']);

Route::get('/razorpay', function () {
    return view('razorpaypayment');
});

Route::view('/pay/razorpay', 'razorpay');


