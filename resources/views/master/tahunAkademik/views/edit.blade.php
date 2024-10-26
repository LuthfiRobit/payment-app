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
                       <div class="mb-3">
                           <label for="tahun" class="form-label">Tahun Akademik</label>
                           <input type="text" class="form-control form-control-sm" id="tahun"
                               placeholder="e.g., 2024/2025" required />
                       </div>
                       <div class="mb-3">
                           <label for="semester" class="form-label">Semester</label>
                           <select id="semester" class="selectpicker form-control wide form-select-md"
                               data-live-search="false" aria-describedby="instansi-feedback"
                               placeholder="Pilih semester" required>
                               <option value="ganjil">Ganjil</option>
                               <option value="genap">Genap</option>
                           </select>
                       </div>
                       <div class="mb-3">
                           {{-- <label for="status" class="form-label">Status</label>
                           <select id="status" class="selectpicker form-control wide form-select-md"
                               data-live-search="false" aria-describedby="instansi-feedback" placeholder="Pilih status"
                               required>
                               <option value="aktif">Aktif</option>
                               <option value="tidak aktif">Tidak Aktif</option>
                           </select> --}}
                           <div class="alert alert-primary">
                               <div class="row g-1">
                                   <div class="col-lg-12 col-sm-12">
                                       <strong>Catatan:</strong> <br />
                                       <span>Status secara otomatis diatur sistem, lakukan perubahan status pada
                                           tabel.</span>
                                   </div>
                               </div>
                           </div>
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
