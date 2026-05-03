@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Tambah Product</h3>

    <form action="{{ route('createProducts') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

       <div class="mb-3">
    <label>Kategori</label>

    <select name="category_id" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>

        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">
                {{ $cat->name }}
            </option>
        @endforeach

    </select>
</div>
        <div class="mb-3">
            <label>Qty</label>
            <input type="number" name="qty" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>
@endsection