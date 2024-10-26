@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> --}}
@endsection

@section('content')
    <div class="content-body default-height">
        <!-- row -->
        <div class="container-fluid">
            <div class="form-head mb-4">
                <h2 class="text-black font-w600 mb-0">Transaksi - Laporan</h2>
            </div>
            <!-- coba -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">List Transaksi</h4>
                            <span class="fs-12">Anda bisa mem-filter berdasarkan tahun akademik, siswa, atau tanggal</span>
                        </div>
                        <div class="border-start mx-3 d-none d-md-block" style="height: 50px;"></div> <!-- Vertical Line -->
                        <div class="d-flex align-items-center gap-1" style="flex: 1;">
                            <select id="filter_tahun" class="selectpicker form-control wide form-select-md"
                                data-live-search="true" aria-describedby="instansi-feedback" size="10"
                                placeholder="Pilih tahun akademik" required>
                                @foreach ($tahunAkademik as $item)
                                    <option value="{{ $item->id_tahun_akademik }}">{{ $item->tahun }} -
                                        {{ $item->semester }}</option>
                                @endforeach
                            </select>
                            <select id="filter_siswa" class="selectpicker form-control wide form-select-md"
                                data-live-search="true" placeholder="Pilih siswa" size="5" required>
                                <option value="">Silahkan input nis atau nama siswa</option>
                            </select>
                            <input type="date" name="filter_tanggal" id="filter_tanggal"
                                class="form-control form-control-sm" placeholder="Pilih tanggal" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Nomor Transaksi</th>
                                        <th>Tahun Akademik</th>
                                        <th>Siswa</th>
                                        <th>Total Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- automatic render data here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('transaksi.laporan.views.create') --}}
    {{-- @include('transaksi.laporan.views.import') --}}
    @include('transaksi.laporan.views.detail')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}

    @include('transaksi.laporan.scripts.main')
    {{-- @include('transaksi.laporan.scripts.store') --}}
    @include('transaksi.laporan.scripts.list')
    @include('transaksi.laporan.scripts.show')
    @include('transaksi.laporan.scripts.print')
    {{-- @include('transaksi.laporan.scripts.update') --}}
@endsection