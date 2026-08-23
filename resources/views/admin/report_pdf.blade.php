<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Reservasi</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            text-align: center;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 6px;
            text-align: center;
            vertical-align: top;
        }

        .text-left {
            text-align: left;
        }

        .product-box {
            margin-bottom: 6px;
            padding-bottom: 4px;
            border-bottom: 1px dashed #ccc;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    <h2>LAPORAN RESERVASI (COMPLETED)</h2>

    @if($month)
        <p>
            Bulan: {{ \Carbon\Carbon::parse($month)->format('F Y') }}
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Invoice</th>
                <th>Produk</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @php $grandTotal = 0; @endphp

            @foreach($data as $res)
                @php
                    // HITUNG TOTAL PER RESERVATION DARI ITEM (lebih aman)
                    $totalPerReservation = $res->items->sum(function($item) {
                        return $item->price * $item->quantity;
                    });
                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}
                    </td>

                    <td class="text-left">{{ $res->name }}</td>

                    <td>{{ $res->invoice }}</td>

                    {{-- DETAIL PRODUK --}}
                    <td class="text-left">
                        @forelse($res->items as $item)
                            <div class="product-box">
                                <strong>{{ $item->product->name ?? 'Produk tidak ditemukan' }}</strong><br>

                                Qty: {{ $item->quantity }}<br>

                                Harga: Rp {{ number_format($item->price, 0, ',', '.') }}<br>

                                Subtotal:
                                <strong>
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </strong>
                            </div>
                        @empty
                            <span>Tidak ada produk</span>
                        @endforelse
                    </td>

                    <td>
                        Rp {{ number_format($totalPerReservation, 0, ',', '.') }}
                    </td>
                </tr>

                @php $grandTotal += $totalPerReservation; @endphp
            @endforeach

            {{-- GRAND TOTAL --}}
            <tr>
                <td colspan="5">
                    <strong>
                        Total Pendapatan Bulan 
                        {{ $month ? \Carbon\Carbon::parse($month)->format('F Y') : 'Semua' }}
                    </strong>
                </td>
                <td>
                    <strong>
                        Rp {{ number_format($grandTotal, 0, ',', '.') }}
                    </strong>
                </td>
            </tr>

        </tbody>
    </table>

</body>

</html>