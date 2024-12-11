<!-- Modal Detail Setoran -->
<div class="modal fade" id="detailSetoranModal" tabindex="-1" aria-labelledby="detailSetoranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailSetoranLabel">Detail Setoran Keuangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <div class="col-6"><span class="fs-6 fw-bold">Bulan/Tahun</span></div>
                            <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_bulan_tahun"
                                    class="mb-0 text-uppercase"></span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><span class="fs-6 fw-bold">Tanggal Setor</span></div>
                            <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_tanggal_setor"
                                    class="mb-0 text-uppercase"></span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><span class="fs-6 fw-bold">Total Tagihan</span></div>
                            <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_total_tagihan"
                                    class="mb-0 text-uppercase"></span></div>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="row mb-2">
                            <div class="col-6"><span class="fs-6 fw-bold">Total Setoran</span></div>
                            <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_total_setoran"
                                    class="mb-0"></span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><span class="fs-6 fw-bold">Sisa Setoran</span></div>
                            <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_sisa_setoran"
                                    class="mb-0"></span></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6"><span class="fs-6 fw-bold">Status ?</span></div>
                            <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_status"
                                    class="mb-0"></span></div>
                        </div>
                    </div>
                </div>

                <!-- Keterangan di bawah -->
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="row mb-2">
                            <div class="col-6"><span class="fs-6 fw-bold">Keterangan</span></div>
                            <div class="col-6"><span class="fs-6 fw-bold">:</span> <span id="show_keterangan"
                                    class="mb-0"></span></div>
                        </div>
                    </div>
                </div>

                <div class="accordion ms-0 me-0" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header p-0">
                            <button class="accordion-button pt-2 pb-1 ps-1" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h6>Rincian Setoran</h6>
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
