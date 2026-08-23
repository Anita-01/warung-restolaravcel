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

    .admin-wrap {
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        color: var(--charcoal);
    }

    .admin-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(30, 42, 74, 0.06);
    }

    .admin-heading {
        font-family: 'Fraunces', Georgia, serif;
        font-weight: 600;
        color: var(--ink-indigo);
        letter-spacing: -0.01em;
    }

    .admin-eyebrow {
        display: block;
        font-size: 0.68rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: var(--clove);
        margin-bottom: 0.15rem;
    }

    .btn-add-admin {
        background: var(--ink-indigo);
        border: none;
        color: var(--ivory);
        font-weight: 600;
    }

    .btn-add-admin:hover {
        background: #2A3A63;
        color: #fff;
    }

    .btn-back {
        border-radius: 10px;
        border: 1px solid #eae4d6;
        background: #fff;
        color: var(--clove);
        font-weight: 600;
    }

    .btn-back:hover {
        background: var(--ivory);
        color: var(--ink-indigo);
    }

    /* Search */
    .search-bar {
        position: relative;
    }

    .search-bar i,
    .search-bar span.icon {
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

    /* Avatar initial */
    .avatar-box {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: var(--turmeric-soft);
        color: #A5771F;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
        border: 1px solid #eae4d6;
    }

    /* Table */
    .admin-wrap table {
        font-size: 0.88rem;
        margin-bottom: 0;
    }

    .admin-wrap thead th {
        background: #FAF6EC;
        color: var(--clove);
        font-weight: 700;
        font-size: 0.72rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        border-bottom-width: 1px;
        white-space: nowrap;
    }

    .admin-wrap tbody tr {
        transition: background-color 0.15s ease;
    }

    .admin-wrap tbody tr:hover {
        background-color: #FAF6EC;
    }

    .btn-edit-admin {
        border-radius: 8px;
        border: 1px solid var(--turmeric);
        color: #A5771F;
        background: #fff;
        font-weight: 700;
        font-size: 0.76rem;
    }

    .btn-edit-admin:hover {
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
</style>

<div class="container my-5 admin-wrap">
    <div class="card admin-card p-4 bg-white">

        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
            <div>
                <span class="admin-eyebrow">Manajemen Akses</span>
                <h3 class="admin-heading m-0">Data Admin</h3>
                <p class="text-muted small m-0">Kelola hak akses dan akun administrator sistem</p>
            </div>

            <div class="d-flex gap-2">
                <a href="/admin/users/create" class="btn btn-add-admin px-4 py-2 rounded-3 shadow-sm d-flex align-items-center gap-2">
                    <i class="bi bi-plus-lg"></i> Tambah Admin
                </a>

                <a href="{{ route('dashboardadmin') }}" class="btn btn-back px-3 py-2 rounded-3 d-flex align-items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        <hr class="text-muted opacity-25 mb-4">

        <div class="row mb-4">
            <div class="col-md-5 col-lg-4">
                <div class="search-bar">
                    <i class="bi bi-search"></i>
                    <input type="text" id="search" class="form-control" placeholder="Cari admin...">
                </div>
            </div>
        </div>

        <div class="table-responsive rounded-3 border">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th class="ps-4" width="60">#</th>
                        <th width="70"></th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th class="text-end pe-4" width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">
                    @forelse($admins as $admin)
                        <tr>
                            <td class="ps-4 text-muted fw-medium row-counter">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <div class="avatar-box">
                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                </div>
                            </td>

                            <td>
                                <span class="fw-bold text-dark">{{ $admin->name }}</span>
                            </td>

                            <td class="text-secondary">
                                {{ $admin->email }}
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="/admin/users/edit/{{ $admin->id }}"
                                        class="btn btn-edit-admin btn-sm px-3 py-1">
                                        Edit
                                    </a>

                                    <button class="btn btn-delete btn-sm btn-delete px-3 py-1"
                                        data-id="{{ $admin->id }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr id="emptyRow">
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-person-badge"></i>
                                    <p class="mb-1 fw-medium">Tidak ada data admin ditemukan</p>
                                    <small class="text-muted">Silakan tambah admin baru terlebih dahulu.</small>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
    let timer;

    // ================= CLIENT-SIDE SEARCH WITH DEBOUNCE =================

    $('#search').on('keyup', function () {
        clearTimeout(timer);

        let key = $(this).val().toLowerCase();

        timer = setTimeout(function () {
            let visibleRows = 0;

            $('#jsEmptyRow').remove();

            $('#tableBody tr:not(#emptyRow)').each(function () {
                let nama = $(this).find('td:eq(2)').text().toLowerCase();
                let email = $(this).find('td:eq(3)').text().toLowerCase();

                if (nama.includes(key) || email.includes(key)) {
                    $(this).show();
                    visibleRows++;
                } else {
                    $(this).hide();
                }
            });

            if (visibleRows === 0 && $('#tableBody tr:not(#emptyRow)').length > 0) {
                $('#tableBody').append(`
                    <tr id="jsEmptyRow">
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="bi bi-person-badge"></i>
                                <p class="mb-1 fw-medium">Pencarian "${key}" tidak ditemukan</p>
                            </div>
                        </td>
                    </tr>
                `);
            }

        }, 250);
    });


    // ================= DELETE PROCESS (AJAX) =================

    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        let button = $(this);

        Swal.fire({
            title: 'Yakin hapus admin?',
            text: "Akses login admin ini akan dicabut secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#B23A2E',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "/admin/users/delete/" + id,
                    method: "POST",

                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },

                    success: function (res) {
                        Swal.fire(
                            'Berhasil!',
                            res.message || 'Data berhasil dihapus',
                            'success'
                        );

                        button.closest('tr').fadeOut(300, function () {
                            $(this).remove();

                            if ($('#tableBody tr:not(#jsEmptyRow)').length === 0) {

                                $('#tableBody').append(`
                                    <tr id="emptyRow">
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <i class="bi bi-person-badge"></i>
                                                <p class="mb-1 fw-medium">Tidak ada data admin ditemukan</p>
                                            </div>
                                        </td>
                                    </tr>
                                `);

                            } else {

                                $('.row-counter').each(function(index) {
                                    $(this).text(index + 1);
                                });

                            }
                        });
                    },

                    error: function () {
                        Swal.fire(
                            'Error!',
                            'Gagal menghapus data dari server',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>

@endsection