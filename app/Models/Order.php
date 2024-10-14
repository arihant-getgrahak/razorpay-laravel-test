<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'amount',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
    ];
}
