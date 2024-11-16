@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
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
                <h2 class="text-black font-w600 mb-0">Dashboard Siswa Baru</h2>
                <span class="badge badge-xl light badge-primary">Tahun Akademik
                    {{ $activeYear ? $activeYear->tahun . '-' . $activeYear->semester : 'Tidak ada' }}</span>
            </div>
            <!-- Row for overview cards -->
            <div class="row">
                <!-- Jumlah Siswa Mendaftar (Sisi Kiri) -->
                <div class="col-xl-3 mb-3 col-xxl-3 col-sm-6">
                    <div class="media align-items-center bgl-secondary rounded p-3">
                        <span class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                            style="width: 60px; height: 60px; background-color: #f8f9fa;">
                            <i class="fas fa-users" style="font-size: 28px; color: #6c757d;"></i>
                        </span>
                        <div class="media-body">
                            <h4 class="fs-18 text-black font-w600 mb-0">Siswa Mendaftar</h4>
                            <span class="fs-16" id="count-siswa-mendaftar">0</span> <!-- Jumlah siswa yang mendaftar -->
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan untuk data lainnya -->
                <div class="col-xl-9 mb-3 col-xxl-9 col-sm-6">
                    <div class="row">
                        <!-- Jumlah Siswa Diterima -->
                        <div class="col-xl-6 mb-3 col-xxl-6 col-sm-6">
                            <div class="media align-items-center bgl-success rounded p-2">
                                <span
                                    class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-check-circle" style="font-size: 24px; color: #28a745;"></i>
                                </span>
                                <div class="media-body">
                                    <h4 class="fs-18 text-black font-w600 mb-0">Siswa Diterima</h4>
                                    <span class="fs-16" id="count-siswa-diterima">0</span> <!-- Jumlah siswa diterima -->
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah Siswa Ditolak -->
                        <div class="col-xl-6 mb-3 col-xxl-6 col-sm-6">
                            <div class="media align-items-center bgl-danger rounded p-2">
                                <span
                                    class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-times-circle" style="font-size: 24px; color: #dc3545;"></i>
                                </span>
                                <div class="media-body">
                                    <h4 class="fs-18 text-black font-w600 mb-0">Siswa Ditolak</h4>
                                    <span class="fs-16" id="count-siswa-ditolak">0</span> <!-- Jumlah siswa ditolak -->
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah Siswa Digenerate -->
                        <div class="col-xl-6 mb-3 col-xxl-6 col-sm-6">
                            <div class="media align-items-center bgl-warning rounded p-2">
                                <span
                                    class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-cogs" style="font-size: 24px; color: #ffc107;"></i>
                                </span>
                                <div class="media-body">
                                    <h4 class="fs-18 text-black font-w600 mb-0">Siswa Digenerate</h4>
                                    <span class="fs-16" id="count-siswa-digenerate">0</span>
                                    <!-- Jumlah siswa yang digenerate -->
                                </div>
                            </div>
                        </div>

                        <!-- Jumlah Belum Diproses -->
                        <div class="col-xl-6 mb-3 col-xxl-6 col-sm-6">
                            <div class="media align-items-center bgl-info rounded p-2">
                                <span
                                    class="bg-white p-3 me-4 rounded text-center d-flex justify-content-center align-items-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="fas fa-clock" style="font-size: 24px; color: #17a2b8;"></i>
                                </span>
                                <div class="media-body">
                                    <h4 class="fs-18 text-black font-w600 mb-0">Belum Diproses</h4>
                                    <span class="fs-16" id="count-belum-diproses">0</span>
                                    <!-- Jumlah siswa yang belum diproses -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="no-data-message" class="alert alert-danger d-none" role="alert">
                    Belum ada data
                </div>
            </div>


            <!-- Row for detailed charts and information -->
            <div class="row">
                <!-- Table for Pendaftar Hari ini -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                            <div class="pr-3 me-auto mb-sm-0 mb-3">
                                <h4 class="fs-20 text-black mb-1">Pendaftar Hari ini</h4>
                                <span class="fs-12">
                                    {{ now()->format('d F Y') }} <!-- Menampilkan tanggal hari ini -->
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-striped display min-w850">
                                    <thead>
                                        <tr>
                                            <th>No. Reg</th>
                                            <th>Nama Siswa</th>
                                            <th>Umur</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Data Pendaftar yang hari ini akan dimuat melalui AJAX --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart for Siswa Berdasarkan Umur -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                            <div class="pr-3 me-auto mb-sm-0 mb-3">
                                <h4 class="fs-20 text-black mb-1">Persentase Umur Siswa Baru</h4>
                                <span class="fs-12">Grafik distribusi umur siswa baru yang mendaftar.</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="umurChartPie"></div> <!-- Pie Chart untuk persentase umur siswa -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content body end -->
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    <!-- Apex Chart start -->
    <script src="{{ asset('template/vendor/apexchart/apexchart.js') }}"></script>
    <!-- Apex Chart end -->

    @include('main.dashboardppdb.scripts.show')
@endsection
