@extends('layouts-landpage.app')

@section('this-page-style')
    <style>
        #modalImage {
            transition: opacity 0.3s ease-in-out;
            opacity: 0;
        }

        #modalImage[src]:not([src=""]) {
            opacity: 1;
        }
    </style>
@endsection

@section('content')
    <!-- start banner Area -->
    <section class="banner-area relative" style="background: url({{ asset('template-landpage/img/bg-ai-4.png') }}) !important"
        id="home">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row d-flex align-items-center justify-content-center">
                <div class="about-content col-lg-12">
                    <h1 class="text-white">Detail Berita</h1>
                    <p class="text-white link-nav">
                        <a href="{{ url('/') }}">Home </a>
                        <span class="lnr lnr-arrow-right"></span><a href="{{ route('landpage.berita.index') }}">Berita </a>
                        <span class="lnr lnr-arrow-right"></span>
                        <a href="#"> Detail berita</a>
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
                <div class="col-lg-8 posts-list" id="berita-detail">
                    <div class="single-post row">
                        <div class="col-lg-12">
                            <div class="feature-img">
                                <img id="gambar-berita" class="img-fluid" src="" alt="Gambar Berita" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 meta-details">
                            <div class="user-details row">
                                <p class="user-name col-lg-12 col-md-12 col-6">
                                    <a href="#" id="writer-berita">Loading...</a>
                                    <span class="lnr lnr-user"></span>
                                </p>
                                <p class="date col-lg-12 col-md-12 col-6">
                                    <a href="#" id="tanggal-berita">Loading...</a>
                                    <span class="lnr lnr-calendar-full"></span>
                                </p>
                                <p class="view col-lg-12 col-md-12 col-6">
                                    <a href="#" id="jumlah-dibaca">0 kali dibaca</a>
                                    <span class="lnr lnr-eye"></span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <h3 class="mt-20 mb-20" id="judul-berita">Judul</h3>
                            <div class="excert" id="isi-berita">
                                Isi berita loading...
                            </div>
                        </div>
                    </div>
                </div>

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
    @include('landpage.berita.scripts.show')
@endsection
