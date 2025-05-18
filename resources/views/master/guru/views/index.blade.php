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
                <h2 class="text-black font-w600 mb-0">Master - Guru dan Karyawan</h2>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">Daftar Guru dan Karyawan</h4>
                            <span class="fs-12">Anda bisa memfilter berdasarkan status atau kategori</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <div class="">
                                <select id="filter_kategori" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" placeholder="Pilih Kategori" required>
                                    <option value="">Semua</option>
                                    <option value="guru">Guru</option>
                                    <option value="karyawan">Karyawan</option>
                                </select>
                            </div>
                            <div class="">
                                <select id="filter_status" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" placeholder="Pilih status" required>
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
                            <span>Gunakan fitur ini untuk mengelola data guru dan karyawan. Anda dapat melakukan:</span>
                            <ul>
                                <li>Menambahkan data guru dan karyawan baru dengan mengisi formulir.</li>
                                <li>Mengedit data guru dan karyawan yang sudah ada.</li>
                                <li>Mengatur status aktif (ditampilkan) atau tidak aktif (tidak ditampilkan) untuk setiap
                                    data.</li>
                            </ul>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Nama</th>
                                        <th>Jabatan</th>
                                        <th>Kategori</th>
                                        <th>Urutan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- auto render data -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('master.guru.views.create')
    @include('master.guru.views.edit')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    <script>
        function initTooltips() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(el) {
                return new bootstrap.Tooltip(el);
            });
        }

        $(document).ready(function() {
            initTooltips(); // Inisialisasi awal

            // Re-inisialisasi setiap kali modal ditampilkan (untuk dinamis DOM)
            $('#ModalCreate, #ModalEdit').on('shown.bs.modal', function() {
                initTooltips();
            });
        });
    </script>
    @include('master.guru.scripts.store')
    @include('master.guru.scripts.list')
    @include('master.guru.scripts.show')
    @include('master.guru.scripts.update')
@endsection
