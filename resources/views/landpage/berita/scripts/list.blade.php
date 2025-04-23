<script>
    $(document).ready(function() {
        // Fungsi untuk memuat berita dengan pagination
        function fetchBerita(page = 1) {
            const url = `{{ route('landpage.berita.show.list.paginated') }}?page=${page}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var container = $('#berita-container');
                    var alertContainer = $('#berita-alert'); // Tempat untuk alert
                    container.empty();
                    alertContainer.empty(); // Kosongkan alert sebelumnya

                    // Jika data kosong, tampilkan alert
                    if (response.data.length === 0) {
                        alertContainer.html(`
                            <div class="col-12 alert alert-warning text-center" role="alert">
                                <strong>Perhatian!</strong> Data berita tidak tersedia saat ini.
                            </div>
                        `);
                    } else {
                        // Menambahkan berita ke dalam kontainer
                        $.each(response.data, function(i, berita) {
                            var urlDetail = '{{ route('landpage.berita.detail', ':id') }}'
                                .replace(':id', berita.id_berita);

                            var card = `
                            <div class="col-lg-3 col-md-6 single-blog">
                                <div class="thumb">
                                    <img class="img-fluid" src="${berita.gambar}" alt="Gambar Berita" style="height: 200px; object-fit: cover;" />
                                </div>
                                <p class="meta">${berita.info}</p>
                                <a href="${urlDetail}">
                                    <h5>${berita.judul}</h5>
                                </a>
                                <p>${berita.isi.substring(0, 150)}...</p>
                                <a href="${urlDetail}" class="details-btn d-flex justify-content-center align-items-center">
                                    <span class="details">Detail</span>
                                    <span class="lnr lnr-arrow-right"></span>
                                </a>
                            </div>`;
                            container.append(card);
                        });
                    }

                    // Generate pagination
                    generatePagination(response);
                },
                error: function(xhr) {
                    console.error('Gagal memuat data berita:', xhr);

                    // Jika gagal memuat data, tampilkan pesan error
                    $('#berita-alert').html(`
                        <div class="col-12 alert alert-danger text-center" role="alert">
                            <strong>Oops!</strong> Gagal memuat data berita. Silakan coba lagi.
                        </div>
                    `);
                }
            });
        }

        // Fungsi untuk generate pagination
        function generatePagination(data) {
            var pagination = $('#pagination');
            pagination.empty();

            if (data.prev_page_url) {
                pagination.append(`
                    <li class="page-item">
                        <a href="#" class="page-link" data-page="${data.current_page - 1}">
                            <span aria-hidden="true"><span class="lnr lnr-chevron-left"></span></span>
                        </a>
                    </li>
                `);
            }

            for (var i = 1; i <= data.last_page; i++) {
                var active = (i === data.current_page) ? 'active' : '';
                pagination.append(`
                    <li class="page-item ${active}">
                        <a href="#" class="page-link" data-page="${i}">${("0" + i).slice(-2)}</a>
                    </li>
                `);
            }

            if (data.next_page_url) {
                pagination.append(`
                    <li class="page-item">
                        <a href="#" class="page-link" data-page="${data.current_page + 1}">
                            <span aria-hidden="true"><span class="lnr lnr-chevron-right"></span></span>
                        </a>
                    </li>
                `);
            }
        }

        // Handle click on pagination links
        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page) fetchBerita(page);
        });

        // Load data berita pertama kali
        fetchBerita();
    });
</script>
