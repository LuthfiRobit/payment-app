@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content-body default-height">
        <div class="container-fluid">
            <div class="form-head mb-4 d-flex justify-content-between align-items-center">
                <h2 class="text-black font-w600 mb-0">Transaksi - Setor Keuangan</h2>
                <a href="{{ route('transaksi.setor.keuangan.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
            <!-- Form Section -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 flex-wrap">
                        <div class="pr-3 me-5 mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">Filter Transaksi</h4>
                            <span class="fs-12">Pilih tahun dan bulan</span>
                        </div>
                        <div class="border-start mx-3 d-none d-md-block" style="height: 50px;"></div> <!-- Vertical Line -->
                        <div class="d-flex align-items-center gap-1" style="flex: 1;">
                            <select id="filter_tahun" class="selectpicker form-control wide form-select-md"
                                data-live-search="true" aria-describedby="instansi-feedback" data-size="6"
                                placeholder="Pilih tahun" required>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                            <select id="filter_bulan" class="selectpicker form-control wide form-select-md"
                                data-live-search="true" aria-describedby="instansi-feedback" data-size="6"
                                placeholder="Pilih bulan" required>
                                @foreach ($months as $index => $month)
                                    <option value="{{ $index }}">{{ $month }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-4">Data Setoran</h4>
                        <div class="row mb-3">
                            <div class="col-xl-6 col-lg-4">
                                <div class="row mb-2">
                                    <div class="col-6"><span class="fs-6 fw-bold">Bulan</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_bulan"
                                            class="mb-0 text-uppercase">-</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6"><span class="fs-6 fw-bold">Tahun</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_tahun"
                                            class="mb-0 text-uppercase">-</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6"><span class="fs-6 fw-bold">Tagihan Terbayar / Total Tagihan</span>
                                    </div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_terbayar"
                                            class="mb-0">-</span></div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-4">
                                <div class="row mb-2">
                                    <div class="col-6"><span class="fs-6 fw-bold">Total Setoran</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_total"
                                            class="mb-0">-</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6"><span class="fs-6 fw-bold">Sisa Setoran</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_sisa"
                                            class="mb-0">-</span></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-6"><span class="fs-6 fw-bold">Status ?</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_status"
                                            class="mb-0 text-uppercase">-</span></div>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="row">
                                    <div class="col-6"><span class="fs-6 fw-bold">Keterangan</span></div>
                                    <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_keterangan"
                                            class="mb-0 text-uppercase">-</span></div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 border-primary" />
                        <h4 class="mb-4">
                            Rincian Setoran <span id="show_filter"></span>
                        </h4>
                        <div id="setoran-details" class="table-responsive mb-4">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Nama Iuran</th>
                                        <th>Total Tagihan</th>
                                        <th>Total Setoran</th>
                                        <th>Sisa Setoran</th>
                                        <th>Status</th> <!-- Kolom Status ditambahkan -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan di-render secara otomatis di sini -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th id="show_total_tagihan">Rp. -</th>
                                        <th id="show_total_setoran">Rp. -</th>
                                        <th id="show_total_sisa">Rp. -</th>
                                        <th id="show_total_status">-</th> <!-- Footer untuk status total (opsional) -->
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <hr class="my-4 border-primary" />

                        <div class="mt-4">
                            <h4 class="mb-3">Tambah Setoran Baru</h4>
                            <form id="createForm">
                                <input type="hidden" name="tahun" id="tahun">
                                <input type="hidden" name="bulan" id="bulan">
                                <input type="hidden" name="nama_bulan" id="nama_bulan">
                                <div id="containerInput" class="mb-3">
                                    <!-- Data will be rendered automatically here -->
                                </div>
                                <div class="row mb-3">
                                    <div class="col-lg-6 mb-2">
                                        <label for="total_setoran_all" class="form-label">Total Setoran</label>
                                        <input type="number" class="form-control" id="total_setoran_all" value="0"
                                            readonly="">
                                    </div>
                                    <div class="col-lg-6 mb-2">
                                        <label for="sisa_setoran_all" class="form-label">Sisa Total Setoran</label>
                                        <input type="number" class="form-control" id="sisa_setoran_all" value="0"
                                            readonly="">
                                    </div>
                                    <div class="col-lg-12">
                                        <label for="keterangan" class="form-label">Keterangan</label>
                                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                            placeholder="eg. tanggal bayar dan tanggal pelunasan atau penggunaan sisa setoran yang belum terbayar"></textarea>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" form="createForm" id="save-setoran-btn"
                                        class="btn btn-outline-primary">
                                        <i class="fas fa-save"></i> Simpan Setoran
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
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    {{-- @include('transaksi.pembayaran.scripts.main') --}}
    @include('transaksi.setor.scripts.find')
    @include('transaksi.setor.scripts.store')
@endsection
