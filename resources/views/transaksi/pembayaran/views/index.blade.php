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
        <div class="container-fluid">
            <div class="form-head mb-4">
                <h2 class="text-black font-w600 mb-0">Transaksi - Pembayaran</h2>
            </div>
            <!-- coba -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 flex-wrap">
                        <div class="pr-3 me-5 mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">Buat Pembayaran</h4>
                            <span class="fs-12">Pilih tahun akademik kemudian pilih siswa</span>
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
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-4">Data Diri Siswa</h4>
                        <div class="row mb-3">
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-6"><span class="fs-6 fw-bold">NIS</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_nis"
                                            class="mb-0 text-uppercase">-</span></div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-6"><span class="fs-6 fw-bold">Nama Siswa</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_nama_siswa"
                                            class="mb-0 text-uppercase">-</span></div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-6"><span class="fs-6 fw-bold">Kelas</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_kelas"
                                            class="mb-0">-</span></div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-6"><span class="fs-6 fw-bold">Status ?</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_status"
                                            class="mb-0 text-uppercase">-</span></div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 border-primary" />

                        <h4 class="mb-4">
                            Detail Pembayaran Siswa Tahun Ajaran <span id="show_filter_tahun"></span>
                        </h4>
                        <div id="payment-details" class="table-responsive mb-4">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Iuran</th>
                                        <th>Besar Iuran</th>
                                        <th>Potongan</th>
                                        <th>Besar Potongan</th>
                                        <th>Total Tagihan</th>
                                        <th>Sisa Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- automatic render data here -->
                                </tbody>
                            </table>
                        </div>

                        <hr class="my-4 border-primary" />

                        <div class="mt-4">
                            <h4 class="mb-3">Tambah Pembayaran</h4>
                            <form id="createForm">
                                <div id="containerInput" class="mb-3">
                                    <!-- automatic render data here -->
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-12 mb-2">
                                        <label for="total_bayar" class="form-label">Total Dibayar</label>
                                        <input type="number" class="form-control" id="total_bayar" value="0"
                                            readonly="">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" form="createForm" id="save-payment-btn"
                                        class="btn btn-outline-primary">
                                        <i class="fas fa-save"></i> Proses Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('transaksi.pembayaran.views.create') --}}
    {{-- @include('transaksi.pembayaran.views.import') --}}
    {{-- @include('transaksi.pembayaran.views.edit') --}}
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}

    @include('transaksi.pembayaran.scripts.main')
    @include('transaksi.pembayaran.scripts.store')
    {{-- @include('transaksi.pembayaran.scripts.list') --}}
    @include('transaksi.pembayaran.scripts.show')
    {{-- @include('transaksi.pembayaran.scripts.update') --}}
@endsection
