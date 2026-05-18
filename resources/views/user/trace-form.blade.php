@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <div class="card p-4">

            <h2>Track Reservation</h2>

            <form action="{{ route('trace.confirm') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label>Invoice</label>

                    <input type="text" name="antrian" class="form-control" placeholder="Masukkan Invoice" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>

                    <input type="email" name="phone" class="form-control" placeholder="Masukkan Email" required>
                </div>

                <button class="btn btn-primary">
                    Track Order
                </button>

            </form>

            @if(session('error'))

                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>

            @endif

        </div>
        <a href="{{ route('index') }}" class="btn btn-secondary mt-3">
            Back to Dashboard
        </a>
    </div>

@endsection