  <script>
      $(document).ready(function() {
          // Initialize DataTable
          var table = $('#example').DataTable({
              processing: true,
              serverSide: true,
              ajax: {
                  url: '{{ route('master-data.iuran.list') }}', // Adjust to your route
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
                      data: 'nama_iuran',
                      name: 'nama_iuran',
                      orderable: false,
                      searchable: true
                  },
                  {
                      data: 'besar_iuran',
                      name: 'besar_iuran',
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
                  searchPlaceholder: "Cari nama iuran",
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

          //   $('#example tbody').on('click', '.edit-button', function() {
          //       var id = $(this).data('id');
          //       $('#ModalEdit').modal('show'); // Show edit modal
          //       // Fetch and fill data as needed
          //   });
      });
  </script>
