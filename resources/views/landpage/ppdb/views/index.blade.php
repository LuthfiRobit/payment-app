@php
    $currentDate = \Carbon\Carbon::now();
    $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
    $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
    $startDate = \Carbon\Carbon::parse($activeSetting->tanggal_mulai ?? null);
    $endDate = \Carbon\Carbon::parse($activeSetting->tanggal_selesai ?? null);
@endphp

@extends('layouts-landpage.app')

@section('this-page-style')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <style>
        .no-list-style {
            list-style-type: none !important;
            counter-reset: none !important;
        }
    </style>
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative about-banner"
        style="background: url({{ asset('template-landpage/img/bg-ai-2.png') }}) !important" id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white" data-aos="fade-up" data-aos-duration="1200">
                        Informasi Pendaftaran Peserta Didik Baru (PPDB)
                    </h1>
                    <p class="text-white link-nav" data-aos="fade-down" data-aos-duration="1000">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="{{ route('landpage.ppdb.index') }}"> PPDB</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <section class="sample-text-area">
        <div class="container">
            @if ($activeSetting && $currentDate->between($startDate, $endDate))
                <!-- Tanggal -->
                <div class="mb-5 text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h4 class="mb-3">Jadwal Pendaftaran</h4>
                    <blockquote class="generic-blockquote">
                        Pendaftaran PPDB dibuka mulai
                        <strong>{{ $startDate->translatedFormat('d F Y') }}</strong> hingga
                        <strong>{{ $endDate->translatedFormat('d F Y') }}</strong>. Seluruh calon peserta
                        didik diharapkan melakukan pengisian data secara lengkap
                        sebelum tanggal penutupan.
                    </blockquote>
                </div>
            @else
                <div class="alert alert-danger text-center" role="alert" data-aos="zoom-in" data-aos-duration="1000">
                    <h4 class="alert-heading text-danger">Pendaftaran Belum/Telah Ditutup</h4>
                    <p>Saat ini pendaftaran PPDB belum dibuka atau sudah ditutup. Silakan cek kembali jadwal resmi atau
                        hubungi panitia PPDB untuk informasi lebih lanjut.</p>
                </div>
            @endif
        </div>

        <div class="container mt-4" data-aos="fade-up" data-aos-duration="1200">
            <img src="{{ asset('template-landpage/img/ppdb_image.jpg') }}" alt="Informasi PPDB"
                class="img-fluid rounded shadow-sm">
        </div>
    </section>
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true // animasi hanya terjadi sekali
        });
    </script>
@endsection
