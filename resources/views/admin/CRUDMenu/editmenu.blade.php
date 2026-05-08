@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Product</h5>
        </div>

        <div class="card-body">

            <form id="formUpdate" action="{{ route('admin.products.update', $product->id) }}" method="POST">
                @csrf

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
                </div>

                <!-- KATEGORI -->
                <div class="mb-3">
                    <label class="form-label">Kategori</label>

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

                <!-- QTY -->
                <div class="mb-3">
                    <label class="form-label">Qty</label>
                    <input type="number" name="qty" value="{{ $product->qty }}" class="form-control" required>
                </div>

                <!-- PRICE -->
                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" value="{{ $product->price }}" class="form-control" required>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.products.view') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>

                    <button type="submit" id="btnUpdate" class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection

{{-- ================= SCRIPT ================= --}}
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// ================= CONFIRM + LOADING =================
document.getElementById('formUpdate').addEventListener('submit', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Yakin update?',
        text: "Data akan diperbarui!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, update!'
    }).then((result) => {

        if (result.isConfirmed) {

            // disable button + loading
            let btn = document.getElementById('btnUpdate');
            btn.disabled = true;
            btn.innerHTML = 'Loading...';

            this.submit(); // lanjut submit
        }
    });
});


// ================= SUCCESS ALERT =================
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session('success') }}',
    showConfirmButton: false,
    timer: 2000
});
@endif
</script>
@endsection