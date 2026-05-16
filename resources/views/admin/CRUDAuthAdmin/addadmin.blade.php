@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h3>Tambah Admin</h3>

        <!-- FORM -->
        <form id="reservationForm">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <label>Password</label>

                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" required>

                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                        <i id="eyeIcon" class="fa fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>
        </form>

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
                            confirmButtonColor: '#3085d6'
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