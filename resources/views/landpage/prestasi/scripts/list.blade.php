<script>
    $(document).ready(function() {
        function fetchPrestasi(page = 1) {
            $.ajax({
                url: '{{ route('landpage.prestasi.show.list.paginated') }}?page=' + page,
                method: 'GET',
                success: function(response) {
                    var container = $('#prestasi-list');
                    container.empty();

                    $.each(response.data, function(i, item) {
                        var tanggal = new Date(item.tanggal).getFullYear();

                        var card = `
                        <div class="col-lg-3 col-md-6 col-sm-12 d-flex mb-4">
                            <div class="card w-100">
                                <div class="position-relative">
                                    <img class="card-img-top img-fluid" src="${item.foto_prestasi}" alt="${item.nama_prestasi}"
                                        style="height: 200px; object-fit: cover" />
                                    <div class="position-absolute w-100 h-100"
                                        style="top: 0; left: 0; background: rgba(0, 0, 0, 0.5);">
                                    </div>
                                    <p class="position-absolute text-white m-2" style="bottom: 0; left: 0">
                                        <span class="lnr lnr-calendar-full"></span>
                                        ${tanggal}
                                    </p>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <a href="#" class="stretched-link text-dark show-prestasi-detail" data-id="${item.id_prestasi}">
                                        <h5 class="card-title">${item.nama_prestasi}</h5>
                                    </a>
                                </div>
                            </div>
                        </div>`;
                        container.append(card);
                    });

                    generatePagination(response);
                }
            });
        }

        function generatePagination(data) {
            var pagination = $('.pagination');
            pagination.empty();

            if (data.prev_page_url) {
                pagination.append(`<li class="page-item"><a href="#" class="page-link" data-page="${data.current_page - 1}">
                <span aria-hidden="true"><span class="lnr lnr-chevron-left"></span></span></a></li>`);
            }

            for (var i = 1; i <= data.last_page; i++) {
                var active = (i === data.current_page) ? 'active' : '';
                pagination.append(`<li class="page-item ${active}">
                <a href="#" class="page-link" data-page="${i}">${("0" + i).slice(-2)}</a>
            </li>`);
            }

            if (data.next_page_url) {
                pagination.append(`<li class="page-item"><a href="#" class="page-link" data-page="${data.current_page + 1}">
                <span aria-hidden="true"><span class="lnr lnr-chevron-right"></span></span></a></li>`);
            }
        }

        $(document).on('click', '.pagination a.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page) fetchPrestasi(page);
        });

        fetchPrestasi();
    });
</script>
