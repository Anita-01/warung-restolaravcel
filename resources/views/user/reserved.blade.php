@extends('layouts.app')

@section('content')
<!-- Reservation Start -->
<div class="container-xxl py-5 px-0">
    <div class="row g-0">

        <!-- LEFT SIDE (VIDEO) -->
        <div class="col-md-6">
            <div class="video" style="background: linear-gradient(rgba(15, 23, 43, .1), rgba(15, 23, 43, .1)), url('https://img.youtube.com/vi/DWRcNpR6Kdc/maxresdefault.jpg'); background-size: cover; height: 100%; min-height: 400px; display: flex; align-items: center; justify-content: center;">
                <button type="button" class="btn-play" data-bs-toggle="modal"
                    data-src="https://www.youtube.com/embed/DWRcNpR6Kdc"
                    data-bs-target="#videoModal">
                    <span></span>
                </button>
            </div>
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-md-6 bg-dark d-flex align-items-center">
            <div class="p-5 w-100">
                <h5 class="text-primary fw-normal text-start">Reservation</h5>
                <h1 class="text-white mb-4">Book A Table Online</h1>

                <!-- FORM START -->
                <form action="{{ route('reservation.store') }}" method="POST" id="reservationForm">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                placeholder="Your Name" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                placeholder="Your Email" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-12">
                            <input type="datetime-local" name="date" class="form-control @error('date') is-invalid @enderror" 
                                value="{{ old('date') }}" required>
                        </div>
                    </div>

                    <h4 class="text-white mb-3">Pilih Makanan</h4>
                    
                    <div class="product-list" style="max-height: 300px; overflow-y: auto; padding-right: 10px;">
                        @forelse($products as $product)
                        <div class="card mb-3 p-3 border-0 shadow-sm">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1 text-dark">{{ $product->name }}</h6>
                                    <small class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                                </div>

                                <div class="d-flex align-items-center gap-2">
                                    <button type="button" class="btn btn-danger btn-sm btn-minus" data-id="{{ $product->id }}">-</button>
                                    <input type="text" name="products[{{ $product->id }}]" id="qty-{{ $product->id }}"
                                        value="{{ old('products.' . $product->id, 0) }}"
                                        class="form-control text-center bg-white" style="width: 50px; font-weight: bold;" readonly>
                                    <button type="button" class="btn btn-success btn-sm btn-plus" data-id="{{ $product->id }}">+</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-light text-center">Belum ada menu tersedia.</div>
                        @endforelse
                    </div>

                    <div class="mt-4 text-white border-top border-secondary pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Total Bayar:</h4>
                            <h4 id="totalPrice" class="text-warning mb-0">Rp 0</h4>
                        </div>
                        <input type="hidden" name="total_price" id="totalPriceInput" value="0">
                    </div>

                    <button type="submit" class="btn btn-warning w-100 py-3 mt-4 fw-bold">BOOK NOW</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- MODAL VIDEO -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-0">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="ratio ratio-16x9">
                    <iframe id="videoIframe" src="" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const prices = @json($products->pluck('price','id'));

    const formatRupiah = (angka) => {
        return "Rp " + new Intl.NumberFormat("id-ID").format(angka);
    };

    const updateTotal = () => {
        let total = 0;
        document.querySelectorAll('input[id^="qty-"]').forEach(input => {
            const id = input.id.replace('qty-', '');
            const qty = parseInt(input.value) || 0;
            if (prices[id]) total += qty * prices[id];
        });
        document.getElementById('totalPrice').innerText = formatRupiah(total);
        document.getElementById('totalPriceInput').value = total;
    };

    // Plus/Minus Buttons
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-plus')) {
            const id = e.target.dataset.id;
            const input = document.getElementById('qty-' + id);
            input.value = parseInt(input.value) + 1;
            updateTotal();
        }
        if (e.target.classList.contains('btn-minus')) {
            const id = e.target.dataset.id;
            const input = document.getElementById('qty-' + id);
            if (parseInt(input.value) > 0) {
                input.value = parseInt(input.value) - 1;
                updateTotal();
            }
        }
    });

    updateTotal();

    // SweetAlert Validasi Form
    document.getElementById('reservationForm').addEventListener('submit', function(e) {
        const totalAmount = parseInt(document.getElementById('totalPriceInput').value) || 0;
        
        if (totalAmount <= 0) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Silahkan pilih minimal satu menu makanan sebelum memesan!',
                confirmButtonColor: '#FEA116'
            });
        }
    });

    // Menampilkan Pesan Error dari Laravel Session (Jika ada)
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            html: '{!! implode("<br>", $errors->all()) !!}',
            confirmButtonColor: '#d33'
        });
    @endif

    // Menampilkan Pesan Sukses dari Laravel Session
  @if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Selamat! 🎉',
    html: `
        {{ session('success') }} <br><br>
        <b>Nomor Antrian: {{ session('queue_number') }}</b><br>
        Estimasi: {{ session('estimate') }} menit
    `,
    confirmButtonText: 'Lihat Detail Order',
    confirmButtonColor: '#FEA116',
    allowOutsideClick: false
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href = "{{ route('trace.order', session('reservation_id')) }}";
    }
});

    @endif
    // Modal Video
    const videoModal = document.getElementById('videoModal');
    if (videoModal) {
        videoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            document.getElementById('videoIframe').src = button.getAttribute('data-src') + "?autoplay=1";
        });
        videoModal.addEventListener('hide.bs.modal', () => {
            document.getElementById('videoIframe').src = "";
        });
    }
});
</script>
@endsection