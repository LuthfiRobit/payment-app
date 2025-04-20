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
                <blockquote class="generic-blockquote text-center">
                    Mencetak generasi yang Santun, Terampil, dan Islami <br>
                    <strong class="text-bold">(SANTRI)</strong>
                    <br>
                    <em>SAN</em> -tun dalam perilaku, <em>TeR</em> -ampil dalam berkarya, <em>I</em> -slami dalam
                    pengamalan
                </blockquote>
            </div>

            <!-- Misi -->
            <div class="mb-5">
                <h4 class="mb-3">MISI</h4>
                <ol class="ordered-list">
                    <li>
                        <span>Pembinaan dan Pengembangan sikap Perilaku dalam kehidupan sehari-hari dengan mengedepankan
                            akhlaqul karimah.</span>
                    </li>
                    <li>
                        <span>Penyelenggaraan pendidikan yang memberi kesempatan luas pada peserta didik untuk mengembangkan
                            kemampuan, bakat dan minat.</span>
                    </li>
                    <li>
                        <span>Meningkatkan penguasaan ilmu pengetahuan dan teknologi dengan mengoptimalkan potensi akademik
                            yang dimiliki oleh setiap siswa.</span>
                    </li>
                    <li>
                        <span>Melaksanakan pembinaan secara intensif serta berpartisipasi aktif dalam ajang kompetisi di
                            bidang ilmu pengetahuan, teknologi, seni dan budaya baik di tingkat lokal maupun
                            nasional.</span>
                    </li>
                    <li>
                        <span>Mengutamakan dan menjunjung tinggi asas keislaman serta berwawasan kebangsaan dan berjiwa
                            demokratis.</span>
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

                <ol class="ordered-list">
                    <li>
                        <span>Pembiasaan berperilaku jujur, sopan, dan tanggung jawab.</span>
                    </li>
                    <li>
                        <span>Meningkatkan profesionalisme pendidik dan tenaga kependidikan yang sesuai dengan bidangnya
                            masing-masing.</span>
                    </li>
                    <li>
                        <span>Meningkatkan prestasi akademik peserta didik.</span>
                    </li>
                    <li>
                        <span>Memenuhi standar sarana dan prasarana yang sesuai dengan Standar Pendidikan Nasional.</span>
                    </li>
                    <li>
                        <span>Memenuhi standar manajemen madrasah yang transparan dan akuntabel.</span>
                    </li>
                    <li>
                        <span>Meningkatkan kemampuan membaca, memahami, dan mengamalkan Al-Qur’an dengan baik dan
                            benar.</span>
                    </li>
                    <li>
                        <span>Pembiasaan pengamalan sholat berjamaah (Dhuhur) di madrasah.</span>
                    </li>
                </ol>
            </div>

        </div>
    </section>
@endsection

@section('this-page-scripts')
@endsection
