<!-- Modal Detail Tagihan -->
<div class="modal fade" id="detailTagihanModal" tabindex="-1" aria-labelledby="detailTagihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTagihanLabel">Detail Tagihan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                <h6>Rincian Tagihan</h6>
                <ul class="list-group" id="tagihanList">
                    {{-- append li here --}}
                </ul>
            </div>
        </div>
    </div>
</div>
