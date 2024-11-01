<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <!-- Judul Halaman -->
    <title>
        Aplikasi Pembayaran Iuran Madrasah Ibtidaiyah Ihyauddiniyah Desa Kecil Besuk Probolinggo
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Meta begin -->
    <!-- Set Karakter -->
    <meta charset="utf-8" />
    <!-- Mode Rendering -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Penulis Halaman -->
    <meta name="author" content="Madrasah Ibtidaiyah Ihyauddiniyah" />
    <!-- Pengindeksan Mesin Pencari -->
    <meta name="robots" content="index, follow" />

    <!-- Kata Kunci SEO -->
    <meta name="keywords"
        content="Pembayaran Iuran, Madrasah Ibtidaiyah Ihyauddiniyah, Desa Kecil Besuk, Probolinggo, Aplikasi Pembayaran, Sistem Pembayaran Iuran, Pendidikan, Madrasah Ibtidaiyah, Manajemen Keuangan, Desain Responsif, UI Modern, Aplikasi Web, Sistem Administrasi, Pembayaran Mudah, Pengelolaan Iuran, Formulir Pembayaran, Pembayaran Online, Solusi Keuangan Madrasah" />

    <!-- Deskripsi Halaman -->
    <meta name="description"
        content="Aplikasi Pembayaran Iuran untuk Madrasah Ibtidaiyah Ihyauddiniyah di Desa Kecil Besuk Probolinggo. Aplikasi ini memudahkan proses pembayaran iuran, melacak transaksi keuangan, dan mengelola administrasi dengan desain responsif dan fitur yang user-friendly." />

    <!-- Metadata Open Graph -->
    <meta property="og:title"
        content="Aplikasi Pembayaran Iuran Madrasah Ibtidaiyah Ihyauddiniyah Desa Kecil Besuk Probolinggo" />
    <meta property="og:description"
        content="Aplikasi Pembayaran Iuran untuk Madrasah Ibtidaiyah Ihyauddiniyah di Desa Kecil Besuk Probolinggo. Aplikasi ini memudahkan proses pembayaran iuran, melacak transaksi keuangan, dan mengelola administrasi dengan desain responsif dan fitur yang user-friendly." />
    <meta property="og:image" content="{{ asset('template/social-image.png') }}" />

    <!-- Twitter Card Metadata -->
    <meta name="twitter:title"
        content="Aplikasi Pembayaran Iuran Madrasah Ibtidaiyah Ihyauddiniyah Desa Kecil Besuk Probolinggo" />
    <meta name="twitter:description"
        content="Aplikasi Pembayaran Iuran untuk Madrasah Ibtidaiyah Ihyauddiniyah di Desa Kecil Besuk Probolinggo. Aplikasi ini memudahkan proses pembayaran iuran, melacak transaksi keuangan, dan mengelola administrasi dengan desain responsif dan fitur yang user-friendly." />
    <meta name="twitter:image" content="{{ asset('template/social-image.png') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <!-- Meta end -->

    <!-- Mobile Specific -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('template/images/logo_mi.png') }}" />

    @yield('this-page-style') <!-- Menyertakan Style tambahan dari halaman -->

    <!-- Global style start -->
    <link href="{{ asset('template/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link class="main-css" href="http://payment-app.test/template/css/style.css" rel="stylesheet" />
    <!-- Global style end -->
    <link class="main-css" href="{{ asset('template/css/style.css') }}" rel="stylesheet">

</head>

<body class="h-100">
    <div class="login-account">
        <div class="row h-100">
            <div class="col-lg-6 align-self-start">
                <div class="account-info-area"
                    style="background-color: green !important;
                    background-image: url({{ asset('template/images/logo_mi.png') }})">
                    <div class="login-content">
                        <p class="sub-title">Masuk ke Aplikasi Pembayaran Iuran</p>
                        <h1 class="title">Madrasah Ibtidaiyah Ihyauddiniyah</h1>
                        <p class="text">Aplikasi ini memudahkan proses pembayaran iuran, melacak transaksi keuangan,
                            dan mengelola administrasi.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-7 col-sm-12 mx-auto align-self-center">
                <div class="login-form" id="login-form">
                    <div class="login-head">
                        <h3 class="title">Selamat Datang Kembali</h3>
                        <p>Silakan masukkan email dan kata sandi Anda untuk masuk ke dalam sistem.</p>
                    </div>
                    <h6 class="login-title"><span>Login</span></h6>
                    <!-- Timer throttle -->
                    <div class="alert alert-warning" id="throttle-timer" style="display: none;">
                        <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 24px;"></i>
                        Anda dapat mencoba lagi dalam <strong id="timer"></strong> detik.
                    </div>
                    <form id="loginForm">
                        <div class="mb-4">
                            <label class="form-label required">Email</label>
                            <input class="form-control" type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-4 position-relative">
                            <label class="mb-1 form-label required">Password</label>
                            <input id="dz-password" class="form-control" type="password" name="password"
                                placeholder="Password" required>
                            <span class="show-pass eye">

                                <i class="fa fa-eye-slash"></i>
                                <i class="fa fa-eye"></i>

                            </span>
                        </div>
                        <div class="text-center mb-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('template/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('template/js/custom.min.js') }}"></script>
    @include('layouts.deznav')


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script token start -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <!-- Script token end -->

    @include('auth.scripts.login')
    {{-- <script src="js/demo.js"></script> --}}
    {{-- <script src="js/styleSwitcher.js"></script> --}}

</body>

</html>
