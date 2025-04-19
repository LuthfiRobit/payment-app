@php
    $currentDate = \Carbon\Carbon::now();
    $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
    $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
    $startDate = \Carbon\Carbon::parse($activeSetting->tanggal_mulai ?? null);
    $endDate = \Carbon\Carbon::parse($activeSetting->tanggal_selesai ?? null);
@endphp

@extends('layouts-landpage.app')

@section('this-page-style')
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
                    <h1 class="text-white">
                        Informasi Pendaftaran Peserta Didik Baru (PPDB)
                    </h1>
                    <p class="text-white link-nav">
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
                <div class="mb-5 text-center">
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
                <div class="alert alert-danger text-center" role="alert">
                    <h4 class="alert-heading text-danger">Pendaftaran Belum/Telah Ditutup</h4>
                    <p>Saat ini pendaftaran PPDB belum dibuka atau sudah ditutup. Silakan cek kembali jadwal resmi atau
                        hubungi panitia PPDB untuk informasi lebih lanjut.</p>
                </div>
            @endif
        </div>

        <div class="container">
            <h4 class="mb-3">KEBUTUHAN DATA</h4>
            <div class="row mb-3">
                <div class="col-lg-12">
                    <h5 class="mb-2">Data Siswa</h5>
                    <ol class="ordered-list">
                        <li>
                            <span>Foto Siswa</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Foto ukuran 3x4
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>NIK (sesuai KK)</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Nomor Induk Kependudukan sesuai dengan
                                    Kartu Keluarga
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Nama Lengkap Siswa</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Diisi dengan nama lengkap calon siswa
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Nama Panggilan</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Nama panggilan calon siswa
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Tempat Lahir</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Tempat lahir calon siswa (Contoh:
                                    Probolinggo)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Tanggal Lahir</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Tanggal lahir calon siswa
                                    (Format:YYYY-MM-DD)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Jenis Kelamin</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Pilih jenis kelamin calon siswa
                                    (Pilihan: Laki-laki, Perempuan)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Usia saat mendaftar</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Usia calon siswa saat melakukan
                                    pendaftaran (dalam tahun)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Jumlah Saudara</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Jumlah saudara kandung calon siswa
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Anak ke</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Urutan anak calon siswa dalam keluarga
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Nomor Songkok/Peci</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Nomor ukuran songkok/peci calon siswa
                                    (jika ada) (Pilihan angka 1-10)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Nomor HP/WA</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Nomor telepon atau WhatsApp yang aktif
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Alamat Email</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Alamat email yang aktif
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Jarak dari rumah ke sekolah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Jarak perkiraan dari rumah calon siswa
                                    ke sekolah (dalam kilometer)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Perjalanan ke sekolah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Cara calon siswa pergi ke sekolah
                                    (Pilihan: Jalan Kaki, Bersepeda, Naik
                                    Motor, Naik Mobil, Naik Angkot, Naik
                                    Ojek, Lainnya)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Sekolah sebelum MI</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Nama sekolah sebelumnya (TK/RA)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Nama RA/TK</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Nama lengkap RA/TK sebelumnya
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Alamat RA/TK</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Alamat lengkap RA/TK sebelumnya
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Imunisasi yang telah diikuti</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Daftar imunisasi yang telah diterima
                                    calon siswa (Pilihan: BCG, DPT, Polio,
                                    Campak, Hepatitis B)
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-6">
                    <h5 class="mb-2">Data Ayah</h5>
                    <ol class="ordered-list">
                        <li>
                            <span>Nama Ayah Kandung</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Budi
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Status Ayah Kandung</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Hidup
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>NIK Ayah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    -
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Tempat Lahir Ayah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Probolinggo
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Tanggal Lahir Ayah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    -
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Pendidikan Terakhir Ayah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Pilihan: SD, SMP, SMA, Diploma, Sarjana,
                                    Pasca Sarjana
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Pekerjaan Ayah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Pilihan: Pegawai Negeri, Swasta,
                                    Wiraswasta, Buruh, Lainnya
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Penghasilan per bulan (IDR) Ayah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Dalam Rupiah
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Alamat Lengkap Ayah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Jl. Kebangsaan No.10
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Foto KTP Ayah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Lurus dan jelas
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-6">
                    <h5 class="mb-2">Data Ibu</h5>
                    <ol class="ordered-list">
                        <li>
                            <span>Nama Ibu Kandung</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Siti
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Status Ibu Kandung</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Hidup
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>NIK Ibu</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    -
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Tempat Lahir Ibu</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Probolinggo
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Tanggal Lahir Ibu</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    -
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Pendidikan Terakhir Ibu</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Pilihan: SD, SMP, SMA, Diploma, Sarjana,
                                    Pasca Sarjana
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Pekerjaan Ibu</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Pilihan: Ibu Rumah Tangga, Guru, Pegawai
                                    Negeri, Swasta, Wiraswasta, Lainnya
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Penghasilan per bulan (IDR) Ibu</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Dalam Rupiah
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Alamat Ibu</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Jl. Kebangsaan No.10
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Foto KTP Ibu</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Lurus dan jelas
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-6">
                    <h5 class="mb-2">Status Keluarga</h5>
                    <ol class="ordered-list">
                        <li>
                            <span>Nama Kepala Keluarga</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Ahmad
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Nomor KK</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    -
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Alamat Rumah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Contoh: Jl. Kebangsaan No.10
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Yang Membiayai Sekolah</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Pilihan: Ayah, Ibu, Wali
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-6">
                    <h5 class="mb-2">Data Wali (Jika Ada)</h5>
                    <ol class="ordered-list">
                        <li>
                            <span>Nama Wali</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Diisi jika yang mengurus bukan orang tua
                                    (Contoh: Rahmat)
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Scan KK Wali</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Jika ada
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Scan Kartu PKH</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Jika ada
                                </li>
                            </ul>
                        </li>
                        <li>
                            <span>Scan Kartu KKS</span>
                            <ul class="unordered-list">
                                <li class="no-list-style">
                                    Jika ada
                                </li>
                            </ul>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('this-page-scripts')
@endsection
