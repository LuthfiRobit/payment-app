  <script>
      $(document).ready(function() {
          // Initialize DataTable
          var table = $('#example').DataTable({
              processing: true,
              serverSide: true,
              ajax: {
                  url: '{{ route('ppdb.setting.list') }}', // Adjust to your route
                  type: 'GET',
                  data: function(d) {
                      d.filter_status = $('#filter_status').val(); // Send filter status
                  }
              },
              columns: [{
                      data: 'aksi',
                      name: 'aksi',
                      orderable: false,
                      searchable: false
                  },
                  {
                      data: 'tahun',
                      name: 'tahun',
                      orderable: false,
                      searchable: true
                  },
                  {
                      data: 'tanggal_mulai',
                      name: 'tanggal_mulai',
                      orderable: false,
                      searchable: true
                  },
                  {
                      data: 'tanggal_selesai',
                      name: 'tanggal_selesai',
                      orderable: false,
                      searchable: false
                  },
                  {
                      data: 'biaya_pendaftaran',
                      name: 'biaya_pendaftaran',
                      orderable: false,
                      searchable: false
                  },
                  {
                      data: 'status',
                      name: 'status',
                      orderable: false,
                      searchable: false
                  }
              ],
              language: {
                  searchPlaceholder: "Cari tahun",
                  search: ''
              },
          });

          // Custom search functionality
          $("#example_filter input").on("input", function() {
              var searchValue = this.value;
              if (searchValue.length >= 4) {
                  // Search in column 1 (Nomor Transaksi)
                  table.column(1).search(searchValue).draw();
              } else {
                  // Clear column search and perform global search
                  table.column(1).search(searchValue).draw();
              }
          });

          $('#filter_status').change(function() {
              table.ajax.reload(); // Reload DataTable with new filter
          });

          // Event listener untuk switch
          $(document).on('change', '.form-check-input[type="checkbox"]', function() {
              var id = $(this).data('id');
              var isChecked = $(this).is(':checked');

              if (isChecked) {
                  // Tampilkan SweetAlert untuk konfirmasi
                  Swal.fire({
                      title: 'Aktifkan setting?',
                      text: "Apakah Anda yakin ingin mengaktifkan setting ini? Tindakan ini akan menonaktifkan setting lainnya.",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Ya, Aktifkan!',
                      cancelButtonText: 'Batal'
                  }).then((result) => {
                      if (result.isConfirmed) {
                          // Kirim permintaan untuk mengganti status
                          $.ajax({
                              url: '{{ route('ppdb.setting.update.status') }}',
                              method: 'POST',
                              data: {
                                  id: id
                              },
                              success: function(response) {
                                  if (response.success) {
                                      Swal.fire('Berhasil!', response.message,
                                          'success');
                                      table.ajax.reload(); // Reload data
                                  } else {
                                      Swal.fire('Gagal!', response.message, 'error');
                                  }
                              },
                              error: function() {
                                  Swal.fire('Gagal!',
                                      'Terjadi kesalahan saat mengubah status setting.',
                                      'error');
                              }
                          });
                      } else {
                          // Jika dibatalkan, set switch kembali
                          $(this).prop('checked', false);
                      }
                  });
              }
          });
      });
  </script>
