@extends('layouts.app')

@section('content')
<div class="container-fluid pt-4 px-4">

    <!-- FILTER BULAN -->
    <form method="GET" action="{{ route('admin.admin.report') }}" class="d-flex gap-2 mb-4">
        <input 
            type="month" 
            name="month" 
            class="form-control"
            value="{{ request('month') }}"
        >

        <button class="btn btn-primary">
            🔍 Search
        </button>

        <a href="{{ route('admin.admin.report.pdf', ['month' => request('month')]) }}" class="btn btn-danger">
            Export PDF
        </a>
    </form>

    <!-- INFO BULAN -->
    @if(request('month'))
        <p class="text-muted mb-3">
            Data bulan: 
            <strong>{{ \Carbon\Carbon::parse(request('month'))->format('F Y') }}</strong>
        </p>
    @endif

    <div class="row g-4">

        <!-- TOTAL -->
        <div class="col-md-6">
            <div class="bg-light rounded p-4">
                <h6>Total Orders</h6>
                <h3>{{ $totalCompleted }}</h3>

                <canvas id="barChart"></canvas>

                <div class="mt-2">
                    Completed: {{ $completedPercent }}% ({{ $totalCompleted }}) |
                    Pending: {{ $pendingPercent }}% ({{ $totalPending }})
                </div>
            </div>
        </div>

        <!-- LINE CHART -->
        <div class="col-md-6">
            <div class="bg-light rounded p-4">
                <h6>Pendapatan Harian</h6>
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <!-- DONUT -->
        <div class="col-md-6">
            <div class="bg-light rounded p-4">
                <h6>Produk Terjual</h6>
                <canvas id="donutChart"></canvas>

                <div class="mt-3">
                    @foreach($productSales as $p)
                        <div>{{ $p->name }} : {{ $p->total }}</div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- BULANAN -->
        <div class="col-md-6">
            <div class="bg-light rounded p-4">
                <h6>Pendapatan Bulanan</h6>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($monthlySales as $m)
                        <tr>
                            <td>{{ \Carbon\Carbon::create()->month($m->month)->format('F') }}</td>
                            <td>Rp {{ number_format($m->total,0,',','.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
             <div class="mt-3">
                <a href="{{ route('admin.dashboardadmin') }}" class="btn btn-secondary">
                    ← Kembali
                </a>
            </div>
    </div>
</div>
@endsection

@push('scripts')

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

// ================= BAR =================
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Completed', 'Pending'],
        datasets: [{
            data: [{{ $totalCompleted }}, {{ $totalPending }}],
            backgroundColor: ['blue', 'lightblue']
        }]
    }
});


// ================= LINE =================
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($dailySales->pluck('date')) !!},
        datasets: [{
            label: 'Pendapatan',
            data: {!! json_encode($dailySales->pluck('total')) !!},
            borderColor: 'green',
            fill: false
        }]
    }
});


// ================= DONUT =================
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($productSales->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($productSales->pluck('total')) !!},
            backgroundColor: ['#007bff','#28a745','#ffc107','#dc3545']
        }]
    }
});

</script>

@endpush