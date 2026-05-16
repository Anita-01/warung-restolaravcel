@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h3>Tambah Product</h3>

        <form action="{{ route('createProducts') }}" method="POST" enctype="multipart/form-data">

            @csrf

            {{-- ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- NAMA --}}
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            {{-- KATEGORI --}}
            <div class="mb-3">
                <label>Kategori</label>
                <select name="category_id" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>

                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- QTY --}}
            <div class="mb-3">
                <label>Qty</label>
                <input type="number" name="qty" class="form-control" value="{{ old('qty') }}" required>
            </div>

            {{-- PRICE --}}
            <div class="mb-3">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>

            {{-- IMAGE --}}
            <div class="mb-3">
                <label>Foto Product</label>

                <input type="file" name="image" class="form-control">

                <small class="text-muted">
                    Format: jpg, jpeg, png (max 2MB)
                </small>
            </div>

            {{-- BUTTON --}}
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>

        </form>

    </div>
@endsection