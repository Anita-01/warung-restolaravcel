@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2 class="mb-4 fw-bold">Detail Order</h2>

    <!-- INFO ANTRIAN -->
    <div class="bg-dark text-white p-4 rounded mb-4 shadow">
        <h4 class="fw-bold text-warning">
            Nomor Antrian: 
            A{{ str_pad($reservation->queue_number, 3, '0', STR_PAD_LEFT) }}
        </h4>

        <p class="mb-1">
            Estimasi Awal: 
            <span class="text-info fw-bold">
                {{ $reservation->queue_number * 5 }} menit
            </span>
        </p>

        <p class="mb-1">Invoice: {{ $reservation->invoice }}</p>

        <p>
            Status: 
            <span class="badge bg-success">
                {{ $reservation->status }}
            </span>
        </p>
    </div>

    <!-- REALTIME -->
    <div class="mb-4 p-4 bg-secondary text-white rounded shadow text-center">
        <div class="row">
            <div class="col-md-4 mb-3">
                <small>Antrian Saat Ini</small><br>
                <h4 id="currentQueue" class="fw-bold text-warning">-</h4>
            </div>

            <div class="col-md-4 mb-3">
                <small>Jumlah Menunggu</small><br>
                <h4 id="totalWaiting" class="fw-bold text-light">0</h4>
            </div>

            <div class="col-md-4 mb-3">
                <small>Estimasi Waktu</small><br>
                <h4 id="waitingTime" class="fw-bold text-info">0 menit</h4>
            </div>
        </div>
    </div>

    <!-- TABLE ORDER -->
    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead class="table-light text-center">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @php $total = 0; @endphp

                    @foreach($reservation->items as $item)
                        @php 
                            $subtotal = $item->price * $item->quantity; 
                            $total += $subtotal;
                        @endphp

                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Total</td>
                        <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- BUTTON -->
    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('invoice.download', $reservation->id) }}" 
           class="btn btn-success">
           Download Invoice PDF
        </a>

        <a href="{{ route('index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

</div>
@endsection

@section('scripts')
<script>
const userQueue = {{ $reservation->queue_number }};

// format A001
function formatQueue(num) {
    return 'A' + String(num).padStart(3, '0');
}

function loadQueueData() {
    fetch('/queue-data')
        .then(res => res.json())
        .then(data => {

            // 🔥 ambil angka dari backend
            let current = parseInt(data.current_queue);

            // tampilkan current queue (AMAN)
            if (!current || isNaN(current)) {
                document.getElementById('currentQueue').innerText = '-';
            } else {
                document.getElementById('currentQueue').innerText = formatQueue(current);
            }

            // jumlah menunggu
            document.getElementById('totalWaiting').innerText =
                data.total_waiting ?? 0;

            // estimasi waktu
            let remaining = userQueue - (current || 0);
            let estimate = remaining > 0 ? remaining * 5 : 0;

            document.getElementById('waitingTime').innerText =
                estimate + " menit";
        })
        .catch(err => {
            console.error('Error ambil queue:', err);
        });
}

// load pertama
loadQueueData();

// refresh tiap 5 detik
setInterval(loadQueueData, 5000);
</script>
@endsection