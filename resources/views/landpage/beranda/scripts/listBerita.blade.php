<!-- Load Berita List -->
<script>
    function loadBeritaList() {
        $.ajax({
            url: "{{ route('landpage.berita.show.list') }}",
            method: "GET",
            success: function(response) {
                var container = $('#berita-list');
                container.empty(); // Kosongkan kontainer sebelum menambah berita baru

                // Cek apakah ada data
                if (response.data.length === 0) {
                    container.html(`
                        <div class="col-12 alert alert-warning text-center" role="alert">
                            <strong>Perhatian!</strong> Data berita tidak tersedia saat ini.
                        </div>
                    `); // Menampilkan pesan menggunakan Bootstrap alert
                } else {
                    // Jika ada data, tampilkan berita
                    $.each(response.data, function(i, berita) {
                        var urlDetail = '{{ route('landpage.berita.detail', ':id') }}'.replace(
                            ':id', berita.id_berita);
                        var image = berita.gambar ??
                            '{{ asset('template-landpage/img/default.jpg') }}';

                        var card = `
                            <div class="col-lg-3 col-md-6 single-blog">
                                <div class="thumb">
                                    <img class="img-fluid" src="${image}" alt="Gambar Berita" style="height: 200px; object-fit: cover;" />
                                </div>
                                <p class="meta">${berita.info}</p>
                                <a href="${urlDetail}">
                                    <h5>${berita.judul}</h5>
                                </a>
                                <p>${berita.isi.substring(0, 120)}...</p>
                                <a href="${urlDetail}" class="details-btn d-flex justify-content-center align-items-center">
                                    <span class="details">Detail</span>
                                    <span class="lnr lnr-arrow-right"></span>
                                </a>
                            </div>
                        `;

                        container.append(card);
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                $('#berita-list').html(`
                    <div class="col-12 alert alert-danger text-center" role="alert">
                        <strong>Oops!</strong> Gagal memuat data berita. Silakan coba lagi.
                    </div>
                `); // Menampilkan pesan menggunakan Bootstrap alert jika gagal memuat data
            }
        });
    }

    $(document).ready(function() {
        loadBeritaList();
    });
</script>
