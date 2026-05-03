@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">List Products</h3>

    
    <input type="text" id="search" class="form-control mb-3" placeholder="Search product...">

    {{-- TABLE --}}
    <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody id="tableBody">
            @foreach($products as $p)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $p->name }}</td>
        <td>
   {{ $p->category->name ?? 'Tanpa Kategori' }}
</td>
                <td>{{ $p->qty }}</td>
                <td>Rp {{ number_format($p->price,0,',','.') }}</td>
                <td>
                    <a href="{{ route('editmenu', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <button class="btn btn-danger btn-sm btn-delete"
                        data-id="{{ $p->id }}">
                        Delete
                    </button>
                </td>
                

            </tr>
            @endforeach
        </tbody>
    </table>

</div>
<div>
     <a href="{{ route('products.add') }}" class="btn btn-outline-primary">Add Menu</a>
</div>
@endsection

@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let timer;

// 🔍 SEARCH AJAX
$('#search').on('keyup', function(){

    clearTimeout(timer);
    let key = $(this).val();

    timer = setTimeout(function(){

        $.ajax({
            url: "/products/search",
            method: "GET",
            data: { key: key },

            success: function(data){

                let rows = '';

                if(data.length === 0){
                    rows = `<tr><td colspan="6" class="text-center">Data tidak ditemukan</td></tr>`;
                } else {
                    data.forEach(function(p, index){
                        rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${p.name}</td>
                            <td>${p.category ? p.category.name : 'Tanpa Kategori'}</td>
                            <td>${p.qty}</td>
                            <td>Rp ${Number(p.price || 0).toLocaleString()}</td>
                            <td>
                                <a href="/editmenu/${p.id}" class="btn btn-warning btn-sm">Edit</a>

                                <button class="btn btn-danger btn-sm btn-delete"
                                    data-id="${p.id}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        `;
                    });
                }

                $('#tableBody').html(rows);
            }
        });

    }, 300);

});

$(document).on('click', '.btn-delete', function(){

    let id = $(this).data('id');

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
                url: "/products/" + id,
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },

                success: function(res){
                    Swal.fire('Berhasil!', res.message, 'success');
                    location.reload();
                }
            });

        }
    });

});
</script>

@endsection