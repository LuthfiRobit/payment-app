   <!-- Modal Edit start -->
   <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-lg">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ModalEditLabel">Edit Data</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="updateForm" class="form-sm">
                       <div class="row">
                           <div class="col-xl-6">
                               <div class="mb-3">
                                   <label for="nis" class="form-label">NIS</label>
                                   <input type="text" class="form-control form-control-sm" id="nis"
                                       placeholder="Masukkan nis" required />
                               </div>
                               <div class="mb-3">
                                   <label for="nama_siswa" class="form-label">Nama Siswa</label>
                                   <input type="text" class="form-control form-control-sm" id="nama_siswa"
                                       placeholder="Masukkan nama siswa" required />
                               </div>
                               <div class="mb-3">
                                   <label for="kelas" class="form-label">Kelas</label>
                                   <select id="kelas" class="selectpicker form-control wide form-select-md"
                                       data-live-search="true" aria-describedby="instansi-feedback"
                                       placeholder="Pilih kelas" required>
                                       <option value="1">1 (Satu)</option>
                                       <option value="2">2 (Dua)</option>
                                       <option value="3">3 (Tiga)</option>
                                       <option value="4">4 (Empat)</option>
                                       <option value="5">5 (Lima)</option>
                                       <option value="6">6 (Enam)</option>
                                   </select>
                               </div>

                               <div class="mb-3">
                                   <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                   <select id="jenis_kelamin" class="selectpicker form-control wide form-select-md"
                                       data-live-search="false" aria-describedby="instansi-feedback"
                                       placeholder="Pilih jenis kelamin" required>
                                       <option value="laki-laki">Laki-laki</option>
                                       <option value="perempuan">Perempuan</option>
                                   </select>
                               </div>
                               <div class="mb-3">
                                   <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                   <input type="date" class="form-control form-control-sm" id="tanggal_lahir" />
                               </div>
                               <div class="mb-3">
                                   <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                   <input type="text" class="form-control form-control-sm" id="tempat_lahir"
                                       placeholder="Masukkan tempat lahir" />
                               </div>
                           </div>
                           <div class="col-xl-6">
                               <div class="mb-3">
                                   <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                   <input type="tel" class="form-control form-control-sm" id="nomor_telepon"
                                       placeholder="Masukkan nomor telepon" pattern="\d{10,15}" />
                               </div>
                               <div class="mb-3">
                                   <label for="email" class="form-label">Email</label>
                                   <input type="email" class="form-control form-control-sm" id="email"
                                       placeholder="Masukkan Email" />
                               </div>
                               <div class="mb-3">
                                   <label for="alamat" class="form-label">Alamat</label>
                                   <textarea class="form-control form-control-sm" id="alamat" rows="4"></textarea>
                               </div>
                               <div class="mb-3">
                                   <label for="status" class="form-label">Status</label>
                                   <select id="status" class="selectpicker form-control wide form-select-md"
                                       data-live-search="false" aria-describedby="instansi-feedback"
                                       placeholder="Pilih status" required>
                                       <option value="aktif">Aktif</option>
                                       <option value="tidak aktif">Tidak Aktif</option>
                                   </select>
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


   <!-- Modal Edit start -->
   <div class="modal fade" id="ModalEditKelas" tabindex="-1" aria-labelledby="ModalEditLabel" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered modal-md">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="ModalEditKelasLabel">Edit Data</h5>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <form id="updateFormKelas" class="form-sm">

                       <input type="hidden" id="siswa_id">
                       <div class="row">
                           <div class="col-xl-12">
                               <div class="mb-3">
                                   <label for="kelas" class="form-label">Kelas</label>
                                   <select id="kelas" name="kelas"
                                       class="selectpicker form-control wide form-select-md" data-live-search="true"
                                       aria-describedby="instansi-feedback" placeholder="Pilih kelas" required>
                                       <option value="1">1 (Satu)</option>
                                       <option value="2">2 (Dua)</option>
                                       <option value="3">3 (Tiga)</option>
                                       <option value="4">4 (Empat)</option>
                                       <option value="5">5 (Lima)</option>
                                       <option value="6">6 (Enam)</option>
                                   </select>
                               </div>
                           </div>
                       </div>
                   </form>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                   <button type="submit" form="updateFormKelas" class="btn btn-primary">Save Change</button>
               </div>
           </div>
       </div>
   </div>
   <!-- Modal Edit end -->
