<!-- Modal Create Start-->
<div class="modal fade" id="ModalCreate" tabindex="-1" aria-labelledby="ModalCreateLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalCreateLabel">Buat Data Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalError" class="alert alert-danger d-none" role="alert"></div>
                <!-- Alert for general errors -->
                <form id="createForm" class="form-sm">
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun Akademik</label>
                        <input type="text" class="form-control form-control-sm" id="tahun"
                            placeholder="e.g., 2024/2025" required />
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select id="semester" class="selectpicker form-control wide form-select-md"
                            data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih semester"
                            required>
                            <option value="ganjil">Ganjil</option>
                            <option value="genap">Genap</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="selectpicker form-control wide form-select-md"
                            data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih status"
                            required>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="createForm" class="btn btn-primary">Create</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Create end -->
