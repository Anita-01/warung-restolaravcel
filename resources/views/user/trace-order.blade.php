@php
    $hideHeader = true;
    $hideFooter = true;
@endphp

@extends('layouts.app')

@section('styles')
    <style>
        body {
            background-color: #FFF6EA;
            background-image: radial-gradient(rgba(18, 40, 58, 0.06) 1px, transparent 1px);
            background-size: 18px 18px;
        }

        .track-wrapper {
            min-height: 84vh;
            padding: 40px 0;
        }

        .ticket-stage {
            position: relative;
            max-width: 560px;
            margin: 0 auto 34px;
        }

        .ticket-shadow-a,
        .ticket-shadow-b {
            position: absolute;
            inset: 0;
            background: #fff;
            border-radius: 16px;
        }

        .ticket-shadow-a {
            transform: rotate(-3deg);
            box-shadow: 0 6px 20px rgba(18, 40, 58, 0.08);
        }

        .ticket-shadow-b {
            transform: rotate(2deg);
            box-shadow: 0 6px 20px rgba(254, 161, 22, 0.10);
        }

        .ticket-card {
            position: relative;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(18, 40, 58, 0.18);
            animation: ticket-drop 0.5s cubic-bezier(0.2, 0.7, 0.3, 1);
        }

        @keyframes ticket-drop {
            from {
                opacity: 0;
                transform: translateY(14px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ticket-head {
            background: #12283A;
            border-radius: 16px 16px 0 0;
            padding: 30px 40px 26px;
            text-align: center;
            color: #fff;
        }

        .ticket-kicker {
            font-family: 'Pacifico', cursive;
            font-size: 17px;
            color: #FDBB55;
            display: block;
            margin-bottom: 6px;
        }

        .ticket-head h2 {
            font-family: 'Lora', serif !important;
            font-weight: 700 !important;
            font-size: 26px !important;
            color: #FFFFFF !important;
            margin: 0 0 4px !important;
            line-height: 1.25;
        }

        .ticket-head .ticket-queue {
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 15px;
            letter-spacing: 0.08em;
            color: #FDA125;
            background: rgba(253, 161, 37, 0.12);
            display: inline-block;
            padding: 5px 14px;
            border-radius: 20px;
            margin-top: 6px;
        }

        .ticket-perforation {
            position: relative;
            height: 1px;
            background: repeating-linear-gradient(90deg, rgba(18, 40, 58, 0.18) 0 6px, transparent 6px 12px);
            margin: 0 28px;
        }

        .ticket-perforation::before,
        .ticket-perforation::after {
            content: "";
            position: absolute;
            top: -10px;
            width: 20px;
            height: 20px;
            background: #FFF6EA;
            border-radius: 50%;
        }

        .ticket-perforation::before {
            left: -38px;
        }

        .ticket-perforation::after {
            right: -38px;
        }

        .ticket-body {
            padding: 26px 40px 6px;
            font-family: 'Nunito', sans-serif;
        }

        .ticket-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .ticket-field label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #3D5164;
            display: block;
            margin-bottom: 4px;
        }

        .ticket-field .val {
            font-size: 16px;
            font-family: 'Heebo', sans-serif;
            color: #12283A;
            font-weight: 600;
        }

        .ticket-status-wrap {
            text-align: center;
            margin: 4px 0 18px;
        }

        .ticket-badge {
            display: inline-block;
            padding: 8px 22px;
            border-radius: 30px;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 14px;
            letter-spacing: 0.03em;
            color: #fff;
        }

        .ticket-badge.bg-warning { background: #FDA125; color: #12283A; }
        .ticket-badge.bg-info { background: #2E9CCA; }
        .ticket-badge.bg-primary { background: #3D5CD8; }
        .ticket-badge.bg-success { background: #2FA96A; }
        .ticket-badge.bg-dark { background: #12283A; }
        .ticket-badge.bg-danger { background: #D9534F; }

        .ticket-items-title {
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #3D5164;
            margin-bottom: 10px;
        }

        .ticket-items {
            list-style: none;
            padding: 0;
            margin: 0 0 6px;
        }

        .ticket-items li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #FFE3B8;
            font-size: 15px;
            color: #12283A;
        }

        .ticket-items li:last-child {
            border-bottom: none;
        }

        .ticket-items li span.qty {
            color: #7D7362;
            font-weight: 600;
        }

        .ticket-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0 4px;
            font-family: 'Nunito', sans-serif;
        }

        .ticket-total .label {
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #3D5164;
        }

        .ticket-total .amount {
            font-size: 20px;
            font-weight: 800;
            color: #12283A;
        }

        .ticket-jag {
            height: 14px;
            margin: 0 -1px;
            background:
                radial-gradient(circle at 14px 0, transparent 14px, #fff 14px) 0 -7px / 28px 14px repeat-x;
        }

        .ticket-foot {
            text-align: center;
            padding: 6px 40px 26px;
            font-family: 'Nunito', sans-serif;
        }

        .ticket-foot small {
            color: #7D7362;
            font-size: 13px;
            font-weight: 500;
        }

        .empty-card {
            position: relative;
            max-width: 520px;
            margin: 0 auto 34px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 45px rgba(18, 40, 58, 0.18);
            padding: 40px;
            text-align: center;
            font-family: 'Nunito', sans-serif;
        }

        .empty-card .empty-icon {
            font-size: 34px;
            color: #FDA125;
            margin-bottom: 14px;
        }

        .empty-card h5 {
            font-family: 'Lora', serif;
            font-weight: 700;
            color: #12283A;
        }

        .empty-card p {
            color: #7D7362;
            font-size: 14px;
            margin: 0;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #12283A;
            color: #FFFFFF !important;
            font-weight: 700;
            font-family: 'Nunito', sans-serif;
            font-size: 15px;
            text-decoration: none;
            padding: 12px 26px;
            border-radius: 9px;
            box-shadow: 0 6px 16px rgba(18, 40, 58, 0.22);
            transition: background 0.2s, transform 0.15s;
        }

        .back-link:hover {
            background: #E8790A;
            color: #fff;
            transform: translateY(-1px);
        }

        .back-link:active {
            transform: translateY(0);
        }

        @media (prefers-reduced-motion: reduce) {
            .ticket-card {
                animation: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container track-wrapper">
        <div class="w-100">

            @if($reservations->isEmpty())

                <div class="empty-card">
                    <div class="empty-icon"><i class="fa fa-search"></i></div>
                    <h5>Data reservation tidak ditemukan</h5>
                    <p>Periksa kembali nomor invoice dan email yang dimasukkan</p>
                </div>

            @else

                @foreach($reservations as $reservation)

                    <div class="ticket-stage">

                        <div class="ticket-shadow-a"></div>
                        <div class="ticket-shadow-b"></div>

                        <div class="ticket-card">

                            {{-- HEAD --}}
                            <div class="ticket-head">
                                <span class="ticket-kicker">warung muslim lia</span>
                                <h2>Invoice: {{ $reservation->invoice }}</h2>
                                <span class="ticket-queue">
                                    ANTRIAN A{{ str_pad($reservation->queue_number, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>

                            <div class="ticket-perforation"></div>

                            {{-- BODY --}}
                            <div class="ticket-body">

                                <div class="ticket-row">
                                    <div class="ticket-field">
                                        <label>Nama Pemesan</label>
                                        <div class="val">{{ $reservation->name }}</div>
                                    </div>
                                    <div class="ticket-field text-end">
                                        <label>Total</label>
                                        <div class="val">Rp {{ number_format($reservation->total_price) }}</div>
                                    </div>
                                </div>

                                <div class="ticket-status-wrap">
                                    <span
                                        id="status-badge-{{ $reservation->invoice }}"
                                        class="ticket-badge
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
                                </div>

                                <div class="ticket-perforation" style="margin-bottom: 18px;"></div>

                                <div class="ticket-items-title">Pesanan</div>
                                <ul class="ticket-items">
                                    @foreach($reservation->items as $item)
                                        <li>
                                            <span>{{ $item->product->name }}</span>
                                            <span class="qty">{{ $item->quantity }}x</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="ticket-perforation"></div>

                                <div class="ticket-total">
                                    <span class="label">Total Bayar</span>
                                    <span class="amount">Rp {{ number_format($reservation->total_price) }}</span>
                                </div>

                            </div>

                            <div class="ticket-jag"></div>

                            <div class="ticket-foot">
                                <small>Simpan invoice ini sampai pesanan Anda selesai</small>
                            </div>

                        </div>
                    </div>

                @endforeach

            @endif

            <div class="text-center mt-2">
                <a href="{{ route('index') }}" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                    Kembali ke dashboard
                </a>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script>
        console.log("DETAIL PAGE SCRIPT JALAN");

        const badgeClassMap = {
            pending: 'bg-warning',
            confirmed: 'bg-info',
            in_preparation: 'bg-primary',
            served: 'bg-success',
            completed: 'bg-dark',
        };

        function updateStatus(invoice) {
            fetch(`/api/reservation-status/${invoice}`)
                .then(res => res.json())
                .then(data => {

                    let badge = document.getElementById(`status-badge-${invoice}`);
                    if (!badge || !data.status) return;

                    let status = data.status;

                    badge.className = "ticket-badge";
                    badge.classList.add(badgeClassMap[status] || 'bg-danger');

                    badge.innerHTML = status.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase());
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
@endsection