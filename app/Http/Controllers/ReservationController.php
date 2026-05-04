<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Product;
use App\Models\ReservationItem;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservationController extends Controller
{
    public function makeReservation(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'date'  => 'required',
        ]);

        // 2. Cek apakah ada produk yang dipilih
        $products = $request->products ?? [];
        $filteredProducts = array_filter($products, function($qty) {
            return $qty > 0;
        });

        if (empty($filteredProducts)) {
            return back()
                ->withErrors(['products' => 'Minimal pilih 1 produk'])
                ->withInput();
        }

        // 3. Mulai Transaksi Database
        return DB::transaction(function () use ($request, $filteredProducts) {
            
            // Hitung nomor antrian hari ini
            $today = now()->toDateString();
            $lastQueue = Reservation::whereDate('created_at', $today)->max('queue_number');
            $nextQueue = $lastQueue ? $lastQueue + 1 : 1;

         
            $reservation = Reservation::create([
                'name'             => $request->name,
                'email'            => $request->email,
                'reservation_date' => $request->date,
                'total_price'      => 0, 
                'queue_number'     => $nextQueue,
                'status'           => 'waiting'
            ]);

            $total = 0;

            // Simpan detail item makanan
            foreach ($filteredProducts as $productId => $qty) {
                $product = Product::find($productId);
                if (!$product) continue;

                $subtotal = $product->price * $qty;
                $total += $subtotal;

                ReservationItem::create([
                    'reservation_id' => $reservation->id,
                    'product_id'     => $productId,
                    'quantity'       => $qty,
                    'price'          => $product->price
                ]);
            }

            // Update total harga ke tabel reservasi
            $reservation->update(['total_price' => $total]);

            // Hitung estimasi waktu (misal 1 orang = 5 menit)
            $estimate = $nextQueue * 5;

            // Redirect dengan data lengkap untuk SweetAlert
            return redirect()->back()->with([
                'success'        => 'Selamat, anda berhasil melakukan reservasi!',
                'reservation_id' => $reservation->id,
                'queue_number'   => 'A' . str_pad($nextQueue, 3, '0', STR_PAD_LEFT),
                'estimate'       => $estimate
            ]);
        });
    }

    public function queueData()
    {
        $today = now()->toDateString();

        $current = Reservation::whereDate('created_at', $today)
            ->where('status', 'waiting')
            ->orderBy('queue_number')
            ->first();

        $totalWaiting = Reservation::whereDate('created_at', $today)
            ->where('status', 'waiting')
            ->count();

        return response()->json([
            'current_queue' => $current ? 'A' . str_pad($current->queue_number, 3, '0', STR_PAD_LEFT) : '-',
            'total_waiting' => $totalWaiting
        ]);
    }
public function detailReservation($id)
{
    $reservation = Reservation::with('items.product')->findOrFail($id);

    return view('user.orderreserved', compact('reservation'));
}

public function downloadInvoice($id)
{
    $reservation = Reservation::with('items.product')->findOrFail($id);

    $pdf = Pdf::loadView('user.invoice_pdf', compact('reservation'));

    return $pdf->download('invoice-'.$reservation->id.'.pdf');
}
public function traceOrder()
    {
$reservation = Reservation::with('items.product')->find($id);

if (!$reservation) {
        return view('trace', [
            'message' => 'Data tidak ditemukan',
            'reservation' => null
        ]);
    }
    return view('user.traceorder', compact('reservation'));
}

}