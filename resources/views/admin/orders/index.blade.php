@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Orders</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Waktu Booking</th>
                <th>Pesanan</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi Admin</th>
            </tr>
        </thead>

        <tbody>
    @forelse($orders as $order)
        <tr>
            <td>{{ $loop->iteration }}</td>

            <td>{{ $order->name }}</td>

            <td>{{ $order->email }}</td>

            <td>{{ $order->reservation_date }}</td>

            <td>
                @foreach($order->items as $item)
                    <div>
                        {{ $item->product->name ?? 'Produk dihapus' }}
                        x {{ $item->quantity }}
                    </div>
                @endforeach
            </td>

            <td>{{ $order->items->sum('quantity') }}</td>

            <td>Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>

            <td>
                @if($order->status == 'waiting')
                    <span class="badge bg-warning">Waiting</span>
                @elseif($order->status == 'confirmed')
                    <span class="badge bg-success">Confirmed</span>
                @elseif($order->status == 'done')
                    <span class="badge bg-primary">Done</span>
                @elseif($order->status == 'cancelled')
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </td>

            <td>
                @if($order->status == 'waiting')
                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-success btn-sm">Confirm</button>
                    </form>

                    <form action="{{ route('admin.orders.cancel', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-danger btn-sm">Cancel</button>
                    </form>

                @elseif($order->status == 'confirmed')
                    <form action="{{ route('admin.orders.done', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary btn-sm">Done</button>
                    </form>

                @else
                    <span class="text-muted">Sudah diproses</span>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="9" class="text-center">Belum ada pesanan.</td>
        </tr>
    @endforelse
</tbody>
    </table>
</div>
@endsection