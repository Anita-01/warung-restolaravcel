
@extends('layouts.login')
@section('content')
<style>
    /* Teks label & link tetap putih saat card bg orange (hover) */
    .service-item:hover label,
    .service-item:hover .form-check-label,
    .service-item:hover a {
        color: #fff !important;
    }

    /* Input background tetap putih & teks gelap agar mudah dibaca */
    .service-item .form-control {
        background-color: #fff !important;
        color: #212529 !important;
    }

    .service-item .form-control::placeholder {
        color: #6c757d !important;
    }

    /* Saat input di-focus: tetap putih, border putih */
    .service-item .form-control:focus {
        background-color: #fff !important;
        color: #212529 !important;
        border-color: #fff !important;
        box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.4) !important;
    }

    /* Tombol Sign In saat card hover: invert jadi putih */
    .service-item:hover .btn-primary {
        background-color: #fff !important;
        color: var(--primary) !important;
        border-color: #fff !important;
    }
</style>
@endsection

@section('main')
    <!-- Login Start -->
    <div class="container-xxl py-5">
        <div class="container">

            {{-- Judul --}}
            <div class="text-center wow fadeInUp mb-4" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Selamat Datang</h5>
                <h1>Login Admin</h1>
            </div>

            {{-- Card Form --}}
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="service-item rounded p-5">

                        {{-- Pesan error --}}
                        @if(session('error'))
                            <div class="alert alert-danger rounded mb-4">
                                <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="/login">
                            @csrf

                            <div class="mb-3">
                                <label class="fw-bold mb-1">Username</label>
                                <input type="text" name="name" class="form-control border-primary py-2" placeholder="email@example.com">
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold mb-1">Password</label>
                                <input type="password" name="password" class="form-control border-primary py-2" placeholder="Password">
                            </div>

        
                            <button type="submit" class="btn btn-primary w-100 py-2">
                                <i class="fa fa-sign-in-alt me-2"></i>Sign in
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <a href="/" class="text-primary text-decoration-none">
                                <i class="fa fa-arrow-left me-1"></i>Kembali ke halaman utama
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Login End -->
@endsection