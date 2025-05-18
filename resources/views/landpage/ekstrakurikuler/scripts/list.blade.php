<script>
    function loadArtikelPopuler() {
        $.ajax({
            url: "{{ route('landpage.artikel.show.list') }}",
            method: "GET",
            success: function(response) {
                var container = $('#artikel-populer');
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

    function loadBeritaPopuler() {
        $.ajax({
            url: "{{ route('landpage.berita.show.list') }}",
            method: "GET",
            success: function(response) {
                var container = $('#berita-populer');
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

    // Contoh: load artikel dengan ID tertentu saat halaman dimuat
    $(document).ready(function() {
        loadArtikelPopuler();
        loadBeritaPopuler();
    });
</script>
