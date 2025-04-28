   <!-- Modal Edit start -->
   <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-xl">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ModalEditLabel">Edit Data</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="updateForm" class="form-sm" enctype="multipart/form-data">
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
                           <div class="d-flex justify-content-between align-items-center mb-3">
                               <!-- Label Foto KTP Ayah -->
                               <label for="gambar" class="form-label">Gambar berita</label>

                               <!-- Preview Foto KTP Ayah jika ada -->
                               <span id="gambar-preview" style="display: none;">
                                   <a href="#" id="view-gambar" target="_blank" class="text-decoration-none">
                                       <i class="fas fa-eye"></i> Lihat Gambar
                                   </a>
                               </span>
                           </div>
                           <input type="file" class="form-control form-control-sm" id="gambar" name="gambar"
                               accept="image/*">
                           <small class="form-text text-muted">Maks. 2MB, JPG/PNG</small>
                       </div>
                       <div class="mb-3">
                           <label for="isi" class="form-label">Isi Berita</label>
                           <textarea id="ckeditor-mine" name="isi"></textarea>
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
