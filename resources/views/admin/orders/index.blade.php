@extends('layouts.admin')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Daftar Reservasi</h5>
            </div>

            {{-- SEARCH --}}
            <div class="p-3">
                <input type="text" id="search" class="form-control" placeholder="Search nama / invoice...">
            </div>

            {{-- INFO --}}
            <div id="infoData" class="px-3 text-muted small">
                -
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">

                    <table class="table table-bordered mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Invoice</th>
                                <th class="text-center">Status</th>
                                <th>Detail</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody"></tbody>

                    </table>

                    <div id="pagination" class="p-3"></div>

                    <div class="m-3">
                        <a href="{{ route('dashboardadmin') }}" class="btn btn-secondary">
                            ← Kembali
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

            function loadData(page = 1, key = '') {

                $.ajax({
                    url: "{{ route('orders.search') }}?page=" + page,
                    method: "GET",
                    data: { key: key },

                    success: function (res) {

                        let rows = '';

                        if (res.data.length === 0) {
                            rows = `<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>`;
                        } else {

                            res.data.forEach(function (r, index) {

                                let color = {
                                    'pending': 'bg-warning text-dark',
                                    'confirmed': 'bg-success',
                                    'in_preparation': 'bg-primary',
                                    'served': 'bg-info',
                                    'completed': 'bg-dark',
                                    'canceled': 'bg-danger'
                                };

                                let statusText = r.status.replace('_', ' ');
                                statusText = statusText.charAt(0).toUpperCase() + statusText.slice(1);

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

                                    <span id="badge-${r.id}" class="badge ${color[r.status]} mb-2">
                                        ${statusText}
                                    </span>

                                    <select class="form-select form-select-sm status-dropdown"
                                            data-id="${r.id}"
                                            style="width:150px; margin:auto;">
                                        ${['pending', 'confirmed', 'in_preparation', 'served', 'completed', 'canceled'].map(s => `
                                            <option value="${s}" ${r.status === s ? 'selected' : ''}>
                                                ${s.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}
                                            </option>
                                        `).join('')}
                                    </select>
                                </td>

                                <td>
                                    <a href="/admin/orders/${r.id}" class="btn btn-outline-warning btn-sm">
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