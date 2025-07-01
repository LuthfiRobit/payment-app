<script>
    $(document).ready(function() {
        const $carousel = $('#guru-carousel');
        const $alertContainer = $('#guru-alert');

        $.ajax({
            url: "{{ route('landpage.guru.show.list') }}",
            type: "GET",
            data: {
                kategori: 'guru'
            },
            dataType: "json",
            success: function(response) {
                $carousel.empty();
                $alertContainer.empty();

                if (response.success && response.data.length) {
                    // Destroy previous instance if exists
                    if ($carousel.hasClass('owl-loaded')) {
                        $carousel.trigger('destroy.owl.carousel');
                        $carousel.removeClass('owl-loaded owl-theme owl-carousel');
                        $carousel.find('.owl-stage-outer').children().unwrap();
                        $carousel.find('.owl-stage').children().unwrap();
                        $carousel.html("");
                    }

                    // Append new items
                    $.each(response.data, function(index, item) {
                        const card = `<div class="item" data-aos="flip-left" data-aos-duration="1500">
                                <div class="card h-100 d-flex flex-column text-center p-3 border rounded shadow-sm">
                                    <img src="${item.foto}" class="img-fluid rounded mb-3 mx-auto" alt="${item.nama}" style="width: 100%; max-width:200px; max-height: 250px;">
                                    <div class="mt-auto">
                                        <h6 class="mb-1">${item.nama}</h6>
                                        <p class="text-muted mb-0">${item.jabatan}</p>
                                    </div>
                                </div>
                            </div>`;
                        $carousel.append(card);
                    });

                    let itemCount = response.data.length;

                    // Re-init Owl Carousel
                    $carousel.owlCarousel({
                        items: 3, // <- Ganti dari 4 ke 3
                        margin: 30,
                        loop: itemCount > 1,
                        dots: true,
                        autoplay: true,
                        autoplayTimeout: 2500,
                        autoplayHoverPause: true,
                        smartSpeed: 500,
                        responsive: {
                            0: {
                                items: 1
                            },
                            576: {
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            992: {
                                items: 3 // <- Sesuaikan juga di breakpoint besar
                            }
                        }
                    });

                    AOS.refresh();
                } else {
                    $alertContainer.html(`
                <div class="alert alert-warning text-center" role="alert">
                    <strong>Perhatian!</strong> Data guru tidak tersedia saat ini.
                </div>
            `);
                }
            },
            error: function(xhr) {
                console.error('Gagal mengambil data guru:', xhr);
                $alertContainer.html(`
            <div class="alert alert-danger text-center" role="alert">
                <strong>Oops!</strong> Gagal memuat data guru. Silakan coba lagi.
            </div>
        `);
            }
        });

    });
</script>
