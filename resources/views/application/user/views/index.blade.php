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
                <h2 class="text-black font-w600 mb-0">Application - Manajemen Pengguna</h2>
            </div>
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">Daftar Pengguna</h4>
                            <span class="fs-12">Anda dapat memfilter pengguna berdasarkan status akun.</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <!-- Filter Options -->
                            <div class="">
                                <select id="filter_status" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="status-feedback" placeholder="Pilih status"
                                    required>
                                    <option value="">Semua</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak aktif">Tidak aktif</option>
                                </select>
                            </div>
                            <div class="">
                                <!-- Create New User Button -->
                                <a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary light btn-sm"
                                    data-bs-toggle="modal" data-bs-target="#ModalCreate" title="Buat Pengguna Baru">
                                    <i class="las la-plus scale5 me-1"></i>Buat Pengguna Baru
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-primary">
                            <div class="row g-1 mt-3">
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Catatan:</strong> <br />
                                    <span>Gunakan fitur ini untuk mengelola pengguna dalam aplikasi Anda. Berikut adalah
                                        beberapa hal yang dapat Anda lakukan:</span>
                                    <ul>
                                        <li>Menambahkan pengguna baru ke dalam sistem dengan mengisi form yang disediakan.
                                        </li>
                                        <li>Mengedit detail pengguna yang sudah ada.</li>
                                        <li>Mengaktifkan atau menonaktifkan status akun pengguna sesuai kebutuhan.</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Ekstra:</strong> <br />
                                    <span>Pastikan status pengguna diatur dengan benar (aktif/tidak aktif).</span> <br />
                                    <span>Data yang sudah ter-update akan langsung diterapkan dalam sistem.</span><br />
                                    <span>Pastikan untuk memeriksa ulang data pengguna sebelum menonaktifkan akun.</span>
                                </div>
                            </div>
                        </div>

                        <!-- Table for Displaying Users -->
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Nama Pengguna</th>
                                        <th>Email</th>
                                        <th>Peran</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Automatic render of users data here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('application.user.views.create')
    @include('application.user.views.edit')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    @include('application.user.scripts.store')
    @include('application.user.scripts.list')
    @include('application.user.scripts.show')
    @include('application.user.scripts.update')
@endsection
