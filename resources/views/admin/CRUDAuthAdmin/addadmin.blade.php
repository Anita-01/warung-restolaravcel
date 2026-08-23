@extends('layouts.admin')

@section('content')

<style>
    :root {
        --ink-indigo: #1E2A4A;
        --turmeric: #D9A441;
        --turmeric-soft: #F3E3C1;
        --ivory: #FBF7EF;
        --charcoal: #2B2B2B;
        --clove: #6B4226;
        --leaf: #4F7942;
        --chili: #B23A2E;
    }

    .admin-wrap {
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        color: var(--charcoal);
    }

    .admin-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(30, 42, 74, 0.06);
    }

    .admin-heading {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        color: var(--ink-indigo);
        letter-spacing: -0.01em;
    }

    .admin-eyebrow {
        display: block;
        font-size: 0.68rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--clove);
        margin-bottom: 0.15rem;
    }

    .btn-back {
        border-radius: 10px;
        border: 1px solid #eae4d6;
        background: #fff;
        color: var(--clove);
        font-weight: 600;
    }

    .btn-back:hover {
        background: var(--ivory);
        color: var(--ink-indigo);
    }

    .form-label-custom {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--clove);
        margin-bottom: 0.35rem;
        display: block;
    }

    .admin-wrap .form-control {
        border-radius: 10px;
        border: 1px solid #eae4d6;
        background: var(--ivory);
        padding: 0.55rem 0.9rem;
    }

    .admin-wrap .form-control:focus {
        border-color: var(--turmeric);
        box-shadow: 0 0 0 0.2rem rgba(217, 164, 65, 0.18);
        background: #fff;
    }

    .btn-toggle-pass {
        border-radius: 0 10px 10px 0 !important;
        border: 1px solid #eae4d6;
        background: #fff;
        color: var(--clove);
    }

    .btn-toggle-pass:hover {
        background: var(--turmeric-soft);
        color: var(--ink-indigo);
    }

    .btn-save-admin {
        background: var(--ink-indigo);
        border: none;
        color: var(--ivory);
        font-weight: 600;
        border-radius: 10px;
    }

    .btn-save-admin:hover {
        background: #2A3A63;
        color: #fff;
    }

    .btn-cancel-admin {
        border-radius: 10px;
        border: 1px solid #eae4d6;
        background: #fff;
        color: var(--chili);
        font-weight: 600;
    }

    .btn-cancel-admin:hover {
        background: var(--chili);
        color: #fff;
        border-color: var(--chili);
    }
</style>

<div class="container my-5 admin-wrap">
    <div class="card admin-card p-4 bg-white" style="max-width: 640px; margin: 0 auto;">

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <span class="admin-eyebrow">Manajemen Akses</span>
                <h3 class="admin-heading m-0">Tambah Admin</h3>
                <p class="text-muted small m-0">Buat akun administrator baru untuk sistem</p>
            </div>

        </div>

        <hr class="text-muted opacity-25 mb-4">

        <!-- FORM -->
        <form id="reservationForm">
            @csrf

            <div class="mb-3">
                <label class="form-label-custom">Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label class="form-label-custom">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email" required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-4">
                <label class="form-label-custom">Password</label>

                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>

                    <button type="button" class="btn btn-toggle-pass" onclick="togglePassword()">
                        <i id="eyeIcon" class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-save-admin px-4 py-2">Simpan</button>
                <a href="{{ route('admin.users') }}" class="btn btn-cancel-admin px-4 py-2">Batal</a>
            </div>
        </form>

    </div>
</div>

@endsection


@section('scripts')

    <!-- jQuery (WAJIB) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- TOGGLE PASSWORD -->
    <script>
        function togglePassword() {
            let input = document.getElementById("password");
            let icon = document.getElementById("eyeIcon");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

    <!-- AJAX SUBMIT -->
    <script>
        $(document).ready(function () {

            $('#reservationForm').submit(function (e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('admin.store') }}",
                    method: "POST",
                    data: formData,

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            confirmButtonColor: '#1E2A4A'
                        }).then(function () {

                            // ✅ redirect setelah klik OK
                            window.location.href = "{{ route('admin.users') }}";

                        });
                    },

                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorText = '';

                        for (let key in errors) {
                            errorText += errors[key][0] + '<br>';
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            html: errorText
                        });
                    }
                });

            });

        });
    </script>

@endsection