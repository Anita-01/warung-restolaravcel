<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: center; }
    </style>
</head>
<body>

<h2>Invoice Reservation</h2>

<p>Nama: {{ $reservation->name }}</p>
<p>Email: {{ $reservation->email }}</p>
<p>Tanggal: {{ $reservation->reservation_date }}</p>
<p>No Antrian: {{ $reservation->queue_number }}</p>

<table>
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
</table>

<h3>Total: Rp {{ number_format($total) }}</h3>

</body>
</html>