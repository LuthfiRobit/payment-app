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
                <h2 class="text-black font-w600 mb-0">Master - Berita</h2>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">List Berita</h4>
                            <span class="fs-12">Anda bisa memfilter berdasarkan status</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <div class="">
                                <select id="filter_status" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih status"
                                    required>
                                    <option value="">Semua</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak aktif</option>
                                </select>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary light btn-sm"
                                data-bs-toggle="modal" data-bs-target="#ModalCreate" title="Create">
                                <i class="las la-plus scale5 me-1"></i>Buat
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-primary">
                            <strong>Catatan:</strong> <br />
                            <span>Gunakan fitur ini untuk mengelola berita dengan efisien. Anda dapat melakukan hal-hal
                                berikut:</span>
                            <ul>
                                <li>Menambah berita baru melalui formulir yang tersedia.</li>
                                <li>Mengedit berita yang telah dipublikasikan.</li>
                                <li>Mengatur status berita aktif (ditampilkan) atau tidak aktif (tidak ditampilkan) sesuai
                                    kebutuhan.</li>
                            </ul>
                        </div>

                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Judul</th>
                                        <th>Status</th>
                                        <th>Dilihat</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- DataTables will render rows here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ModalCreate (Opsional - bisa tambahkan partial/modalnya sendiri di sini) --}}

    @include('master.berita.views.create')
    @include('master.berita.views.edit')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>
    <script src="{{ asset('template/vendor/ckeditor/ckeditor.js') }}"></script>
    @include('master.berita.scripts.list')
    @include('master.berita.scripts.store')
    @include('master.berita.scripts.show')
    @include('master.berita.scripts.update')
@endsection
