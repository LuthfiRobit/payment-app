@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> --}}
@endsection

@section('content')
    <!-- Content body start -->
    <div class="content-body default-height">
        <div class="container-fluid">
            <!-- Section heading -->
            <div class="form-head mb-4">
                <h2 class="text-black font-w600 mb-0">Main - Dashboard</h2>
            </div>

            <!-- Row for overview cards -->
            <div class="row">
                <!-- Card for Total Iuran -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header flex-wrap border-0 pb-0">
                            <div class="me-3 mb-2">
                                <p class="fs-14 mb-1">Total Iuran</p>
                                <span class="fs-24 text-black font-w600">Rp. 10.000.000</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <canvas id="widgetChart1" height="80"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card for Iuran Terbayar -->
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header flex-wrap border-0 pb-0">
                            <div class="me-3 mb-2">
                                <p class="fs-14 mb-1">Iuran Terbayar</p>
                                <span class="fs-24 text-black font-w600">Rp. 2.000.000</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <canvas id="widgetChart2" height="80"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Card for Sisa Iuaran -->
                <div class="col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="card-header d-sm-flex d-block border-0 pb-0">
                            <div class="me-3 mb-2">
                                <p class="fs-14 mb-1">Sisa Iuaran</p>
                                <span class="fs-24 text-black font-w600">Rp. 8.000.000</span>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <canvas id="widgetChart3" height="80"></canvas>
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
                                <span class="fs-12">01 September 2024</span>
                            </div>
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
                                        <tr>
                                            <td>PS010</td>
                                            <td>88990 | Joko</td>
                                            <td>Rp 100,000</td>
                                        </tr>
                                        <tr>
                                            <td>PS011</td>
                                            <td>88991 | Siti</td>
                                            <td>Rp 150,000</td>
                                        </tr>
                                        <tr>
                                            <td>PS012</td>
                                            <td>88992 | Budi</td>
                                            <td>Rp 200,000</td>
                                        </tr>
                                        <tr>
                                            <td>PS013</td>
                                            <td>88993 | Dewi</td>
                                            <td>Rp 250,000</td>
                                        </tr>
                                        <tr>
                                            <td>PS014</td>
                                            <td>88994 | Edi</td>
                                            <td>Rp 300,000</td>
                                        </tr>
                                        <tr>
                                            <td>PS015</td>
                                            <td>88995 | Lina</td>
                                            <td>Rp 350,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card for Detail Iuran -->
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <!-- Detail Iuran List -->
                                <div class="col-xl-5 col-xxl-12 col-md-5">
                                    <h4 class="fs-20 text-black mb-4">Detail Iuran</h4>
                                    <div class="row">
                                        <!-- Detail item: LKS -->
                                        <div class="d-flex col-xl-12 col-xxl-6 col-md-12 col-sm-6 mb-4">
                                            <svg class="me-3" width="14" height="54" viewBox="0 0 14 54"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="-6.10352e-05" width="14" height="54" rx="7"
                                                    fill="#AC39D4" />
                                            </svg>
                                            <div>
                                                <p class="fs-14 mb-2">LKS</p>
                                                <span class="fs-14 font-w500"><span class="text-black me-2">Rp.
                                                        100.000</span>/RP. 200.000</span>
                                            </div>
                                        </div>

                                        <!-- Detail item: Tasyakuran -->
                                        <div class="d-flex col-xl-12 col-xxl-6 col-md-12 col-sm-6 mb-4">
                                            <svg class="me-3" width="14" height="54" viewBox="0 0 14 54"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="-6.10352e-05" width="14" height="54" rx="7"
                                                    fill="#40D4A8" />
                                            </svg>
                                            <div>
                                                <p class="fs-14 mb-2">Tasyakuran</p>
                                                <span class="fs-14 font-w500"><span class="text-black me-2">Rp.
                                                        100.000</span>/RP. 200.000</span>
                                            </div>
                                        </div>

                                        <!-- Detail item: Kelulusan -->
                                        <div class="d-flex col-xl-12 col-xxl-6 col-md-12 col-sm-6 mb-4">
                                            <svg class="me-3" width="14" height="54" viewBox="0 0 14 54"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="-6.10352e-05" width="14" height="54" rx="7"
                                                    fill="#1EB6E7" />
                                            </svg>
                                            <div>
                                                <p class="fs-14 mb-2">Kelulusan</p>
                                                <span class="fs-14 font-w500"><span class="text-black me-2">Rp.
                                                        100.000</span>/RP. 200.000</span>
                                            </div>
                                        </div>

                                        <!-- Detail item: Total -->
                                        <div class="d-flex col-xl-12 col-xxl-6 col-md-12 col-sm-6 mb-4">
                                            <svg class="me-3" width="14" height="54" viewBox="0 0 14 54"
                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect x="-6.10352e-05" width="14" height="54" rx="7"
                                                    fill="#461EE7" />
                                            </svg>
                                            <div>
                                                <p class="fs-14 mb-2">Total</p>
                                                <span class="fs-14 font-w500"><span class="text-black me-2">Rp.
                                                        100.000</span>/RP. 200.000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Donut charts for each detail -->
                                <div class="col-xl-7 col-xxl-12 col-md-7">
                                    <div class="row g-3">
                                        <!-- Donut chart: LKS -->
                                        <div class="col-sm-6">
                                            <div class="bg-secondary rounded text-center p-3">
                                                <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                    <span class="donut1"
                                                        data-peity='{ "fill": ["rgb(255, 255, 255)", "rgba(255, 255, 255, 0.2)"], "innerRadius": 33, "radius": 10}'>5/8</span>
                                                    <small class="text-white">71%</small>
                                                </div>
                                                <span class="fs-14 text-white d-block">LKS</span>
                                            </div>
                                        </div>

                                        <!-- Donut chart: Tasyakuran -->
                                        <div class="col-sm-6">
                                            <div class="bg-success rounded text-center p-3">
                                                <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                    <span class="donut1"
                                                        data-peity='{ "fill": ["rgb(255, 255, 255)", "rgba(255, 255, 255, 0.2)"], "innerRadius": 33, "radius": 10}'>3/8</span>
                                                    <small class="text-white">30%</small>
                                                </div>
                                                <span class="fs-14 text-white d-block">Tasyakuran</span>
                                            </div>
                                        </div>

                                        <!-- Donut chart: Kelulusan -->
                                        <div class="col-sm-6">
                                            <div class="border border-2 border-primary rounded text-center p-3">
                                                <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                    <span class="donut1"
                                                        data-peity='{ "fill": ["rgb(30, 170, 231)", "rgba(234, 234, 234, 1)"], "innerRadius": 33, "radius": 10}'>1/8</span>
                                                    <small class="text-black">5%</small>
                                                </div>
                                                <span class="fs-14 text-black d-block">Kelulusan</span>
                                            </div>
                                        </div>

                                        <!-- Donut chart: Total -->
                                        <div class="col-sm-6">
                                            <div class="bg-info rounded text-center p-3">
                                                <div class="d-inline-block position-relative donut-chart-sale mb-3">
                                                    <span class="donut1"
                                                        data-peity='{ "fill": ["rgb(255, 255, 255)", "rgba(255, 255, 255, 0.2)"], "innerRadius": 33, "radius": 10}'>9/10</span>
                                                    <small class="text-white">96%</small>
                                                </div>
                                                <span class="fs-14 text-white d-block">Total</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}

    {{-- @include('main.dashboard.scripts.store') --}}
    {{-- @include('main.dashboard.scripts.list') --}}
    {{-- @include('main.dashboard.scripts.show') --}}
    {{-- @include('main.dashboard.scripts.update') --}}
@endsection
