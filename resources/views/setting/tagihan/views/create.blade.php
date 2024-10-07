 <!-- Modal untuk set tagihan -->
 <div class="modal fade" id="setTagihanModal" tabindex="-1" aria-labelledby="setTagihanLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="setTagihanLabel">Set Tagihan</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="setTagihanForm">
                 <div class="modal-body">
                     <input type="hidden" id="siswa_id">
                     <div class="mb-3">
                         <label for="iuran_id" class="form-label">Iuran</label>
                         <!-- Multiple select to choose more than one iuran -->
                         <select class="form-control selectpicker" id="iuran_id" name="iuran_ids[]" multiple
                             aria-describedby="iuran_idsHelpBlock">
                             @foreach ($iuran as $i)
                                 <option value="{{ $i->id_iuran }}">{{ $i->nama_iuran }} - {{ $i->besar_iuran }}
                                 </option>
                             @endforeach
                         </select>
                         <small id="iuran_idsHelpBlock" class="form-text text-muted">
                             Anda bisa memilih lebih dari satu iuran
                         </small>
                     </div>
                     {{-- <button type="submit" class="btn btn-primary">Set Tagihan</button> --}}
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Set Tagihan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
