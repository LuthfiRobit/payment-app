<!-- Load Berita List -->
<script>
    function loadBeritaList() {
        $.ajax({
            url: "{{ route('landpage.berita.show.list') }}",
            method: "GET",
            success: function(response) {
                var container = $('#berita-list');
                container.empty(); // Kosongkan sebelum isi baru

                if (response.data.length === 0) {
                    container.html(`
              <div class="col-12 alert alert-warning text-center" role="alert" data-aos="fade-in">
                <strong>Perhatian!</strong> Data berita tidak tersedia saat ini.
              </div>
            `);
                } else {
                    $.each(response.data, function(i, berita) {
                        var urlDetail = '{{ route('landpage.berita.detail', ':id') }}'.replace(
                            ':id', berita.id_berita);
                        var image = berita.gambar ??
                            '{{ asset('template-landpage/img/default.jpg') }}';

                        var card = `
                                    <div class="col-lg-3 col-md-6 mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="${i * 100}">
                                    <div class="single-blog h-100">
                                        <div class="thumb mb-3">
                                        <img class="img-fluid w-100" src="${image}" alt="Gambar Berita" style="height: 200px; object-fit: cover;" />
                                        </div>
                                        <p class="meta text-muted">${berita.info}</p>
                                        <a href="${urlDetail}">
                                        <h5 class="mb-2">${berita.judul}</h5>
                                        </a>
                                        <p class="text-muted">${berita.isi.substring(0, 120)}...</p>
                                        <a href="${urlDetail}" class="details-btn d-flex justify-content-center align-items-center mt-2">
                                        <span class="details">Detail</span>
                                        <span class="lnr lnr-arrow-right ml-2"></span>
                                        </a>
                                    </div>
                                    </div>
                                `;
                        container.append(card);
                    });

                    // Penting: inisialisasi ulang AOS setelah append dinamis
                    AOS.refresh();
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#berita-list').html(`
            <div class="col-12 alert alert-danger text-center" role="alert" data-aos="fade-in">
              <strong>Oops!</strong> Gagal memuat data berita. Silakan coba lagi.
            </div>
          `);
            }
        });
    }

    // Panggil saat halaman siap
    $(document).ready(function() {
        loadBeritaList();
    });
</script>
