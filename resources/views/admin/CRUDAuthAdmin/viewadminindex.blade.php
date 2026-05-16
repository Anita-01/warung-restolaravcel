@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Data Admin</h3>
            <a href="{{ route('dashboardadmin') }}" class="btn btn-back">
                ← Kembali
            </a>
        </div>

        <input type="text" id="search" class="form-control mb-3" placeholder="Search admin...">

        {{-- TABLE --}}
        <table class="table table-bordered table-hover">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <a href="/admin/users/edit/{{ $admin->id }}" class="btn btn-warning btn-sm">Edit</a>

                            <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $admin->id }}">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <div>
        <a href="/admin/users/create" class="btn btn-outline-primary">Tambah Admin</a>
    </div>
@endsection

@section('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let timer;


        $('#search').on('keyup', function () {

            clearTimeout(timer);
            let key = $(this).val().toLowerCase();

            timer = setTimeout(function () {

                let rows = '';
                let index = 1;

                $('#tableBody tr').each(function () {
                    let nama = $(this).find('td:eq(1)').text().toLowerCase();
                    let email = $(this).find('td:eq(2)').text().toLowerCase();

                    if (nama.includes(key) || email.includes(key)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

            }, 300);

        });

        $(document).on('click', '.btn-delete', function () {

            let id = $(this).data('id');
            let button = $(this);

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
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },

                        success: function (res) {

                            Swal.fire('Berhasil!', res.message, 'success');

                            // ✅ HAPUS ROW TANPA RELOAD
                            button.closest('tr').remove();
                        }
                    });

                }
            });

        });
    </script>

@endsection