@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- CDN --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .img-box {
        width: 70px;
        height: 70px;
        overflow: hidden;
        border-radius: 8px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="container mt-4">

    <h3>List Products</h3>

    {{-- SEARCH --}}
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Search product...">
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($products as $p)
                <tr id="row-{{ $p->id }}">
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <div class="img-box">
                            @if($p->image)
                                <img src="{{ asset('storage/' . $p->image) }}">
                            @else
                                <span class="text-muted small">No</span>
                            @endif
                        </div>
                    </td>

                    <td>{{ $p->name }}</td>
                    <td>{{ $p->qty }}</td>
                    <td>Rp {{ number_format($p->price,0,',','.') }}</td>

                    <td>
                        <a href="{{ route('editmenu', $p->id) }}" 
                           class="btn btn-warning btn-sm me-1">
                           EDIT
                        </a>

                        <button class="btn btn-danger btn-sm btn-delete"
                            data-id="{{ $p->id }}"
                            data-url="{{ route('destroy', $p->id) }}">
                            DELETE
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('dashboardadmin') }}" class="btn btn-back">
                ← Kembali
            </a>

    {{-- PAGINATION --}}
    <div id="pagination">
        {!! $products->links() !!}
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

        response.data.forEach((item, index) => {
            rows += `
            <tr id="row-${item.id}">
                <td>${(response.current_page - 1) * 10 + (index + 1)}</td>

                <td>
                    <div class="img-box">
                        ${
                            item.image 
                            ? `<img src="/storage/${item.image}">`
                            : `<span class="text-muted small">No</span>`
                        }
                    </div>
                </td>

                <td>${item.name}</td>
                <td>${item.qty}</td>
                <td>Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</td>

                <td>
                    <a href="/editmenu/${item.id}" 
                       class="btn btn-warning btn-sm me-1">
                       EDIT
                    </a>

                    <button class="btn btn-danger btn-sm btn-delete"
                        data-id="${item.id}"
                        data-url="/products/${item.id}">
                        DELETE
                    </button>
                </td>
            </tr>
            `;
        });

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
            headers: {
                'Accept': 'application/json'
            },

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
        }
    });


    // ================= DELETE =================
    $(document).on('click', '.btn-delete', function () {

        let id = $(this).data('id');
        let url = $(this).data('url');

        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!'
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
                        Swal.fire('Error!', 'Terjadi kesalahan server', 'error');
                    }
                });

            }

        });

    });

});

</script>

@endsection