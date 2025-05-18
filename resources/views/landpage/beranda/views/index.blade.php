@extends('layouts-landpage.app')

@section('this-page-style')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        @keyframes floatY {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        .float-animation {
            animation: floatY 3s ease-in-out infinite;
        }

        @media (max-width: 991.98px) {
            .float-animation {
                animation: none !important;
            }
        }


        /* Kontainer galeri */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
            padding: 1rem;
        }

        /* Item gambar */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Efek overlay */
        .gallery-item .custom-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease;
            border-radius: 8px;
        }

        /* Menampilkan overlay saat hover */
        .gallery-item:hover .custom-overlay {
            opacity: 1;
        }

        .custom-overlay .text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <!-- Start banner Area -->
    <section class="banner-area relative"
        style="background: url({{ asset('template-landpage/img/bg-ai-2.png') }}) center center / cover no-repeat !important;"
        id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row fullscreen d-flex align-items-center justify-content-center text-center text-lg-left">
                <!-- Banner Content (Always visible) -->
                <div class="banner-content col-lg-9 col-md-12 order-2 order-lg-1">
                    <h1 class="text-uppercase" data-aos="zoom-in-down" data-aos-duration="1200">
                        Madrasah Ibtidaiyah Ihyauddiniyah
                    </h1>
                    <p class="pt-2 pb-2" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                        Desa Kecik Kecamatan Besuk Kabupaten Probolinggo
                    </p>
                </div>

                <!-- Banner Image (Only visible on lg and up) -->
                <div class="banner-img col-lg-3 d-none d-lg-flex justify-content-center order-1 order-lg-2"
                    data-aos="fade-left" data-aos-duration="1000" data-aos-delay="400">
                    <img src="{{ asset('template-landpage/img/logo_mi_new.png') }}"
                        alt="Logo Madrasah Ibtidaiyah Ihyauddiniyah" class="img-fluid float-animation"
                        style="max-width: 220px;">
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

    <!-- Start Sambutan Kepala Sekolah -->
    <section class="pt-5 pb-5 bg-light">
        <div class="container">
            <!-- Judul -->
            <div class="row">
                <div class="col-12 text-center mb-4" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="font-weight-bold">Sambutan Kepala Sekolah</h2>
                    <hr class="w-25 mx-auto">
                </div>
            </div>

            <!-- Konten Sambutan -->
            <div class="row align-items-center">
                <!-- Foto Kepala Sekolah -->
                <div class="col-md-4 text-center mb-4" data-aos="fade-right" data-aos-duration="1000" data-aos-delay="200">
                    <img src="https://placehold.co/300x400?text=FOTO+KEPALA-SEKOLAH" alt="Kepala Sekolah"
                        class="img-fluid rounded mb-3">
                    <h5 class="mb-0">MUZAMMIL, M.Pd.</h5>
                    <p class="text-muted">Kepala Sekolah</p>
                </div>

                <!-- Teks Sambutan -->
                <div class="col-md-8" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="400">
                    <p class="text-justify mb-0">
                        <strong>Assalamu’alaikum Warahmatullahi Wabarakatuh,</strong><br><br>
                        Dengan penuh rasa syukur dan bangga, saya menyambut Anda di website resmi sekolah kami.
                        Website ini hadir sebagai sarana informasi dan komunikasi antara sekolah dengan masyarakat luas.
                        <br><br>
                        Melalui platform ini, kami ingin menunjukkan komitmen kami dalam memberikan pendidikan yang unggul,
                        berkarakter, dan siap menghadapi tantangan zaman.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End Sambutan Kepala Sekolah -->

    <!-- Start Blog Area -->
    <section class="blog-area section-gap py-5" id="blog">
        <div class="container">
            <!-- Judul -->
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="font-weight-bold">Berita Terbaru dari Madrasah</h2>
                    <p class="text-muted">Informasi dan kabar terbaru seputar kegiatan kami.</p>
                </div>
            </div>

            <!-- Daftar Berita (akan diisi oleh JS) -->
            <div class="row" id="berita-list">
                <!-- Konten berita dinamis dimuat di sini -->
            </div>
        </div>
    </section>
    <!-- End Blog Area -->

    <!-- Start Data Statistik Madrasah -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Judul -->
            <div class="row justify-content-center text-center mb-5">
                <div class="col-lg-8" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="fw-bold">Data Statistik Madrasah</h2>
                    <p class="text-muted">
                        Menyajikan informasi terkini terkait jumlah siswa, guru, dan fasilitas madrasah kami.
                    </p>
                </div>
            </div>

            <!-- Data Cards -->
            <div class="row g-4">
                <!-- Siswa -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card border-0 shadow text-center p-4 h-100">
                        <img src="{{ asset('template-landpage/img/img-siswa.png') }}" alt="Total Siswa"
                            class="img-fluid rounded mb-3" style="height: 175px; object-fit: cover;">
                        <h3 class="fw-semibold mb-1 text-primary">239</h3>
                        <p class="mb-0 text-muted">Total Siswa</p>
                    </div>
                </div>

                <!-- Guru -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card border-0 shadow text-center p-4 h-100">
                        <img src="{{ asset('template-landpage/img/img-guru.png') }}" alt="Total Guru"
                            class="img-fluid rounded mb-3" style="height: 175px; object-fit: cover; ">
                        <h3 class="fw-semibold mb-1 text-success">31</h3>
                        <p class="mb-0 text-muted">Pendidik & Tenaga Kependidikan</p>
                    </div>
                </div>

                <!-- Ruang Kelas -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card border-0 shadow text-center p-4 h-100">
                        <img src="{{ asset('template-landpage/img/img-gedung.png') }}" alt="Ruang Kelas"
                            class="img-fluid rounded mb-3" style="height: 175px; object-fit: cover;">
                        <h3 class="fw-semibold mb-1 text-danger">12</h3>
                        <p class="mb-0 text-muted">Ruang Kelas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Data Statistik Madrasah -->

    <!-- Start Prestasi Siswa Area -->
    <section class="popular-course-area section-gap py-5 bg-white">
        <div class="container">
            <!-- Judul -->
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center mb-5" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="font-weight-bold">Prestasi Siswa</h2>
                    <p class="text-muted">Berbagai penghargaan dan prestasi yang telah diraih oleh siswa-siswi kami</p>
                </div>
            </div>

            <!-- Alert container -->
            <div class="row justify-content-center">
                <div class="col-12" id="prestasi-alert" data-aos="fade-in"></div>
            </div>

            <!-- Carousel container -->
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel owl-theme" id="prestasi-carousel" data-aos="zoom-in"
                        data-aos-duration="1000">
                        <!-- Item prestasi akan dimuat via AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Prestasi Siswa Area -->

    <!-- Start Gallery Area -->
    <section class="gallery-area section-gap bg-light pt-5 pb-5">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="font-weight-bold">Galeri Kegiatan</h2>
                    <p>Dokumentasi berbagai kegiatan yang telah dilakukan oleh Madrasah.</p>
                    <hr class="w-25 mx-auto mb-4">
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="gallery-grid" id="gallery-container">
                <!-- Gambar akan dimuat secara dinamis di sini -->
            </div>
        </div>
    </section>
    <!-- End Gallery Area -->
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    @include('landpage.beranda.scripts.listBerita')
    @include('landpage.beranda.scripts.listPrestasi')
    @include('landpage.beranda.scripts.listGaleri')
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',

            once: true
        });
    </script>
@endsection
