<!-- Load Prestasi Carousel -->
<script>
    $(document).ready(function() {
        const $carousel = $('#prestasi-carousel');

        // Ambil data prestasi
        $.ajax({
            url: "{{ route('landpage.prestasi.show.list') }}",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.success && response.data.length) {
                    // Kosongkan isi carousel dulu
                    $carousel.empty();

                    // Tambahkan isi baru
                    $.each(response.data, function(index, item) {
                        $carousel.append(`
                            <div class="single-popular-carusel mx-auto">
                                <div class="thumb-wrap relative">
                                    <div class="thumb relative">
                                        <div class="overlay overlay-bg"></div>
                                        <img class="img-fluid" src="${item.foto_prestasi}" alt="Prestasi Siswa" />
                                    </div>
                                    <div class="meta d-flex justify-content-between">
                                        <p><span class="lnr lnr-calendar-full"></span> ${item.tanggal}</p>
                                    </div>
                                </div>
                                <div class="details">
                                    <a href="#"><h4>${item.nama_prestasi}</h4></a>
                                </div>
                            </div>
                        `);
                    });

                    // Baru inisialisasi Owl Carousel
                    $carousel.owlCarousel({
                        items: 4,
                        margin: 30,
                        loop: true,
                        dots: true,
                        autoplay: true,
                        autoplayHoverPause: true,
                        smartSpeed: 650,
                        responsive: {
                            0: {
                                items: 1
                            },
                            480: {
                                items: 1
                            },
                            768: {
                                items: 2
                            },
                            992: {
                                items: 4
                            }
                        }
                    });
                }
            },
            error: function(xhr) {
                console.error('Gagal mengambil data prestasi:', xhr);
            }
        });
    });
</script>
