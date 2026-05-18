<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationController extends Controller
{

    public function makeReservation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'date' => 'required|date'
        ]);

        $selectedDate = Carbon::parse($request->date)->seconds(0);
        $now = Carbon::now()->seconds(0);

        if ($selectedDate->lt($now)) {
            return back()->withErrors([
                'date' => 'Tidak bisa booking di waktu yang sudah lewat'
            ])->withInput();
        }

        if ($selectedDate->isSameDay($now)) {
            $minTime = $now->copy()->addHour();

            if ($selectedDate->lt($minTime)) {
                return back()->withErrors([
                    'date' => 'Reservasi hari ini minimal 1 jam dari sekarang'
                ])->withInput();
            }
        }

        $products = $request->products ?? [];
        $filteredProducts = array_filter($products, fn($qty) => $qty > 0);

        if (empty($filteredProducts)) {
            return back()->withErrors([
                'products' => 'Minimal pilih 1 produk'
            ])->withInput();
        }

        try {
            return DB::transaction(function () use ($request, $filteredProducts) {

                $today = now()->toDateString();

                $lastQueue = Reservation::whereDate('created_at', $today)
                    ->max('queue_number');

                $nextQueue = $lastQueue ? $lastQueue + 1 : 1;

                $productIds = array_keys($filteredProducts);

                $productsDB = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                foreach ($filteredProducts as $productId => $qty) {
                    $product = $productsDB[$productId] ?? null;

                    if (!$product)
                        continue;

                    if ($qty > $product->qty) {
                        throw new \Exception(
                            "Produk {$product->name} hanya tersedia {$product->qty}"
                        );
                    }
                }

                $reservation = Reservation::create([
                    'invoice' => $this->generateInvoice(),
                    'name' => $request->name,
                    'email' => $request->email,
                    'reservation_date' => $request->date,
                    'total_price' => 0,
                    'queue_number' => $nextQueue,
                    'status' => 'pending',
                ]);

                $total = 0;

                foreach ($filteredProducts as $productId => $qty) {
                    $product = $productsDB[$productId];

                    $subtotal = $product->price * $qty;
                    $total += $subtotal;

                    ReservationItem::create([
                        'reservation_id' => $reservation->id,
                        'product_id' => $productId,
                        'quantity' => $qty,
                        'price' => $product->price,
                    ]);


                }

                $reservation->update([
                    'total_price' => $total
                ]);

                $estimate = $nextQueue * 5;

                return redirect()->back()->with([
                    'success' => 'Berhasil reservasi!',
                    'reservation_id' => $reservation->id,
                    'queue_number' => 'A' . str_pad($nextQueue, 3, '0', STR_PAD_LEFT),
                    'estimate' => $estimate,
                ]);
            });

        } catch (\Exception $e) {
            return back()->withErrors([
                'products' => $e->getMessage()
            ])->withInput();
        }
    }


    public function queueData()
    {
        $today = now()->toDateString();

        // Antrian yang sedang diproses
        $current = Reservation::whereDate('created_at', $today)
            ->where('status', 'in_preparation')
            ->orderBy('queue_number')
            ->first();

        // Total yang masih menunggu
        $totalWaiting = Reservation::whereDate('created_at', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        return response()->json([
        
            'current_queue' => $current ? (int)$current->queue_number : 0,

            'total_waiting' => $totalWaiting,

            'estimate' => $totalWaiting * 5
        ]);
    }


   
    public function nextQueue()
    {
        $today = now()->toDateString();

        // Ambil antrian yang sedang diproses
        $current = Reservation::whereDate('created_at', $today)
            ->where('status', 'in_preparation')
            ->orderBy('queue_number')
            ->first();

        // Selesaikan yang sekarang
        if ($current) {
            $current->update(['status' => 'served']);
        }

        // Ambil antrian berikutnya
        $next = Reservation::whereDate('created_at', $today)
            ->whereIn('status', ['pending', 'confirmed'])
            ->orderBy('queue_number')
            ->first();

        // Set jadi diproses
        if ($next) {
            $next->update(['status' => 'in_preparation']);
        }

        return response()->json([
            'success' => true,
            'next_queue' => $next ? (int)$next->queue_number : null
        ]);
    }



    public function generateQueueNumber()
    {
        $today = now()->toDateString();


        $lastQueue = Reservation::whereDate('created_at', $today)
            ->max('queue_number');

        return $lastQueue ? $lastQueue + 1 : 1;
    }
       public function detailReservation($id)
    {
        $reservation = Reservation::with('items.product')
            ->findOrFail($id);

        return view('user.orderreserved', compact('reservation'));
    }

    public function downloadInvoice($id)
    {
        $reservation = Reservation::with('items.product')
            ->findOrFail($id);

        $pdf = Pdf::loadView('user.invoice_pdf', compact('reservation'));

        return $pdf->download('invoice-' . $reservation->id . '.pdf');
    }

    public function traceOrder(Request $request)
    {
        $request->validate([
            'antrian' => 'required',
            'phone' => 'required|email',
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

        return view('user.trace-order', compact('reservation'));
    }

    private function generateInvoice()
    {
        $date = now()->format('Ymd');

        $count = Reservation::whereDate('created_at', now())->count() + 1;

        return 'INV-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}