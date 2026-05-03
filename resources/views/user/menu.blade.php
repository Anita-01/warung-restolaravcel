<div class="row g-4">
    @forelse($products as $p)
        <div class="col-lg-6">
            <div class="d-flex align-items-center">

                <img class="flex-shrink-0 img-fluid rounded"
                     src="{{ asset('img/' . $p->image) }}"
                     alt="{{ $p->name }}"
                     style="width: 80px; height: 80px; object-fit: cover;">

                <div class="w-100 d-flex flex-column text-start ps-4">
                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                        <span>{{ $p->name }}</span>
                        <span class="text-primary">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </span>
                    </h5>

                    <small class="fst-italic">
                        Kategori: {{ $p->category }} | Qty: {{ $p->qty }}
                    </small>
                </div>

            </div>
        </div>
    @empty
    @endforelse
    <div class="col-12 text-center">\
           <h3> Silahkan melakukan Reservation</h3>
            <a href="/" class="nav-item nav-link">Kembali ke halaman utama</a>
        </div>
</div>

