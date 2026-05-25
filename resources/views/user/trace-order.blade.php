@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card p-4">
        <h2>Tracking Reservation</h2>
        <hr>

        {{-- Kalau tidak ada data --}}
        @if($reservations->isEmpty())
            <div class="alert alert-danger">
                Data reservation tidak ditemukan
            </div>
        @else

            {{-- Loop semua reservation --}}
            @foreach($reservations as $reservation)

                <div class="border rounded p-3 mb-4">

                    <h4>
                        Invoice: {{ $reservation->invoice }}
                    </h4>

                    <h5>
                        Queue:
                        A{{ str_pad($reservation->queue_number, 3, '0', STR_PAD_LEFT) }}
                    </h5>

                    <p>
                        Name: {{ $reservation->name }}
                    </p>

                    <p>
                        Total:
                        Rp {{ number_format($reservation->total_price) }}
                    </p>

                    <p><strong>Pesanan:</strong></p>

                    <ul>
                        @foreach($reservation->items as $item)
                            <li>
                                {{ $item->product->name }}
                                ({{ $item->quantity }}x)
                            </li>
                        @endforeach
                    </ul>

                    <p>Status:
                        <span 
                            id="status-badge-{{ $reservation->invoice }}" 
                            class="badge 
                                @if($reservation->status == 'pending') bg-warning
                                @elseif($reservation->status == 'confirmed') bg-info
                                @elseif($reservation->status == 'in_preparation') bg-primary
                                @elseif($reservation->status == 'served') bg-success
                                @elseif($reservation->status == 'completed') bg-dark
                                @else bg-danger
                                @endif
                            ">
                            {{ ucfirst(str_replace('_', ' ', $reservation->status)) }}
                        </span>
                    </p>

                </div>

            @endforeach

        @endif

    </div>

    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">
        Back to Dashboard
    </a>

</div>

@endsection


<script>
    console.log("DETAIL PAGE SCRIPT JALAN");

    function updateStatus(invoice) {
        fetch(`/api/reservation-status/${invoice}`)
            .then(res => res.json())
            .then(data => {

                let badge = document.getElementById(`status-badge-${invoice}`);
                if (!badge || !data.status) return;

                let status = data.status;

                badge.className = "badge";

                if (status === 'pending') badge.classList.add('bg-warning');
                else if (status === 'confirmed') badge.classList.add('bg-info');
                else if (status === 'in_preparation') badge.classList.add('bg-primary');
                else if (status === 'served') badge.classList.add('bg-success');
                else if (status === 'completed') badge.classList.add('bg-dark');
                else badge.classList.add('bg-danger');

                badge.innerHTML = status.replace('_', ' ');
            });
    }

    const invoices = [
        @foreach($reservations as $reservation)
            "{{ $reservation->invoice }}",
        @endforeach
    ];

    // langsung update
    invoices.forEach(inv => updateStatus(inv));

    // auto refresh
    setInterval(() => {
        invoices.forEach(inv => updateStatus(inv));
    }, 5000);
</script>