@extends('layouts-landpage.app')

@section('this-page-style')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative" style="background: url({{ asset('template-landpage/img/bg-ai-1.png') }}) !important"
        id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white" data-aos="fade-up" data-aos-duration="1200"> Ekstrakurikuler</h1>
                    <p class="text-white link-nav" data-aos="fade-down" data-aos-duration="1000">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="{{ route('landpage.visi.index') }}"> Ekstrakurikuler</a>
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
                <!-- Konten Utama: Ekstrakurikuler -->
                <div class="col-lg-8 posts-list">
                    <div class="single-post">

                        <!-- Judul Halaman -->
                        <h2 class="mb-3" data-aos="fade-down" data-aos-duration="800">Ekstrakurikuler</h2>
                        <p class="text-muted mb-4" data-aos="fade-down" data-aos-delay="100" data-aos-duration="700">
                            Madrasah Ibtidaiyah Ihyauddiniyah – Desa Kecik, Kecamatan Besuk, Kabupaten Probolinggo
                        </p>

                        <!-- Paragraf Pembuka -->
                        <p class="text-justify" data-aos="fade-up" data-aos-delay="200" data-aos-duration="700">
                            Untuk menunjang pengembangan potensi peserta didik secara menyeluruh, MI Ihyauddiniyah
                            menyediakan berbagai program ekstrakurikuler yang terbagi dalam dua kelompok utama: akademik dan
                            non-akademik. Program ini dirancang sebagai sarana pembentukan karakter, keterampilan, dan bakat
                            siswa di luar pembelajaran kelas.
                        </p>

                        <!-- Ekstrakurikuler Akademik -->
                        <div class="mt-5" data-aos="fade-up" data-aos-delay="300" data-aos-duration="700">
                            <h4 class="mb-3"><span class="lnr lnr-book"></span> Ekstrakurikuler Akademik</h4>
                            <p class="text-justify">
                                Kegiatan ekstrakurikuler akademik dirancang untuk memperkuat kemampuan belajar dan
                                memperluas wawasan siswa dalam bidang keilmuan dan bahasa.
                            </p>
                            <ul class="unordered-list">
                                <li><strong>Tahfidz Al-Qur’an</strong> – Menghafal Al-Qur’an dengan metode talaqqi,
                                    ditargetkan khatam Juz 30.</li>
                                <li><strong>Bahasa Arab</strong> – Memperkuat dasar bahasa Arab melalui latihan membaca dan
                                    percakapan sederhana.</li>
                                <li><strong>Bahasa Inggris</strong> – Pengenalan kosakata dan kalimat dasar dalam Bahasa
                                    Inggris secara komunikatif.</li>
                                <li><strong>Kelas Baca Tulis Iqra’</strong> – Bimbingan khusus untuk siswa yang membutuhkan
                                    pendalaman membaca huruf hijaiyah.</li>
                            </ul>
                        </div>

                        <!-- Ekstrakurikuler Non-Akademik -->
                        <div class="mt-5" data-aos="fade-up" data-aos-delay="400" data-aos-duration="700">
                            <h4 class="mb-3"><span class="lnr lnr-graduation-hat"></span> Ekstrakurikuler Non-Akademik
                            </h4>
                            <p class="text-justify">
                                Kegiatan non-akademik bertujuan mengembangkan soft skill, kreativitas, kepemimpinan, serta
                                kecintaan terhadap budaya Islam.
                            </p>
                            <ul class="unordered-list">
                                <li><strong>Pramuka</strong> – Melatih kemandirian, kepemimpinan, dan semangat kebersamaan
                                    siswa.</li>
                                <li><strong>Hadrah</strong> – Seni musik Islami tradisional yang mengasah keterampilan
                                    ritmis dan keberanian tampil di depan umum.</li>
                                <li><strong>Kaligrafi</strong> – Seni menulis huruf Arab sebagai wujud kecintaan terhadap
                                    nilai estetika Islam.</li>
                                <li><strong>Olahraga</strong> – Kegiatan seperti futsal, senam pagi, dan permainan edukatif
                                    untuk meningkatkan kesehatan jasmani.</li>
                            </ul>
                        </div>

                        <!-- Jadwal Kegiatan -->
                        <div class="mt-5" data-aos="fade-up" data-aos-delay="500" data-aos-duration="700">
                            <h4 class="mb-3"><span class="lnr lnr-calendar-full"></span> Jadwal Ekstrakurikuler</h4>
                            <ol class="ordered-list">
                                <li><strong>Senin</strong> – Tahfidz & Hadrah</li>
                                <li><strong>Rabu</strong> – Pramuka</li>
                                <li><strong>Jumat</strong> – Kaligrafi & Bahasa Arab</li>
                                <li><strong>Sabtu</strong> – Bahasa Inggris & Kegiatan Olahraga</li>
                            </ol>
                        </div>

                        <!-- Manfaat Ekstrakurikuler -->
                        <div class="mt-5" data-aos="fade-up" data-aos-delay="600" data-aos-duration="700">
                            <h4 class="mb-3"><span class="lnr lnr-thumbs-up"></span> Manfaat Kegiatan Ekstrakurikuler</h4>
                            <ul class="unordered-list">
                                <li>Meningkatkan kepercayaan diri dan kemampuan bersosialisasi</li>
                                <li>Mengembangkan potensi bakat dan minat anak secara positif</li>
                                <li>Membentuk jiwa kepemimpinan, kemandirian, dan kerja sama</li>
                                <li>Mendorong semangat belajar serta kecintaan terhadap nilai-nilai Islam</li>
                            </ul>
                        </div>

                        <!-- Penutup -->
                        <div class="mt-5" data-aos="fade-up" data-aos-delay="700" data-aos-duration="700">
                            <p class="text-justify">
                                Kami percaya bahwa pendidikan tidak hanya terbatas di ruang kelas. Melalui kegiatan
                                ekstrakurikuler yang bervariasi dan bermakna, MI Ihyauddiniyah mendampingi siswa tumbuh
                                menjadi pribadi yang berilmu, beriman, dan berakhlak mulia. Setiap kegiatan dilaksanakan
                                dengan pengawasan guru pembina yang kompeten dan penuh tanggung jawab.
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Sidebar Kanan -->
                <div class="col-lg-4 sidebar-widgets" data-aos="fade-left" data-aos-delay="300" data-aos-duration="800">
                    <div class="widget-wrap mb-3">
                        <div class="single-sidebar-widget popular-post-widget">
                            <h4 class="popular-title">Artikel Populer</h4>
                            <div class="popular-post-list" id="artikel-populer">
                                <!-- Artikel populer akan dimuat di sini -->
                            </div>
                        </div>
                    </div>

                    <div class="widget-wrap">
                        <div class="single-sidebar-widget popular-post-widget">
                            <h4 class="popular-title">Berita Populer</h4>
                            <div class="popular-post-list" id="berita-populer">
                                <!-- Berita populer akan dimuat di sini -->
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
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    @include('landpage.ekstrakurikuler.scripts.list')
    <script>
        AOS.init({
            once: true // animasi hanya terjadi sekali
        });
    </script>
@endsection
