@extends('layouts.app')

@section('content')

<div class="container py-5">

    {{-- HEADER --}}
    <div class="text-center mx-auto mb-5" style="max-width: 500px;">
        <h1 class="display-5 mb-3">Menu Kami</h1>

        <p class="text-muted">
            Pilihan makanan terbaik dengan cita rasa khas dan bahan berkualitas.
        </p>
    </div>

    {{-- PRODUCT --}}
    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="product-item border rounded shadow-sm h-100">

                    {{-- IMAGE --}}
                    <div class="position-relative bg-light overflow-hidden">
                        @if($product->photo)
                            <img class="img-fluid w-100"
                                 src="{{ asset('storage/' . $product->photo) }}"
                                 alt="{{ $product->name }}"
                                 style="height: 220px; object-fit: cover;">
                        @else
                            <img class="img-fluid w-100"
                                 src="{{ asset('img/no-image.png') }}"
                                 alt="No Image"
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
                            <a class="text-body text-decoration-none" href="#">
                                <i class="fa fa-eye text-primary me-2"></i>
                                View Detail
                            </a>
                        </small>

                        <small class="w-50 text-center py-2">
                            <a class="text-body text-decoration-none" href="#">
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

{{-- STYLE --}}
<style>
    .btn-back {
        background-color: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        transition: 0.3s;
        font-weight: 500;
    }

    .btn-back:hover {
        background-color: red;
        color: white;
    }
</style>

@endsection