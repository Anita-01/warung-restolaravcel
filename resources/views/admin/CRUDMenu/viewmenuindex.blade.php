@extends('layouts.admin')

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

                            {{-- 🔥 FIX GAMBAR --}}
                            <td class="text-center">
                                @if($p->image)
                                    <img src="{{ asset('storage/' . $p->image) }}" width="60" height="60"
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

                                <button class="btn btn-danger btn-sm fw-bold btn-delete" data-id="{{ $p->id }}">
                                    DELETE
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
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

        <a href="{{ route('products.add') }}" class="btn btn-outline-warning mt-3 fw-bold">
            + ADD MENU
        </a>

    </div>
@endsection


@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            let timer;

            function loadData(page = 1, key = '') {
                $.ajax({
                    url: "/products/search?page=" + page,
                    method: "GET",
                    data: { key: key },
                    success: function (res) {
                        let rows = '';

                        if (res.data.length === 0) {
                            rows = `<tr><td colspan="7" class="text-center">Data tidak ditemukan</td></tr>`;
                        } else {
                            res.data.forEach(function (p, index) {

                                // 🔥 FIX GAMBAR AJAX
                                let image = p.image
                                    ? `<img src="/storage/${p.image}" 
                                       width="60" height="60"
                                       style="object-fit:cover;border-radius:5px;">`
                                    : `<span class="text-muted small">No Image</span>`;

                                rows += `
                            <tr>
                                <td class="text-center">${res.from + index}</td>
                                <td class="text-center">${image}</td>
                                <td>${p.name}</td>
                                <td>${p.category ? p.category.name : 'Uncategorized'}</td>
                                <td>${p.qty}</td>
                                <td>Rp ${Number(p.price || 0).toLocaleString('id-ID')}</td>
                                <td class="text-center">
                                    <a href="/editmenu/${p.id}" 
                                       class="btn btn-warning btn-sm fw-bold text-dark">EDIT</a>

                                    <button class="btn btn-danger btn-sm fw-bold btn-delete" 
                                            data-id="${p.id}">
                                        DELETE
                                    </button>
                                </td>
                            </tr>`;
                            });
                        }

                        $('#tableBody').html(rows);
                        $('#infoData').html(
                            `Showing ${res.from ?? 0} to ${res.to ?? 0} of ${res.total} results`
                        );
                        $('#pagination').html(res.links);
                    }
                });
            }

            // SEARCH
            $('#search').on('keyup', function () {
                clearTimeout(timer);
                let key = $(this).val();

                timer = setTimeout(function () {
                    loadData(1, key);
                }, 300);
            });

            // PAGINATION AJAX
            $(document).on('click', '#pagination a', function (e) {
                e.preventDefault();
                let url = $(this).attr('href');

                if (url) {
                    let page = url.split('page=')[1];
                    let key = $('#search').val();
                    loadData(page, key);
                }
            });

            // DELETE
            $(document).on('click', '.btn-delete', function () {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin hapus?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/products/" + id,
                            method: "POST",
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function (res) {
                                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                                loadData();
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection