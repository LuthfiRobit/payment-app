<script>
    $(document).ready(function() {
        // Inisialisasi Owl Carousel (jika belum diinit)
        $('#prestasi-carousel').owlCarousel({
            items: 4,
            margin: 30,
            loop: true,
            dots: true,
            autoplayHoverPause: true,
            smartSpeed: 650,
            autoplay: true,
            responsive: {
                0: {
                    items: 1,
                },
                480: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 4,
                },
            },
        });

        // Ambil data dari endpoint
        $.ajax({
            url: "{{ route('landpage.prestasi.show.list') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.success && response.data.length) {
                    // Kosongkan carousel
                    var $carousel = $('#prestasi-carousel');
                    $carousel.trigger('destroy.owl.carousel'); // Hapus instance lama
                    $carousel.html(''); // Kosongkan konten lama

                    $.each(response.data, function(index, item) {
                        var content = `
                        <div class="single-popular-carusel mx-auto">
                            <div class="thumb-wrap relative">
                                <div class="thumb relative">
                                    <div class="overlay overlay-bg"></div>
                                    <img class="img-fluid" src="${item.foto_prestasi}" alt="Prestasi Siswa" />
                                </div>
                                <div class="meta d-flex justify-content-between">
                                    <p>
                                        <span class="lnr lnr-calendar-full"></span>
                                        ${item.tanggal}
                                    </p>
                                </div>
                            </div>
                            <div class="details">
                                <a href="#">
                                    <h4>${item.nama_prestasi}</h4>
                                </a>
                            </div>
                        </div>
                    `;
                        $carousel.append(content);
                    });

                    // Re-inisialisasi carousel
                    $carousel.owlCarousel({
                        items: 4,
                        margin: 30,
                        loop: true,
                        dots: true,
                        autoplayHoverPause: true,
                        smartSpeed: 650,
                        autoplay: true,
                        responsive: {
                            0: {
                                items: 1,
                            },
                            480: {
                                items: 1,
                            },
                            768: {
                                items: 2,
                            },
                            992: {
                                items: 4,
                            },
                        },
                    });
                }
            },
            error: function(xhr) {
                console.error('Gagal mengambil data prestasi:', xhr);
            }
        });
    });
</script>
