  <script>
      // Panggil fungsi ini saat halaman dimuat atau saat ingin menampilkan detail artikel
      function loadArtikelDetail(id) {
          var urlShow = '{{ route('landpage.artikel.show', ':id') }}'.replace(':id', id);

          $.ajax({
              url: urlShow,
              method: 'GET',
              dataType: 'json',
              success: function(response) {
                  if (response.success) {
                      const data = response.data;

                      // Set gambar
                      $('#gambar-artikel').attr('src', data.gambar);

                      // Set judul
                      $('#judul-artikel').text(data.judul);
                      $('#writer-artikel').text(data.username);

                      // Format tanggal
                      const tanggal = new Date(data.created_at).toLocaleDateString('id-ID', {
                          day: 'numeric',
                          month: 'long',
                          year: 'numeric'
                      });
                      $('#tanggal-artikel').text(tanggal);

                      // Set isi (HTML)
                      $('#isi-artikel').html(data.isi);
                      $('#jumlah-dibaca').text(data.dilihat + ' kali dibaca');
                  } else {
                      alert('Artikel tidak ditemukan!');
                  }
              },
              error: function(xhr) {
                  console.error(xhr.responseText);
                  alert('Terjadi kesalahan saat mengambil data.');
              }
          });
      }

      function loadArtikelPopuler() {
          $.ajax({
              url: "{{ route('landpage.artikel.show.list') }}",
              method: "GET",
              success: function(response) {
                  var container = $('.popular-post-list');
                  container.empty();

                  $.each(response.data, function(i, artikel) {
                      var urlDetail = '{{ route('landpage.artikel.detail', ':id') }}'
                          .replace(':id', artikel.id_artikel);

                      var card = `
                                <div class="single-post-list d-flex flex-row align-items-center">
                                    <div class="thumb">
                                        <img class="img-fluid" 
                                            src="${artikel.gambar}" 
                                            alt="" 
                                            style="max-width: 100px; height: 70px; object-fit: cover; border-radius: 5px;" />
                                    </div>
                                    <div class="details">
                                        <a href="${urlDetail}">
                                            <h6>${artikel.judul}</h6>
                                        </a>
                                        <p>${artikel.info}</p>
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



      // Contoh: load artikel dengan ID tertentu saat halaman dimuat
      $(document).ready(function() {
          // Ambil bagian terakhir dari URL sebagai ID artikel
          const urlParts = window.location.pathname.split('/');
          const artikelId = urlParts[urlParts.length - 1];

          loadArtikelDetail(artikelId);
          loadArtikelPopuler();
      });
  </script>
