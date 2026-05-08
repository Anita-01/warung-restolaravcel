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
            margin-bottom: 20px;
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
        }

        .text-left {
            text-align: left;
        }
    </style>
</head>

<body>

    <h2>LAPORAN RESERVASI (COMPLETED)</h2>

@if($month)
    <p style="text-align:center;">
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
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}
                </td>

                <td class="text-left">{{ $res->name }}</td>

                <td>{{ $res->invoice }}</td>

                <td class="text-left">
                    @foreach($res->items as $item)
                        {{ $item->product->name }} (x{{ $item->quantity }})<br>
                    @endforeach
                </td>

                <td>
                    Rp {{ number_format($res->total_price, 0, ',', '.') }}
                </td>
            </tr>

            @php $grandTotal += $res->total_price; @endphp
            @endforeach

            <!-- TOTAL -->
            <tr>
                <td colspan="5"><strong>TOTAL</strong></td>
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