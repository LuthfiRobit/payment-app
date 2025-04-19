<header id="header" id="home">
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-8 header-top-left no-padding">
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/mi.ihyauddiniyah.90"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/miihyauddiniyah/"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="https://youtube.com/@miihyauddiniyahofficial9877?si=DEMvqyXn_5xcmFxe"><i
                                    class="fa fa-youtube"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-sm-6 col-4 header-top-right no-padding">
                    <a href="tel: {{ $activeContact ? $activeContact->kontak_telepon : '' }}"><span
                            class="lnr lnr-phone-handset"></span>
                        <span class="text">
                            {{ $activeContact ? $activeContact->kontak_telepon : 'Belum ada data' }}</span></a>
                    <a href="mailto: {{ $activeContact ? $activeContact->kontak_email : '' }}"><span
                            class="lnr lnr-envelope"></span>
                        <span class="text">
                            {{ $activeContact ? $activeContact->kontak_email : 'Belum ada data' }}</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container main-menu">
        <div class="row align-items-center justify-content-between d-flex">
            <div id="logo">
                <a href="{{ url('/') }}" class="d-flex align-items-center text-white text-decoration-none">
                    <img src="{{ asset('template-landpage/img/logo_mi_new.png') }}"
                        alt="Logo Madrasah Ibtidaiyah Ihyauddiniyah" style="max-width: 50px; margin-right: 10px" />
                    <h6 class="mb-0 text-white">MI Ihyauddiniyah</h6>
                </a>
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="menu-has-children">
                        <a href="">Informasi</a>
                        <ul>
                            <li><a href="{{ route('landpage.profil.index') }}">Profil</a></li>
                            <li><a href="{{ route('landpage.visi.index') }}">Visi Misi</a></li>
                            <li>
                                <a href="ppdb.html">Pendaftaran Peserta Didik Baru
                                    (PPDB)</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-has-children">
                        <a href="">Media</a>
                        <ul>
                            <li><a href="berita.html">Berita</a></li>
                            <li>
                                <a href="{{ route('landpage.galeri.index') }}">Galeri Foto</a>
                            </li>
                            <li>
                                <a href="{{ route('landpage.prestasi.index') }}">Prestasi</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="{{ route('landpage.kontak.index') }}">Kontak</a></li>
                </ul>
            </nav>
            <!-- #nav-menu-container -->
        </div>
    </div>
</header>
<!-- #header -->
