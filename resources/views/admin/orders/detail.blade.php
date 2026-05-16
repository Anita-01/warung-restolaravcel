@extends('layouts.app')

@section('content')

    <div class="container-fluid mt-4">

        <!-- Customer Detail -->
        <div class="card mb-4">
            <h5 class="card-header bg-dark text-white">Customer Details</h5>
            <div class="card-body">
                <p><strong>Nama:</strong> {{ $order->name }}</p>
                <p><strong>Email:</strong> {{ $order->email }}</p>
                <p><strong>Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($order->reservation_date)->format('d M Y') }}
                </p>

                <p><strong>Status:</strong>
                    @if($order->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($order->status == 'confirmed')
                        <span class="badge bg-success">Confirmed</span>
                    @elseif($order->status == 'in_preparation')
                        <span class="badge bg-primary">Preparation</span>
                    @elseif($order->status == 'served')
                        <span class="badge bg-info">Served</span>
                    @elseif($order->status == 'completed')
                        <span class="badge bg-dark">Completed</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </p>
            </div>
        </div>

        <!-- Item Detail -->
        <div class="card">
            <div class="card-body">
                <h4>Item Details</h4>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp

                            @foreach($order->items as $item)
                                @php
                                    $subtotal = $item->price * $item->quantity;
                                    $total += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $item->product->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach

                            <!-- Total -->
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total</strong></td>
                                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="mt-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>
                </div>

            </div>
        </div>

    </div>

@endsection