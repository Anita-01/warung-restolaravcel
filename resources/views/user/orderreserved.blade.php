@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h2 class="mb-4">Detail Order</h2>

        <!-- INFO ANTRIAN -->
        <div class="bg-dark text-white p-3 rounded mb-4">
            <h5>Nomor Antrian:
                A{{ str_pad($reservation->queue_number, 3, '0', STR_PAD_LEFT) }}
            </h5>
            <h5>Estimasi Awal: {{ $reservation->queue_number * 5 }} menit</h5>
            <h5>Invoice: {{ $reservation->invoice }}</h5>
            <h5>Status: {{ $reservation->status }}</h5>
        </div>

        <!-- REALTIME -->
        <div class="mb-4 p-3 bg-secondary text-white rounded">
            <h5>Antrian Saat Ini: <span id="currentQueue">-</span></h5>
            <h5>Jumlah Menunggu: <span id="totalWaiting">0</span></h5>
            <h5>Estimasi Waktu: <span id="waitingTime">0 menit</span></h5>
        </div>

        <!-- TABLE ORDER -->
        <table class="table table-bordered">
            <thead>
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
                    @php $subtotal = $item->price * $item->quantity; @endphp
                    @php $total += $subtotal; @endphp

                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>Rp {{ number_format($item->price) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp {{ number_format($subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>Rp {{ number_format($total) }}</th>
                </tr>
            </tfoot>
        </table>

        <a href="{{ route('invoice.download', $reservation->id) }}" class="btn btn-success mt-3">
            Download Invoice PDF
        </a>

        <div class="m-3">
            <a href="{{ route('index') }}" class="btn btn-secondary">
                ← Kembali
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const userQueue = {{ $reservation->queue_number }};

        function formatQueue(num) {
            return 'A' + String(num).padStart(3, '0');
        }

        function loadQueueData() {
            fetch('/queue-data')
                .then(res => res.json())
                .then(data => {

                    let current = data.current_queue || 0;

                    // tampilkan current queue
                    document.getElementById('currentQueue').innerText =
                        current ? formatQueue(current) : '-';

                    // jumlah menunggu
                    document.getElementById('totalWaiting').innerText =
                        data.total_waiting;

                    // hitung estimasi REAL
                    let remaining = userQueue - current;

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