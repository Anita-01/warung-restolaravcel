

@extends('layouts.app')

@section('content')
<div class="container-xxl py-5">
    <!-- Tambahkan justify-content-center di sini -->
    <div class="row g-0 justify-content-center">

        <!-- Ubah col-md-6 menjadi col-lg-6 atau col-md-8 sesuai selera lebar form -->
        <div class="col-md-8 col-lg-6 bg-dark d-flex align-items-center shadow-lg" style="border-radius: 15px; overflow: hidden;">
            <div class="p-5 w-100">

                <h5 class="text-primary text-center">Reservation</h5>
                <h1 class="text-white mb-4 text-center">Book A Table</h1>

                <form action="{{ route('reservation.store') }}" method="POST" id="reservationForm">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <input type="text" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Your Name"
                                value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-6">
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Your Email"
                                value="{{ old('email') }}" required>
                        </div>

                        <div class="col-md-12">
                            <input type="datetime-local" name="date"
                                id="dateInput"
                                class="form-control @error('date') is-invalid @enderror"
                                required>
                        </div>
                    </div>

                    <h4 class="text-white mb-3">Pilih Makanan</h4>

                    <div style="max-height:300px; overflow-y:auto;">
                        @forelse($products as $product)
                        <div class="card mb-2 p-3 border-0 shadow-sm">
                            <div class="d-flex justify-content-between">

                                <div>
                                    <h6>{{ $product->name }}</h6>
                                    <small>Rp {{ number_format($product->price) }}</small>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-danger btn-sm btn-minus" data-id="{{ $product->id }}">-</button>

                                    <input type="text"
                                        name="products[{{ $product->id }}]"
                                        id="qty-{{ $product->id }}"
                                        value="0"
                                        class="form-control text-center"
                                        style="width:50px"
                                        readonly>

                                    <button type="button" class="btn btn-success btn-sm btn-plus" data-id="{{ $product->id }}">+</button>
                                </div>

                            </div>
                        </div>
                        @empty
                        <p class="text-white">Belum ada menu</p>
                        @endforelse
                    </div>

                    <!-- TOTAL -->
                    <div class="mt-4 text-white border-top pt-3">
                        <div class="d-flex justify-content-between">
                            <h5>Total</h5>
                            <h5 id="totalPrice" class="text-warning">Rp 0</h5>
                        </div>
                        <input type="hidden" id="totalPriceInput" name="total_price">
                    </div>

                    <button class="btn btn-warning w-100 mt-3">BOOK NOW</button>

                </form>
            </div>
        </div>
    </div>
     <div class="mt-5">
        <a href="{{ route('index') }}" class="btn btn-back">
            ← Kembali
        </a>
    </div>

</div>

 
@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // ======================
    // MIN DATETIME (+1 JAM)
    // ======================
    let now = new Date();
    now.setHours(now.getHours() + 1);
    document.getElementById('dateInput').min = now.toISOString().slice(0,16);

    // ======================
    // DATA PRODUK
    // ======================
    const prices = @json($products->pluck('price','id'));
    const stocks = @json($products->pluck('qty','id'));
    const formatRupiah = (angka) => "Rp " + new Intl.NumberFormat("id-ID").format(angka);

    const updateTotal = () => {
        let total = 0;
        document.querySelectorAll('[id^="qty-"]').forEach(input => {
            let id = input.id.replace('qty-', '');
            let qty = parseInt(input.value) || 0;
            if (prices[id]) total += qty * prices[id];
        });
        document.getElementById('totalPrice').innerText = formatRupiah(total);
        document.getElementById('totalPriceInput').value = total;
    };

    // ======================
    // BUTTON PLUS MINUS
    // ======================
    document.addEventListener('click', function(e) {

       if (e.target.classList.contains('btn-plus')) {
    let id = e.target.dataset.id;
    let input = document.getElementById('qty-' + id);
    let current = parseInt(input.value);

    if (current >= stocks[id]) {
        Swal.fire('Stok Habis', 'Melebihi stok tersedia', 'warning');
        return;
    }

    input.value = current + 1;
    updateTotal();
}



    if (e.target.classList.contains('btn-minus')) {

        let id = e.target.dataset.id;
        let input = document.getElementById('qty-' + id);
        let current = parseInt(input.value);

        if (current <= 0) return;

        input.value = current - 1;
        updateTotal();
    }

    });

    // ======================
    // VALIDASI SUBMIT
    // ======================
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        let total = parseInt(document.getElementById('totalPriceInput').value) || 0;

        if (total <= 0) {
            e.preventDefault();
            Swal.fire('Oops!', 'Pilih minimal 1 menu', 'warning');
        }
    });

    // ======================
    // ERROR LARAVEL
    // ======================
    @if($errors->any())
        Swal.fire('Error', `{!! implode("<br>", $errors->all()) !!}`, 'error');
    @endif

    // ======================
    // SUCCESS
    // ======================
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        html: `
            {{ session('success') }}<br>
            <b>Antrian: {{ session('queue_number') }}</b><br>
            Estimasi: {{ session('estimate') }} menit
        `,
        confirmButtonText: 'Lihat Detail'
    }).then(() => {
        window.location.href = "{{ route('reservation.detail', session('reservation_id')) }}";
    });
    @endif

});
</script>

@endsection