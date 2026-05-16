@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <h3>Edit Admin</h3>

        <form action="{{ route('admin.users.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $admin->name }}">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $admin->email }}">
            </div>

            <div class="mb-3">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control">
                <small>Kosongkan kalau tidak ingin mengganti password.</small>
            </div>

            <button class="btn btn-primary">Update</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>
        </form>

    </div>
@endsection