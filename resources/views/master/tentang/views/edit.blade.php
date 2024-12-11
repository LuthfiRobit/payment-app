<!-- Modal Edit start -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditLabel">Edit Entry</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" class="form-sm">
                    <input type="hidden" name="_method" value="PUT">

                    <!-- Field Deskripsi -->
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control form-control-sm" id="deskripsi" name="deskripsi" rows="5"
                            placeholder="Masukkan deskripsi" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Field Gambar -->
                    <div class="mb-3">
                        <label for="img" class="form-label">Gambar</label>
                        <input type="file" class="form-control form-control-sm" id="img" name="img"
                            accept="image/*" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <div class="alert alert-primary">
                            <div class="row g-1">
                                <div class="col-lg-12 col-sm-12">
                                    <strong>Catatan:</strong> <br />
                                    <span>Status tentang secara default adalah "tidak aktif". Anda dapat mengubahnya
                                        setelah
                                        data disimpan.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="updateForm" id="btnUpdateTentang" class="btn btn-primary">Save
                    Change</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit end -->
