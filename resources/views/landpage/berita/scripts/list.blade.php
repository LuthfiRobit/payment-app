<script>
    $(document).ready(function() {
        function fetchBerita(page = 1) {
            const url = `{{ route('landpage.berita.show.list.paginated') }}?page=${page}`;

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    var container = $('#berita-container');
                    container.empty();

                    $.each(response.data, function(i, berita) {
                        var urlDetail = '{{ route('landpage.berita.detail', ':id') }}'
                            .replace(':id', berita.id_berita);

                        var card = `
                        <div class="col-lg-3 col-md-6 single-blog">
                            <div class="thumb">
                                <img class="img-fluid" src="${berita.gambar}" alt="" />
                            </div>
                            <p class="meta">
                                ${berita.info}
                            </p>
                            <a href="${urlDetail}">
                                <h5>${berita.judul}</h5>
                            </a>
                            <p>
                                ${berita.isi.substring(0, 150)}...
                            </p>
                            <a href="${urlDetail}" class="details-btn d-flex justify-content-center align-items-center">
                                <span class="details">Detail</span>
                                <span class="lnr lnr-arrow-right"></span>
                            </a>
                        </div>`;
                        container.append(card);
                    });

                    generatePagination(response);
                }
            });
        }

        function generatePagination(data) {
            var pagination = $('#pagination');
            pagination.empty();

            if (data.prev_page_url) {
                pagination.append(`<li class="page-item">
                    <a href="#" class="page-link" data-page="${data.current_page - 1}">
                        <span class="lnr lnr-chevron-left"></span>
                    </a>
                </li>`);
            }

            for (var i = 1; i <= data.last_page; i++) {
                var active = (i === data.current_page) ? 'active' : '';
                pagination.append(`<li class="page-item ${active}">
                    <a href="#" class="page-link" data-page="${i}">
                        ${("0" + i).slice(-2)}
                    </a>
                </li>`);
            }

            if (data.next_page_url) {
                pagination.append(`<li class="page-item">
                    <a href="#" class="page-link" data-page="${data.current_page + 1}">
                        <span class="lnr lnr-chevron-right"></span>
                    </a>
                </li>`);
            }
        }

        $(document).on('click', '.pagination .page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page) fetchBerita(page);
        });

        fetchBerita();
    });
</script>
