@extends('layouts.app')

@section('content')
<style>
    #pagination svg {
        width: 20px;
        height: 20px;
    }
    #pagination nav div:first-child {
        display: none; 
    }

    .pagination .page-link {
        color: #007bff !important;
        background-color: #fff !important;
        border: 1px solid #dee2e6 !important;
    }
    .pagination .page-item.active .page-link {
        background-color: #007bff !important;
        border-color: #007bff !important;
        color: #fff !important;
    }
    .pagination .page-item.disabled .page-link {
        color: #6c757d !important;
    }
</style>

<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">List Products</h3>
        <a href="{{ route('dashboardadmin') }}" class="btn btn-secondary btn-sm">
            ← Kembali
        </a>
    </div>

    {{-- SEARCH --}}
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Search product...">
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light text-center">
                <tr>
                    <th width="50">#</th>
                    <th width="100">Foto</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th width="180">Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($products as $p)
                <tr>
                    <td class="text-center">
                        {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                    </td>

                    <td class="text-center">
                        @if($p->image)
                            <img src="{{ asset('storage/' . $p->image) }}" 
                                 width="60" height="60"
                                 style="object-fit: cover; border-radius: 5px;">
                        @else
                            <span class="text-muted small">No Image</span>
                        @endif
                    </td>

                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name ?? 'Uncategorized' }}</td>
                    <td>{{ $p->qty }}</td>
                    <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>

                    <td class="text-center">
                        <a href="{{ route('editmenu', $p->id) }}" 
                           class="btn btn-warning btn-sm fw-bold text-dark">EDIT</a>

                        <button class="btn btn-danger btn-sm fw-bold btn-delete" 
                                data-id="{{ $p->id }}">
                            DELETE
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- PAGINATION + INFO --}}
    <div class="mt-3">
        <div id="pagination">
            {{ $products->links() }}
        </div>

        <div id="infoData" class="text-muted small mt-2">
            Showing {{ $products->firstItem() ?? 0 }} 
            to {{ $products->lastItem() ?? 0 }} 
            of {{ $products->total() }} results
        </div>
    </div>

    {{-- BUTTON BAWAH --}}
    <div class="mt-3 d-flex gap-2">
        <a href="{{ route('products.add') }}" class="btn btn-outline-warning fw-bold">
            + ADD MENU
        </a>

        <a href="{{ route('dashboardadmin') }}" class="btn btn-secondary">
            KEMBALI
        </a>
    </div>

</div>
@endsection