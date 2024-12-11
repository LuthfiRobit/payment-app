    @php
        $currentDate = \Carbon\Carbon::now();
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
        $activeContact = \App\Helpers\AppHelper::getKontak();
        $activeAbout = \App\Helpers\AppHelper::getTentang();
        $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
    @endphp
    <!-- Footer start -->
    <footer class="py-5 px-5 border-top border-3 footer shadow-lg">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-5">
            <div class="col mb-3">
                <a href="/" class="d-flex align-items-center mb-3 link-body-emphasis text-decoration-none">
                    <img src="{{ asset('template/images/logo_mi.png') }}" style="height: 75px"
                        alt="Logo Madrasah Ibtidaiyah Ihyauddiniyah" />
                </a>
                <p class="text-body-secondary">
                <h5>Madrasah Ibtidaiyah Ihyauddiniyah</h5> © 2024
                </p>
            </div>

            <!-- Section for other content -->
            <div class="col mb-3"></div>

            <!-- Useful Links Section -->
            <div class="col mb-3">
                <h5>Informasi</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="{{ url('/') }}#section-tentang" class="nav-link p-0 text-body-secondary">Tentang
                            Kami</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('landpage.ppdb.registration') }}"
                            class="nav-link p-0 text-body-secondary">Pendaftaran</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ url('/') }}#section-pendaftaran"
                            class="nav-link p-0 text-body-secondary">Kontak</a>
                    </li>
                </ul>
            </div>

            <!-- Address Section -->
            <div class="col mb-3">
                <h5>Alamat</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <p class="nav-link p-0 text-body-secondary">
                            {{ $activeContact ? $activeContact->kontak_alamat : 'Belum ada data' }}</p>
                    </li>
                    <li class="nav-item mb-2">
                        <p class="nav-link p-0 text-body-secondary">Telepon:
                            {{ $activeContact ? $activeContact->kontak_telepon : 'Belum ada data' }}</p>
                    </li>
                    <li class="nav-item mb-2">
                        <p class="nav-link p-0 text-body-secondary">Email:
                            {{ $activeContact ? $activeContact->kontak_email : 'Belum ada data' }}</p>
                    </li>
                </ul>
            </div>

            <!-- Quick Links Section -->
            <div class="col mb-3">
                <h5>Quick Links</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="https://kemenag.go.id/" class="nav-link p-0 text-body-secondary">Kementrian Agama
                            RI</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="https://www.kemdikbud.go.id/" class="nav-link p-0 text-body-secondary">Kementerian
                            Pendidikan dan
                            Kebudayaan</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link p-0 text-body-secondary" data-bs-toggle="modal"
                            data-bs-target="#faqModal">FAQ</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between pt-3 border-top border-3">
            <p>
                Copyright © Designed &amp; Developed by
                <a href="https://www.poterteknik.com" target="_blank">PT. POTER TEKNIK INTERNASIONAL</a>
                <span class="current-year">2024</span>
            </p>
            <ul class="list-unstyled d-flex">
                <li class="ms-3">
                    <a class="link-body-emphasis" href="https://twitter.com" target="_blank">
                        <i class="bi bi-twitter"></i> <!-- Ikon Twitter -->
                    </a>
                </li>
                <li class="ms-3">
                    <a class="link-body-emphasis" href="https://instagram.com" target="_blank">
                        <i class="bi bi-instagram"></i> <!-- Ikon Instagram -->
                    </a>
                </li>
                <li class="ms-3">
                    <a class="link-body-emphasis" href="https://facebook.com" target="_blank">
                        <i class="bi bi-facebook"></i> <!-- Ikon Facebook -->
                    </a>
                </li>
            </ul>
        </div>
    </footer>
    <!-- Footer end -->
