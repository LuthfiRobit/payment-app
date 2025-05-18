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

            if (!data.length) {
                container.html(`
            <div class="col-12 alert alert-warning text-center" role="alert">
                <strong>Perhatian!</strong> Data galeri tidak tersedia saat ini.
            </div>
        `);
                return;
            }

            $.each(data, function(i, item) {
                const imageUrl = item.foto.startsWith('http') ? item.foto :
                    `{{ url('/') }}${item.foto}`;

                const galeriItem = `
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4" data-aos="fade-up" data-aos-delay="${i * 100}">
                <div class="gallery-item">
                    <a href="${imageUrl}" class="img-gal" title="${item.kegiatan}">
                        <img src="${imageUrl}" alt="${item.kegiatan}">
                        <div class="custom-overlay">
                            <div class="text">${item.kegiatan}</div>
                        </div>
                        <div class="tanggal-info">
                            <span class="lnr lnr-calendar-full"></span> ${item.tanggal}
                        </div>
                    </a>
                </div>
            </div>
        `;
                container.append(galeriItem);
            });

            // Re-init magnificPopup
            $(".img-gal").magnificPopup({
                type: "image",
                gallery: {
                    enabled: true
                },
                titleSrc: 'title'
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
