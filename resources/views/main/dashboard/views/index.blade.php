@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> --}}
@endsection

@section('content')
    @php
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
    @endphp
    <!-- Content body start -->
    <div class="content-body default-height">
        <div class="container-fluid">
            <!-- Section heading -->
            <div class="form-head mb-4 d-flex justify-content-between align-items-center">
                <h2 class="text-black font-w600 mb-0">Main - Dashboard</h2>
                <span class="badge badge-xl light badge-primary">Tahun Akademik
                    {{ $activeYear ? $activeYear->tahun . '-' . $activeYear->semester : 'Tidak ada' }}</span>
            </div>

            <!-- Row for overview cards -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center" id="report">
                                <div class="col-xl-4 mb-3 col-xxl-4 col-sm-6">
                                    <div class="media align-items-center bgl-secondary rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-users" style="font-size: 24px; color: #6c757d;"></i>
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Siswa</h4>
                                            <span class="fs-16" id="count-aktif">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 mb-3 col-xxl-4 col-sm-6">
                                    <div class="media align-items-center bgl-success rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-file-invoice-dollar"
                                                style="font-size: 24px; color: #28a745;"></i>
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Siswa - Tagihan</h4>
                                            <span class="fs-16" id="count-with-tagihan">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 mb-3 col-xxl-4 col-sm-6">
                                    <div class="media align-items-center bgl-info rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-money-bill-wave" style="font-size: 24px; color: #17a2b8;"></i>
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Transaksi Hari ini</h4>
                                            <span class="fs-16" id="total-jumlah-bayar-today">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div id="no-data-message-one" class="alert alert-danger d-none" role="alert">
                                    Belum ada data
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-xl-3 mb-3 col-xxl-3 col-sm-6">
                                    <div class="media align-items-center bgl-secondary rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-file-invoice-dollar"
                                                style="font-size: 24px; color: #6c757d;"></i>
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Tagihan</h4>
                                            <span class="fs-16" id="tagihan-value">0</span> <!-- Tambahkan ID -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 mb-3 col-xxl-3 col-sm-6">
                                    <div class="media align-items-center bgl-danger rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-percent" style="font-size: 24px; color: #dc3545;"></i>
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Potongan</h4>
                                            <span class="fs-16" id="potongan-value">0</span> <!-- Tambahkan ID -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 mb-3 col-xxl-3 col-sm-6">
                                    <div class="media align-items-center bgl-warning rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-calculator" style="font-size: 24px; color: #ffc107;"></i>
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Total Tagihan</h4>
                                            <span class="fs-16" id="total-tagihan-value">0</span>
                                            <!-- Tambahkan ID -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 mb-3 col-xxl-3 col-sm-6">
                                    <div class="media align-items-center bgl-success rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-check-circle" style="font-size: 24px; color: #28a745;"></i>
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Total Terbayar</h4>
                                            <span class="fs-16" id="total-bayar-value">0</span>
                                            <!-- Tambahkan ID -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="no-data-message-two" class="alert alert-danger d-none" role="alert">
                                Belum ada data
                            </div> <!-- Pesan untuk tidak ada data -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row for detailed information -->
            <div class="row">
                <!-- Card for Pembayaran Hari Ini -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                            <div class="pr-3 me-auto mb-sm-0 mb-3">
                                <h4 class="fs-20 text-black mb-1">Pembayaran Hari Ini</h4>
                                <span class="fs-12 date-now">
                                    {{-- isi tanggal hari ini dengan format "10 oktober 2024" --}}
                                </span>
                            </div>
                            <!-- Icon Detail -->
                            <a href="{{ route('transaksi.laporan.index') }}"
                                class="btn btn-rounded btn-outline-primary light btn-sm" title="Detail">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped display min-w850">
                                    <thead>
                                        <tr>
                                            <th>Nomor Transaksi</th>
                                            <th>Siswa</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- populated otomatis dari ajax --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card for Detail Iuran -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body p-3">
                            <div id="weeklyChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row for overview setoran cards -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                            <div class="pr-3 me-auto mb-sm-0 mb-3">
                                <h4 class="fs-20 text-black mb-1">Setoran Keuangan Bulan ini</h4>
                                <span class="fs-12 month-now">
                                    {{-- isi tanggal bulan dengan format "oktober 2024" --}}
                                </span>
                            </div>
                            <!-- Icon Detail -->
                            <a href="{{ route('transaksi.setor.keuangan.index') }}"
                                class="btn btn-rounded btn-outline-primary light btn-sm" title="Detail">
                                <i class="fas fa-info-circle"></i>
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-xl-4 mb-3 col-xxl-4">
                                    <div class="media align-items-center bgl-secondary rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-money-bill-wave"
                                                style="font-size: 24px; color: #6c757d;"></i> <!-- Ikon pembayaran -->
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Pembayaran</h4>
                                            <span class="fs-16" id="total-tagihan-setoran-value">0</span>
                                            <!-- Tambahkan ID -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 mb-3 col-xxl-4">
                                    <div class="media align-items-center bgl-danger rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-credit-card" style="font-size: 24px; color: #dc3545;"></i>
                                            <!-- Ikon setoran -->
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Setoran</h4>
                                            <span class="fs-16" id="total-setoran-value">0</span> <!-- Tambahkan ID -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 mb-3 col-xxl-4">
                                    <div class="media align-items-center bgl-warning rounded p-2">
                                        <span
                                            class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-wallet" style="font-size: 24px; color: #ffc107;"></i>
                                            <!-- Ikon sisa saldo -->
                                        </span>
                                        <div class="media-body">
                                            <h4 class="fs-18 text-black font-w600 mb-0">Sisa</h4>
                                            <span class="fs-16" id="total-sisa-value">0</span>
                                            <!-- Tambahkan ID -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="no-data-message-five" class="alert alert-danger d-none" role="alert">
                                Belum ada data
                            </div> <!-- Pesan untuk tidak ada data -->
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Content body end -->
    {{-- @include('main.dashboard.views.create') --}}
    {{-- @include('main.dashboard.views.import') --}}
    {{-- @include('main.dashboard.views.edit') --}}
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    <!-- Apex Chart start -->
    <script src="{{ asset('template/vendor/apexchart/apexchart.js') }}"></script>
    <!-- Apex Chart end -->

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}

    {{-- @include('main.dashboard.scripts.store') --}}
    {{-- @include('main.dashboard.scripts.list') --}}
    @include('main.dashboard.scripts.show')
    {{-- @include('main.dashboard.scripts.update') --}}
@endsection
