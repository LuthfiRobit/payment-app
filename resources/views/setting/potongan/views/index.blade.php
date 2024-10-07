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
                <h2 class="text-black font-w600 mb-0">Setting - Potongan Siswa</h2>
            </div>
            <!-- coba -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">List Potongan Siswa</h4>
                            <span class="fs-12">Anda bisa memfilter berdasarkan status</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <!-- Filter Class -->
                            <div class="">
                                <select id="filter_kelas" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih kelas"
                                    required>
                                    <option value="">Semua</option>
                                    <option value="1">1 (Satu)</option>
                                    <option value="2">2 (Dua)</option>
                                    <option value="3">3 (Tiga)</option>
                                    <option value="4">4 (Empat)</option>
                                    <option value="5">5 (Lima)</option>
                                    <option value="6">6 (Enam)</option>
                                </select>
                            </div>
                            <!-- Filter Activation Status -->
                            <div class="">
                                <select id="filter_potongan" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="instansi-feedback"
                                    placeholder="Pilih potongan" required>
                                    <option value="">Semua</option>
                                    <option value="ada">Ada</option>
                                    <option value="tidak">Tidak ada</option>
                                </select>
                            </div>
                            <!-- Import Button -->
                            {{-- <a href="javascript:void(0)" class="btn btn-rounded btn-outline-secondary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#ImportModal" title="Import">
                                <i class="las la-file-import scale5 me-1"></i>Import
                            </a> --}}
                            <!-- Create Button -->
                            <a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary light btn-sm"
                                id="setTagihanMassalBtn" title="Set tagihan by tahun akademik">
                                <i class="las la-plus scale5 me-1"></i>Set Tagihan *
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary">
                            <div class="row g-1">
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Catatan :</strong> <br />
                                    <span>List berdasarkan siswa yang sudah ter-setting tagihannnya pada menu (Tagihan
                                        Siswa)</span> <br>
                                    <span>* Pilih setidaknya satu siswa untuk set tagihan by tahun akademik</span>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Ekstra :</strong> <br />
                                    <span>Hasil set tagihan by tahun akademik dilampirkan pada menu (Tagihan - List
                                        Tagihan)</span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Tagihan</th>
                                        <th>Potongan</th>
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

    {{-- @include('setting.potongan.views.create') --}}
    {{-- @include('setting.potongan.views.import') --}}
    {{-- @include('setting.potongan.views.edit') --}}
    @include('setting.potongan.views.detail')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}

    @include('setting.potongan.scripts.store')
    @include('setting.potongan.scripts.list')
    @include('setting.potongan.scripts.show')
    {{-- @include('setting.potongan.scripts.update') --}}
@endsection
