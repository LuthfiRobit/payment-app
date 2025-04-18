@extends('layouts-landpage.app')

@section('this-page-style')
@endsection

@section('content')
    @php
        $currentDate = \Carbon\Carbon::now();
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
        $activeContact = \App\Helpers\AppHelper::getKontak();
        $activeAbout = \App\Helpers\AppHelper::getTentang();
        $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
    @endphp

    <!-- start banner Area -->
    <section class="banner-area relative about-banner"
        style="background: url({{ asset('template-landpage/img/bg-ai-3.png') }}) !important" id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">Hubungi Kami</h1>
                    <p class="text-white link-nav">
                        <a href="{{ url('/') }}">Beranda</a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="{{ route('landpage.kontak.index') }}"> Kontak</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <!-- End banner Area -->

    <!-- Start contact-page Area -->
    <section class="contact-page-area pt-70 pb-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 d-flex flex-column address-wrap">
                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-home"></span>
                        </div>
                        <div class="contact-details">
                            <h5> {{ $activeContact ? $activeContact->kontak_alamat : 'Belum ada data' }}</h5>
                            <p>Jawa Timur, Indonesia</p>
                        </div>
                    </div>
                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-phone-handset"></span>
                        </div>
                        <div class="contact-details">
                            <h5>
                                <a href="https://wa.me/{{ $activeContact ? $activeContact->kontak_telepon : '' }}"
                                    target="_blank"
                                    style="
                                            text-decoration: none;
                                            color: inherit;
                                        ">
                                    {{ $activeContact ? $activeContact->kontak_telepon : 'Belum ada data' }}
                                </a>
                            </h5>
                            <p>Senin - Jum'at</p>
                        </div>
                    </div>

                    <div class="single-contact-address d-flex flex-row">
                        <div class="icon">
                            <span class="lnr lnr-envelope"></span>
                        </div>
                        <div class="contact-details">
                            <h5>
                                <a href="mailto: {{ $activeContact ? $activeContact->kontak_email : '' }}"
                                    style="
                                            text-decoration: none;
                                            color: inherit;
                                        ">
                                    {{ $activeContact ? $activeContact->kontak_email : 'Belum ada data' }}
                                </a>
                            </h5>
                            <p>Silahkan kirim email anda</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="map-wrap" style="width: 100%; height: 445px" id="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d988.1853076079682!2d113.49050132226458!3d-7.817192144160499!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd6fdf5c5ea9d0f%3A0x4b6285952a92cd3!2sMIS%20IHYAUDDINIYAH!5e0!3m2!1sid!2sid!4v1744770187163!5m2!1sid!2sid"
                            width="100%" height="100%" style="border: 0" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End contact-page Area -->
@endsection

@section('this-page-scripts')
@endsection
