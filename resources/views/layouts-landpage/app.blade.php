<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Site Title -->
    <title>Madrasah Ibtidaiyah Ihyauddiniyah</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="Madrasah Ibtidaiyah Ihyauddiniyah" />
    <meta name="robots" content="index, follow" />

    <meta name="keywords"
        content="Pendaftaran Siswa Baru, Madrasah Ibtidaiyah Ihyauddiniyah, Desa Kecik Besuk, Probolinggo, Pendaftaran Sekolah, Aplikasi Pendaftaran, Sistem Pendaftaran, Pendidikan, Sekolah Dasar, Formulir Pendaftaran, Pendidikan Islam, Madrasah Ibtidaiyah, Sistem Informasi Pendaftaran, Aplikasi Pendidikan, UI Modern, Desain Responsif, Aplikasi Web, Sistem Administrasi, Formulir Online, Pendaftaran Mudah, Pengelolaan Pendaftaran" />

    <meta name="description"
        content="Aplikasi Pendaftaran Siswa Baru untuk Madrasah Ibtidaiyah Ihyauddiniyah di Desa Kecik Besuk Probolinggo. Aplikasi ini memudahkan proses pendaftaran siswa baru dengan sistem yang mudah digunakan, desain responsif, dan fitur yang mendukung administrasi pendaftaran dengan efisien." />

    <meta property="og:title"
        content="Pendaftaran Siswa Baru Madrasah Ibtidaiyah Ihyauddiniyah Desa Kecik Besuk Probolinggo" />
    <meta property="og:description"
        content="Aplikasi Pendaftaran Siswa Baru untuk Madrasah Ibtidaiyah Ihyauddiniyah di Desa Kecik Besuk Probolinggo. Aplikasi ini memudahkan proses pendaftaran siswa baru dengan sistem yang mudah digunakan, desain responsif, dan fitur yang mendukung administrasi pendaftaran dengan efisien." />
    <meta property="og:image" content="social-image.png" />

    <meta name="format-detection" content="telephone=no" />

    <meta name="twitter:title"
        content="Pendaftaran Siswa Baru Madrasah Ibtidaiyah Ihyauddiniyah Desa Kecik Besuk Probolinggo" />
    <meta name="twitter:description"
        content="Aplikasi Pendaftaran Siswa Baru untuk Madrasah Ibtidaiyah Ihyauddiniyah di Desa Kecik Besuk Probolinggo. Aplikasi ini memudahkan proses pendaftaran siswa baru dengan sistem yang mudah digunakan, desain responsif, dan fitur yang mendukung administrasi pendaftaran dengan efisien." />
    <meta name="twitter:image" content="social-image.png" />
    <meta name="twitter:card" content="summary_large_image" />

    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('template-landpage/img/logo_mi.png') }}" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet" />
    <!-- CSS -->

    @yield('this-page-style') <!-- Menyertakan Style tambahan dari halaman -->

    <link rel="stylesheet" href="{{ asset('template-landpage/css/linearicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-landpage/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-landpage/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-landpage/css/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-landpage/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-landpage/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-landpage/css/owl.carousel.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-landpage/css/jquery-ui.css') }}" />
    <link rel="stylesheet" href="{{ asset('template-landpage/css/main.css') }}" />
</head>

<body>

    @php
        $currentDate = \Carbon\Carbon::now();
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
        $activeContact = \App\Helpers\AppHelper::getKontak();
        $activeAbout = \App\Helpers\AppHelper::getTentang();
        $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
    @endphp

    @include('layouts-landpage.header')

    @yield('content')

    @include('layouts-landpage.footer')

    <script src="{{ asset('template-landpage/js/vendor/jquery-2.2.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="{{ asset('template-landpage/js/vendor/bootstrap.min.js') }}"></script>
    <!--  -->
    <script src="{{ asset('template-landpage/js/easing.min.js') }}"></script>
    <script src="{{ asset('template-landpage/js/hoverIntent.js') }}"></script>
    <script src="{{ asset('template-landpage/js/superfish.min.js') }}"></script>
    <script src="{{ asset('template-landpage/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('template-landpage/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('template-landpage/js/jquery.tabs.min.js') }}"></script>
    <script src="{{ asset('template-landpage/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('template-landpage/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('template-landpage/js/mail-script.js') }}"></script>
    <script src="{{ asset('template-landpage/js/main.js') }}"></script>

    @yield('this-page-scripts') <!-- Menyertakan JS tambahan dari halaman -->
</body>

</html>
