@extends('layouts.admin')

@section('content')

    {{-- Meta Tag untuk memaksa seluruh request AJAX berjalan via HTTPS --}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

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
            --teal: #2E6E6E;
        }

        .reservasi-wrap {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            color: var(--charcoal);
        }

        .reservasi-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(30, 42, 74, 0.06);
            overflow: hidden;
        }

        .reservasi-card .card-header {
            background: var(--ink-indigo);
            border-bottom: none;
            padding: 1rem 1.25rem;
        }

        .reservasi-card .card-header h5 {
            font-family: 'Fraunces', Georgia, serif;
            color: var(--ivory);
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .reservasi-card .card-header .eyebrow {
            display: block;
            font-size: 0.68rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(251, 247, 239, 0.55);
            margin-bottom: 0.15rem;
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
        }

        #infoData {
            font-size: 0.8rem;
        }

        /* Table */
        .reservasi-card table {
            font-size: 0.87rem;
            margin-bottom: 0;
        }

        .reservasi-card thead th {
            background: #FAF6EC;
            color: var(--clove);
            font-weight: 700;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-bottom-width: 1px;
            white-space: nowrap;
        }

        .reservasi-card tbody tr {
            transition: background-color 0.15s ease;
        }

        .reservasi-card tbody tr:hover {
            background-color: #FAF6EC;
        }

        .reservasi-card td {
            vertical-align: middle;
        }

        /* Status badges */
        .status-badge {
            display: inline-block;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.32rem 0.6rem;
            border-radius: 999px;
            margin-bottom: 0.4rem;
        }

        .status-pending        { background: var(--turmeric-soft); color: #A5771F; }
        .status-confirmed      { background: rgba(79, 121, 66, 0.14); color: var(--leaf); }
        .status-in_preparation { background: rgba(30, 42, 74, 0.10); color: var(--ink-indigo); }
        .status-served         { background: rgba(46, 110, 110, 0.14); color: var(--teal); }
        .status-completed       { background: rgba(43, 43, 43, 0.10); color: var(--charcoal); }
        .status-canceled        { background: rgba(178, 58, 46, 0.12); color: var(--chili); }

        .status-dropdown {
            font-size: 0.78rem;
            border-radius: 8px;
            border-color: #e4ddce;
        }

        .status-dropdown:focus {
            border-color: var(--turmeric);
            box-shadow: 0 0 0 0.2rem rgba(217, 164, 65, 0.18);
        }

        .btn-detail {
            border-radius: 8px;
            border-color: var(--turmeric);
            color: #A5771F;
            font-weight: 600;
            font-size: 0.78rem;
        }

        .btn-detail:hover {
            background: var(--turmeric);
            border-color: var(--turmeric);
            color: #fff;
        }

        .btn-back {
            border-radius: 8px;
            background: var(--ink-indigo);
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .btn-back:hover {
            background: #2A3A63;
        }

        /* Pagination */
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

        #pagination .page-link:focus-visible {
            outline: 2px solid var(--turmeric);
            outline-offset: 1px;
        }

        .empty-state {
            padding: 2.5rem 1rem;
            text-align: center;
            color: #9a9a9a;
        }

        .empty-state i {
            font-size: 1.8rem;
            color: var(--turmeric-soft);
            display: block;
            margin-bottom: 0.5rem;
        }

        .loading-row td {
            text-align: center;
            color: #9a9a9a;
            padding: 1.5rem;
        }
    </style>

    <div class="container mt-4 reservasi-wrap">

        <div class="card reservasi-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <span class="eyebrow">Warung Muslim Lia</span>
                    <h5 class="mb-0">Daftar Reservasi</h5>
                </div>
                <i class="bi bi-calendar-check text-white-50 fs-4"></i>
            </div>

            {{-- SEARCH --}}
            <div class="p-3 pb-2">
                <div class="search-bar">
                    <i class="bi bi-search"></i>
                    <input type="text" id="search" class="form-control" placeholder="Cari nama / invoice...">
                </div>
            </div>

            {{-- INFO --}}
            <div id="infoData" class="px-3 pb-2 text-muted">
                Memuat data...
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-bordered align-middle">
                        <thead>
                            <tr>
                                <th style="width:48px;">No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Invoice</th>
                                <th class="text-center" style="width:190px;">Status</th>
                                <th style="width:90px;">Detail</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            <tr class="loading-row">
                                <td colspan="6">
                                    <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div>
                                    Memuat data reservasi...
                                </td>
                            </tr>
                        </tbody>

                    </table>

                    <div id="pagination" class="p-3"></div>

                    <div class="m-3">
                        <a href="{{ route('dashboardadmin') }}" class="btn btn-back text-white">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {

            let timer;

            const statusLabel = {
                'pending': 'Menunggu',
                'confirmed': 'Dikonfirmasi',
                'in_preparation': 'Diproses',
                'served': 'Disajikan',
                'completed': 'Selesai',
                'canceled': 'Dibatalkan'
            };

            function loadData(page = 1, key = '') {
                // Menggunakan relative path agar aman dari isu Mixed Content HTTP/HTTPS
                let searchUrl = "/admin/orders/search?page=" + page;

                $.ajax({
                    url: searchUrl,
                    method: "GET",
                    data: { key: key },

                    success: function (res) {

                        let rows = '';

                        if (res.data.length === 0) {
                            rows = `
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <i class="bi bi-inbox"></i>
                                            Data tidak ditemukan
                                        </div>
                                    </td>
                                </tr>`;
                        } else {

                            res.data.forEach(function (r, index) {

                                let statusText = statusLabel[r.status] ?? r.status;

                                let tanggal = new Date(r.reservation_date)
                                    .toLocaleDateString('id-ID', {
                                        day: '2-digit',
                                        month: 'short',
                                        year: 'numeric'
                                    });

                                rows += `
                            <tr>
                                <td>${res.from + index}</td>
                                <td>${tanggal}</td>
                                <td>${r.name}</td>
                                <td>${r.invoice}</td>

                                <td class="text-center">

                                    <span id="badge-${r.id}" class="status-badge status-${r.status}">
                                        ${statusText}
                                    </span>

                                    <select class="form-select form-select-sm status-dropdown"
                                            data-id="${r.id}"
                                            style="width:160px; margin:auto;">
                                        ${['pending', 'confirmed', 'in_preparation', 'served', 'completed', 'canceled'].map(s => `
                                            <option value="${s}" ${r.status === s ? 'selected' : ''}>
                                                ${statusLabel[s]}
                                            </option>
                                        `).join('')}
                                    </select>
                                </td>

                                <td>
                                    <a href="/admin/orders/${r.id}" class="btn btn-outline-warning btn-detail btn-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            `;
                            });
                        }

                        $('#tableBody').html(rows);

                        $('#infoData').html(
                            `Menampilkan ${res.from ?? 0} - ${res.to ?? 0} dari ${res.total} data`
                        );

                        $('#pagination').html(res.links);
                    }
                });
            }

            loadData();

            // SEARCH
            $('#search').on('keyup', function () {
                clearTimeout(timer);

                let key = $(this).val();

                timer = setTimeout(function () {
                    loadData(1, key);
                }, 300);
            });

            // PAGINATION
            $(document).on('click', '#pagination a', function (e) {
                e.preventDefault();

                let url = $(this).attr('href');
                let page = url.split('page=')[1];
                let key = $('#search').val();

                loadData(page, key);
            });

            // UPDATE STATUS
            $(document).on('change', '.status-dropdown', function () {

                let id = $(this).data('id');
                let status = $(this).val();

                // CONFIRM KHUSUS IN PREPARATION
                if (status === 'in_preparation') {
                    if (!confirm('Yakin ingin memproses antrian ini? Antrian lain akan di-reset!')) {
                        loadData();
                        return;
                    }
                }

                $.ajax({
                    url: "/admin/orders/" + id + "/status",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: { status: status },

                    success: function () {
                        loadData();
                    }
                });

            });

        });
    </script>

@endsection
