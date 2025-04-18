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
                        Visi dan Misi Madrasah Ibtidaiyah Ihyauddiniyah
                    </h1>
                    <p class="text-white link-nav">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="{{ route('landpage.visi.index') }}"> Visi Misi</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <section class="sample-text-area pt-70 pb-10">
        <div class="container">
            <h3 class="text-heading text-center mb-4">
                Visi, Misi, Motto dan Tujuan Madrasah
            </h3>

            <!-- Visi -->
            <div class="mb-5">
                <h4 class="mb-3">VISI</h4>
                <blockquote class="generic-blockquote">
                    Mewujudkan Madrasah Yang Unggul, Profesional,
                    Berkarakter, Berkemajuan, dan Berwawasan Lingkungan.
                </blockquote>
            </div>

            <!-- Misi -->
            <div class="mb-5">
                <h4 class="mb-3">MISI</h4>
                <ol class="ordered-list">
                    <li><span>Mewujudkan Madrasah Yang Unggul</span></li>
                    <li>
                        <span>Mewujudkan Madrasah Yang Berkualitas</span>
                    </li>
                    <li><span>Mewujudkan Madrasah Berkarakter</span></li>
                    <li>
                        <span>Mewujudkan Madrasah Yang Humanis, Responsif,
                            dan Ramah Lingkungan</span>
                    </li>
                    <li>
                        <span>Mewujudkan Madrasah Sebagai Rumah Tumbuhnya
                            Inovasi dan Kreativitas</span>
                    </li>
                </ol>
            </div>

            <!-- Motto -->
            <div class="mb-5">
                <h4 class="mb-3">MOTTO</h4>
                <blockquote class="generic-blockquote text-center">
                    “Membangun Pondasi Iman, Ilmu dan Akhlaqul Karimah”
                </blockquote>
            </div>

            <!-- Tujuan -->
            <div class="mb-5">
                <h4 class="mb-3">TUJUAN MADRASAH</h4>

                <h5 class="mb-2">Tujuan Umum</h5>
                <ol class="ordered-list">
                    <li>
                        <span>Mengembangkan Sistem Pendidikan Madrasah Secara
                            Profesional, Agar Menjadi Madrasah Yang Unggul
                            Dan Berdaya Saing Di Era Globalisasi.</span>
                    </li>
                    <li>
                        <span>Meningkatkan Kompetensi Dan Profesionalisme
                            Pendidik Dan Tenaga Kependidikan.</span>
                    </li>
                    <li>
                        <span>Mengembangkan Kreasi, Inspirasi Dan Inovasi
                            Siswa Melalui Sarana Dan Prasarana Yang
                            Memadai.</span>
                    </li>
                    <li>
                        <span>Membina Siswa-Siswi Shalih-Shalihah Dan
                            Berprestasi Berdasarkan Iman Dan Taqwa.</span>
                    </li>
                    <li>
                        <span>Membentuk Karakter Islami Siswa-Siswi Secara
                            Optimal.</span>
                    </li>
                    <li>
                        <span>Mengembangkan Potensi Fisik Dan Intelektual
                            Siswa-Siswi Secara Optimal.</span>
                    </li>
                    <li>
                        <span>Menumbuhkan Jiwa Tawadhu’ (Ramah, Rendah Hati),
                            Ta’awun (Tolong Menolong), Tasamuh (Toleransi),
                            Dan Tawasuth (Moderat).</span>
                    </li>
                    <li><span>Menumbuhkan Nilai-Nilai Humanis.</span></li>
                    <li>
                        <span>Menumbuhkan Kepedulian Siswa-Siswi Terhadap
                            Lingkungan Kehidupan (Caring, Sharing Dan
                            Empati).</span>
                    </li>
                    <li>
                        <span>Menumbuhkan Perilaku Ramah Lingkungan.</span>
                    </li>
                </ol>
            </div>
        </div>
    </section>
@endsection

@section('this-page-scripts')
@endsection
