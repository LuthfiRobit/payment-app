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
                <h2 class="text-black font-w600 mb-0">Master - Iuran</h2>
            </div>
            <!-- coba -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">List Iuran</h4>
                            <span class="fs-12">Anda bisa memfilter berdasarkan status</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <!-- Filter Activation Status -->
                            <div class="">
                                <select id="filter_status" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih status"
                                    required>
                                    <option value="">Semua</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak aktif</option>
                                </select>
                            </div>
                            <!-- Import Button -->
                            {{-- <a href="javascript:void(0)" class="btn btn-rounded btn-outline-secondary btn-sm"
                                data-bs-toggle="modal" data-bs-target="#ImportModal" title="Import">
                                <i class="las la-file-import scale5 me-1"></i>Import
                            </a> --}}
                            <!-- Create Button -->
                            <a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary light btn-sm"
                                data-bs-toggle="modal" data-bs-target="#ModalCreate" title="Create">
                                <i class="las la-plus scale5 me-1"></i>Buat
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary">
                            <strong>Catatan:</strong> <br />
                            <span>Gunakan fitur ini untuk mengelola iuran siswa dengan efisien. Anda dapat melakukan hal-hal
                                berikut:</span>
                            <ul>
                                <li>Menambah iuran baru dengan mengisi formulir yang disediakan.</li>
                                <li>Mengedit iuran yang sudah ada untuk memperbarui informasi.</li>
                                <li>Mengaktifkan atau menonaktifkan status iuran sesuai kebutuhan.</li>
                            </ul>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Nama Iuran</th>
                                        <th>Besar Iuran</th>
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

    @include('master.iuran.views.create')
    @include('master.iuran.views.import')
    @include('master.iuran.views.edit')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}

    @include('master.iuran.scripts.store')
    @include('master.iuran.scripts.list')
    @include('master.iuran.scripts.show')
    @include('master.iuran.scripts.update')
@endsection
