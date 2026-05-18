@extends('layouts.app')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- CDN --}}


<div class="container mt-4">

    <h3>List Products</h3>

    {{-- SEARCH --}}
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Search product...">
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
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

    {{-- PAGINATION --}}
    <div id="pagination">
        {{ $products->links() }}
    </div>

</div>

<script>

// LOAD DATA (SEARCH)
function loadData(key = '') {
    $.ajax({
        url: "{{ route('search') }}",
        type: "GET",
        data: { key: key },

        success: function (response) {

            let rows = '';

            response.data.forEach((item, index) => {
                rows += `
                <tr id="row-${item.id}">
                    <td>${index + 1}</td>
                    <td>${item.name}</td>
                    <td>${item.qty}</td>
                    <td>Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</td>
                    <td>
                        <a href="{{ url('editmenu') }}/${item.id}" 
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
            $('#pagination').html(response.links);
        }
    });
}

// SEARCH EVENT
$('#search').on('keyup', function () {
    let key = $(this).val();
    loadData(key);
});


// DELETE (SweetAlert + AJAX)
$(document).on('click', '.btn-delete', function () {

    let id = $(this).data('id');
    let url = $(this).data('url');

    Swal.fire({
        title: 'Yakin hapus?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
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

                success: function (response) {

                    if (response.success) {

                        $('#row-' + id).fadeOut(300, function () {
                            $(this).remove();
                        });

                        Swal.fire('Berhasil!', response.message, 'success');

                    } else {
                        Swal.fire('Gagal!', 'Data gagal dihapus', 'error');
                    }

                },

                error: function () {
                    Swal.fire('Error!', 'Terjadi kesalahan server', 'error');
                }
            });

        }

    });

});

</script>

@endsection