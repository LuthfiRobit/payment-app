@extends('layouts-landpage.app')

@section('this-page-style')
@endsection

@section('content')
    @php
        $currentDate = \Carbon\Carbon::now();
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
        $activeContact = \App\Helpers\AppHelper::getKontak();
        $activeAbout = \App\Helpers\AppHelper::getTentang();
        $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
    @endphp
    <!-- start banner Area -->
    <section class="banner-area relative" style="background: url({{ asset('template-landpage/img/bg-ai-2.png') }}) !important"
        id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row fullscreen d-flex align-items-center justify-content-between">
                <div class="banner-content col-lg-9 col-md-12">
                    <h1 class="text-uppercase">
                        Madrasah Ibtidaiyah Ihyauddiniyah
                    </h1>
                    <p class="pt-10 pb-10">
                        Desa Kecik Kecamatan Besuk Kabupaten Probolinggo
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <!-- Start feature Area -->
    <section class="feature-area">
        <div class="container">
            <div class="row align-items-stretch">
                <!-- Profil -->
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="single-feature d-flex flex-column w-100">
                        <div class="title">
                            <h4>Profil Madrasah</h4>
                        </div>
                        <div class="desc-wrap mt-auto">
                            <p>
                                Madrasah Ibtidaiyah Ihyauddiniyah merupakan
                                lembaga pendidikan dasar Islam yang
                                berkomitmen dalam membentuk generasi yang
                                cerdas, berakhlak mulia, dan berwawasan
                                keislaman.
                            </p>
                            <a href="#">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- PPDB -->
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="single-feature d-flex flex-column w-100">
                        <div class="title">
                            <h4>PPDB</h4>
                        </div>
                        <div class="desc-wrap mt-auto">
                            <p>
                                Informasi Penerimaan Peserta Didik Baru
                                (PPDB) MI Ihyauddiniyah tahun. Daftarkan
                                segera putra-putri Anda untuk mendapatkan
                                pendidikan terbaik berbasis Islam.
                            </p>
                            <a href="#">Daftar Sekarang</a>
                        </div>
                    </div>
                </div>

                <!-- Kontak -->
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="single-feature d-flex flex-column w-100">
                        <div class="title">
                            <h4>Kontak Kami</h4>
                        </div>
                        <div class="desc-wrap mt-auto">
                            <p>
                                Hubungi kami untuk informasi lebih lanjut
                                seputar kegiatan madrasah, pendaftaran, atau
                                kerja sama. Kami siap membantu Anda dengan
                                senang hati.
                            </p>
                            <a href="#">Hubungi Kami</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End feature Area -->

    <!-- Start blog Area -->
    <section class="blog-area section-gap" id="blog">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Berita Terbaru dari Madrasah</h1>
                        <p>Informasi dan kabar terbaru seputar kegiatan kami.</p>
                    </div>
                </div>
            </div>
            <div class="row mb-0">
                <div class="col-lg-3 col-md-6 single-blog">
                    <div class="thumb">
                        <img class="img-fluid" src="{{ asset('template-landpage/img/b1.jpg') }}" alt="" />
                    </div>
                    <p class="meta">25 April 2018 | Oleh <a href="#">Mark Wiens</a></p>
                    <a href="blog-single.html">
                        <h5>Kecanduan: Saat Judi Menjadi Masalah</h5>
                    </a>
                    <p>
                        Komputer telah menjadi bagian dari hampir setiap aspek kehidupan
                        kita. Di tempat kerja, banyak yang menghabiskan waktu berjam-jam
                        di depannya.
                    </p>
                    <a href="#" class="details-btn d-flex justify-content-center align-items-center"><span
                            class="details">Detail</span><span class="lnr lnr-arrow-right"></span></a>
                </div>

                <div class="col-lg-3 col-md-6 single-blog">
                    <div class="thumb">
                        <img class="img-fluid" src="{{ asset('template-landpage/img/b2.jpg') }}" alt="" />
                    </div>
                    <p class="meta">25 April 2018 | Oleh <a href="#">Mark Wiens</a></p>
                    <a href="blog-single.html">
                        <h5>Perangkat Keras Komputer: PC dan Laptop</h5>
                    </a>
                    <p>
                        Ah, wawancara teknis. Bukan hanya menimbulkan kecemasan, tetapi
                        juga karena berbagai alasan yang berbeda.
                    </p>
                    <a href="#" class="details-btn d-flex justify-content-center align-items-center"><span
                            class="details">Detail</span><span class="lnr lnr-arrow-right"></span></a>
                </div>

                <div class="col-lg-3 col-md-6 single-blog">
                    <div class="thumb">
                        <img class="img-fluid" src="{{ asset('template-landpage/img/b3.jpg') }}" alt="" />
                    </div>
                    <p class="meta">25 April 2018 | Oleh <a href="#">Mark Wiens</a></p>
                    <a href="blog-single.html">
                        <h5>Desain Terbaik di MySpace Anda</h5>
                    </a>
                    <p>
                        Plantronics bersama GN Netcom menciptakan generasi terbaru headset
                        nirkabel dan produk lainnya seperti headset nirkabel lainnya.
                    </p>
                    <a href="#" class="details-btn d-flex justify-content-center align-items-center"><span
                            class="details">Detail</span><span class="lnr lnr-arrow-right"></span></a>
                </div>

                <div class="col-lg-3 col-md-6 single-blog">
                    <div class="thumb">
                        <img class="img-fluid" src="{{ asset('template-landpage/img/b4.jpg') }}" alt="" />
                    </div>
                    <p class="meta">25 April 2018 | Oleh <a href="#">Mark Wiens</a></p>
                    <a href="blog-single.html">
                        <h5>Video Game dan Imajinasi Anak</h5>
                    </a>
                    <p>
                        Sekitar 64% remaja online melakukan hal-hal yang tidak ingin
                        diketahui orang tua mereka. 11% pengguna dewasa juga melakukan hal
                        serupa.
                    </p>
                    <a href="#" class="details-btn d-flex justify-content-center align-items-center"><span
                            class="details">Detail</span><span class="lnr lnr-arrow-right"></span></a>
                </div>
            </div>
        </div>
    </section>
    <!-- End blog Area -->

    <!-- Data Statistik Madrasah -->

    <!-- Start top-category-widget Area -->
    <section class="top-category-widget-area pt-30 pb-30">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Data Statistik Madrasah</h1>
                        <p>
                            Informasi statistik terkini mengenai madrasah
                            kami.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="single-cat-widget">
                        <div class="content relative">
                            <div class="overlay overlay-bg"></div>
                            <a href="#" target="_blank">
                                <div class="thumb">
                                    <img class="content-image img-fluid d-block mx-auto"
                                        src="{{ asset('template-landpage/img/img-siswa.png') }}" alt="" />
                                </div>
                                <div class="content-details">
                                    <h4 class="content-title mx-auto text-uppercase">
                                        300
                                    </h4>
                                    <span></span>
                                    <p>Total keseluruhan siswa kami</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-cat-widget">
                        <div class="content relative">
                            <div class="overlay overlay-bg"></div>
                            <a href="#" target="_blank">
                                <div class="thumb">
                                    <img class="content-image img-fluid d-block mx-auto"
                                        src="{{ asset('template-landpage/img/img-guru.png') }}" alt="" />
                                </div>
                                <div class="content-details">
                                    <h4 class="content-title mx-auto text-uppercase">
                                        30
                                    </h4>
                                    <span></span>
                                    <p>Jumlah guru pengajar akademik</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="single-cat-widget">
                        <div class="content relative">
                            <div class="overlay overlay-bg"></div>
                            <a href="#" target="_blank">
                                <div class="thumb">
                                    <img class="content-image img-fluid d-block mx-auto"
                                        src="{{ asset('template-landpage/img/img-gedung.png') }}" alt="" />
                                </div>
                                <div class="content-details">
                                    <h4 class="content-title mx-auto text-uppercase">
                                        30
                                    </h4>
                                    <span></span>
                                    <p>
                                        Total ruang kelas di Madrasah kami
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End top-category-widget Area -->

    <!-- prestasi -->

    <!-- Start prestasi-siswa Area -->
    <section class="popular-course-area section-gap">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10">Prestasi Siswa</h1>
                        <p>
                            Berbagai penghargaan dan prestasi yang telah
                            diraih oleh siswa-siswi kami
                        </p>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="active-popular-carusel">
                    <div class="single-popular-carusel mx-auto">
                        <div class="thumb-wrap relative">
                            <div class="thumb relative">
                                <div class="overlay overlay-bg"></div>
                                <img class="img-fluid" src="{{ asset('template-landpage/img/p1.jpg') }}"
                                    alt="Prestasi Siswa" />
                            </div>
                            <div class="meta d-flex justify-content-between">
                                <p>
                                    <span class="lnr lnr-calendar-full"></span>
                                    2023
                                </p>
                            </div>
                        </div>
                        <div class="details">
                            <a href="#">
                                <h4>Juara 1 MTQ Tingkat Kabupaten</h4>
                            </a>
                            <p>
                                Siswa kami meraih juara pertama dalam
                                Musabaqah Tilawatil Quran tingkat kabupaten
                                tahun 2023
                            </p>
                        </div>
                    </div>
                    <div class="single-popular-carusel mx-auto">
                        <div class="thumb-wrap relative">
                            <div class="thumb relative">
                                <div class="overlay overlay-bg"></div>
                                <img class="img-fluid" src="{{ asset('template-landpage/img/p2.jpg') }}"
                                    alt="Prestasi Siswa" />
                            </div>
                            <div class="meta d-flex justify-content-between">
                                <p>
                                    <span class="lnr lnr-calendar-full"></span>
                                    2022
                                </p>
                            </div>
                        </div>
                        <div class="details">
                            <a href="#">
                                <h4>Olimpiade Matematika Nasional</h4>
                            </a>
                            <p>
                                Medali perak dalam Olimpiade Matematika
                                Nasional untuk tingkat Sekolah
                                Dasar/Madrasah Ibtidaiyah
                            </p>
                        </div>
                    </div>
                    <div class="single-popular-carusel mx-auto">
                        <div class="thumb-wrap relative">
                            <div class="thumb relative">
                                <div class="overlay overlay-bg"></div>
                                <img class="img-fluid" src="{{ asset('template-landpage/img/about-img.jpg') }}"
                                    alt="Prestasi Siswa" />
                            </div>
                            <div class="meta d-flex justify-content-between">
                                <p>
                                    <span class="lnr lnr-calendar-full"></span>
                                    2023
                                </p>
                            </div>
                        </div>
                        <div class="details">
                            <a href="#">
                                <h4>Festival Seni Islami</h4>
                            </a>
                            <p>
                                Juara harapan 1 dalam Festival Seni Islami
                                Tingkat Provinsi kategori kaligrafi
                            </p>
                        </div>
                    </div>
                    <div class="single-popular-carusel mx-auto">
                        <div class="thumb-wrap relative">
                            <div class="thumb relative">
                                <div class="overlay overlay-bg"></div>
                                <img class="img-fluid" src="{{ asset('template-landpage/img/p4.jpg') }}"
                                    alt="Prestasi Siswa" />
                            </div>
                            <div class="meta d-flex justify-content-between">
                                <p>
                                    <span class="lnr lnr-calendar-full"></span>
                                    2023
                                </p>
                            </div>
                        </div>
                        <div class="details">
                            <a href="#">
                                <h4>Festival Seni Islami</h4>
                            </a>
                            <p>
                                Juara harapan 1 dalam Festival Seni Islami
                                Tingkat Provinsi kategori kaligrafi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End prestasi-siswa Area -->

    <!-- Start ppdb-cta Area -->
    <section class="cta-two-area bg-success">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 cta-left text-white">
                    <h1 class="mb-3 mb-lg-0">
                        Daftarkan Putra/Putri Anda Sekarang!
                    </h1>
                    <!-- <p class="mb-0">Tahun Ajaran 2024/2025 - Kuota Terbatas</p> -->
                </div>
                <div class="col-lg-4 cta-right text-lg-right">
                    <a class="primary-btn wh" href="#">Informasi PPDB</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End ppdb-cta Area -->
@endsection

@section('this-page-scripts')
@endsection
