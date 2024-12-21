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
                           <label for="kontak_telepon" class="form-label">Nomor Telepon</label>
                           <input type="text" class="form-control form-control-sm" id="kontak_telepon"
                               placeholder="e.g., +62 812 3456 7890" required />
                       </div>
                       <div class="mb-3">
                           <label for="kontak_email" class="form-label">Email</label>
                           <input type="email" class="form-control form-control-sm" id="kontak_email"
                               placeholder="e.g., email@domain.com" required />
                       </div>
                       <div class="mb-3">
                           <label for="kontak_alamat" class="form-label">Alamat</label>
                           <textarea class="form-control form-control-sm" id="kontak_alamat" rows="3" required
                               placeholder="Masukkan alamat lengkap"></textarea>
                       </div>
                       <div class="mb-3">
                           <div class="alert alert-primary">
                               <div class="row g-1">
                                   <div class="col-lg-12 col-sm-12">
                                       <strong>Catatan:</strong> <br />
                                       <span>Status kontak secara default adalah "tidak aktif". Anda dapat mengubahnya
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
                   <button type="submit" form="updateForm" class="btn btn-primary">Save Change</button>
               </div>
           </div>
       </div>
   </div>
   <!-- Modal Edit end -->