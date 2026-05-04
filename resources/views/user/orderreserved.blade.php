@extends('layouts.app')

@section('content')
<div class="container py-5">

    <h2 class="mb-4">Detail Order</h2>

    <!-- INFO ANTRIAN -->
    <div class="g-dark text-white">
        <h5>Nomor Antrian: {{ $reservation->queue_number }}</h5>
        <h5>Estimasi: {{ $reservation->queue_number * 5 }} menit</h5>
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
    <a href="{{ route('invoice.download', $reservation->id) }}" 
   class="btn btn-success mt-3">
   Download Invoice PDF
</a>
</div>
@section('scripts')
<script>
function loadQueueData() {
    fetch('/queue-data')
        .then(res => res.json())
        .then(data => {
            document.getElementById('currentQueue').innerText = data.current_queue;
            document.getElementById('totalWaiting').innerText = data.total_waiting;
            document.getElementById('waitingTime').innerText = (data.total_waiting * 5) + " menit";
        });
}

loadQueueData();
setInterval(loadQueueData, 5000);
</script>
@endsection
@endsection