<!-- Sidebar start -->
<div class="deznav">
    <div class="deznav-scroll">
        <!-- Sidebar menu -->
        <ul class="metismenu" id="menu">
            <!-- Main section -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-chart-line fw-bold"></i>
                    <span class="nav-text">Main</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('main.dashboard.index') }}" class="fs-6">Dashboard Pembayaran</a></li>
                    <li><a href="{{ route('main.dashboard-ppdb.index') }}" class="fs-6">Dashboard PPDB</a></li>
                </ul>
            </li>
            <!-- Payment section -->
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-money-check-alt fw-bold"></i>
                    <span class="nav-text">Transaksi</span>
                </a>
                <ul aria-expanded="false">
                    <li>
                        <a href="{{ route('transaksi.pembayaran.index') }}" class="fs-6">Pembayaran</a>
                    </li>
                    <li>
                        <a href="{{ route('transaksi.laporan.index') }}" class="fs-6">Laporan</a>
                    </li>
                    <li>
                        <a href="{{ route('transaksi.setor.keuangan.index') }}" class="fs-6">Setor Keuangan</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-money-bill-wave fw-bold"></i>
                    <span class="nav-text">Tagihan</span>
                </a>
                @php
                    $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
                @endphp
                <ul aria-expanded="false">
                    <li><a href="{{ route('tagihan.generate-tagihan.index') }}" class="fs-6">Generate tagihan</a>
                    </li>
                    <li><a href="{{ route('tagihan.daftar-tagihan.index') }}" class="fs-6">List tagihan
                            {{ $activeYear ? $activeYear->tahun . '-' . $activeYear->semester : 'Tidak ada' }}
                        </a>
                    </li>
                    <li><a href="{{ route('tagihan.riwayat-tagihan.index') }}" class="fs-6">Riwayat tagihan</a>
                    </li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-gear fw-bold"></i>
                    <span class="nav-text">Setting</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('setting.tagihan-siswa.index') }}" class="fs-6">Tagihan siswa</a></li>
                    <li><a href="{{ route('setting.potongan-siswa.index') }}" class="fs-6">Potongan siswa</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-server fw-bold"></i>
                    <span class="nav-text">Master</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('master-data.tahun-akademik.index') }}" class="fs-6">Tahun akademik</a>
                    </li>
                    <li><a href="{{ route('master-data.iuran.index') }}" class="fs-6">Iuran</a></li>
                    <li><a href="{{ route('master-data.potongan.index') }}" class="fs-6">Potongan</a></li>
                    <li><a href="{{ route('master-data.siswa.index') }}" class="fs-6">Siswa</a></li>

                    <li><a href="{{ route('master-data.kontak.index') }}" class="fs-6">CMS Kontak</a></li>

                    <li><a href="{{ route('master-data.tentang.index') }}" class="fs-6">CMS Tentang</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-id-card fw-bold"></i>
                    <span class="nav-text">PPDB</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('ppdb.create') }}" class="fs-6">Tambah data siswa</a></li>
                    <li><a href="{{ route('ppdb.index') }}" class="fs-6">List data siswa</a></li>

                    <li><a href="{{ route('ppdb.setting.index') }}" class="fs-6">Setting</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void(0);" aria-expanded="false">
                    <i class="fas fa-cogs fw-bold"></i> <!-- Ganti dengan ikon yang lebih sesuai untuk aplikasi -->
                    <span class="nav-text">Aplikasi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('application.user.index') }}" class="fs-6">Manajemen Pengguna</a></li>
                </ul>
            </li>
        </ul>

        <!-- Footer with copyright information -->
        <div class="copyright">
            <p><strong>Payment App</strong> © 2024 All Rights Reserved</p>
            <p>Developed by <a href="https://www.poterteknik.com" target="_blank">PT. POTER TEKNIK INTERNASIONAL</a></p>
        </div>
    </div>
</div>
<!-- Sidebar end -->
