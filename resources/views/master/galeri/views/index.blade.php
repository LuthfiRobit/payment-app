@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content-body default-height">
        <div class="container-fluid">
            <div class="form-head mb-4">
                <h2 class="text-black font-w600 mb-0">Master - Galeri</h2>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">Daftar Kegiatan Galeri</h4>
                            <span class="fs-12">Filter berdasarkan status aktif atau tidak aktif.</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <div>
                                <select id="filter_status" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" placeholder="Pilih status" required>
                                    <option value="">Semua</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary light btn-sm"
                                data-bs-toggle="modal" data-bs-target="#ModalCreate" title="Tambah Galeri">
                                <i class="las la-plus scale5 me-1"></i>Tambah
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary">
                            <strong>Petunjuk:</strong> <br />
                            <span>Gunakan fitur ini untuk mengelola dokumentasi kegiatan melalui galeri:</span>
                            <ul>
                                <li>Menambahkan kegiatan baru ke dalam galeri.</li>
                                <li>Mengedit data kegiatan yang sudah ada.</li>
                                <li>Mengubah status aktif untuk mengatur tampil atau tidaknya di halaman publik.</li>
                            </ul>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data akan dimuat via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('master.galeri.views.create')
    @include('master.galeri.views.edit')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    @include('master.galeri.scripts.store')
    @include('master.galeri.scripts.list')
    @include('master.galeri.scripts.show')
    @include('master.galeri.scripts.update')
@endsection
