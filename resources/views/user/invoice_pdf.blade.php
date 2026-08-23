<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $reservation->queue_number }}</title>
    <style>
        /* NOTE: kept to dompdf-safe CSS — table-based layout, web-safe fonts,
           no flexbox/grid, minimal box-shadow — so it renders reliably as PDF. */

        @page {
            margin: 28px 34px;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            color: #2B2B2B;
            font-size: 12px;
            margin: 0;
        }

        .brand-name {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 20px;
            font-weight: bold;
            color: #1E2A4A;
            margin: 0;
        }

        .brand-tagline {
            font-size: 9px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #6B4226;
            margin: 2px 0 0 0;
        }

        .mark {
            width: 34px;
            height: 34px;
            background-color: #D9A441;
            color: #1E2A4A;
            font-family: Georgia, serif;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
            vertical-align: middle;
            border-radius: 6px;
        }

        /* ---------- Header table ---------- */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .header-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }

        .invoice-title {
            font-family: Georgia, serif;
            font-size: 22px;
            font-weight: bold;
            color: #1E2A4A;
            text-align: right;
            margin: 0;
        }

        .invoice-meta {
            text-align: right;
            font-size: 10px;
            color: #7a7a7a;
            margin-top: 4px;
        }

        .invoice-meta strong {
            color: #2B2B2B;
        }

        .divider {
            border-bottom: 2px solid #D9A441;
            margin-bottom: 16px;
        }

        /* ---------- Customer info box ---------- */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #FAF6EC;
            margin-bottom: 20px;
        }

        .info-table td {
            border: none;
            padding: 10px 14px;
            font-size: 11px;
            vertical-align: top;
        }

        .info-label {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6B4226;
            margin-bottom: 2px;
        }

        .info-value {
            font-weight: bold;
            color: #2B2B2B;
        }

        .queue-box {
            background-color: #1E2A4A;
            color: #FBF7EF;
            text-align: center;
            padding: 8px 14px;
        }

        .queue-box .info-label {
            color: #D9A441;
        }

        .queue-box .info-value {
            color: #FBF7EF;
            font-size: 16px;
        }

        /* ---------- Items table ---------- */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        table.items thead th {
            background-color: #1E2A4A;
            color: #FBF7EF;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 10px;
            border: 1px solid #1E2A4A;
        }

        table.items thead th.text-left {
            text-align: left;
        }

        table.items tbody td {
            padding: 7px 10px;
            border: 1px solid #eae4d6;
            font-size: 11px;
        }

        table.items tbody tr:nth-child(even) td {
            background-color: #FBF7EF;
        }

        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* ---------- Total ---------- */
        table.total-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        table.total-table td {
            border: none;
            padding: 6px 10px;
            font-size: 11px;
        }

        table.total-table tr.grand-total td {
            background-color: #D9A441;
            color: #1E2A4A;
            font-weight: bold;
            font-size: 14px;
            padding: 10px;
        }

        /* ---------- Footer ---------- */
        .footer-note {
            margin-top: 26px;
            text-align: center;
            font-size: 10px;
            color: #9a9a9a;
            border-top: 1px solid #eae4d6;
            padding-top: 12px;
        }

        .footer-note strong {
            color: #6B4226;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <table class="header-table">
        <tr>
            <td style="width:44px;">
                <table style="border-collapse:collapse;">
                    <tr><td class="mark">WML</td></tr>
                </table>
            </td>
            <td style="padding-left:10px;">
                <p class="brand-name">Warung Muslim Lia</p>
                <p class="brand-tagline">Invoice Reservasi</p>
            </td>
            <td style="width:45%;">
                <p class="invoice-title">INVOICE</p>
                <p class="invoice-meta">
                    No. Antrian <strong>{{ $reservation->queue_number }}</strong><br>
                    Tanggal <strong>{{ \Carbon\Carbon::parse($reservation->reservation_date)->translatedFormat('d F Y') }}</strong>
                </p>
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- Customer info --}}
    <table class="info-table">
        <tr>
            <td style="width:38%;">
                <span class="info-label">Nama Pelanggan</span>
                <span class="info-value">{{ $reservation->name }}</span>
            </td>
            <td style="width:38%;">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $reservation->email }}</span>
            </td>
            <td class="queue-box" style="width:24%;">
                <span class="info-label">No. Antrian</span>
                <span class="info-value">{{ $reservation->queue_number }}</span>
            </td>
        </tr>
    </table>

    {{-- Items --}}
    <table class="items">
        <thead>
            <tr>
                <th class="text-left">Produk</th>
                <th class="text-right" style="width:110px;">Harga</th>
                <th class="text-center" style="width:60px;">Qty</th>
                <th class="text-right" style="width:120px;">Subtotal</th>
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
                    <td class="text-left">{{ $item->product->name }}</td>
                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Total --}}
    <table class="total-table">
        <tr>
            <td style="width:70%;"></td>
            <td class="text-right" style="width:30%; color:#7a7a7a;">Total Pembayaran</td>
        </tr>
        <tr class="grand-total">
            <td style="width:70%;"></td>
            <td class="text-right" style="width:30%;">Rp {{ number_format($total, 0, ',', '.') }}</td>
        </tr>
    </table>

    {{-- Footer --}}
    <div class="footer-note">
        Terima kasih telah memesan di <strong>Warung Muslim Lia</strong>. Mohon tunjukkan invoice ini saat pengambilan pesanan.
    </div>

</body>

</html>