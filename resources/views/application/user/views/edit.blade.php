<!-- Modal Edit start -->
<div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditLabel">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" class="form-sm">
                    <input type="hidden" id="user_id" /> <!-- Hidden input for user ID -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control form-control-sm" id="name"
                            placeholder="Nama Pengguna" required />
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control form-control-sm" id="email" placeholder="Email"
                            required />
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Peran</label>
                        <select id="role" class="selectpicker form-control wide form-select-md"
                            data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih peran"
                            required>
                            <option value="kepsek">Kepala Sekolah</option>
                            <option value="bendahara">Bendahara</option>
                            <option value="petugas_pembayaran">Petugas Pembayaran</option>
                            <option value="petugas_emis">Petugas Emis</option>
                            <!-- Add other roles as needed -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control form-control-sm" id="password"
                            placeholder="Password (kosongkan jika tidak ingin mengubah)" />
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control form-control-sm" id="confirm_password"
                            placeholder="Konfirmasi Password" />
                        <small id="password-error" class="form-text text-danger" style="display: none;">Password dan
                            konfirmasi password tidak cocok.</small>
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
