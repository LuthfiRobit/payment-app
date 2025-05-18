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
                    <h1 class="text-white">Guru dan Karyawan</h1>
                    <p class="text-white link-nav">
                        <a href="{{ url('/') }}">Home </a>
                        <span class="lnr lnr-arrow-right"></span><a href="#">Guru dan Karyawan</a>
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
                <!-- Konten Utama -->
                <div class="col-lg-12">
                    <div class="single-post">

                        <!-- Judul -->
                        <div class="text-center mb-5">
                            <h2 class="mb-3">Guru & Karyawan</h2>
                            <p class="text-muted">
                                Berikut adalah daftar guru dan tenaga kependidikan di Madrasah Ibtidaiyah Ihyauddiniyah.
                            </p>
                        </div>

                        <!-- Daftar Guru -->
                        <h4 class="mb-4"><span class="lnr lnr-users"></span> Data Guru</h4>
                        <div class="row justify-content-center" id="guru-container">
                            <!-- Card Guru -->

                        </div>

                        <!-- Daftar Karyawan -->
                        <h4 class="mt-5 mb-4"><span class="lnr lnr-briefcase"></span> Data Karyawan</h4>
                        <div class="row justify-content-center" id="karyawan-container">
                            <!-- Card Karyawan -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End post-content Area -->
@endsection

@section('this-page-scripts')
    @include('landpage.guru.scripts.list')
@endsection
