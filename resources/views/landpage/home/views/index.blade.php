@extends('layouts.landpageApp')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
@endsection

@section('content')
    @php
        $currentDate = \Carbon\Carbon::now();
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
        $activeContact = \App\Helpers\AppHelper::getKontak();
        $activeAbout = \App\Helpers\AppHelper::getTentang();
        $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
    @endphp

    <!-- Conatiner Section start -->
    <div class="container-large">
        <div id="section-home" class="custom-banner-image-section position-relative">
            <div class="custom-image">
                <img src="{{ asset('template/images/sidebar-img/2.jpg') }}" class="img-fluid w-100" alt="Banner Image">
                <div
                    class="custom-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center text-white">
                    <div class="custom-text-content text-center">
                        <h3 class="fw-bold">Aplikasi Pendaftaran Peserta Didik Baru</h3>
                        <span class="d-block mb-3">Untuk Madrasah Ibtidaiyah Ihyauddiniyah di Desa Kecik Besuk
                            Probolinggo</span>
                        <p class="mb-4">Aplikasi ini memudahkan proses pendaftaran, pengelolaan data peserta
                            didik,
                            dan administrasi dengan desain responsif serta fitur yang user-friendly.</p>
                        <a href="{{ route('landpage.ppdb.registration') }}" class="btn btn-primary light btn-md text-white">
                            Daftar Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div id="section-pendaftaran" class="py-3 mt-4">
            <div class="container">
                <div class="text-start mb-4">
                    <h2>
                        <span>Pendaftaran Peserta Didik Baru</span>
                    </h2>
                    <p>Informasi penting mengenai pendaftaran untuk Madrasah Ibtidaiyah Ihyauddiniyah.</p>
                </div>

                <!-- Informasi Pendaftaran -->
                <div class="row g-3">
                    <!-- Link Pendaftaran -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column text-center">
                                <div class="mb-3">
                                    <i class="bi bi-person-plus fs-1 text-warning bg-light rounded-circle p-2"></i>
                                </div>
                                <h5 class="card-title">Pendaftaran Online</h5>
                                <p class="card-text text-muted">Daftar sekarang untuk menjadi bagian dari kami!</p>
                                <a href="{{ route('landpage.ppdb.registration') }}" class="btn btn-primary mt-auto">Daftar
                                    Sekarang</a>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Pendaftaran -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column text-center">
                                <div class="mb-3">
                                    <i class="bi bi-calendar-check fs-1 text-primary bg-light rounded-circle p-2"></i>
                                </div>
                                <h5 class="card-title">Jadwal Pendaftaran</h5>
                                <p class="card-text text-muted">Pendaftaran Peserta Didik Baru akan dibuka dari:
                                </p>
                                <p class="fw-bold text-danger">
                                    {{ $activeSetting ? \Carbon\Carbon::parse($activeSetting->tanggal_mulai)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($activeSetting->tanggal_selesai)->translatedFormat('d F Y') : 'Belum ada data' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Biaya Pendaftaran -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column text-center">
                                <div class="mb-3">
                                    <i class="bi bi-credit-card fs-1 text-success bg-light rounded-circle p-2"></i>
                                </div>
                                <h5 class="card-title">Biaya Pendaftaran</h5>
                                <p class="card-text text-muted">Biaya pendaftaran untuk Peserta Didik Baru:</p>
                                <p class="fw-bold text-danger">
                                    {{ $activeSetting ? \Number::currency($activeSetting->biaya_pendaftaran, 'IDR', 'id') : 'Belum ada data' }}
                                </p>
                                <small class="text-muted">Biaya ini sudah mencakup biaya administrasi dan
                                    perlengkapan awal.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Kontak yang Bisa Dihubungi -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column text-center">
                                <div class="mb-3">
                                    <i class="bi bi-telephone fs-1 text-info bg-light rounded-circle p-2"></i>
                                </div>
                                <h5 class="card-title">Kontak Kami</h5>
                                <p class="card-text text-muted">Jika Anda memiliki pertanyaan atau membutuhkan
                                    bantuan, silakan hubungi:</p>
                                <p class="fw-bold text-info">
                                    {{ $activeContact ? $activeContact->kontak_telepon : 'Belum ada data' }}</p>
                                <small class="text-muted">Email:
                                    <a href="mailto:{{ $activeContact ? $activeContact->kontak_email : '' }}">
                                        {{ $activeContact ? $activeContact->kontak_email : 'Belum ada data' }}
                                    </a>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Alert Information -->
                <div class="alert alert-warning mt-4" role="alert">
                    <h4 class="alert-heading">Penting!</h4>
                    <p>Pastikan Anda melengkapi semua dokumen yang diperlukan sebelum melakukan pendaftaran online.
                        Untuk informasi lebih lanjut, kunjungi halaman FAQ atau hubungi kami melalui kontak yang
                        tersedia.</p>
                    <hr>
                    <p class="mb-0">Jangan lewatkan kesempatan untuk bergabung dengan Madrasah Ibtidaiyah
                        Ihyauddiniyah!</p>
                </div>

                <!-- Button untuk membuka modal FAQs -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#faqModal">FAQ -
                        Pertanyaan yang Sering Diajukan</button>
                </div>
            </div>
        </div>
        <div id="section-tentang" class="py-3 mb-5">
            <div class="container">
                <div class="text-end mb-4">
                    <h2>
                        <span>Tentang</span>
                    </h2>
                </div>
                <div class="row align-items-center">
                    <!-- Image Column -->
                    <div class="col-lg-6">
                        <div class="about-image">
                            <img src=" {{ $activeAbout ? asset($activeAbout->img) : asset('template/images/under-m.png') }}"
                                alt="about" class="img-fluid rounded shadow-sm">
                        </div>
                    </div>

                    <!-- Content Column -->
                    <div class="col-lg-6 col-md-12">
                        <div class="inner-column">
                            <div class="sec-title">
                                <h2>
                                    Sekilas tentang
                                    <span>Madrasah Ibtidaiyah Ihyauddiniyah</span>
                                </h2>
                            </div>
                            <div class="text">
                                <p>
                                    {{ $activeAbout ? $activeAbout->deskripsi : 'Belum ada data' }}
                                </p>
                            </div>
                            <div class="signature"
                                style="font-family: 'Dancing Script', cursive; font-size: 24px; color: #555; position: relative; margin-top: 20px;">
                                <span style="text-decoration: underline; cursor: pointer;"
                                    onmouseover="this.style.color='#007bff'" onmouseout="this.style.color='#555'">
                                    Madrasah Ibtidaiyah Ihyauddiniyah
                                </span>
                                <span style="display: block; font-size: 18px; color: #777;">Tim Pengajar &
                                    Pengelola</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Container Section end -->


    <!-- Modal FAQ -->
    <div class="modal fade" id="faqModal" tabindex="-1" aria-labelledby="faqModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="faqModalLabel">Pertanyaan yang Sering Diajukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6>1. Apa saja syarat pendaftaran?</h6>
                    <p>Dokumen yang perlu disiapkan antara lain: Kartu Keluarga, Akta Kelahiran, dan foto
                        terbaru.</p>
                    <h6>2. Bagaimana cara membayar biaya pendaftaran?</h6>
                    <p>Silahkan hubungi admin pada nomor :
                        {{ $activeContact ? $activeContact->kontak_telepon : 'Belum ada data' }}</p>
                    <h6>3. Apakah ada kuota pendaftaran?</h6>
                    <p>Silahkan hubungi admin pada nomor :
                        {{ $activeContact ? $activeContact->kontak_telepon : 'Belum ada data' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('main.dashboard.views.create') --}}
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- @include('main.dashboard.scripts.show') --}}
@endsection
