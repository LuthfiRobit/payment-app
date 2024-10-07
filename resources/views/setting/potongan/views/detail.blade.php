<!-- Modal Detail Tagihan -->
<div class="modal fade" id="detailTagihanModal" tabindex="-1" aria-labelledby="detailTagihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTagihanLabel">Detail Tagihan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createPotonganForm">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-6"><span class="fs-6 fw-bold">Nama Siswa</span></div>
                                <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_nama_siswa"
                                        class="mb-0 text-uppercase"></span></div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-6"><span class="fs-6 fw-bold">Kelas</span></div>
                                <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_kelas"
                                        class="mb-0"></span></div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div class="row">
                                <div class="col-6"><span class="fs-6 fw-bold">Status ?</span></div>
                                <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_status"
                                        class="mb-0 text-uppercase"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center gap-1 mb-3">
                        <h6 class="mb-0">Rincian Tagihan</h6>
                        <input type="hidden" name="siswa_id" id="siswa_id">
                        {{-- <select id="tahun_akademik" name="tahun_akademik"
                            class="selectpicker form-control form-select-xs w-25" data-live-search="true"
                            aria-describedby="instansi-feedback" placeholder="Pilih tahun akademik" required>
                            @foreach ($tahunAkademik as $item)
                                <option value="{{ $item['id_tahun_akademik'] }}">{{ $item['nama'] }}</option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div id="container-tagihan">
                        {{-- otomatis terisi --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="createPotonganForm" class="btn btn-primary">Set Tagihan</button>
                </div>
            </form>
        </div>
    </div>
</div>
