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

            {{-- Optional: skip kalau kosong --}}
            @if($cat->menus->count() > 0)

                <div class="mb-5 wow fadeInUp" data-wow-delay="0.1s">

                    <!-- Judul kategori -->
                    <div class="text-center mb-4">
                        <h3 class="text-primary">
                            <i class="fa {{ $cat->icon }} me-2"></i>
                            {{ $cat->name }}
                        </h3>
                        <small class="text-body">{{ $cat->subtitle }}</small>
                    </div>

                    <!-- Menu -->
                    <div class="row g-4">

                        @foreach($cat->menus as $menu)
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center">

                                    <img class="flex-shrink-0 img-fluid rounded" src="{{ asset('img/' . $menu->image) }}"
                                        alt="{{ $menu->name }}" style="width: 80px; height: 80px; object-fit: cover;">

                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                            <span>{{ $menu->name }}</span>
                                            <span class="text-primary">
                                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                                            </span>
                                        </h5>
                                        <small class="fst-italic">
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

    </div>
</div>