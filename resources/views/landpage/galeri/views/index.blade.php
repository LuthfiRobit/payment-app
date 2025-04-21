@extends('layouts-landpage.app')

@section('this-page-style')
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative about-banner"
        style="background: url({{ asset('template-landpage/img/bg-ai-4.png') }}) !important" id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">Galeri Madrasah</h1>
                    <p class="text-white link-nav">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="{{ route('landpage.galeri.index') }}"> Galeri</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <!-- Start feature Area -->
    <section class="feature-area pb-20">
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
                                Madrasah Ibtidaiyah Ihyauddiniyah merupakan lembaga pendidikan dasar yang terletak di Desa
                                Kecik,
                                Kecamatan Besuk, Kabupaten Probolinggo.
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

    <!-- Start gallery Area -->
    <section class="gallery-area pt-80">
        <div class="container">
            <div class="row justify-content-center" id="galeri-container"></div>

            <nav class="blog-pagination justify-content-center d-flex">
                <ul class="pagination" id="pagination"></ul>
            </nav>
        </div>
    </section>
    <!-- End gallery Area -->
@endsection

@section('this-page-scripts')
    @include('landpage.galeri.scripts.list')
@endsection
