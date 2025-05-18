@extends('layouts-landpage.app')

@section('this-page-style')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        /* Container Gallery */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            height: 250px;
            /* Seragamkan tinggi */
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 10px;
            display: block;
        }

        /* Overlay custom */
        .gallery-item .custom-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 10px;
        }

        .gallery-item:hover .custom-overlay {
            opacity: 1;
        }

        .custom-overlay .text {
            position: absolute;
            bottom: 10px;
            left: 10px;
            right: 10px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            text-align: left;
        }

        .gallery-item .tanggal-info {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 0.85rem;
            color: #fff;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 4px 8px;
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative about-banner"
        style="background: url({{ asset('template-landpage/img/bg-ai-4.png') }}) !important" id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white" data-aos="fade-up" data-aos-duration="1200"> Galeri Madrasah</h1>
                    <p class="text-white link-nav" data-aos="fade-down" data-aos-duration="1000">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="{{ route('landpage.galeri.index') }}"> Geleri</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <!-- Start Feature Area -->
    <section class="feature-area pb-20">
        <div class="container">
            <div class="row align-items-stretch">
                <!-- Profil Madrasah -->
                <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="0">
                    <div class="single-feature d-flex flex-column w-100">
                        <div class="title">
                            <h4>Profil Madrasah</h4>
                        </div>
                        <div class="desc-wrap mt-auto">
                            <p>
                                Madrasah Ibtidaiyah Ihyauddiniyah merupakan lembaga pendidikan dasar yang terletak di Desa
                                Kecik, Kecamatan Besuk, Kabupaten Probolinggo.
                            </p>
                            <a href="{{ route('landpage.profil.index') }}">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- PPDB -->
                <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="200">
                    <div class="single-feature d-flex flex-column w-100">
                        <div class="title">
                            <h4>PPDB</h4>
                        </div>
                        <div class="desc-wrap mt-auto">
                            <p>
                                Informasi Penerimaan Peserta Didik Baru (PPDB) MI Ihyauddiniyah tahun. Daftarkan segera
                                putra-putri Anda
                                untuk mendapatkan pendidikan terbaik berbasis Islam.
                            </p>
                            <a href="#">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>

                <!-- Kontak Kami -->
                <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="400">
                    <div class="single-feature d-flex flex-column w-100">
                        <div class="title">
                            <h4>Kontak Kami</h4>
                        </div>
                        <div class="desc-wrap mt-auto">
                            <p>
                                Hubungi kami untuk informasi lebih lanjut seputar kegiatan madrasah, pendaftaran, atau kerja
                                sama. Kami siap membantu Anda dengan senang hati.
                            </p>
                            <a href="{{ route('landpage.kontak.index') }}">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Feature Area -->

    <!-- Start gallery Area -->
    <section class="gallery-area pt-80 " data-aos="fade-up">
        <div class="container">
            <div class="row justify-content-center gallery-grid" id="galeri-container"></div>

            <nav class="blog-pagination justify-content-center d-flex">
                <ul class="pagination" id="pagination"></ul>
            </nav>
        </div>
    </section>
    <!-- End gallery Area -->
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    @include('landpage.galeri.scripts.list')
    <script>
        AOS.init({
            once: true
        });
    </script>
@endsection
