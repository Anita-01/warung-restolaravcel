@extends('layouts.admin')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- CDN --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    .produk-wrap {
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        color: var(--charcoal);
    }

    .produk-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(30, 42, 74, 0.06);
    }

    .produk-heading {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        color: var(--ink-indigo);
        letter-spacing: -0.01em;
    }

    .produk-eyebrow {
        display: block;
        font-size: 0.68rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--clove);
        margin-bottom: 0.15rem;
    }

    .btn-add-menu {
        background: var(--ink-indigo);
        border: none;
        color: var(--ivory);
        font-weight: 600;
    }

    .btn-add-menu:hover {
        background: #2A3A63;
        color: #fff;
    }

    /* Search */
    .search-bar {
        position: relative;
    }

    .search-bar i {
        position: absolute;
        left: 0.9rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9a9a9a;
    }

    .search-bar input {
        padding-left: 2.3rem;
        border-radius: 10px;
        border: 1px solid #eae4d6;
        background: var(--ivory);
    }

    .search-bar input:focus {
        border-color: var(--turmeric);
        box-shadow: 0 0 0 0.2rem rgba(217, 164, 65, 0.18);
        background: #fff;
    }

    /* Image box */
    .img-box {
        width: 56px;
        height: 56px;
        overflow: hidden;
        border-radius: 12px;
        background: var(--turmeric-soft);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #eae4d6;
    }

    .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .img-box .no-img {
        color: #A5771F;
        font-size: 0.65rem;
        font-weight: 700;
        text-align: center;
    }

    /* Table */
    .produk-wrap table {
        font-size: 0.88rem;
        margin-bottom: 0;
    }

    .produk-wrap thead th {
        background: #FAF6EC;
        color: var(--clove);
        font-weight: 700;
        font-size: 0.72rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border-bottom-width: 1px;
        white-space: nowrap;
    }

    .produk-wrap tbody tr {
        transition: background-color 0.15s ease;
    }

    .produk-wrap tbody tr:hover {
        background-color: #FAF6EC;
    }

    .qty-badge {
        display: inline-block;
        background: rgba(30, 42, 74, 0.08);
        color: var(--ink-indigo);
        font-weight: 700;
        font-size: 0.76rem;
        padding: 0.32rem 0.65rem;
        border-radius: 999px;
    }

    .price-tag {
        color: var(--leaf);
        font-weight: 700;
    }

    .btn-edit-menu {
        border-radius: 8px;
        border: 1px solid var(--turmeric);
        color: #A5771F;
        background: #fff;
        font-weight: 700;
        font-size: 0.76rem;
    }

    .btn-edit-menu:hover {
        background: var(--turmeric);
        color: #fff;
    }

    .btn-delete {
        border-radius: 8px;
        border: none;
        background: rgba(178, 58, 46, 0.1);
        color: var(--chili);
        font-weight: 700;
        font-size: 0.76rem;
    }

    .btn-delete:hover {
        background: var(--chili);
        color: #fff;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #9a9a9a;
    }

    .empty-state i {
        font-size: 1.8rem;
        color: var(--turmeric-soft);
        display: block;
        margin-bottom: 0.5rem;
    }

    #pagination .pagination {
        margin-bottom: 0;
    }

    #pagination .page-link {
        color: var(--ink-indigo);
        border-color: #eae4d6;
    }

    #pagination .page-item.active .page-link {
        background: var(--ink-indigo);
        border-color: var(--ink-indigo);
    }
</style>

<div class="container my-5 produk-wrap">
    <div class="card produk-card p-4 bg-white">

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <span class="produk-eyebrow">Warung Muslim Lia</span>
                <h3 class="produk-heading m-0">Daftar Produk</h3>
                <p class="text-muted small m-0">Kelola informasi, stok, dan harga menu Anda</p>
            </div>
            <a href="{{ route('products.add') }}" class="btn btn-add-menu px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                <i class="bi bi-plus-lg"></i> Tambah Menu
            </a>
        </div>

        <hr class="text-muted opacity-25 mb-4">

        <div class="row mb-4">
            <div class="col-md-5 col-lg-4">
                <div class="search-bar">
                    <i class="bi bi-search"></i>
                    <input type="text" id="search" class="form-control" placeholder="Cari produk...">
                </div>
            </div>
        </div>

        <div class="table-responsive rounded-3 border mb-4">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" width="60">#</th>
                        <th width="90">Foto</th>
                        <th>Nama</th>
                        <th width="110">Qty</th>
                        <th width="160">Harga</th>
                        <th class="text-end pe-4" width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @forelse($products as $p)
                    <tr id="row-{{ $p->id }}">
                        <td class="ps-4 text-muted fw-medium">{{ $loop->iteration }}</td>
                        <td>
                            <div class="img-box">
                                @if($p->image)
                                    <img src="{{ asset('storage/' . $p->image) }}" alt="{{ $p->name }}">
                                @else
                                    <span class="no-img">No Img</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">{{ $p->name }}</span>
                        </td>
                        <td>
                            <span class="qty-badge">{{ $p->qty }} pcs</span>
                        </td>
                        <td>
                            <span class="price-tag">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('editmenu', $p->id) }}" class="btn btn-edit-menu btn-sm px-3 py-1">
                                    Edit
                                </a>
                                <button class="btn btn-delete btn-sm btn-delete-item px-3 py-1"
                                    data-id="{{ $p->id }}"
                                    data-url="{{ route('destroy', $p->id) }}">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-basket"></i>
                                <p class="mb-1 fw-medium">Tidak ada produk ditemukan</p>
                                <small class="text-muted">Silakan tambah produk baru terlebih dahulu.</small>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3 mt-2">
            <a href="{{ route('dashboardadmin') }}" class="btn btn-link text-decoration-none text-muted p-0 d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>

            <div id="pagination">
                {!! $products->links() !!}
            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function () {

    // ================= RENDER TABLE =================
    function renderTable(response) {
        if (!response || !response.data) {
            console.error('Response error:', response);
            return;
        }

        let rows = '';

        if (response.data.length === 0) {
            rows = `
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="bi bi-basket"></i>
                        <p class="mb-1 fw-medium">Tidak ada produk ditemukan</p>
                    </div>
                </td>
            </tr>`;
        } else {
            response.data.forEach((item, index) => {
                let formattedPrice = new Intl.NumberFormat('id-ID').format(item.price);
                let itemNumber = (response.current_page - 1) * response.per_page + (index + 1);

                rows += `
                <tr id="row-${item.id}">
                    <td class="ps-4 text-muted fw-medium">${itemNumber}</td>
                    <td>
                        <div class="img-box">
                            ${item.image ? `<img src="/storage/${item.image}">` : `<span class="no-img">No Img</span>`}
                        </div>
                    </td>
                    <td><span class="fw-bold text-dark">${item.name}</span></td>
                    <td><span class="qty-badge">${item.qty} pcs</span></td>
                    <td><span class="price-tag">Rp ${formattedPrice}</span></td>
                    <td class="text-end pe-4">
                        <div class="d-inline-flex gap-2">
                            <a href="/editmenu/${item.id}" class="btn btn-edit-menu btn-sm px-3 py-1">Edit</a>
                            <button class="btn btn-delete btn-sm btn-delete-item px-3 py-1" data-id="${item.id}" data-url="/products/${item.id}">Hapus</button>
                        </div>
                    </td>
                </tr>`;
            });
        }

        $('#tableBody').html(rows);
        $('#pagination').html(response.links ?? '');
    }

    // ================= LOAD DATA =================
    function loadData(key = '', url = "{{ route('search') }}") {
        $.ajax({
            url: url,
            type: "GET",
            data: { key: key },
            dataType: 'json',
            headers: { 'Accept': 'application/json' },
            success: function (response) {
                renderTable(response);
            },
            error: function (err) {
                console.error('ERROR:', err.responseText);
            }
        });
    }

    // ================= SEARCH =================
    $('#search').on('keyup', function () {
        loadData($(this).val());
    });

    // ================= PAGINATION =================
    $(document).on('click', '#pagination a', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let key = $('#search').val();

        if (url) {
            if (!url.includes('/products/search')) {
                url = "{{ url('/products/search') }}" + url.substring(url.indexOf('?'));
            }
            loadData(key, url);
        }
    });

    // ================= DELETE =================
    $(document).on('click', '.btn-delete-item', function () {
        let id = $(this).data('id');
        let url = $(this).data('url');

        Swal.fire({
            title: 'Yakin hapus produk?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#B23A2E',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        _method: 'DELETE'
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#row-' + id).fadeOut(300, function () {
                                $(this).remove();
                            });
                            Swal.fire('Berhasil!', res.message, 'success');
                        }
                    },
                    error: function () {
                        Swal.fire('Error!', 'Terjadi kesalahan pada server', 'error');
                    }
                });
            }
        });
    });
});
</script>

@endsection