<script>
    $(document).ready(function() {
        loadGaleri(1); // Load page pertama saat pertama kali

        function loadGaleri(page) {
            $.ajax({
                url: "{{ route('landpage.galeri.show.list.paginated') }}?page=" + page,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    renderGaleri(response.data);
                    renderPagination(response);
                }
            });
        }

        function renderGaleri(data) {
            var container = $("#galeri-container");
            container.empty();

            $.each(data, function(index, item) {
                var galeriItem = `
                    <div class="col-lg-3 col-md-6 col-sm-12 d-flex mb-4">
                        <a href="${item.foto}" class="img-gal w-100" title="${item.kegiatan}">
                            <div class="single-imgs relative w-100 h-100" style="min-height: 300px">
                                <div class="overlay overlay-bg"></div>
                                <div class="relative h-100">
                                    <img class="img-fluid h-100 w-100" src="${item.foto}" alt="${item.kegiatan}" style="object-fit: cover" />
                                     <p class="position-absolute text-white m-2" style="bottom: 0; left: 0">
                                        <span class="lnr lnr-calendar-full"></span>
                                        ${item.tanggal}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                `;
                container.append(galeriItem);
            });

            // Re-inisialisasi Lightbox
            $(".img-gal").magnificPopup({
                type: "image",
                gallery: {
                    enabled: true
                },
                titleSrc: 'title' // Ambil dari atribut title
            });
        }

        function renderPagination(response) {
            var pagination = $("#pagination");
            pagination.empty();

            // Previous
            if (response.prev_page_url) {
                pagination.append(
                    `<li class="page-item"><a class="page-link" href="#" data-page="${response.current_page - 1}">&laquo;</a></li>`
                );
            }

            // Numbered pages
            for (var i = 1; i <= response.last_page; i++) {
                var active = (i === response.current_page) ? "active" : "";
                pagination.append(
                    `<li class="page-item ${active}"><a class="page-link" href="#" data-page="${i}">${("0" + i).slice(-2)}</a></li>`
                );
            }

            // Next
            if (response.next_page_url) {
                pagination.append(
                    `<li class="page-item"><a class="page-link" href="#" data-page="${response.current_page + 1}">&raquo;</a></li>`
                );
            }
        }

        // Handle pagination click
        $(document).on("click", ".page-link", function(e) {
            e.preventDefault();
            var page = $(this).data("page");
            if (page) {
                loadGaleri(page);
            }
        });
    });
</script>
