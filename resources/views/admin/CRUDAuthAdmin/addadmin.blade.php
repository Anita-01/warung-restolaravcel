@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Tambah Admin</h3>

    <form action="{{ route('admin.users.store') }}" method="POST">
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
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>

<!-- SCRIPT -->
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

@endsection