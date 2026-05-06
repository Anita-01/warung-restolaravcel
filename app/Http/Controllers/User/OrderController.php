<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'booking_time' => 'required|date',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|integer|min:0',
        ]);

        Order::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'booking_time' => $request->booking_time,
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Pesanan berhasil dikirim. Tunggu konfirmasi admin.');
    }
}