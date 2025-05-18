@extends('layouts-landpage.app')

@section('this-page-style')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        #modalImage {
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
        }

        #modalImage[src]:not([src=""]) {
            opacity: 1;
        }
    </style>
    <!-- Tambahkan di bagian <head> atau sebelum penutup </body> -->
    <style>
        .prestasi-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .prestasi-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .prestasi-img {
            height: 175px;
            object-fit: cover;
            width: 100%;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .prestasi-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            color: white;
            z-index: 2;
        }

        .prestasi-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0;
            color: #333;
        }

        .prestasi-wrapper {
            position: relative;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative about-banner"
        style="background: url({{ asset('template-landpage/img/bg-ai-4.png') }}) !important" id="home" data-aos="fade-up"
        data-aos-duration="1000">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white" data-aos="fade-up" data-aos-duration="1000">Prestasi Madrasah</h1>
                    <p class="text-white link-nav" data-aos="fade-up" data-aos-duration="1000">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="{{ route('landpage.prestasi.index') }}"> Prestasi</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <!-- Start feature Area -->
    <section class="feature-area pb-20" data-aos="fade-up" data-aos-duration="1000">
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
                                putra-putri Anda untuk mendapatkan pendidikan terbaik berbasis Islam.
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
    <!-- End feature Area -->

    <!-- Start Prestasi Area -->
    <section class="popular-course-area pt-80" data-aos="fade-up" data-aos-duration="1000">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-70 col-lg-8">
                    <div class="title text-center">
                        <h1 class="mb-10" data-aos="fade-up" data-aos-duration="1000">Prestasi Siswa</h1>
                        <p data-aos="fade-up" data-aos-duration="1000">
                            Berbagai penghargaan dan prestasi yang telah diraih oleh siswa-siswi kami.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Alert untuk pemberitahuan data kosong atau error -->
            <div id="prestasi-alert"></div>

            <!-- Kontainer untuk daftar prestasi -->
            <div class="row justify-content-center" id="prestasi-list">
                <!-- Data prestasi akan di-render di sini -->
            </div>

            <!-- Pagination -->
            <nav class="blog-pagination justify-content-center d-flex">
                <ul class="pagination">
                    <!-- Pagination akan di-generate di sini -->
                </ul>
            </nav>
        </div>
    </section>
    <!-- End Prestasi Area -->


    <div class="modal fade" id="dynamicDetailModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Loading...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" class="img-fluid mb-3" alt="Prestasi" />
                    <p id="modalDescription">Sedang memuat...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    @include('landpage.prestasi.scripts.list')
    @include('landpage.prestasi.scripts.show')
    <script>
        AOS.init({
            once: true // animasi hanya terjadi sekali
        });
    </script>
@endsection
