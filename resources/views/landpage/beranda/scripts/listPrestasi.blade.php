<!-- Load Prestasi Carousel -->
<script>
    $(document).ready(function() {
        const $carousel = $('#prestasi-carousel');
        const $alertContainer = $('#prestasi-alert');

        $.ajax({
            url: "{{ route('landpage.prestasi.show.list') }}",
            type: "GET",
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

                    $.each(response.data, function(index, item) {
                        const card = `
                                <div class="item">
                                    <div class="single-popular-carusel text-center p-3 border rounded shadow-sm">
                                    <div class="thumb-wrap relative mb-3">
                                        <div class="thumb position-relative">
                                        <div class="overlay overlay-bg"></div>
                                        <img class="img-fluid w-100 rounded" src="${item.foto_prestasi}" alt="Prestasi Siswa"
                                            style="height: 175px; object-fit: cover;">
                                        </div>
                                        <div class="meta d-flex justify-content-center mt-2">
                                        <small class="text-muted"><i class="lnr lnr-calendar-full"></i> ${item.tanggal}</small>
                                        </div>
                                    </div>
                                    <div class="details mt-3">
                                        <h5 class="font-weight-bold">${item.nama_prestasi}</h5>
                                    </div>
                                    </div>
                                </div>
                                `;
                        $carousel.append(card);
                    });

                    let itemCount = response.data.length;

                    // Inisialisasi carousel setelah semua item ditambahkan
                    $carousel.owlCarousel({
                        items: 4,
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
                                items: 4
                            }
                        }
                    });

                    AOS.refresh(); // Untuk memunculkan animasi setelah elemen baru ditambahkan
                } else {
                    $alertContainer.html(`
            <div class="alert alert-warning text-center" role="alert">
              <strong>Perhatian!</strong> Data prestasi tidak tersedia saat ini.
            </div>
          `);
                }
            },
            error: function(xhr) {
                console.error('Gagal mengambil data prestasi:', xhr);
                $alertContainer.html(`
                    <div class="alert alert-danger text-center" role="alert">
                        <strong>Oops!</strong> Gagal memuat data prestasi. Silakan coba lagi.
                    </div>
                    `);
            }
        });
    });
</script>
