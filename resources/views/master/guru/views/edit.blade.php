   <!-- Modal Edit start -->
   <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ModalEditLabel">Edit Data</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="updateForm" class="form-sm">
                       <div class="mb-3">
                           <label for="kategori" class="form-label">Kategori</label>
                           <select id="kategori" name="kategori" class="selectpicker form-control wide form-select-md"
                               data-live-search="false" required>
                               <option value="guru">Guru</option>
                               <option value="karyawan">Karyawan</option>
                           </select>
                       </div>

                       <div class="mb-3">
                           <label for="nama" class="form-label">Nama Lengkap</label>
                           <input type="text" class="form-control form-control-sm" id="nama" name="nama"
                               placeholder="Masukkan nama lengkap" required />
                       </div>

                       <div class="mb-3">
                           <label for="jabatan" class="form-label">Jabatan</label>
                           <input type="text" class="form-control form-control-sm" id="jabatan" name="jabatan"
                               placeholder="Masukkan jabatan" required />
                       </div>

                       <div class="mb-3">
                           <div class="d-flex justify-content-between align-items-center mb-3">
                               <label for="foto" class="form-label">
                                   Foto
                                   <i class="fas fa-info-circle text-primary" data-bs-toggle="tooltip"
                                       data-bs-placement="top" data-bs-html="true"
                                       title="Ukuran ideal: <strong>200 x 250 piksel</strong><br>Lebar 200px dan tinggi 250px agar foto tampil seragam.">
                                   </i>
                               </label>
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
                           <label for="urutan" class="form-label">Urutan Tampil</label>
                           <input type="number" min="1" class="form-control form-control-sm" id="urutan"
                               name="urutan" placeholder="Masukkan urutan tampilan" required />
                           <small class="form-text text-muted">Sebagai penanda urutan tampilan pada landing page
                               guru/karyawan.</small>
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
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                   <button type="submit" form="updateForm" class="btn btn-primary">Save Change</button>
               </div>
           </div>
       </div>
   </div>
   <!-- Modal Edit end -->
