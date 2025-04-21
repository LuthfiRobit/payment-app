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

    <!-- Start info Area -->
    <section class="info-area pb-120">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-6 no-padding info-area-left">
                    <img class="img-fluid" src="{{ asset('template-landpage/img/bg-ai-2.png') }}"
                        style="max-height: 450px !important" alt="Gedung Madrasah" />
                </div>
                <div class="col-lg-6 info-area-right">
                    <h1>Profil Madrasah</h1>
                    <p class="text-justify">
                        Madrasah Ibtidaiyah Ihyauddiniyah merupakan lembaga pendidikan dasar yang terletak di Desa Kecik,
                        Kecamatan Besuk, Kabupaten Probolinggo. Madrasah ini menjadikan Al-Qur’an dan Hadits sebagai sumber
                        rujukan utama dalam setiap aktivitas pendidikan serta menjunjung tinggi nilai-nilai dan tradisi
                        pesantren sebagai budaya yang melekat dalam kehidupan sehari-hari di lingkungan madrasah. Dengan
                        visi "Mencetak generasi yang Santun, Terampil, dan Islami (SANTRI): SANtun dalam perilaku, TeRampil
                        dalam berkarya, Islami dalam pengamalan," MI Ihyauddiniyah terus mengembangkan diri dan terus
                        berkomitmen untuk mencetak lulusan yang unggul secara akademik, kuat dalam kepribadian, serta
                        berakhlakul karimah.
                    </p>
                    <p id="moreText" class="text-justify" style="display:none;">
                        Arah pengembangan lembaga difokuskan pada penguatan karakter, peningkatan mutu pembelajaran, serta
                        pengintegrasian nilai-nilai keislaman dalam seluruh aspek pendidikan.
                    </p>
                    <p id="moreText" class="text-justify" style="display:none;">
                        Didirikan pada tahun 1950, MI Ihyauddiniyah telah menjadi bagian penting dalam sejarah pendidikan
                        Islam di wilayah Besuk, Probolinggo. Selama puluhan tahun, madrasah ini telah melahirkan alumni yang
                        tersebar dan berkiprah di berbagai bidang kehidupan, mulai dari dunia pendidikan, keagamaan,
                        aparatur pemerintahan, dunia usaha hingga menjadi pegiat sosial di tengah masyarakat. Beberapa di
                        antaranya menjadi pendidik, tokoh masyarakat, pengusaha, hingga pemimpin di lingkup lokal maupun
                        nasional. Capaian ini menjadi bukti bahwa MI Ihyauddiniyah tidak hanya mencetak lulusan yang cerdas
                        secara intelektual, tetapi juga matang dalam spiritual dan sosial.
                    </p>
                    <p id="moreText" class="text-justify" style="display:none;">
                        Dalam upaya mengembangkan bakat dan minat siswa, MI Ihyauddiniyah menyelenggarakan berbagai kegiatan
                        intrakurikuler, kokurikuler, dan ekstrakurikuler yang dirancang secara integratif. Kegiatan
                        intrakurikuler difokuskan pada penguatan akademik dan nilai-nilai keislaman, sementara kegiatan
                        kokurikuler mendukung pengayaan pembelajaran melalui kegiatan keagamaan dan sosial. Sedangkan
                        kegiatan ekstrakurikuler di madrasah ini meliputi pencaksilat, drumband, olahraga, karate, hadrah,
                        serta kepramukaan.
                    </p>
                    <p id="moreText" class="text-justify" style="display:none;">
                        Kegiatan kelembagaan juga diperkuat dengan program unggulan tahfidz Al-Qur’an sebagai upaya
                        menanamkan kecintaan terhadap Al-Qur’an sejak dini, serta pendalaman kitab kuning yang menjadi ciri
                        khas tradisi keilmuan pesantren. Seluruh kegiatan ini bertujuan untuk menumbuhkan jiwa disiplin,
                        semangat kebersamaan, serta kepemimpinan yang tangguh pada setiap peserta didik, sejalan dengan misi
                        madrasah dalam membentuk generasi masa depan yang siap menghadapi tantangan zaman tanpa meninggalkan
                        nilai-nilai keislaman.
                    </p>

                    <a href="javascript:void(0)" onclick="toggleText()" id="readMoreBtn">Baca Selengkapnya</a>
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
                                MIS. IHYAUDDINIYAH
                            </li>
                            <li class="mb-3">
                                <strong>NPSN:</strong>
                                60716322
                            </li>
                            <li class="mb-3">
                                <strong>NSM:</strong>
                                111235130239
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
                                <strong>Akreditasi Madrasah:</strong>
                                B
                            </li>
                            <li class="mb-3">
                                <strong>Alamat Sekolah:</strong>
                                Jl Masjid Darussalam, Desa Kecik, Kec. Besuk, Kab. Probolinggo, Provinsi Jawa Timur
                            </li>
                            <li class="mb-3">
                                <strong>Nama Yayasan:</strong>
                                YAYASAN IHYAUDDINIYAH
                            </li>
                            <li class="mb-3">
                                <strong>Alamat Yayasan:</strong>
                                Jl Masjid Darussalam, Desa Kecik, Kec. Besuk, Kab. Probolinggo, Provinsi Jawa Timur
                            </li>
                            <li class="mb-3">
                                <strong>No Akte Pendirian Yayasan:</strong>
                                C-178.HT.03.01-Th. 2003
                            </li>
                            <li class="mb-3">
                                <strong>Kepemilikan Tanah:</strong>Yayasan
                            </li>
                            <li class="mb-3">
                                <strong>Luas Tanah:</strong>
                                1605 m²
                            </li>
                            <li class="mb-3">
                                <strong>Status Bangunan:</strong>
                                Yayasan
                            </li>
                        </ul>

                    </blockquote>
                </div>

                <!-- Kolom gambar dipindah ke kanan (urutan kedua) -->
                <div class="col-lg-6 no-padding info-area-left order-lg-2 order-1">
                    <img class="img-fluid" src="{{ asset('template-landpage/img/bg-ai-4.png') }}" alt="Gedung Madrasah" />
                </div>
            </div>
        </div>
    </section>
    <!-- End info Area -->
@endsection

@section('this-page-scripts')
    <script>
        function toggleText() {
            var moreText = document.querySelectorAll("#moreText");
            var btnText = document.getElementById("readMoreBtn");

            if (moreText[0].style.display === "none") {
                moreText.forEach(function(paragraph) {
                    paragraph.style.display = "block";
                });
                btnText.innerHTML = "Tampilkan Lebih Sedikit";
            } else {
                moreText.forEach(function(paragraph) {
                    paragraph.style.display = "none";
                });
                btnText.innerHTML = "Baca Selengkapnya";
            }
        }
    </script>
@endsection
