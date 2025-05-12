<!-- Sidebar start -->
<div class="deznav">
    <div class="deznav-scroll">
        @php
            $role = auth()->user()->role;
        @endphp

        <ul class="metismenu" id="menu">
            {{-- MAIN --}}
            @if (in_array($role, ['developer', 'kepsek', 'bendahara', 'petugas_pembayaran', 'petugas_emis']))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);">
                        <i class="fas fa-chart-line fw-bold"></i><span class="nav-text">Main</span>
                    </a>
                    <ul>
                        @if (in_array($role, ['developer', 'kepsek', 'bendahara', 'petugas_pembayaran']))
                            <li><a href="{{ route('main.dashboard.index') }}">Dashboard Pembayaran</a></li>
                        @endif
                        @if (in_array($role, ['developer', 'kepsek', 'petugas_emis']))
                            <li><a href="{{ route('main.dashboard-ppdb.index') }}">Dashboard PPDB</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- TRANSAKSI --}}
            @if (in_array($role, ['developer', 'petugas_pembayaran', 'kepsek', 'bendahara']))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);">
                        <i class="fas fa-money-check-alt fw-bold"></i><span class="nav-text">Transaksi</span>
                    </a>
                    <ul>
                        @if (in_array($role, ['developer', 'petugas_pembayaran']))
                            <li><a href="{{ route('transaksi.pembayaran.index') }}">Pembayaran</a></li>
                        @endif
                        @if (in_array($role, ['developer', 'petugas_pembayaran', 'kepsek']))
                            <li><a href="{{ route('transaksi.laporan.index') }}">Laporan</a></li>
                        @endif
                        @if (in_array($role, ['developer', 'kepsek', 'bendahara']))
                            <li><a href="{{ route('transaksi.setor.keuangan.index') }}">Setor Keuangan</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- TAGIHAN --}}
            @if (in_array($role, ['developer', 'petugas_pembayaran', 'kepsek']))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);">
                        <i class="fas fa-money-bill-wave fw-bold"></i><span class="nav-text">Tagihan</span>
                    </a>
                    @php $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear(); @endphp
                    <ul>
                        @if (in_array($role, ['developer', 'petugas_pembayaran']))
                            <li><a href="{{ route('tagihan.generate-tagihan.index') }}">Generate tagihan</a></li>
                        @endif
                        <li><a href="{{ route('tagihan.daftar-tagihan.index') }}">List tagihan
                                {{ $activeYear ? $activeYear->tahun . '-' . $activeYear->semester : 'Tidak ada' }}</a>
                        </li>
                        <li><a href="{{ route('tagihan.riwayat-tagihan.index') }}">Riwayat tagihan</a></li>
                    </ul>
                </li>
            @endif

            {{-- SETTING --}}
            @if (in_array($role, ['developer', 'petugas_pembayaran', 'kepsek']))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);">
                        <i class="fas fa-gear fw-bold"></i><span class="nav-text">Setting</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('setting.tagihan-siswa.index') }}">Tagihan siswa</a></li>
                        <li><a href="{{ route('setting.potongan-siswa.index') }}">Potongan siswa</a></li>
                    </ul>
                </li>
            @endif

            {{-- MASTER --}}
            @if (in_array($role, ['developer', 'petugas_pembayaran', 'kepsek', 'petugas_emis']))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);">
                        <i class="fas fa-server fw-bold"></i><span class="nav-text">Master</span>
                    </a>
                    <ul>
                        @if (in_array($role, ['developer', 'petugas_pembayaran', 'kepsek']))
                            <li><a href="{{ route('master-data.tahun-akademik.index') }}">Tahun akademik</a></li>
                            <li><a href="{{ route('master-data.iuran.index') }}">Iuran</a></li>
                            <li><a href="{{ route('master-data.potongan.index') }}">Potongan</a></li>
                            <li><a href="{{ route('master-data.siswa.index') }}">Siswa</a></li>
                        @endif
                        @if (in_array($role, ['developer', 'kepsek', 'petugas_emis']))
                            <li><a href="{{ route('master-data.kontak.index') }}">CMS Kontak</a></li>
                            <li><a href="{{ route('master-data.tentang.index') }}">CMS Tentang</a></li>
                            <li><a href="{{ route('master-data.galeri.index') }}">CMS Galeri</a></li>
                            <li><a href="{{ route('master-data.prestasi.index') }}">CMS Prestasi</a></li>
                            <li><a href="{{ route('master-data.berita.index') }}">CMS Berita</a></li>
                        @endif
                    </ul>
                </li>
            @endif

            {{-- PPDB --}}
            @if (in_array($role, ['developer', 'kepsek', 'petugas_emis', 'petugas_ppdb']))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);">
                        <i class="fas fa-id-card fw-bold"></i><span class="nav-text">PPDB</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('ppdb.index') }}">Data siswa baru</a></li>
                        @if (in_array($role, ['developer', 'petugas_emis']))
                            <li><a href="{{ route('ppdb.setting.index') }}">Setting</a></li>
                        @endif
                    </ul>
                </li>
            @endif


            {{-- APLIKASI --}}
            @if (in_array($role, ['developer', 'kepsek']))
                <li>
                    <a class="has-arrow ai-icon" href="javascript:void(0);">
                        <i class="fas fa-cogs fw-bold"></i><span class="nav-text">Aplikasi</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('application.user.index') }}">Manajemen Pengguna</a></li>
                    </ul>
                </li>
            @endif
        </ul>


        <!-- Footer with copyright information -->
        <div class="copyright">
            <p><strong>Payment App</strong> © 2024 All Rights Reserved</p>
            <p>Developed by <a href="https://www.poterteknik.com" target="_blank">PT. POTER TEKNIK INTERNASIONAL</a></p>
        </div>
    </div>
</div>
<!-- Sidebar end -->
