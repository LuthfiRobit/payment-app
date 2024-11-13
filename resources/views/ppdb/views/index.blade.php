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
                <h2 class="text-black font-w600 mb-0">
                    Halaman Registrasi Siswa Baru
                </h2>
            </div>
            <!-- coba -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">Daftar Siswa Baru</h4>
                            <span class="fs-12">Anda dapat memfilter daftar berdasarkan tahun akademik atau status</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <!-- Filter tahun ajaran -->
                            <div class="">
                                <select id="filter_tahun" class="selectpicker form-control wide form-select-md"
                                    data-live-search="true" aria-describedby="instansi-feedback" size="5"
                                    placeholder="Pilih tahun akademik" required>
                                    @foreach ($tahunAkademik as $item)
                                        <option value="{{ $item->id_tahun_akademik }}">{{ $item->tahun }} -
                                            {{ $item->semester }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <select id="filter_status" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih status"
                                    required>
                                    <option value="">Semua</option>
                                    <option value="null">Belum Diproses</option>
                                    <option value="diterima">Diterima</option>
                                    <option value="ditolak">Ditolak</option>
                                    <option value="digenerate">Digenerate</option>
                                </select>
                            </div>
                            <!-- Filter Activation Status -->
                            <div class="">
                                <a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary light btn-sm"
                                    id="btnExportSiswa" title="Export siswa baru">
                                    <i class="las la-file-export scale5 me-1"></i> Export *
                                </a>
                            </div>
                            <div class="">
                                <a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary light btn-sm"
                                    id="btnGenerateSiswa" title="Generate siswa baru">
                                    <i class="las la-user-plus scale5 me-1"></i> Generate *
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary">
                            <div class="row g-1">
                                <!-- Informasi Ekspor Data Siswa -->
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Catatan:</strong> <br />
                                    <span>Anda dapat memperbarui data siswa, termasuk informasi siswa, orang tua, wali,
                                        serta status keluarga.</span><br>
                                    <span>Selain itu, Anda juga dapat **mengekspor data siswa** tanpa batasan status.
                                        Artinya, Anda dapat memilih untuk mengekspor semua data siswa—baik yang diterima,
                                        yang digenerate, atau lainnya—sesuai kebutuhan Anda.</span><br>
                                    <span>Proses ekspor data dapat dilakukan untuk memilih **data siswa** bersama dengan
                                        informasi tambahan seperti data orang tua (ibu, ayah), wali, dan keluarga, jika
                                        diperlukan. Pilih kolom yang ingin Anda ekspor melalui panel pengaturan
                                        ekspor.</span><br>
                                    <span>Anda dapat **generate siswa baru** yang diterima ke dalam tabel siswa untuk
                                        memproses mereka menjadi siswa aktif di sistem.</span><br>
                                </div>

                                <!-- Informasi Proses Generate Siswa Baru -->
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Extra:</strong><br />
                                    <span>Proses **generate siswa baru** akan mempengaruhi siswa yang sudah ada dalam
                                        sistem:</span><br>
                                    <span><strong>Siswa di kelas 1 hingga 5</strong> akan dipromosikan ke kelas berikutnya
                                        (misalnya, kelas 1 menjadi kelas 2, kelas 2 menjadi kelas 3, dst.).</span><br>
                                    <span><strong>Siswa di kelas 6</strong> akan dianggap "Lulus", dan status mereka akan
                                        berubah menjadi "Lulus", serta kelasnya diubah menjadi 0.</span><br>
                                    <span>Pastikan hanya siswa yang berstatus "Diterima" yang dipilih untuk digenerate.
                                        Siswa yang berstatus "Digenerate" tidak akan diproses ulang.</span><br>
                                    <span><strong>Perhatian:</strong> Proses generate siswa ini dilakukan secara otomatis
                                        dan tidak dapat dibatalkan setelah selesai.</span><br>
                                    <span><strong>Informasi Penting:</strong> **NIS siswa yang digenerate** langsung diambil
                                        dari nomor registrasi yang ada di sistem dan dijamin tidak ada duplikasi
                                        NIS.</span><br>

                                    <!-- Tooltip untuk penjelasan lebih lanjut -->
                                    <span><i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="NIS siswa yang digenerate langsung diambil dari nomor registrasi, memastikan tidak ada duplikasi."></i>
                                        Pastikan Anda memeriksa dengan cermat sebelum menjalankan proses generate siswa
                                        baru.</span>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th style="max-width: 5px"><input type="checkbox" class="form-check-input"
                                                id="selectAll"> *</th>
                                        <th>Aksi</th>
                                        <th>No. Registrasi</th>
                                        <th>Nama Siswa</th>
                                        <th>Tahun Akademik</th>
                                        <th>NIK</th>
                                        <th>Sekolah Sebelum MI</th>
                                        <th>Usia</th>
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

    @include('ppdb.views.modals')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    <!-- Penjelasan tentang proses export -->
    <script>
        // Menambahkan tooltip (untuk ikon informasi di atas)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    </script>

    @include('ppdb.scripts.list')
    @include('ppdb.scripts.picture')
    @include('ppdb.scripts.shows')
    @include('ppdb.scripts.update')
    @include('ppdb.scripts.export')
    @include('ppdb.scripts.generate')
@endsection
