@extends('layouts-landpage.app')

@section('this-page-style')
@endsection

@section('content')
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
                            <a href="{{ route('landpage.profil.index') }}">Selengkapnya</a>
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
                            <a href="{{ route('landpage.kontak.index') }}">Hubungi Kami</a>
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
            <div class="row mb-0" id="berita-list">
                <!-- Item berita akan dimuat di sini lewat JS -->
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
                <div class="active-popular-carusel" id="prestasi-carousel">
                    <!-- Konten awal (opsional) -->
                </div>
            </div>

        </div>
    </section>
    <!-- End prestasi-siswa Area -->
@endsection

@section('this-page-scripts')
    @include('landpage.beranda.scripts.listBerita')
    @include('landpage.beranda.scripts.listPrestasi')
@endsection
