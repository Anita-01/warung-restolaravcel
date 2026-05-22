<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Product;

class ReservationAdminController extends Controller
{
    // =========================
    // LIST ORDER
    // =========================
    public function index()
    {
        $reservations = Reservation::paginate(5);

        return view('admin.orders.index', compact('reservations'));
    }

    // =========================
    // DETAIL
    // =========================
    public function show($id)
    {
        $order = Reservation::with('items.product')->findOrFail($id);

        return view('admin.orders.detail', compact('order'));
    }

    public function search(Request $request)
    {
        $query = Reservation::latest();
        if ($request->key) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->key . '%')
                    ->orWhere('invoice', 'like', '%' . $request->key . '%');
            });
        }

        $reservations = $query->paginate(5);

        return response()->json([
            'data' => $reservations->items(),
            'links' => $reservations->links()->render(),
            'from' => $reservations->firstItem(),
            'to' => $reservations->lastItem(),
            'total' => $reservations->total(),
        ]);
    }




    public function updateStatusAjax(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,in_preparation,served,completed,canceled'
        ]);

        DB::transaction(function () use ($request, $id) {

            $today = now()->toDateString();

            $order = Reservation::with('items.product')->lockForUpdate()->findOrFail($id);

            // FIX ANTRIAN
            if ($request->status == 'in_preparation') {

                Reservation::whereDate('created_at', $today)
                    ->where('status', 'in_preparation')
                    ->update(['status' => 'pending']);
            }

            // HANDLE STOCK
            if ($request->status == 'completed' && $order->status != 'completed') {

                foreach ($order->items as $item) {

                    $product = Product::lockForUpdate()->find($item->product_id);

                    if (!$product)
                        continue;

                    if ($product->qty < $item->quantity) {
                        throw new \Exception("Stok {$product->name} tidak cukup");
                    }

                    $product->decrement('qty', $item->quantity);
                }
            }

            // UPDATE STATUS
            $order->update([
                'status' => $request->status
            ]);
            // cek git controller aman
        });

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diupdate',
            'status' => $request->status
        ]);
    }
    public function report(Request $request)
    {
        $month = $request->month;

        $query = Reservation::where('status', 'completed');

        if ($month) {
            $query->whereMonth('reservation_date', Carbon::parse($month)->month)
                ->whereYear('reservation_date', Carbon::parse($month)->year);
        }

        $totalAll = Reservation::count();
        $totalCompleted = $query->count();
        $totalPending = Reservation::where('status', '!=', 'completed')->count();

        $completedPercent = $totalAll > 0 ? round(($totalCompleted / $totalAll) * 100) : 0;
        $pendingPercent = $totalAll > 0 ? round(($totalPending / $totalAll) * 100) : 0;

        $dailySales = Reservation::select(
            DB::raw('DATE(reservation_date) as date'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('status', 'completed')
            ->when($month, function ($q) use ($month) {
                $q->whereMonth('reservation_date', Carbon::parse($month)->month)
                    ->whereYear('reservation_date', Carbon::parse($month)->year);
            })
            ->groupBy('date')
            ->get();

        $productSales = DB::table('reservation_items')
            ->join('reservations', 'reservation_items.reservation_id', '=', 'reservations.id')
            ->join('products', 'reservation_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(reservation_items.quantity) as total'))
            ->where('reservations.status', 'completed')
            ->when($month, function ($q) use ($month) {
                $q->whereMonth('reservation_date', Carbon::parse($month)->month)
                    ->whereYear('reservation_date', Carbon::parse($month)->year);
            })
            ->groupBy('products.name')
            ->get();

        $monthlySales = Reservation::select(
            DB::raw('MONTH(reservation_date) as month'),
            DB::raw('SUM(total_price) as total')
        )
            ->where('status', 'completed')
            ->groupBy('month')
            ->get();

        return view('admin.report', compact(
            'month',
            'totalAll',
            'totalCompleted',
            'totalPending',
            'completedPercent',
            'pendingPercent',
            'dailySales',
            'productSales',
            'monthlySales'
        ));
    }

    public function exportPdf(Request $request)
    {
        $month = $request->month;

        $query = Reservation::with('items.product')
            ->where('status', 'completed');

        if ($month) {
            $query->whereMonth('reservation_date', \Carbon\Carbon::parse($month)->month)
                ->whereYear('reservation_date', \Carbon\Carbon::parse($month)->year);
        }

       $data = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.report_pdf', compact('data', 'month'));

        return $pdf->download('laporan-' . ($month ?? 'all') . '.pdf');
    }
}