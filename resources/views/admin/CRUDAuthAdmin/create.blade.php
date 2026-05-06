@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Tambah Admin</h3>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>
    </form>

</div>
@endsection