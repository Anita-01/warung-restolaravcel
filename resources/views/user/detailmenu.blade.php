@php
    $hideHeader = true;
    $hideFooter = true;
@endphp


@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                    {{-- IMAGE --}}
                    <div class="bg-light position-relative" style="height:320px;">
                        @if($product->image && file_exists(public_path('storage/' . $product->image)))
                            <img src="{{ asset('storage/' . $product->image) }}"
                                class="w-100 h-100"
                                style="object-fit:cover;" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('img/no-image.png') }}"
                                class="w-100 h-100"
                                style="object-fit:cover;" alt="No Image">
                        @endif

                        {{-- CATEGORY OVERLAY --}}
                        <span class="position-absolute top-0 start-0 m-3 badge bg-dark bg-opacity-75 rounded-pill px-3 py-2">
                            {{ $product->category->name ?? 'Tanpa Kategori' }}
                        </span>
                    </div>

                    <div class="card-body p-4">

                        {{-- NAME --}}
                        <h2 class="fw-bold mb-1 text-center">{{ $product->name }}</h2>

                        {{-- PRICE --}}
                        <h3 class="text-primary fw-bold text-center mb-4">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </h3>

                        <hr>

                        {{-- STOCK --}}
                        <div class="d-flex justify-content-between align-items-center bg-light rounded-3 p-3 mb-4">
                            <span class="fw-semibold text-dark">
                                <i class="bi bi-box-seam me-2"></i>Stok tersedia
                            </span>

                            @if($product->qty > 0)
                                <span class="badge bg-success rounded-pill px-3 py-2 fs-6 text-white">
                                    {{ $product->qty }} unit
                                </span>
                            @else
                                <span class="badge bg-danger rounded-pill px-3 py-2 fs-6 text-white">
                                    Stok Habis
                                </span>
                            @endif
                        </div>

                        {{-- BACK BUTTON --}}
                        <div class="text-center">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">
                                ← Kembali
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection