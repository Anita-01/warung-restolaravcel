@extends('layouts.login')
@section('content')

    <!-- Google Fonts untuk tipografi yang lebih elegan -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        .service-item:hover label,
        .service-item:hover .form-check-label,
        .service-item:hover a {
            color: #fff !important;
        }

        .service-item .form-control {
            background-color: #fff !important;
            color: #212529 !important;
        }

        .service-item .form-control::placeholder {
            color: #6c757d !important;
        }

        .service-item .form-control:focus {
            background-color: #fff !important;
            color: #212529 !important;
            border-color: #fff !important;
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.4) !important;
        }

        .service-item:hover .btn-primary {
            background-color: #fff !important;
            color: var(--primary) !important;
            border-color: #fff !important;
        }

        .login-wrapper {
            overflow: hidden;
            border-radius: 0.5rem;
        }

        .login-photo {
            position: relative;
            background-image: url("{{ asset('img/about-2.jpg') }}");
            background-size: cover;
            background-position: center;
            min-height: 480px; /* dipaksa punya tinggi pasti, jaga2 kalau parent tidak stretch */
        }

        .login-photo::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            background: linear-gradient(160deg,
                        rgba(20, 15, 10, 0.55) 0%,
                        rgba(20, 15, 10, 0.35) 40%,
                        rgba(10, 8, 5, 0.85) 100%);
        }

        .login-photo-caption {
            position: relative;
            z-index: 5; /* dinaikkan supaya pasti di atas overlay & elemen lain */
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            height: 100%;
            padding: 3rem 2.5rem;
        }

        .login-photo-caption .icon-badge {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.35);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff !important;
            margin-bottom: 1.5rem;
        }

        .login-photo-caption .caption-overline {
            font-family: 'Poppins', sans-serif !important;
            font-size: 0.78rem;
            font-weight: 400;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.75) !important;
            margin-bottom: 0.6rem;
            display: block;
        }

        .login-photo-caption h3 {
            font-family: 'Playfair Display', serif !important;
            font-size: 2.4rem;
            font-weight: 700 !important;
            line-height: 1.15;
            margin-bottom: 1rem;
            color: #ffffff !important;
            text-shadow: 0 4px 14px rgba(0, 0, 0, 0.6);
        }

        .login-photo-caption .caption-divider {
            width: 55px;
            height: 3px;
            background: var(--primary, #f5a623) !important;
            border-radius: 2px;
            margin-bottom: 1rem;
        }

        .login-photo-caption p {
            font-family: 'Poppins', sans-serif !important;
            font-size: 0.95rem;
            font-weight: 300;
            letter-spacing: 0.02em;
            color: rgba(255, 255, 255, 0.85) !important;
            margin-bottom: 0;
            max-width: 320px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        @media (max-width: 991.98px) {
            .login-photo {
                min-height: 260px;
            }

            .login-photo-caption h3 {
                font-size: 1.9rem;
            }
        }

        .login-form-side {
            display: flex;
            align-items: center;
        }
    </style>

    <!-- Login Start -->
    <div class="container-xxl py-5">
        <div class="container">

            <div class="text-center wow fadeInUp mb-4" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Selamat Datang</h5>
                <h1>Login Admin</h1>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9 col-md-11 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="login-wrapper shadow">
                        <div class="row g-0">

                            {{-- Sisi Kiri: Foto + Caption --}}
                            <div class="col-lg-6 login-photo">
                                <div class="login-photo-caption">
                                    <div class="icon-badge">
                                        <i class="fa fa-utensils"></i>
                                    </div>
                                    <span class="caption-overline">Panel Administrator</span>
                                    <h3>Warung Muslim Lia</h3>
                                    <div class="caption-divider"></div>
                                    <p>Kelola pesanan, menu, dan operasional restoran dengan mudah melalui satu dashboard.</p>
                                </div>
                            </div>

                            {{-- Sisi Kanan: Form Login --}}
                            <div class="col-lg-6 login-form-side">
                                <div class="service-item p-5 w-100 h-100">

                                    @if(session('error'))
                                        <div class="alert alert-danger rounded mb-4">
                                            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="/login">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Username</label>
                                            <input type="text" name="name" class="form-control border-primary py-2"
                                                placeholder="email@example.com">
                                        </div>

                                        <div class="mb-3">
                                            <label class="fw-bold mb-1">Password</label>
                                            <input type="password" name="password" class="form-control border-primary py-2"
                                                placeholder="Password">
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
            </div>

        </div>
    </div>
    <!-- Login End -->
@endsection