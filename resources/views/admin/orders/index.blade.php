@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Daftar Reservasi</h5>
        </div>

       
        <div class="p-3">
            <input type="text" id="search" class="form-control" placeholder="Search nama / invoice...">
        </div>

        
        <div id="infoData" class="px-3 pb-2 text-muted small">
            Menampilkan {{ $reservations->firstItem() ?? 0 }} - {{ $reservations->lastItem() ?? 0 }} 
            dari {{ $reservations->total() }} data
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

<!-- CSRF -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){

    let timer;

  
    function loadData(page = 1, key = '') {

        $.ajax({
            url: "{{ route('orders.search') }}?page=" + page,
            method: "GET",
            data: { key: key },

            success: function(res){

                let rows = '';

                if(res.data.length === 0){
                    rows = `<tr>
                                <td colspan="6" class="text-center">
                                    Data tidak ditemukan
                                </td>
                            </tr>`;
                } else {

                    res.data.forEach(function(r, index){

                        let color = {
                            'pending': 'bg-warning text-dark',
                            'confirmed': 'bg-success',
                            'in_preparation': 'bg-primary',
                            'served': 'bg-info',
                            'completed': 'bg-dark',
                            'canceled': 'bg-danger'
                        };

                        let statusText = r.status.replace('_',' ');
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
                                <div class="mb-2">
                                    <span id="badge-${r.id}" class="badge ${color[r.status] || 'bg-secondary'}">
                                        ${statusText}
                                    </span>
                                </div>

                                <select class="form-select form-select-sm status-dropdown"
                                        data-id="${r.id}"
                                        style="width:150px; margin:auto;">
                                    ${['pending','confirmed','in_preparation','served','completed','canceled'].map(s => `
                                        <option value="${s}" ${r.status === s ? 'selected' : ''}>
                                            ${s.replace('_',' ').replace(/\b\w/g, l => l.toUpperCase())}
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
                $('#pagination .pagination').addClass('justify-content-center');
            }
        });
    }


    loadData();

  
    $('#search').on('keyup', function(){

        clearTimeout(timer);

        let key = $(this).val();

        timer = setTimeout(function(){
            loadData(1, key);
        }, 300);
    });

  
    $(document).on('click', '#pagination a', function(e){
        e.preventDefault();

        let url = $(this).attr('href');
        if(!url) return;

        let page = url.split('page=')[1];
        let key = $('#search').val();

        loadData(page, key);
    });

  
    $(document).on('change', '.status-dropdown', function(){

        let id = $(this).data('id');
        let status = $(this).val();

        $.ajax({
            url: "/admin/orders/" + id + "/status",
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { status: status },

            success: function(){

                let badge = $('#badge-' + id);

                let color = {
                    'pending': 'bg-warning text-dark',
                    'confirmed': 'bg-success',
                    'in_preparation': 'bg-primary',
                    'served': 'bg-info',
                    'completed': 'bg-dark',
                    'canceled': 'bg-danger'
                };

                badge.removeClass().addClass('badge ' + color[status]);

                let text = status.replace('_',' ');
                badge.text(text.charAt(0).toUpperCase() + text.slice(1));
            }
        });

    });

});
</script>

@endsection