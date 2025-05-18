<script>
    $(document).ready(function() {
        // Fungsi untuk memuat artikel dengan pagination
        function fetchArtikel(page = 1) {
            const url = `{{ route('landpage.artikel.show.list.paginated') }}?page=${page}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var container = $('#artikel-container');
                    var alertContainer = $('#artikel-alert');
                    container.empty();
                    alertContainer.empty();

                    // Jika data kosong, tampilkan alert
                    if (response.data.length === 0) {
                        alertContainer.html(`
                            <div class="col-12 alert alert-warning text-center" role="alert">
                                <strong>Perhatian!</strong> Data artikel tidak tersedia saat ini.
                            </div>
                        `);
                    } else {
                        // Menambahkan artikel ke dalam kontainer
                        $.each(response.data, function(i, artikel) {
                            var urlDetail = '{{ route('landpage.artikel.detail', ':id') }}'
                                .replace(':id', artikel.id_artikel);

                            var card = `
                            <div class="col-lg-3 col-md-6 single-blog" data-aos="flip-left" data-aos-duration="1000">
                                <div class="thumb">
                                    <img class="img-fluid" src="${artikel.gambar}" alt="Gambar Artikel" style="height: 200px; object-fit: cover;" />
                                </div>
                                <p class="meta">${artikel.info}</p>
                                <a href="${urlDetail}">
                                    <h5>${artikel.judul}</h5>
                                </a>
                                <p>${artikel.isi.substring(0, 150)}...</p>
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
                    console.error('Gagal memuat data artikel:', xhr);
                    $('#artikel-alert').html(`
                        <div class="col-12 alert alert-danger text-center" role="alert">
                            <strong>Oops!</strong> Gagal memuat data artikel. Silakan coba lagi.
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
            if (page) fetchArtikel(page);
        });

        // Load data artikel pertama kali
        fetchArtikel();
    });
</script>
