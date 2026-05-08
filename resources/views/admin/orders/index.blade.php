@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Daftar Reservasi</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small text-uppercase">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Invoice</th>
                            <th class="text-center">Status</th>
                            <th>Detail</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($reservations as $key => $r)
                        <tr>

                            <td>{{ $key + 1 }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($r->reservation_date)->format('d M Y') }}
                            </td>

                            <td>{{ $r->name }}</td>

                            <td>{{ $r->invoice }}</td>

                            <td class="text-center">

                                @php
                                    $badgeClass = [
                                        'pending' => 'bg-warning text-dark',
                                        'confirmed' => 'bg-success',
                                        'in preparation' => 'bg-primary',
                                        'served' => 'bg-info',
                                        'completed' => 'bg-dark',
                                        'canceled' => 'bg-danger'
                                    ][$r->status] ?? 'bg-secondary';
                                @endphp

                                <!-- BADGE -->
                                <div class="mb-2">
                                    <span id="badge-{{ $r->id }}" class="badge {{ $badgeClass }}">
                                        {{ ucfirst($r->status) }}
                                    </span>
                                </div>

                                <!-- DROPDOWN AJAX -->
                                <select class="form-select form-select-sm status-dropdown"
                                        data-id="{{ $r->id }}"
                                        style="width: 150px; margin:auto;">
                                        
                                    @foreach(['pending','confirmed','in preparation','served','completed','canceled'] as $status)
                                        <option value="{{ $status }}"
                                            {{ $r->status == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach

                                </select>

                            </td>

                            <td>
                                <a href="{{ route('admin.orders.detail', $r->id) }}"
                                   class="btn btn-outline-warning btn-sm">
                                   Detail
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
                   <div class="mt-3">
                <a href="{{ route('admin.dashboardadmin') }}" class="btn btn-secondary">
                    ← Kembali
                </a>

            </div>
        </div>
    </div>

</div>

<!-- AJAX SCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('.status-dropdown').change(function(){

    let id = $(this).data('id');
    let status = $(this).val();

    $.ajax({
        url: "/admin/orders/" + id + "/status",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            status: status
        },
        success: function(res){

            let badge = $('#badge-' + id);

            let color = {
                'pending': 'bg-warning text-dark',
                'confirmed': 'bg-success',
                'in preparation': 'bg-primary',
                'served': 'bg-info',
                'completed': 'bg-dark',
                'canceled': 'bg-danger'
            };

            badge.removeClass().addClass('badge ' + color[status]);
            badge.text(status.charAt(0).toUpperCase() + status.slice(1));

        }
    });

});
</script>

@endsection