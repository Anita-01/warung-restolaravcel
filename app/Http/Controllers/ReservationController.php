<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CREATE RESERVATION
    |--------------------------------------------------------------------------
    */

    public function makeReservation(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'date'  => 'required',
        ]);

        // Ambil produk yang dipilih
        $products = $request->products ?? [];

        $filteredProducts = array_filter($products, function ($qty) {
            return $qty > 0;
        });

        // Minimal pilih 1 produk
        if (empty($filteredProducts)) {
            return back()
                ->withErrors([
                    'products' => 'Minimal pilih 1 produk'
                ])
                ->withInput();
        }

        // Transaction database
        return DB::transaction(function () use ($request, $filteredProducts) {

            // Generate nomor antrian hari ini
            $today = now()->toDateString();

            $lastQueue = Reservation::whereDate('created_at', $today)
                ->max('queue_number');

            $nextQueue = $lastQueue ? $lastQueue + 1 : 1;

            // Simpan reservasi
            $reservation = Reservation::create([
                'invoice'         => $this->generateInvoice(),
                'name'            => $request->name,
                'email'           => $request->email,
                'reservation_date'=> $request->date,
                'total_price'     => 0,
                'queue_number'    => $nextQueue,
                'status'          => 'pending',
            ]);

            $total = 0;

            // Simpan item reservation
            foreach ($filteredProducts as $productId => $qty) {

                $product = Product::find($productId);

                if (!$product) {
                    continue;
                }

                $subtotal = $product->price * $qty;

                $total += $subtotal;

                ReservationItem::create([
                    'reservation_id' => $reservation->id,
                    'product_id'     => $productId,
                    'quantity'       => $qty,
                    'price'          => $product->price,
                ]);
            }

            // Update total price
            $reservation->update([
                'total_price' => $total
            ]);

            // Estimasi waktu
            $estimate = $nextQueue * 5;

            return redirect()->back()->with([
                'success'        => 'Selamat, anda berhasil melakukan reservasi!',
                'reservation_id' => $reservation->id,
                'queue_number'   => 'A' . str_pad($nextQueue, 3, '0', STR_PAD_LEFT),
                'estimate'       => $estimate,
            ]);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | QUEUE DATA
    |--------------------------------------------------------------------------
    */

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
            'current_queue' => $current
                ? 'A' . str_pad($current->queue_number, 3, '0', STR_PAD_LEFT)
                : '-',

            'total_waiting' => $totalWaiting,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL RESERVATION
    |--------------------------------------------------------------------------
    */

    public function detailReservation($id)
    {
        $reservation = Reservation::with('items.product')
            ->findOrFail($id);

        return view('user.orderreserved', compact('reservation'));
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF INVOICE
    |--------------------------------------------------------------------------
    */

    public function downloadInvoice($id)
    {
        $reservation = Reservation::with('items.product')
            ->findOrFail($id);

        $pdf = Pdf::loadView(
            'user.invoice_pdf',
            compact('reservation')
        );

        return $pdf->download(
            'invoice-' . $reservation->id . '.pdf'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TRACE ORDER
    |--------------------------------------------------------------------------
    */

    public function traceOrder(Request $request)
    {
        $request->validate([
            'antrian' => 'required',
            'phone'   => 'required|email',
        ]);

        $reservation = Reservation::with('items.product')
            ->where('invoice', $request->antrian)
            ->where('email', $request->phone)
            ->first();

        if (!$reservation) {
            return back()->with([
                'error' => 'Data reservation tidak ditemukan'
            ]);
        }

        return view(
            'user.trace-order',
            compact('reservation')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GENERATE INVOICE
    |--------------------------------------------------------------------------
    */

    private function generateInvoice()
    {
        $date = now()->format('Ymd');

        $last = Reservation::whereDate(
            'created_at',
            now()
        )->count();

        $number = str_pad(
            $last + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

        return "INV-$date-$number";
    }

    /*
    |--------------------------------------------------------------------------
    | STORE RESERVATION
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email',
            'date'  => 'required',
        ]);

        // Generate nomor antrian
        $lastQueue = Reservation::max('queue_number');

        $queueNumber = $lastQueue
            ? $lastQueue + 1
            : 1;

        // Generate invoice
        $invoice = 'INV-' .
            now()->format('Ymd') .
            '-' .
            strtoupper(Str::random(5));

        // Simpan reservation
        $reservation = Reservation::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'reservation_date' => $request->date,
            'total_price'      => $request->total_price,
            'queue_number'     => $queueNumber,
            'invoice'          => $invoice,
            'status'           => 'pending',
        ]);

        return redirect()->route(
            'reservation.detail',
            $reservation->id
        );
    }
}