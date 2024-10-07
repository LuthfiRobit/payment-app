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
                     <div class="alert alert-primary text-center">
                         <span>Apakah anda yakin untuk meng-generate data tagihan pada tahun akademik
                             <strong
                                 class="fs-4">{{ $activeYear ? $activeYear->tahun . ' - ' . $activeYear->semester : 'Tidak ada' }}</strong>
                             ? </span>
                         <br>
                         <br>
                         <div class="text-start">
                             <strong>Catatan :</strong> <br>
                             <span>- Data yang sudah ter-generate tidak bisa dikembalikan!</span> <br>
                             <span>- Pastikan tagihan siswa sudah terploting dengan benar pada menu <a
                                     href="">Tagihan siswa</a>
                             </span> <br>
                             <span>- Pastikan potongan siswa sudah terploting dengan benar pada menu <a
                                     href="">Potongan siswa</a>
                             </span>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Set Tagihan</button>
                 </div>
             </form>
         </div>
     </div>
 </div>
