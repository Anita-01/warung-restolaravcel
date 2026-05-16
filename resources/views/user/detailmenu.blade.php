@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-6 text-center">

                {{-- IMAGE --}}
                @if($product->image && file_exists(public_path('img/' . $product->image)))
                    <img src="{{ asset('img/' . $product->image) }}" class="img-fluid rounded mb-4"
                        style="max-height:300px; object-fit:cover;" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded mb-4"
                        style="max-height:300px; object-fit:cover;" alt="No Image">
                @endif

                {{-- NAME --}}
                <h2 class="fw-bold">{{ $product->name }}</h2>

                {{-- CATEGORY --}}
                <p class="text-muted">
                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                </p>

                {{-- PRICE --}}
                <h4 class="text-primary mb-3">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </h4>

                {{-- STOCK --}}
                <p class="fw-semibold">
                    Stok tersedia:
                    <span class="text-success">{{ $product->qty }}</span>
                </p>

                {{-- BACK BUTTON --}}
                <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
                    ← Kembali
                </a>

            </div>
        </div>

    </div>
@endsection