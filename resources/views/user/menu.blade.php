@extends('layouts.app')

<div class="row g-4">
    @foreach($products as $product)
    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
        <div class="product-item">
            <!-- 1. Image Area & Badge -->
            <div class="position-relative bg-light overflow-hidden">
                <img class="img-fluid w-100" 
                     src="{{ asset('img/' . $product->image) }}" 
                     alt="{{ $product->name }}">
                <!-- Badge "New" di pojok kiri atas -->
                <div class="bg-secondary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">New</div>
            </div>

            <!-- 2. Product Info (Nama & Harga) -->
            <div class="text-center p-4">
                <a class="d-block h5 mb-2" href="">{{ $product->name }}</a>
                <span class="text-primary me-1">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                <!-- Harga coret (opsional, jika ada data diskon) -->
                <span class="text-body text-decoration-line-through">Rp {{ number_format($product->price + 5000, 0, ',', '.') }}</span>
            </div>

            <!-- 3. Action Buttons (View Detail & Add to Cart) -->
            <div class="d-flex border-top">
                <small class="w-50 text-center border-end py-2">
                    <a class="text-body" href="">
                        <i class="fa fa-eye text-primary me-2"></i>View detail
                    </a>
                </small>
                <small class="w-50 text-center py-2">
                    <a class="text-body" href="">
                        <i class="fa fa-shopping-bag text-primary me-2"></i>Add to cart
                    </a>
                </small>
            </div>
        </div>
    </div>
    @endforeach
</div>