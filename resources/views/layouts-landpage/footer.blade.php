<!-- Start ppdb-cta Area -->
<section class="cta-two-area bg-success">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 cta-left text-white">
                <h1 class="mb-3 mb-lg-0">
                    Daftarkan Putra/Putri Anda Sekarang!
                </h1>
                <!-- <p class="mb-0">Tahun Ajaran 2024/2025 - Kuota Terbatas</p> -->
            </div>
            <div class="col-lg-4 cta-right text-lg-right">
                <a class="primary-btn wh" href="#">Informasi PPDB</a>
            </div>
        </div>
    </div>
</section>
<!-- End ppdb-cta Area -->

<!-- start footer Area -->
<footer class="footer-area section-gap">
    <div class="container">
        <div class="row">
            <!-- Logo dan Nama MI -->
            <div class="col-lg-2 col-md-6 col-sm-6 text-center">
                <div class="single-footer-widget">
                    <img src="{{ asset('template-landpage/img/logo_mi_new.png') }}"
                        alt="Logo Madrasah Ibtidaiyah Ihyauddiniyah" style="max-width: 100px; margin-bottom: 10px" />
                    <h6 class="text-white">
                        Madrasah Ibtidaiyah Ihyauddiniyah
                    </h6>
                </div>
            </div>

            <!-- Link Informasi -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="{{ route('landpage.profil.index') }}">Profil</a></li>
                        <li><a href="{{ route('landpage.visi.index') }}">Visi & Misi</a></li>
                        <li><a href="{{ route('landpage.prestasi.index') }}">Prestasi</a></li>
                        <li><a href="galeri.html">Galeri</a></li>
                    </ul>
                </div>
            </div>

            <!-- Link Terkait -->
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h4>Terkait</h4>
                    <ul>
                        <li>
                            <a href="https://kemenag.go.id/">Kementerian Agama</a>
                        </li>
                        <li>
                            <a href="https://emis.kemenag.go.id/">EMIS</a>
                        </li>
                        <li>
                            <a href="https://simpatika.kemenag.go.id/">SIMPATIKA</a>
                        </li>
                        <li>
                            <a href="https://kemenag.go.id/tag/kurikulum">Kurikulum</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Kontak -->
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="single-footer-widget">
                    <h4>Kontak Kami</h4>
                    <ul>
                        <li><i class="fa fa-map-marker"></i>
                            {{ $activeContact ? $activeContact->kontak_alamat : 'Belum ada data' }}</li>
                        <li><i class="fa fa-phone"></i>
                            {{ $activeContact ? $activeContact->kontak_telepon : 'Belum ada data' }}</li>
                        <li><i class="fa fa-envelope"></i>
                            {{ $activeContact ? $activeContact->kontak_email : 'Belum ada data' }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="footer-bottom row align-items-center justify-content-between">
            <p class="footer-text m-0 col-lg-6 col-md-12">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;
                <span id="year"></span>
                All rights reserved Madrasah Ibtidaiyah Ihyauddiniyah | Made with
                <i class="fa fa-heart-o" aria-hidden="true"></i> by
                <a href="https://colorlib.com" target="_blank">Colorlib</a>
                &amp; developed by
                <a href="https://www.poterteknik.com" target="_blank">PT. POTER TEKNIK INTERNASIONAL</a>
            </p>

            <script>
                document.getElementById('year').textContent = new Date().getFullYear();
            </script>

            <div class="col-lg-6 col-sm-12 footer-social">
                <a href="https://www.facebook.com/mi.ihyauddiniyah.90"><i class="fa fa-facebook"></i></a>
                <a href="https://www.instagram.com/miihyauddiniyah/"><i class="fa fa-instagram"></i></a>
                <a href="https://youtube.com/@miihyauddiniyahofficial9877?si=DEMvqyXn_5xcmFxe"><i
                        class="fa fa-youtube"></i></a>
            </div>
        </div>
    </div>
</footer>
<!-- End footer Area -->
