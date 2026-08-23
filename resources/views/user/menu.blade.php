@php
    $hideHeader = true;
    $hideFooter = true;
@endphp

@extends('layouts.app')

@section('styles')
    <style>
        body {
            background-color: #fff8f0;
        }

        .menu-header {
            background: linear-gradient(135deg, #0d1b2a 0%, #1b2f45 50%, #0d1b2a 100%);
            border-radius: 16px;
            padding: 45px 20px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(13, 27, 42, 0.35);
            border: 1px solid rgba(254, 161, 22, 0.25);
        }

        .menu-icon {
            font-size: 28px;
            color: #FEA116;
            background: rgba(254, 161, 22, 0.12);
            width: 60px;
            height: 60px;
            line-height: 60px;
            border-radius: 50%;
            margin: 0 auto;
            border: 2px solid rgba(254, 161, 22, 0.4);
            position: relative;
            z-index: 1;
        }

        .menu-header h1 {
            color: #fff;
            font-weight: 700;
            position: relative;
            z-index: 1;
            letter-spacing: 0.5px;
        }

        .menu-header h1 .text-highlight {
            color: #FEA116;
            text-shadow: 0 0 20px rgba(254, 161, 22, 0.5);
        }

        .menu-header p {
            color: rgba(255, 255, 255, 0.75);
            margin: 0;
            position: relative;
            z-index: 1;
            font-size: 15px;
        }

        .orange-divider {
            height: 4px;
            background: linear-gradient(90deg, #FEA116, #ff8c00, #FEA116);
            border-radius: 4px;
            opacity: 0.5;
        }

        .product-item {
            transition: transform 0.3s, box-shadow 0.3s;
            background: #fff;
            border-color: #ffe0b2 !important;
        }

        .product-item:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 24px rgba(254, 161, 22, 0.25) !important;
            border-color: #FEA116 !important;
        }

        .product-item .bg-secondary {
            background-color: #FEA116 !important;
        }

        .product-item .border-top {
            border-color: #ffe0b2 !important;
            background-color: #fff8f0;
        }

        .product-item .border-top small a:hover {
            color: #FEA116 !important;
        }

        .btn-back {
            background-color: #FEA116;
            color: white;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s;
            font-weight: 500;
        }

        .btn-back:hover {
            background-color: #e08c00;
            color: white;
        }
    </style>
@endsection


@section('content')
    <div class="container py-5">

        {{-- HEADER --}}
        <div class="menu-header text-center mx-auto mb-2" style="max-width: 700px;">
            <div class="menu-icon mb-2">
                <i class="fa fa-utensils"></i>
            </div>
            <h1 class="display-5 mb-3">Menu <span class="text-highlight">Kami</span></h1>
            <p>
                Pilihan makanan terbaik dengan cita rasa khas dan bahan berkualitas.
            </p>
        </div>

        {{-- DIVIDER --}}
        <div class="orange-divider mx-auto mb-5" style="max-width: 200px;"></div>

        {{-- PRODUCT --}}
        <div class="row g-4">

            @foreach($products as $product)

                <div class="col-xl-3 col-lg-4 col-md-6">

                    <div class="product-item border rounded shadow-sm h-100">

                        {{-- IMAGE --}}
                        <div class="position-relative bg-light overflow-hidden">

                            @if($product->image)

                                <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}" style="height: 220px; object-fit: cover;">

                            @else

                                <img class="img-fluid w-100" src="{{ asset('img/no-image.png') }}" alt="No Image"
                                    style="height: 220px; object-fit: cover;">

                            @endif


                            {{-- BADGE --}}
                            <div class="bg-secondary rounded text-white position-absolute start-0 top-0 m-3 py-1 px-3">
                                New
                            </div>

                        </div>


                        {{-- PRODUCT INFO --}}
                        <div class="text-center p-4">

                            <h5 class="mb-2">
                                {{ $product->name }}
                            </h5>

                            <p class="text-muted mb-2">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                            </p>

                            <span class="text-primary fw-bold me-2">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>

                            <span class="text-body text-decoration-line-through">
                                Rp {{ number_format($product->price + 5000, 0, ',', '.') }}
                            </span>

                        </div>


                        {{-- ACTION BUTTON --}}
                        <div class="d-flex border-top">

                            <small class="w-50 text-center border-end py-2">

                                <a class="text-body text-decoration-none" href="{{ route('menu.detail', $product->id) }}">

                                    <i class="fa fa-eye text-primary me-2"></i>
                                    View Detail

                                </a>

                            </small>


                            <small class="w-50 text-center py-2">

                                <a href="{{ route('reserved') }}" class="text-body text-decoration-none">

                                    <i class="fa fa-shopping-bag text-primary me-2"></i>
                                    Add to Cart

                                </a>

                            </small>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- BUTTON KEMBALI --}}
        <div class="mt-5">

            <a href="{{ route('index') }}" class="btn btn-back">
                ← Kembali
            </a>

        </div>

    </div>
@endsection