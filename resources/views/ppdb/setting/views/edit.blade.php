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
                           <label for="tahun_akademik_id" class="form-label">Tahun Akademik</label>
                           <select id="tahun_akademik_id" class="selectpicker form-control wide form-select-md"
                               data-live-search="true" aria-describedby="instansi-feedback" size="5"
                               placeholder="Pilih tahun akademik" required>
                               @foreach ($tahunAkademik as $item)
                                   <option value="{{ $item->id_tahun_akademik }}">{{ $item->tahun }} -
                                       {{ $item->semester }}</option>
                               @endforeach
                           </select>
                       </div>
                       <div class="mb-3">
                           <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                           <input type="date" class="form-control form-control-sm" id="tanggal_mulai" />
                       </div>
                       <div class="mb-3">
                           <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                           <input type="date" class="form-control form-control-sm" id="tanggal_selesai" />
                           <small class="form-text text-muted">Setelah/lebih tinggi tanggal mulai</small>
                       </div>
                       <div class="mb-3">
                           <label for="biaya_pendaftaran" class="form-label required">Biaya Pendaftaran</label>
                           <input type="number" class="form-control" id="biaya_pendaftaran" name="biaya_pendaftaran"
                               placeholder="eg. 2000000" min="0" required />
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
