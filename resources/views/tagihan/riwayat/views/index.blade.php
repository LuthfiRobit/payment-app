@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> --}}
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
    @php
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
    @endphp
    <div class="content-body default-height">
        <div class="container-fluid">
            <div class="form-head mb-4 d-flex justify-content-between align-items-center">
                <h2 class="text-black font-w600 mb-0">Tagihan - Riwayat Tagihan</h2>
            </div>
            <!-- coba -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">List Tagihan Siswa</h4>
                            <span class="fs-12">Anda bisa memfilter berdasarkan tahun akademik, kelas dan status
                                pelunasan</span>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <select id="filter_tahun" class="selectpicker form-control wide form-select-md"
                                data-live-search="true" aria-describedby="instansi-feedback" size="10"
                                placeholder="Pilih tahun akademik" required>
                                <option value="">Semua</option>
                                @foreach ($tahunAkademik as $item)
                                    <option value="{{ $item->id_tahun_akademik }}">{{ $item->tahun }} -
                                        {{ $item->semester }}</option>
                                @endforeach
                            </select>
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
                                    <option value="0">0 (Lulus)</option>
                                </select>
                            </div>
                            <div class="">
                                <select id="filter_status" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih status"
                                    required>
                                    <option value="">Semua</option>
                                    <option value="lunas">Lunas</option>
                                    <option value="belum lunas">Belum Lunas</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary">
                            <div class="row g-1">
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Catatan:</strong> <br />
                                    <span>Berikut adalah riwayat tagihan siswa</span>
                                    <br />
                                    <span>Anda bisa melihat status pelunasan tagihan siswa di semua tahun akademik.</span>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Ekstra:</strong> <br />
                                    <span>-</span>
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th>Aksi</th>
                                        <th>Tahun Akademik</th>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Besar Tagihan</th>
                                        <th>Besar Potongan</th>
                                        <th>Total Tagihan</th>
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

    {{-- @include('tagihan.riwayat.views.create') --}}
    {{-- @include('tagihan.riwayat.views.import') --}}
    {{-- @include('tagihan.riwayat.views.edit') --}}
    @include('tagihan.riwayat.views.detail')
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}

    {{-- @include('tagihan.riwayat.scripts.store') --}}
    @include('tagihan.riwayat.scripts.list')
    @include('tagihan.riwayat.scripts.show')
    {{-- @include('tagihan.riwayat.scripts.update') --}}
@endsection
