@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Admin</h5>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.users.update', $admin->id) }}" method="POST">
                @csrf

                <!-- NAMA -->
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input 
                        type="text" 
                        name="name" 
                        value="{{ $admin->name }}" 
                        class="form-control" 
                        required
                    >
                </div>

                <!-- EMAIL -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ $admin->email }}" 
                        class="form-control" 
                        required
                    >
                </div>

                <!-- PASSWORD -->
                <div class="mb-3">
                    <label class="form-label">Password (opsional)</label>

                    <div class="input-group">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control"
                        >

                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                            <i id="eyeIcon" class="fa fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        ← Kembali
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<!-- SCRIPT SHOW PASSWORD -->
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