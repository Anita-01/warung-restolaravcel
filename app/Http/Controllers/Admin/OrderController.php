<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Reservation::with('items.product')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function confirm($id)
    {
        $order = Reservation::findOrFail($id);

        $order->update([
            'status' => 'confirmed'
        ]);

        return back()->with('success', 'Pesanan berhasil dikonfirmasi.');
    }

    public function cancel($id)
    {
        $order = Reservation::findOrFail($id);

        $order->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function done($id)
    {
        $order = Reservation::findOrFail($id);

        $order->update([
            'status' => 'done'
        ]);

        return back()->with('success', 'Pesanan selesai.');
    }
}