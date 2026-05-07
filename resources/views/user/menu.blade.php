@extends('layouts.Hmm')

@section('nav-menu', 'active')

@section('hero')
    <div class="container-xxl py-5 bg-dark hero-header mb-5">
        <div class="container my-5 py-5">
            <div class="row align-items-center g-5">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-3 text-white animated slideInLeft">Menu Kami</h1>
                    <p class="text-white animated slideInLeft mb-4 pb-2">Temukan pilihan makanan lezat dari Warung Muslim Lia. Semua dimasak dengan bahan segar dan penuh cita rasa.</p>
                </div>
                <div class="col-lg-6 text-center text-lg-end overflow-hidden">
                    <img class="img-fluid" src="img/hero.png" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('main')
    <!-- Menu Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Pilihan Menu</h5>
                <h1 class="mb-5">Menu Makanan & Minuman</h1>
            </div>

            {{-- isi tidak diubah --}}
            <div class="row g-4">
                @forelse($products as $p)
                    <div class="col-lg-6">
                        <div class="d-flex align-items-center">

                            <img class="flex-shrink-0 img-fluid rounded"
                                 src="{{ asset('img/' . $p->image) }}"
                                 alt="{{ $p->name }}"
                                 style="width: 80px; height: 80px; object-fit: cover;">

                            <div class="w-100 d-flex flex-column text-start ps-4">
                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                    <span>{{ $p->name }}</span>
                                    <span class="text-primary">
                                        Rp {{ number_format($p->price, 0, ',', '.') }}
                                    </span>
                                </h5>

                                <small class="fst-italic">
                                    Kategori: {{ $p->category }} | Qty: {{ $p->qty }}
                                </small>
                            </div>

                        </div>
                    </div>
                @empty
                @endforelse
                <div class="col-12 text-center">
                    <h3> Silahkan melakukan Reservation</h3>
                    <a href="/" class="nav-item nav-link">Kembali ke halaman utama</a>
                </div>
            </div>

        </div>
    </div>
    <!-- Menu End -->
@endsection