<!-- Modal Edit start -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditLabel">Edit Data Galeri</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" class="form-sm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Galeri</label>
                        <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="kegiatan" class="form-label">Nama Galeri</label>
                        <input type="text" class="form-control form-control-sm" id="kegiatan" name="kegiatan"
                            placeholder="Masukkan nama galeri" required />
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control form-control-sm" id="keterangan" name="keterangan" rows="3"
                            placeholder="Masukkan keterangan (opsional)"></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label for="foto" class="form-label">Foto Galeri</label>
                            <span id="foto-preview" style="display: none;">
                                <a href="#" id="view-foto" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-eye"></i> Lihat Foto
                                </a>
                            </span>
                        </div>
                        <input type="file" class="form-control form-control-sm" id="foto" name="foto"
                            accept="image/*">
                        <small class="form-text text-muted">Maks. 2MB, JPG/PNG</small>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="selectpicker form-control wide form-select-md"
                            data-live-search="false" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="updateForm" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit end -->
