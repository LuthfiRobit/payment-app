<!-- Modal Create Start -->
<div class="modal fade" id="ModalCreate" tabindex="-1" aria-labelledby="ModalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCreateLabel">Buat Berita Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalError" class="alert alert-danger d-none" role="alert"></div>
                <form id="createForm" class="form-sm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Berita</label>
                        <input type="text" class="form-control form-control-sm" id="judul" name="judul"
                            placeholder="Masukkan judul berita" required />
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="selectpicker form-control wide form-select-md"
                            data-live-search="false" required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label">Gambar Berita</label>
                        <input type="file" class="form-control form-control-sm" id="gambar" name="gambar"
                            accept="image/*" required>
                        <small class="form-text text-muted">Maks. 2MB, JPG/PNG</small>
                    </div>

                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Berita</label>
                        <textarea id="ckeditor-mine" name="isi"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" form="createForm" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Create End -->
