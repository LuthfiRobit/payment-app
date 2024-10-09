 <!-- Modal Detail start -->
 <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="modalLabel">Detail Pembayaran</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <!-- Data Diri Section -->
                 <div class="alert alert-outline-light">
                     <ul class="list-group list-group-flush">
                         <li class="list-group-item d-flex p-1 justify-content-between m-1">
                             <strong>Nomor Transaksi</strong>
                             <span id="show_nomor_transaksi">-</span>
                         </li>
                         <li class="list-group-item d-flex p-1 justify-content-between m-1">
                             <strong>Nama Siswa</strong>
                             <span id="show_nama_siswa">-</span>
                         </li>
                         <li class="list-group-item d-flex p-1 justify-content-between m-1">
                             <strong>NIS</strong>
                             <span id="show_nis">-</span>
                         </li>
                         <li class="list-group-item d-flex p-1 justify-content-between m-1">
                             <strong>Kelas</strong>
                             <span id="show_kelas">-</span>
                         </li>
                         <li class="list-group-item d-flex p-1 justify-content-between m-1">
                             <strong>Tanggal Transaksi</strong>
                             <span id="show_tanggal">-</span>
                         </li>
                     </ul>
                 </div>

                 <!-- Rincian Tagihan Section -->
                 <h5 class="mt-4">Rincian Tagihan</h5>

                 <div id="payment-details" class="table-responsive mb-4">
                     <table class="table table-striped table-hover table-responsive-sm">
                         <thead>
                             <tr>
                                 <th>Iuran</th>
                                 <th>Total Tagihan</th>
                                 <th>Total Dibayar</th>
                                 <th>Status</th>
                             </tr>
                         </thead>
                         <tbody id="modalRincianIuran">
                             <!-- Rincian Tagihan rows will be inserted here by JavaScript -->
                         </tbody>
                     </table>
                 </div>
                 <div class="d-flex justify-content-between mt-4">
                     <button class="btn btn-outline-primary btn-sm no-print" title="Cetak"
                         onclick="printModalContent()">
                         <i class="bi bi-printer"></i>
                     </button>
                     <strong>Total Dibayar: <span id="show_total_bayar">-</span></strong>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Detail end -->
