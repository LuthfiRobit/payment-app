@extends('layouts-landpage.app')

@section('this-page-style')
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative" style="background: url({{ asset('template-landpage/img/bg-ai-2.png') }}) !important"
        id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">Pimpinan Sekolah</h1>
                    <p class="text-white link-nav">
                        <a href="{{ url('/') }}">Home </a>
                        <span class="lnr lnr-arrow-right"></span><a href="#">Pimpinan Sekolah</a>
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
                <!-- Konten Utama: Sambutan -->
                <div class="col-lg-8 posts-list">
                    <div class="single-post">
                        <div class="row align-items-start">
                            <!-- Foto Kepala Sekolah -->
                            <div class="col-md-4 text-center mb-3">
                                <img src="https://placehold.co/300x400?text=FOTO+KEPALA-SEKOLAH" alt="Kepala Sekolah"
                                    class="img-fluid rounded">
                                <h5 class="mt-3 mb-0">Drs. Budi Santoso</h5>
                                <p class="mb-0">Kepala Sekolah</p>
                            </div>

                            <!-- Sambutan Utama -->
                            <div class="col-md-8">
                                <h3 class="mb-3">Sambutan Kepala Sekolah</h3>
                                <p class="text-justify">
                                    Assalamu’alaikum Warahmatullahi Wabarakatuh,<br><br>
                                    Dengan penuh rasa syukur dan bangga, saya menyambut Anda di website resmi sekolah kami.
                                    Website ini hadir sebagai sarana informasi dan komunikasi antara sekolah dengan
                                    masyarakat
                                    luas.
                                    <br><br>
                                    Melalui platform ini, kami ingin menunjukkan komitmen kami dalam memberikan pendidikan
                                    yang
                                    unggul, berkarakter, dan siap menghadapi tantangan zaman.
                                </p>
                            </div>
                        </div>

                        <!-- Paragraf Tambahan Full Width -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <p class="text-justify">
                                    Kami percaya bahwa kolaborasi antara guru, siswa, orang tua, dan masyarakat akan menjadi
                                    kekuatan utama dalam mencapai visi dan misi sekolah. Dengan dukungan teknologi dan
                                    semangat inovasi, kami siap melangkah ke depan membawa perubahan positif demi masa depan
                                    generasi penerus bangsa. Terima kasih atas kunjungan Anda, semoga informasi yang kami
                                    sajikan dapat bermanfaat.
                                </p>
                            </div>
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
