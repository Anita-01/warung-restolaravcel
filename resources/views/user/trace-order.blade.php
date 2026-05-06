@extends('layouts.app')

@section('content')

<div class="container mt-5">

    <div class="card p-4">

        <h2>Tracking Reservation</h2>

        <hr>

        <h4>
            Invoice:
            {{ $reservation->invoice }}
        </h4>

        <h5>
            Queue:
            A{{ str_pad($reservation->queue_number, 3, '0', STR_PAD_LEFT) }}
        </h5>

        <p>
            Name:
            {{ $reservation->name }}
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

            @if($reservation->status == 'pending')

                <span class="badge bg-warning">
                    Pending
                </span>

            @elseif($reservation->status == 'confirmed')

                <span class="badge bg-info">
                    Confirmed
                </span>

            @elseif($reservation->status == 'in_preparation')

                <span class="badge bg-primary">
                    In Preparation
                </span>

            @elseif($reservation->status == 'served')

                <span class="badge bg-success">
                    Served
                </span>

            @elseif($reservation->status == 'completed')

                <span class="badge bg-dark">
                    Completed
                </span>

            @else

                <span class="badge bg-danger">
                    Cancelled
                </span>

            @endif

        </p>

    </div>
    <a href="{{ route('index') }}"
   class="btn btn-secondary mt-3">
    Back to Dashboard
</a>



</div>

@endsection