  <script>
      // Panggil fungsi ini saat halaman dimuat atau saat ingin menampilkan detail berita
      function loadBeritaDetail(id) {
          var urlShow = '{{ route('landpage.berita.show', ':id') }}'.replace(':id', id);

          $.ajax({
              url: urlShow,
              method: 'GET',
              dataType: 'json',
              success: function(response) {
                  if (response.success) {
                      const data = response.data;

                      // Set gambar
                      $('#gambar-berita').attr('src', data.gambar);

                      // Set judul
                      $('#judul-berita').text(data.judul);
                      $('#writer-berita').text(data.username);

                      // Format tanggal
                      const tanggal = new Date(data.created_at).toLocaleDateString('id-ID', {
                          day: 'numeric',
                          month: 'long',
                          year: 'numeric'
                      });
                      $('#tanggal-berita').text(tanggal);

                      // Set isi (HTML)
                      $('#isi-berita').html(data.isi);
                      $('#jumlah-dibaca').text(data.dilihat + ' kali dibaca');
                  } else {
                      alert('Berita tidak ditemukan!');
                  }
              },
              error: function(xhr) {
                  console.error(xhr.responseText);
                  alert('Terjadi kesalahan saat mengambil data.');
              }
          });
      }

      function loadBeritaPopuler() {
          $.ajax({
              url: "{{ route('landpage.berita.show.list') }}",
              method: "GET",
              success: function(response) {
                  var container = $('.popular-post-list');
                  container.empty();

                  $.each(response.data, function(i, berita) {
                      var urlDetail = '{{ route('landpage.berita.detail', ':id') }}'
                          .replace(':id', berita.id_berita);

                      var card = `
                                <div class="single-post-list d-flex flex-row align-items-center">
                                    <div class="thumb">
                                        <img class="img-fluid" 
                                            src="${berita.gambar}" 
                                            alt="" 
                                            style="max-width: 100px; height: 70px; object-fit: cover; border-radius: 5px;" />
                                    </div>
                                    <div class="details">
                                        <a href="${urlDetail}">
                                            <h6>${berita.judul}</h6>
                                        </a>
                                        <p>${berita.info}</p>
                                    </div>
                                </div>
                            `;
                      container.append(card);
                  });
              },
              error: function(xhr) {
                  console.error(xhr.responseText);
                  $('.popular-post-list').html('<p>Gagal memuat data.</p>');
              }
          });
      }



      // Contoh: load berita dengan ID tertentu saat halaman dimuat
      $(document).ready(function() {
          // Ambil bagian terakhir dari URL sebagai ID berita
          const urlParts = window.location.pathname.split('/');
          const beritaId = urlParts[urlParts.length - 1];

          loadBeritaDetail(beritaId);
          loadBeritaPopuler();
      });
  </script>
