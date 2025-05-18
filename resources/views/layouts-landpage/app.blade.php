<!DOCTYPE html>
<html lang="id" class="no-js">

<head>
    @php
        $currentDate = \Carbon\Carbon::now();
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
        $activeContact = \App\Helpers\AppHelper::getKontak();
        $activeAbout = \App\Helpers\AppHelper::getTentang();
        $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
    @endphp

    <title>Madrasah Ibtidaiyah Ihyauddiniyah | MI Unggulan di Probolinggo</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO Essentials -->
    <meta name="description"
        content="Profil resmi Madrasah Ibtidaiyah Ihyauddiniyah di Desa Kecik, Besuk, Probolinggo. Menyediakan pendidikan dasar Islam yang unggul dan berkarakter.">
    <meta name="keywords"
        content="Madrasah Ibtidaiyah, MI Ihyauddiniyah, MI Probolinggo, Sekolah Islam Dasar, Besuk, Pendidikan Islam, MI Kecik Besuk">
    <meta name="author" content="Madrasah Ibtidaiyah Ihyauddiniyah">
    <meta name="robots" content="index, follow">

    <!-- Canonical -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:title" content="Madrasah Ibtidaiyah Ihyauddiniyah | Sekolah Islam Dasar Unggulan">
    <meta property="og:description"
        content="Kenali lebih dekat Madrasah Ibtidaiyah Ihyauddiniyah di Probolinggo. Pendidikan berbasis nilai Islam, unggul dalam karakter dan akademik.">
    <meta property="og:image" content="{{ asset('template-landpage/img/logo_mi.png') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="Madrasah Ibtidaiyah Ihyauddiniyah">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="MI Ihyauddiniyah | Sekolah Dasar Islam di Besuk, Probolinggo">
    <meta name="twitter:description"
        content="Sekolah Islam Dasar yang unggul dan terpercaya di wilayah Besuk, Probolinggo.">
    <meta name="twitter:image" content="{{ asset('template-landpage/img/logo_mi.png') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('template-landpage/img/logo_mi.png') }}" type="image/png">

    <!-- CSRF -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "Madrasah Ibtidaiyah Ihyauddiniyah",
      "url": "{{ url('/') }}",
      "logo": "{{ asset('template-landpage/img/logo_mi_new.png') }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Desa Kecik",
        "addressLocality": "Kecamatan Besuk",
        "addressRegion": "Probolinggo",
        "addressCountry": "ID"
      },
      "description": "Madrasah Ibtidaiyah Ihyauddiniyah adalah lembaga pendidikan dasar Islam yang berada di Probolinggo, Jawa Timur. Menyediakan pendidikan berkualitas dan pembentukan karakter Islami.",
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ $activeContact && $activeContact->kontak_telepon ? '+62' . $activeContact->kontak_telepon : '+620000000000' }}",
        "contactType": "customer support",
        "areaServed": "ID",
        "availableLanguage": "Indonesian"
      }
    }
    </script>

    <!-- Preconnect Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">

    <!-- Styles -->
    @yield('this-page-style')
    <link rel="stylesheet" href="{{ asset('template-landpage/css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('template-landpage/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template-landpage/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('template-landpage/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('template-landpage/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('template-landpage/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template-landpage/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('template-landpage/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('template-landpage/css/main.css') }}">
    <style>
        html,
        body {
            overflow-x: hidden;
        }

        .header-top .container,
        .main-menu .container {
            max-width: 100%;
            overflow-x: hidden;
        }

        .nav-menu ul {
            position: absolute;
            left: 0;
            top: 100%;
            display: none;
            background: #fff;
            z-index: 999;
            padding: 10px 0;
            min-width: 200px;
        }

        .nav-menu li:hover>ul {
            display: block;
        }

        /* Fix menu dropdown di mobile */
        @media (max-width: 768px) {
            .nav-menu {
                flex-direction: column;
                overflow-x: hidden;
            }

            .nav-menu ul {
                position: static;
                width: 100%;
                display: none;
            }

            .menu-has-children:hover ul {
                display: block;
            }
        }
    </style>
</head>

<body>
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
