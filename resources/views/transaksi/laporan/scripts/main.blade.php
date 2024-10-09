  <script>
      function debounce(func, delay) {
          let timeout;
          return function(...args) {
              clearTimeout(timeout);
              timeout = setTimeout(() => func.apply(this, args), delay);
          };
      }

      function formatTanggal(tanggal) {
          const bulan = [
              "Januari", "Februari", "Maret", "April", "Mei", "Juni",
              "Juli", "Agustus", "September", "Oktober", "November", "Desember"
          ];

          const date = new Date(tanggal);
          const day = String(date.getDate()).padStart(2, '0'); // Mengambil tanggal
          const month = bulan[date.getMonth()]; // Mengambil nama bulan
          const year = date.getFullYear(); // Mengambil tahun

          return `${day} ${month} ${year}`;
      }

      $(document).ready(function() {
          $('#filter_siswa').selectpicker('refresh');

          const handleInput = debounce(function() {
              const $select = $(this).closest('.bootstrap-select').find('select');
              if ($select.attr('id') === 'filter_siswa') {
                  let query = $(this).val();
                  if (query.length >= 3) {
                      $.ajax({
                          url: '{{ route('master-data.siswa.list-siswa') }}',
                          method: 'GET',
                          data: {
                              search: query
                          },
                          dataType: 'json',
                          success: function(response) {
                              if (response.success) {
                                  let options = '';
                                  $.each(response.data, function(index, siswa) {
                                      options +=
                                          `<option value="${siswa.id_siswa}">${siswa.nis} - ${siswa.nama_siswa} (${siswa.kelas})</option>`;
                                  });
                                  $select.html(options).selectpicker('refresh');
                              } else {
                                  $select.html(
                                          '<option value="">Data tidak ditemukan</option>')
                                      .selectpicker('refresh');
                              }
                          },
                          error: function() {
                              Swal.fire({
                                  icon: 'error',
                                  title: 'Error!',
                                  text: 'Terjadi kesalahan, coba lagi nanti.',
                                  confirmButtonText: 'OK'
                              });
                          }
                      });
                  }
              }
          }, 300); // Adjust the delay as needed

          $(document).on('input', '.bootstrap-select .bs-searchbox input', handleInput);
      });
  </script>
