@extends('layouts.app')

@section('content')

    <!-- Service Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h5 class="section-title ff-secondary text-center text-primary fw-normal">Layanan Kami</h5>
                <h1 class="mb-5">Solusi Kuliner Warung Muslim Lia</h1>
            </div>
            <div class="row g-4">
                <!-- Pesanan Online -->
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-cart-plus text-primary mb-4"></i>
                            <h5>Pemesanan Digital</h5>
                            <p>Pesan Nasi Uduk atau Lontong Sayur favorit Anda tanpa antre melalui sistem website kami.</p>
                        </div>
                    </div>
                </div>
                <!-- Menu Higienis -->
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-utensils text-primary mb-4"></i>
                            <h5>Menu Rumahan</h5>
                            <p>Sajian Bubur Ayam, Nasi Goreng Kampung, dan aneka sayur dengan cita rasa otentik dan halal.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Akurasi Pesanan -->
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-check-circle text-primary mb-4"></i>
                            <h5>Akurasi Pesanan</h5>
                            <p>Sistem terintegrasi meminimalisir kesalahan catat menu atau salah antar meja di Balige.</p>
                        </div>
                    </div>
                </div>
                <!-- Jasa Katering -->
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item rounded pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-truck text-primary mb-4"></i>
                            <h5>Jasa Katering</h5>
                            <p>Melayani pesanan katering untuk acara kantor atau keluarga dengan manajemen data yang rapi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Service End -->

@endsection