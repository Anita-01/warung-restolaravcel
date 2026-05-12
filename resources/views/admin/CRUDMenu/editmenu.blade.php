@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Edit Product</h3>

    <form action="{{ route('updateProduct') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" value="{{ $product->id }}">

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" 
                   name="name" 
                   class="form-control" 
                   value="{{ $product->name }}" 
                   required>
        </div>

        <div class="mb-3">
            <label>Kategori</label>

            <select name="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>

                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}"
                        {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Qty</label>
            <input type="number" 
                   name="qty" 
                   class="form-control" 
                   value="{{ $product->qty }}" 
                   required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" 
                   name="price" 
                   class="form-control" 
                   value="{{ $product->price }}" 
                   required>
        </div>

        <div class="mb-3">
            <label>Foto Product</label>

            @if($product->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->photo) }}"
                         width="120"
                         height="120"
                         style="object-fit: cover; border-radius: 8px;">
                </div>
            @else
                <p class="text-muted mb-2">Belum ada foto</p>
            @endif

            <input type="file" 
                   name="photo" 
                   class="form-control">

            <small class="text-muted">
                Kosongkan jika tidak ingin mengganti foto.
            </small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection