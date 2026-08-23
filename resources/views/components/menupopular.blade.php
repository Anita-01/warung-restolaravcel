<div class="container-xxl py-5">
    <div class="container">

        <!-- Title -->
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h5 class="section-title ff-secondary text-center text-primary fw-normal">
                Food Menu
            </h5>
            <h1 class="mb-5">Most Popular Items</h1>
        </div>

        <!-- Loop kategori -->
        @foreach($categories as $cat)

            @if($cat->menus->count() > 0)

                <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s">

                    <!-- Judul kategori -->
                    <div class="text-center mb-4">
                        <h3 class="text-primary d-inline-flex align-items-center gap-2">
                            <i class="fa {{ $cat->icon }}"></i>
                            {{ $cat->name }}
                        </h3>
                        <p class="text-body mb-0">{{ $cat->subtitle }}</p>
                    </div>

                    <!-- Menu -->
                    <div class="row g-4">

                        @foreach($cat->menus as $menu)
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center bg-white rounded shadow-sm p-3 menu-card h-100">

                                    <div class="flex-shrink-0 position-relative">
                                        <img class="rounded"
                                             src="{{ asset('img/' . $menu->image) }}"
                                             alt="{{ $menu->name }}"
                                             style="width: 85px; height: 85px; object-fit: cover;">
                                    </div>

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-2">
                                            <h5 class="mb-0 fw-bold">{{ $menu->name }}</h5>
                                            <span class="text-primary fw-bold">
                                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <small class="fst-italic text-muted">
                                            {{ $menu->description }}
                                        </small>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>

                </div>

            @endif

        @endforeach

                {{-- BUTTON LIHAT SEMUA MENU --}}
        <div class="text-center mt-4">
            <a href="{{ route('menu') }}" class="btn btn-primary px-5 py-3 rounded-pill">
                <i class="fa fa-utensils me-2"></i>
                Lihat Semua Menu
            </a>
        </div>

    </div>
</div>

<style>
.menu-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}
.menu-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
}
.menu-card img {
    transition: transform 0.3s ease;
}
.menu-card:hover img {
    transform: scale(1.08);
}
</style>