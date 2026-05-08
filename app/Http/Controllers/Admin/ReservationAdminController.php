<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReservationAdminController extends Controller
{
    // =========================
    // LIST ORDER
    // =========================
    public function index()
    {
        $reservations = Reservation::with('items.product')->latest()->get();

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

    // =========================
    // UPDATE STATUS (URL)
    // =========================
    public function updateStatus(Request $request, $id)
{
    $validStatus = ['Pending', 'Confirmed', 'Served', 'Completed'];

    if (!in_array($request->status, $validStatus)) {
        return back()->with('error', 'Status tidak valid');
    }

    $order = Reservation::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Status berhasil diupdate');
}
    // =========================
    // UPDATE STATUS AJAX
    // =========================
    public function updateStatusAjax(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,in preparation,served,completed,canceled'
    ]);

    $order = Reservation::findOrFail($id);
    $order->status = $request->status;
    $order->save();

    return response()->json([
        'success' => true,
        'message' => 'Status berhasil diupdate',
        'status' => $order->status
    ]);
}

    // =========================
    // DASHBOARD / REPORT
    // =========================
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