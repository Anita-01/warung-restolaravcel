@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Data Admin</h3>

    <!-- SEARCH -->
    <input type="text" id="search" class="form-control mb-3" placeholder="Search admin...">

    <!-- TABLE -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th width="180">Action</th>
            </tr>
        </thead>

        <tbody id="tableBody">
            @forelse($admins as $admin)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td class="text-center">

                    <a href="{{ url('/admin/users/edit/'.$admin->id) }}" 
                       class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    <button class="btn btn-danger btn-sm btn-delete"
                        data-id="{{ $admin->id }}">
                        Delete
                    </button>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Data admin kosong</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- BUTTON TAMBAH -->
    <a href="{{ url('/admin/users/create') }}" class="btn btn-primary">
        + Tambah Admin
    </a>

</div>
@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

// ================= SEARCH (FRONTEND FILTER) =================
$('#search').on('keyup', function(){
    let value = $(this).val().toLowerCase();

    $('#tableBody tr').filter(function(){
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
});


// ================= DELETE =================
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
                url: "/admin/users/delete/" + id,
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },

                success: function(res){
                    Swal.fire('Berhasil!', 'Data berhasil dihapus', 'success');
                    location.reload();
                },

                error: function(){
                    Swal.fire('Error!', 'Gagal menghapus data', 'error');
                }
            });

        }
    });

});
</script>

@endsection