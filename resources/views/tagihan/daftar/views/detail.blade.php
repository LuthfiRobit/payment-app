<!-- Modal Detail Tagihan -->
<div class="modal fade" id="detailTagihanModal" tabindex="-1" aria-labelledby="detailTagihanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailTagihanLabel">Detail Tagihan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-12 mb-2">
                        <div class="row">
                            <div class="col-6"><span class="fs-6 fw-bold">NIS</span></div>
                            <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_nis"
                                    class="mb-0 text-uppercase"></span></div>
                        </div>
                    </div>
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
                </div>
                <h6>Tagihan</h6>
                <div class="d-flex flex-wrap mb-sm-2 justify-content-between">
                    <div class="pr-3 mb-3">
                        <p class="fs-14 mb-1">Besar Tagihan</p>
                        <span class="text-black fs-6 font-w500" id="show_besar_tagihan"></span>
                    </div>
                    <div class="pr-3 mb-3">
                        <p class="fs-14 mb-1">Besar Potongan</p>
                        <span class="text-black fs-6 font-w500" id="show_besar_potongan"></span>
                    </div>
                    <div class="pr-3 mb-3">
                        <p class="fs-14 mb-1">Total Tagihan</p>
                        <span class="text-black fs-6 font-w500" id="show_total_tagihan"></span>
                    </div>
                    <div class="mb-3">
                        <p class="fs-14 mb-1">Status</p>
                        <span class="text-black fs-6 font-w500 text-uppercase" id="show_status"></span>
                    </div>
                </div>
                <div class="accordion ms-0 me-0" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header p-0">
                            <button class="accordion-button pt-2 pb-1 ps-1" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h6>Rincian Tagihan</h6>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body px-0" id="container-rincian">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
