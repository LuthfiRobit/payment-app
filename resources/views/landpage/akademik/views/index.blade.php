@extends('layouts-landpage.app')

@section('this-page-style')
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative" style="background: url({{ asset('template-landpage/img/bg-ai-1.png') }}) !important"
        id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">Akademik</h1>
                    <p class="text-white link-nav">
                        <a href="{{ url('/') }}">Home </a>
                        <span class="lnr lnr-arrow-right"></span><a href="#">Akademik</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <!-- Start post-content Area -->
    <section class="post-content-area single-post-area">
        <div class="container">
            <div class="row">
                <!-- Konten Utama: Informasi Akademik -->
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <!-- Judul Halaman -->
                        <div class="mb-4">
                            <h2 class="mb-3">Informasi Akademik</h2>
                            <p class="text-muted mb-0">
                                Madrasah Ibtidaiyah Ihyauddiniyah<br>
                                Desa Kecik, Kecamatan Besuk, Kabupaten Probolinggo
                            </p>
                        </div>

                        <!-- Gambaran Umum -->
                        <p class="text-justify">
                            MI Ihyauddiniyah adalah lembaga pendidikan dasar Islam yang berfokus pada pengembangan akhlak
                            mulia, kecerdasan akademik, dan keterampilan sosial siswa. Kami mengedepankan pendekatan
                            pembelajaran yang aktif, menyenangkan, dan berbasis nilai-nilai keislaman.
                        </p>

                        <!-- Kurikulum -->
                        <div class="mt-5">
                            <h4 class="mb-3">Kurikulum</h4>
                            <p class="text-justify">
                                Madrasah menerapkan Kurikulum 2013 (K-13) yang terintegrasi dengan kurikulum dari
                                Kementerian Agama Republik Indonesia. Kurikulum ini dirancang untuk membentuk peserta didik
                                yang kompeten dalam ilmu pengetahuan dan memiliki karakter Islami yang kuat.
                            </p>
                            <p class="text-justify">
                                Pembelajaran dikembangkan secara tematik terpadu dan kontekstual, dengan menyeimbangkan
                                antara pelajaran umum dan agama.
                            </p>
                        </div>

                        <!-- Mata Pelajaran -->
                        <div class="mt-5">
                            <h4 class="mb-3">Mata Pelajaran</h4>
                            <p class="text-justify">Berikut adalah kelompok mata pelajaran yang diajarkan di MI
                                Ihyauddiniyah:</p>
                            <ul class="unordered-list">
                                <li>Pelajaran Umum: Matematika, Bahasa Indonesia, IPA, IPS, PPKn</li>
                                <li>Pelajaran Agama: Al-Qur’an Hadis, Akidah Akhlak, Fiqih, SKI (Sejarah Kebudayaan Islam),
                                    Bahasa Arab</li>
                                <li>Pelajaran Tambahan: Bahasa Inggris Dasar, Pendidikan Jasmani dan Kesehatan, SBdP (Seni
                                    Budaya dan Prakarya)</li>
                            </ul>
                        </div>

                        <!-- Kegiatan Akademik -->
                        <div class="mt-5">
                            <h4 class="mb-3">Kegiatan Akademik</h4>
                            <p class="text-justify">
                                Kegiatan akademik disusun dalam kalender pendidikan tahunan. Semua aktivitas dirancang untuk
                                membentuk kedisiplinan, semangat belajar, dan penguatan karakter Islami.
                            </p>
                            <ol class="ordered-list">
                                <li>Pembelajaran tatap muka di kelas</li>
                                <li>Penilaian harian, tengah semester, dan akhir semester</li>
                                <li>Program pembiasaan ibadah harian</li>
                                <li>Pesantren Ramadhan dan peringatan hari besar Islam</li>
                                <li>Kegiatan literasi dan numerasi siswa</li>
                            </ol>
                        </div>

                        <!-- Sistem Penilaian -->
                        <div class="mt-5">
                            <h4 class="mb-3">Sistem Penilaian</h4>
                            <p class="text-justify">
                                Penilaian di MI Ihyauddiniyah mencakup aspek pengetahuan, keterampilan, dan sikap. Evaluasi
                                dilakukan secara berkelanjutan dan berorientasi pada pertumbuhan karakter serta prestasi
                                siswa.
                            </p>
                            <ul class="unordered-list">
                                <li>Ulangan Harian dan Tugas</li>
                                <li>Penilaian Proyek dan Portofolio</li>
                                <li>Ujian Tengah dan Akhir Semester</li>
                                <li>Observasi dan penilaian karakter harian</li>
                            </ul>
                        </div>

                        <!-- Program Unggulan -->
                        <div class="mt-5">
                            <h4 class="mb-3">Program Unggulan</h4>
                            <ul class="unordered-list">
                                <li><strong>Tahfidz Juz 30</strong> – Menghafal Al-Qur’an secara bertahap dengan
                                    pendampingan guru tahfidz.</li>
                                <li><strong>Pendidikan Karakter Islami</strong> – Melalui kegiatan keagamaan rutin dan
                                    pembiasaan akhlak mulia.</li>
                                <li><strong>Ekstrakurikuler</strong> – Pramuka, Hadrah, Kaligrafi, dan Seni Islami lainnya.
                                </li>
                                <li><strong>Penguatan Bahasa Asing</strong> – Pengantar dasar Bahasa Arab dan Bahasa Inggris
                                    sejak dini.</li>
                            </ul>
                        </div>

                        <!-- Penutup -->
                        <div class="mt-5">
                            <p class="text-justify">
                                Melalui sistem akademik yang terstruktur dan berlandaskan nilai-nilai Islam, MI
                                Ihyauddiniyah berkomitmen mendidik generasi yang unggul dalam ilmu, iman, dan akhlak. Kami
                                mengundang masyarakat untuk berkolaborasi membentuk masa depan yang cerah melalui pendidikan
                                dasar yang berkualitas.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Kanan -->
                <div class="col-lg-4 sidebar-widgets">
                    <div class="widget-wrap">
                        <div class="single-sidebar-widget popular-post-widget">
                            <h4 class="popular-title">Postingan Populer</h4>
                            <div class="popular-post-list">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End post-content Area -->
@endsection

@section('this-page-scripts')
    {{-- @include('landpage.berita.scripts.show') --}}
@endsection
