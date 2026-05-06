<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_email',
        'booking_time',
        'product_name',
        'quantity',
        'total_price',
        'status',
    ];
}