@extends('layouts-landpage.app')

@section('this-page-style')
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative about-banner"
        style="background: url({{ asset('template-landpage/img/bg-ai-2.png') }}) !important" id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">
                        Profil Madrasah Ibtidaiyah Ihyauddiniyah
                    </h1>
                    <p class="text-white link-nav">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="{{ route('landpage.profil.index') }}"> Profil</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <!-- Start feature Area -->
    <section class="feature-area pb-120">
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

    <!-- Start info Area -->
    <section class="info-area pb-120">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 no-padding info-area-left">
                    <img class="img-fluid" src="{{ asset('template-landpage/img/about-img.jpg') }}" alt="Gedung Madrasah" />
                </div>
                <div class="col-lg-6 info-area-right">
                    <h1>Profil Madrasah</h1>
                    <p class="text-justify">
                        Madrasah Ibtidaiyah Ihyauddiniyah merupakan lembaga
                        pendidikan dasar berbasis Islam yang berlokasi di
                        Desa Kecik, Kecamatan Besuk, Kabupaten Probolinggo.
                        Kami berkomitmen untuk memberikan pendidikan
                        berkualitas yang mengintegrasikan ilmu pengetahuan
                        umum dengan nilai-nilai keislaman serta membentuk
                        generasi yang berakhlak mulia.
                    </p>
                    <br />
                    <p class="text-justify">
                        Berdiri sejak tahun 1985, madrasah kami telah
                        mencetak generasi-generasi muslim yang berakhlak
                        mulia dan berprestasi. Dengan fasilitas yang memadai
                        dan tenaga pendidik yang profesional, kami
                        menyelenggarakan proses pembelajaran yang
                        menyenangkan dan mengembangkan potensi peserta didik
                        secara holistik. Kurikulum kami mengacu pada KMA 183
                        tahun 2019 dengan penekanan pada penguatan karakter
                        religius dan nasionalisme.
                    </p>
                    <br />
                    <p class="text-justify">
                        Selain kegiatan intrakurikuler, kami juga memiliki
                        berbagai program unggulan seperti tahfidz Al-Qur'an,
                        kaligrafi, dan pembinaan ibadah praktis untuk
                        membentuk siswa yang beriman, berilmu, dan beramal
                        shaleh. Program-program tersebut dirancang untuk
                        mengembangkan kemampuan spiritual, intelektual, dan
                        sosial peserta didik secara seimbang.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End info Area -->

    <!-- Start info Area -->
    <section class="info-area pb-120">
        <div class="container-fluid">
            <div class="row align-items-center">
                <!-- Kolom teks dipindah ke kiri (urutan pertama) -->
                <div class="col-lg-6 info-area-right order-lg-1 order-2">
                    <h1>Identitas Madrasah</h1>
                    <blockquote class="generic-blockquote">
                        <ul class="unordered-list">
                            <li class="mb-3">
                                <strong>Nama Madrasah:</strong>
                                MI Ihyauddiniyah
                            </li>
                            <li class="mb-3">
                                <strong>NPSN:</strong>
                                0xxxx
                            </li>
                            <li class="mb-3">
                                <strong>NSM:</strong>
                                1xxxx
                            </li>
                            <li class="mb-3">
                                <strong>Jenjang Pendidikan:</strong>
                                MI (Madrasah Ibtidaiyah)
                            </li>
                            <li class="mb-3">
                                <strong>Status Sekolah:</strong>
                                Swasta
                            </li>
                            <li class="mb-3">
                                <strong>Alamat Sekolah:</strong>
                                Desa Kecik, Kec. Besuk, Kab. Probolinggo
                            </li>
                            <li>
                                <strong>Kode Pos:</strong>
                                6xxx
                            </li>
                        </ul>
                    </blockquote>
                </div>

                <!-- Kolom gambar dipindah ke kanan (urutan kedua) -->
                <div class="col-lg-6 no-padding info-area-left order-lg-2 order-1">
                    <img class="img-fluid" src="{{ asset('template-landpage/img/about-img.jpg') }}" alt="Gedung Madrasah" />
                </div>
            </div>
        </div>
    </section>
    <!-- End info Area -->
@endsection

@section('this-page-scripts')
@endsection
