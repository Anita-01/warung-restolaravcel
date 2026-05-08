@extends('layouts.hmm')

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

                            <div class="form-check mb-4">
                                <input type="checkbox" class="form-check-input">
                                <label class="form-check-label">Remember me</label>
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