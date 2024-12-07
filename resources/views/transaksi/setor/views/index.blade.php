@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
    <style>
        #container-rincian .rincian-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            /* Add padding for better spacing */
        }

        #container-rincian .rincian-item {
            flex: 1;
            /* Each item will take equal space */
            min-width: 120px;
            /* Adjust this width as needed */
            text-align: left;
            /* Align text to the left */
        }

        #container-rincian p {
            margin: 0;
            /* Remove margin for better alignment */
        }

        #container-rincian span {
            display: block;
            /* Ensure spans stack vertically */
        }
    </style>
@endsection

@section('content')
    <div class="content-body default-height">
        <!-- row -->
        <div class="container-fluid">
            <div class="form-head mb-4">
                <h2 class="text-black font-w600 mb-0">Transaksi - Setor Keuangan</h2>
            </div>
            <!-- coba -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">List Setoran</h4>
                            <span class="fs-12">Anda bisa mem-filter berdasarkan tahun, bulan dan status</span>
                        </div>
                        <div class="border-start mx-3 d-none d-md-block" style="height: 50px;"></div> <!-- Vertical Line -->
                        <div class="d-flex align-items-center gap-1" style="flex: 1;">
                            <select id="filter_tahun" class="selectpicker form-control wide form-select-md"
                                data-live-search="true" aria-describedby="instansi-feedback" data-size="6"
                                placeholder="Pilih tahun" required>
                                <option value="">Semua</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                            <select id="filter_bulan" class="selectpicker form-control wide form-select-md"
                                data-live-search="true" aria-describedby="instansi-feedback" data-size="6"
                                placeholder="Pilih bulan" required>
                                <option value="">Semua</option>
                                @foreach ($months as $index => $month)
                                    <option value="{{ $index }}">{{ $month }}</option>
                                @endforeach
                            </select>
                            <select id="filter_status" class="selectpicker form-control wide form-select-md"
                                data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih status"
                                required>
                                <option value="">Semua</option>
                                <option value="lunas">Lunas</option>
                                <option value="belum lunas">Belum Lunas</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-2">
                            <a href="javascript:void(0)" class="btn btn-sm btn-rounded btn-outline-success light btn-sm"
                                id="btnExport" title="Export setoran">
                                <i class="las la-file-export scale5 me-1"></i> Export *
                            </a>
                            <a href="{{ route('transaksi.setor.keuangan.create') }}"
                                class="btn btn-sm btn-rounded btn-outline-primary light btn-sm" id="btnExport"
                                title="Buat setoran">
                                <i class="las la-plus scale5 me-1"></i> Buat Setoran
                            </a>
                        </div>

                        <div class="alert alert-primary">
                            <div class="row g-1">
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Catatan:</strong> <br />
                                    <span>Gunakan fitur ini untuk melihat dan mengekspor data setoran dengan lebih
                                        mudah. Anda dapat melakukan hal-hal berikut:</span> <br />
                                    <ul>
                                        <li>Menampilkan daftar setoran berdasarkan tahun, bulan atau status.</li>
                                        <li>Mengekspor data setoran ke dalam format Excel untuk laporan lebih lanjut atau
                                            arsip.</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Ekstra:</strong> <br />
                                    <span>* Pastikan semua filter sudah dipilih dengan benar sebelum mengekspor data untuk
                                        memastikan laporan yang akurat.</span> <br />
                                    <span>Hanya setoran yang sesuai dengan filter yang akan diekspor ke file Excel.</span>
                                    <br />
                                    <span>Setelah mengekspor data, Anda bisa mengunduh file Excel untuk analisis lebih
                                        lanjut atau arsip.</span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Bulan/Tahun</th>
                                        <th>Total Tagihan</th>
                                        <th>Total Setoran</th>
                                        <th>Sisa Setoran</th>
                                        <th>Tanggal Setor</th>
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
    @include('transaksi.setor.views.detail')
    @include('transaksi.setor.views.export')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    {{-- @include('transaksi.setor.scripts.main') --}}
    @include('transaksi.setor.scripts.list')
    @include('transaksi.setor.scripts.show')
    @include('transaksi.setor.scripts.export')
@endsection
