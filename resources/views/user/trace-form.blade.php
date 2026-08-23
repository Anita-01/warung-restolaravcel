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
            display: flex;
            align-items: center;
            padding: 40px 0;
        }

        .ticket-stage {
            position: relative;
            max-width: 520px;
            margin: 0 auto;
        }

        .ticket-shadow-a,
        .ticket-shadow-b {
            position: absolute;
            inset: 0;
            background: #fff;
            border-radius: 16px;
        }

        .ticket-shadow-a {
            transform: rotate(-4deg);
            box-shadow: 0 6px 20px rgba(18, 40, 58, 0.08);
        }

        .ticket-shadow-b {
            transform: rotate(3deg);
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
            padding: 38px 40px 32px;
            text-align: center;
            color: #fff;
        }

        .ticket-kicker {
            font-family: 'Pacifico', cursive;
            font-size: 19px;
            color: #FDBB55;
            display: block;
            margin-bottom: 6px;
        }

        .ticket-head h2 {
            font-family: 'Lora', serif !important;
            font-weight: 700 !important;
            font-size: 32px !important;
            color: #FFFFFF !important;
            margin: 0 0 8px !important;
            line-height: 1.25;
        }

        .ticket-head p {
            font-family: 'Nunito', sans-serif;
            color: rgba(255, 255, 255, 0.75);
            font-size: 15px;
            margin: 0;
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
            padding: 34px 40px 10px;
            font-family: 'Nunito', sans-serif;
        }

        .ticket-field {
            margin-bottom: 22px;
        }

        .ticket-field label {
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #3D5164;
            display: block;
            margin-bottom: 8px;
        }

        .ticket-field .form-control {
            border: none;
            border-bottom: 2px solid #FFE3B8;
            border-radius: 0;
            padding: 10px 2px;
            font-size: 17px;
            font-family: 'Heebo', sans-serif;
            letter-spacing: 0.03em;
            color: #12283A;
            background: transparent;
        }

        .ticket-field .form-control:focus {
            border-bottom-color: #FDA125;
            box-shadow: none;
        }

        .ticket-field .form-control::placeholder {
            color: #B7AA8F;
            letter-spacing: normal;
            font-family: 'Nunito', sans-serif;
        }

        .btn-track {
            background: #FDA125;
            color: #12283A;
            border: none;
            border-radius: 9px;
            padding: 14px;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 16px;
            width: 100%;
            margin-top: 8px;
            transition: transform 0.15s, background 0.2s;
        }

        .btn-track:hover {
            background: #E8790A;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-track:active {
            transform: translateY(0);
        }

        .ticket-jag {
            height: 14px;
            margin: 0 -1px;
            background:
                radial-gradient(circle at 14px 0, transparent 14px, #fff 14px) 0 -7px / 28px 14px repeat-x;
        }

        .ticket-foot {
            text-align: center;
            padding: 6px 40px 30px;
            font-family: 'Nunito', sans-serif;
        }

        .ticket-foot small {
            color: #7D7362;
            font-size: 13px;
            font-weight: 500;
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

            <div class="ticket-stage">

                <div class="ticket-shadow-a"></div>
                <div class="ticket-shadow-b"></div>

                <div class="ticket-card">

                    {{-- HEAD --}}
                    <div class="ticket-head">
                        <span class="ticket-kicker">warung muslim lia</span>
                        <h2>Lacak pesanan</h2>
                        <p>Masukkan invoice dan email untuk melihat status</p>
                    </div>

                    <div class="ticket-perforation"></div>

                    {{-- BODY --}}
                    <div class="ticket-body">

                        <form action="{{ route('trace.confirm') }}" method="POST">
                            @csrf

                            <div class="ticket-field">
                                <label>No. Invoice</label>
                                <input type="text" name="antrian" class="form-control" placeholder="INV-000123">
                            </div>

                            <div class="ticket-field">
                                <label>Email Pemesan</label>
                                <input type="email" name="email" class="form-control" placeholder="nama@email.com">
                            </div>

                            <button class="btn-track">
                                Lacak sekarang
                            </button>
                        </form>

                        @if(session('error'))
                            <div class="alert alert-danger mt-3 mb-0" style="border-radius: 8px; font-size: 14px;">
                                {{ session('error') }}
                            </div>
                        @endif

                    </div>

                    <div class="ticket-jag"></div>

                    <div class="ticket-foot">
                        <small>Simpan invoice ini sampai pesanan Anda selesai</small>
                    </div>

                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('index') }}" class="back-link">
                    <i class="fa fa-arrow-left"></i>
                    Kembali ke dashboard
                </a>
            </div>

        </div>
    </div>
@endsection