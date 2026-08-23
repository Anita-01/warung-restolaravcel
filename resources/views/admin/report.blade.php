@extends('layouts.admin')

@section('content')

<style>
    :root {
        --ink-indigo: #1E2A4A;
        --turmeric: #D9A441;
        --turmeric-soft: #F3E3C1;
        --ivory: #FBF7EF;
        --charcoal: #2B2B2B;
        --clove: #6B4226;
        --leaf: #4F7942;
        --chili: #B23A2E;
    }

    .admin-wrap {
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        color: var(--charcoal);
    }

    .admin-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(30, 42, 74, 0.06);
    }

    .admin-heading {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        color: var(--ink-indigo);
        letter-spacing: -0.01em;
    }

    .admin-eyebrow {
        display: block;
        font-size: 0.68rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--clove);
        margin-bottom: 0.15rem;
    }

    .btn-back {
        border-radius: 10px;
        border: 1px solid #eae4d6;
        background: #fff;
        color: var(--clove);
        font-weight: 600;
    }

    .btn-back:hover {
        background: var(--ivory);
        color: var(--ink-indigo);
    }

    /* Filter bar */
    .filter-card {
        background: #fff;
    }

    .admin-wrap .form-control {
        border-radius: 10px;
        border: 1px solid #eae4d6;
        background: var(--ivory);
        padding: 0.5rem 0.9rem;
    }

    .admin-wrap .form-control:focus {
        border-color: var(--turmeric);
        box-shadow: 0 0 0 0.2rem rgba(217, 164, 65, 0.18);
        background: #fff;
    }

    .btn-search-report {
        background: var(--ink-indigo);
        border: none;
        color: var(--ivory);
        font-weight: 600;
        border-radius: 10px;
    }

    .btn-search-report:hover {
        background: #2A3A63;
        color: #fff;
    }

    .btn-export-pdf {
        border-radius: 10px;
        border: none;
        background: rgba(178, 58, 46, 0.1);
        color: var(--chili);
        font-weight: 700;
    }

    .btn-export-pdf:hover {
        background: var(--chili);
        color: #fff;
    }

    /* Stat cards */
    .stat-card {
        background: #fff;
        text-align: center;
        padding: 1.5rem 1rem;
    }

    .stat-eyebrow {
        font-size: 0.7rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--clove);
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .stat-value {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        color: var(--ink-indigo);
        font-size: 2rem;
        margin: 0;
    }

    .stat-sub {
        color: #9a9a9a;
        font-size: 0.8rem;
    }

    .stat-card.completed .stat-value {
        color: var(--leaf);
    }

    .stat-card.pending .stat-value {
        color: var(--turmeric);
    }

    /* Chart cards */
    .chart-card {
        background: #fff;
    }

    .chart-title {
        font-weight: 700;
        color: var(--clove);
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 0.75rem;
    }

    /* Product sales */
    .product-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.7rem 0;
        border-bottom: 1px solid #f1ece0;
    }

    .product-row:last-child {
        border-bottom: none;
    }

    .product-name {
        color: var(--charcoal);
        font-weight: 500;
    }

    .product-total {
        background: var(--turmeric-soft);
        color: #A5771F;
        font-weight: 700;
        font-size: 0.8rem;
        padding: 0.25rem 0.7rem;
        border-radius: 8px;
    }

    .empty-state {
        padding: 2rem 1rem;
        text-align: center;
        color: #9a9a9a;
    }
</style>

<div class="container my-5 admin-wrap">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <span class="admin-eyebrow">Analitik &amp; Statistik</span>
            <h3 class="admin-heading m-0">Dashboard Laporan</h3>
            <p class="text-muted small m-0">Ringkasan performa penjualan dan pesanan</p>
        </div>

        <a href="{{ route('dashboardadmin') }}" class="btn btn-back px-3 py-2 rounded-3 d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- FILTER -->
    <div class="card admin-card filter-card mb-4 p-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <form method="GET" action="{{ route('report') }}" class="d-flex gap-2">
                <input type="month" name="month" value="{{ request('month') }}" class="form-control">
                <button class="btn btn-search-report px-4">Search</button>
            </form>

            <a href="{{ route('report.pdf', ['month' => request('month')]) }}" class="btn btn-export-pdf px-4">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    <!-- STAT CARDS -->
    <div class="row mb-4 g-3">
        <div class="col-md-4">
            <div class="card admin-card stat-card">
                <div class="stat-eyebrow">Total Orders</div>
                <p class="stat-value">{{ $totalAll }}</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card admin-card stat-card completed">
                <div class="stat-eyebrow">Completed</div>
                <p class="stat-value">{{ $totalCompleted }}</p>
                <span class="stat-sub">{{ $completedPercent }}%</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card admin-card stat-card pending">
                <div class="stat-eyebrow">Pending</div>
                <p class="stat-value">{{ $totalPending }}</p>
                <span class="stat-sub">{{ $pendingPercent }}%</span>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="row mb-4 g-3">

        <!-- DAILY -->
        <div class="col-md-6">
            <div class="card admin-card chart-card p-3">
                <div class="chart-title">Pendapatan Harian</div>
                <canvas id="dailyChart"></canvas>
            </div>
        </div>

        <!-- MONTHLY -->
        <div class="col-md-6">
            <div class="card admin-card chart-card p-3">
                <div class="chart-title">Pendapatan Bulanan</div>
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

    </div>

    <!-- PRODUCT SALES -->
    <div class="card admin-card p-4">
        <div class="chart-title mb-2">Produk Terlaris</div>

        @forelse($productSales as $p)
            <div class="product-row">
                <span class="product-name">{{ $p->name }}</span>
                <span class="product-total">{{ $p->total }}</span>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-graph-up-arrow d-block mb-2" style="font-size: 1.6rem; color: var(--turmeric-soft);"></i>
                <p class="mb-0">Tidak ada data</p>
            </div>
        @endforelse
    </div>

</div>

@endsection


@section('scripts')

    <!-- CHART JS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        /* =========================
           SHARED THEME COLORS
        ========================= */
        const inkIndigo = '#1E2A4A';
        const turmeric = '#D9A441';

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
                    borderColor: inkIndigo,
                    backgroundColor: 'rgba(30, 42, 74, 0.08)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: inkIndigo
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                }
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
                    backgroundColor: turmeric,
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>

@endsection