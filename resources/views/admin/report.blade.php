@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h4 class="mb-4 fw-bold">📊 Dashboard Laporan</h4>

    <!-- FILTER -->
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body d-flex justify-content-between align-items-center">
            <form method="GET" action="{{ route('report') }}" class="d-flex gap-2">
                <input type="month" name="month" value="{{ request('month') }}" class="form-control">
                <button class="btn btn-warning">Search</button>
            </form>

            <a href="{{ route('report.pdf', ['month' => request('month')]) }}"
               class="btn btn-danger">
               Export PDF
            </a>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-3">
                <h6>Total Orders</h6>
                <h2>{{ $totalAll }}</h2>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-3">
                <h6>Completed</h6>
                <h2>{{ $totalCompleted }}</h2>
                <small>{{ $completedPercent }}%</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center p-3">
                <h6>Pending</h6>
                <h2>{{ $totalPending }}</h2>
                <small>{{ $pendingPercent }}%</small>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="row mb-4">

        <!-- DAILY -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-3">
                <h6>Pendapatan Harian</h6>
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <!-- MONTHLY -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-3">
                <h6>Pendapatan Bulanan</h6>
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

    </div>

    <!-- PRODUCT SALES -->
    <div class="card shadow-sm border-0 p-3">
        <h6>Produk Terlaris</h6>

        @forelse($productSales as $p)
            <div class="d-flex justify-content-between border-bottom py-2">
                <span>{{ $p->name }}</span>
                <strong>{{ $p->total }}</strong>
            </div>
        @empty
            <p class="text-muted">Tidak ada data</p>
        @endforelse
    </div>

    <div class="mt-3">
        <a href="{{ route('dashboardadmin') }}" class="btn btn-secondary">← Kembali</a>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* =========================
   DAILY CHART
========================= */
let dailyLabels = {!! json_encode($dailySales->pluck('date')) !!};
let dailyData = {!! json_encode($dailySales->pluck('total')) !!};

new Chart(document.getElementById('dailyChart'), {
    type: 'line',
    data: {
        labels: dailyLabels,
        datasets: [{
            label: 'Pendapatan Harian',
            data: dailyData,
            borderWidth: 2,
            tension: 0.3
        }]
    }
});


/* =========================
   MONTHLY CHART
========================= */
let monthLabels = {!! json_encode($monthlySales->pluck('month')) !!};
let monthData = {!! json_encode($monthlySales->pluck('total')) !!};

new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: monthLabels,
        datasets: [{
            label: 'Pendapatan Bulanan',
            data: monthData,
            borderWidth: 1
        }]
    }
});
</script>

@endsection