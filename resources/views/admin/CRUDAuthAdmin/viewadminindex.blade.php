<h2>Data Admin</h2>

<a href="/admin/users/create">Tambah Admin</a>

<table border="1">
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Aksi</th>
    </tr>

    @foreach($admins as $admin)
    <tr>
        <td>{{ $admin->name }}</td>
        <td>{{ $admin->email }}</td>
        <td>
            <a href="/admin/users/edit/{{ $admin->id }}">Edit</a>

            <form action="/admin/users/delete/{{ $admin->id }}" method="POST">
                @csrf
                @method('DELETE')
                <button>Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>