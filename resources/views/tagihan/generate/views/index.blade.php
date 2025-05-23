@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">

    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css"> --}}
@endsection

@section('content')
    @php
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
    @endphp
    <div class="content-body default-height">
        <div class="container-fluid">
            <div class="form-head mb-4 d-flex justify-content-between align-items-center">
                <h2 class="text-black font-w600 mb-0">Tagihan - Generate Tagihan</h2>
                <span class="badge badge-xl light badge-primary">Tahun Akademik
                    {{ $activeYear ? $activeYear->tahun . '-' . $activeYear->semester : 'Tidak ada' }}</span>
            </div>
            <!-- coba -->
            <div class="row">
                <div class="card">
                    <div class="card-header d-sm-flex d-block border-0 pb-0 flex-wrap">
                        <div class="pr-3 me-auto mb-sm-0 mb-3">
                            <h4 class="fs-20 text-black mb-1">List Tagihan Siswa</h4>
                            <span class="fs-12">Anda bisa memfilter berdasarkan kelas, status tagihan dan status
                                potongan</span>
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
                                    <option value="0">0 (Lulus)</option>
                                </select>
                            </div>
                            <div class="">
                                <select id="filter_tagihan" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="instansi-feedback"
                                    placeholder="Pilih tagihan" required>
                                    <option value="">Semua</option>
                                    <option value="ada">Ada</option>
                                    <option value="tidak">Tidak ada</option>
                                </select>
                            </div>
                            <div class="">
                                <select id="filter_potongan" class="selectpicker form-control wide form-select-md"
                                    data-live-search="false" aria-describedby="instansi-feedback"
                                    placeholder="Pilih potongan" required>
                                    <option value="">Semua</option>
                                    <option value="ada">Ada</option>
                                    <option value="tidak">Tidak ada</option>
                                </select>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-rounded btn-outline-primary light btn-sm"
                                id="setTagihanMassalBtn" title="Set tagihan siswa">
                                <i class="las la-plus scale5 me-1"></i>Set Tagihan *
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-primary">
                            <div class="row g-1">
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Catatan:</strong> <br />
                                    <span>Gunakan fitur ini untuk meng-generate tagihan siswa dengan efisien berdasarkan
                                        tahun akademik aktif. Anda dapat melakukan hal-hal berikut:</span> <br />
                                    <ul>
                                        <li>Meng-generate tagihan, baik secara satuan maupun dalam jumlah banyak.</li>
                                        <li>Hasil generate tagihan akan ditampilkan pada menu <strong><a
                                                    href="{{ route('tagihan.daftar-tagihan.index') }}">Daftar
                                                    Tagihan</a></strong>.</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <strong>Ekstra:</strong> <br />
                                    <span>* Pilih setidaknya satu siswa untuk meng-generate tagihan siswa.</span> <br />
                                    <span>Data yang sudah ter-generate tidak bisa dikembalikan!</span> <br />
                                    <span>Pastikan tagihan siswa sudah ter-plotting dengan benar pada menu <strong><a
                                                href="{{ route('setting.tagihan-siswa.index') }}">Tagihan
                                                Siswa</a></strong>.</span> <br />
                                    <span>Pastikan potongan siswa sudah ter-plotting dengan benar pada menu <strong><a
                                                href="{{ route('setting.potongan-siswa.index') }}">Potongan
                                                Siswa</a></strong>.</span>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="example" class="table table-striped display min-w850">
                                <thead>
                                    <tr>
                                        <th style="max-width: 5px"><input type="checkbox" class="form-check-input"
                                                id="selectAll"> *</th>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Iuran</th>
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

    @include('tagihan.generate.views.create')
    {{-- @include('tagihan.generate.views.import') --}}
    {{-- @include('tagihan.generate.views.edit') --}}
    {{-- @include('tagihan.generate.views.detail') --}}
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('template/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/vendor/datatables/responsive/responsive.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script> --}}

    @include('tagihan.generate.scripts.store')
    @include('tagihan.generate.scripts.list')
    {{-- @include('tagihan.generate.scripts.show') --}}
    {{-- @include('tagihan.generate.scripts.update') --}}
@endsection
