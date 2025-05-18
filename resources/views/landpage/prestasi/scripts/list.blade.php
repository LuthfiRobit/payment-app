<script>
    $(document).ready(function() {
        function fetchPrestasi(page = 1) {
            $.ajax({
                url: '{{ route('landpage.prestasi.show.list.paginated') }}?page=' + page,
                method: 'GET',
                success: function(response) {
                    var container = $('#prestasi-list');
                    var alertContainer = $('#prestasi-alert'); // Tempat untuk alert
                    container.empty();

                    // Jika data kosong, tampilkan alert
                    if (response.data.length === 0) {
                        alertContainer.html(`
                            <div class="col-12 alert alert-warning text-center" role="alert">
                                <strong>Perhatian!</strong> Data prestasi tidak tersedia saat ini.
                            </div>
                        `);
                    } else {
                        alertContainer.empty(); // Kosongkan alert jika ada data

                        // Menambahkan card prestasi ke dalam container dengan variasi animasi AOS
                        $.each(response.data, function(i, item) {
                            var tanggal = new Date(item.tanggal).getFullYear();

                            var card = `<div class="col-lg-3 col-md-6 col-sm-12 d-flex mb-4 show-prestasi-detail" data-id="${item.id_prestasi}" data-aos="fade-up" data-aos-duration="800" data-aos-delay="${i * 100}">
                                            <div class="card prestasi-card w-100 h-100">
                                                <div class="prestasi-wrapper">
                                                    <img src="${item.foto_prestasi}" alt="Prestasi Siswa" class="prestasi-img">

                                                    <div class="prestasi-overlay">
                                                        <span class="lnr lnr-calendar-full mr-1"></span>${tanggal}
                                                    </div>
                                                </div>
                                                <div class="card-body d-flex flex-column justify-content-between">
                                                    <a href="#" class="stretched-link text-dark show-prestasi-detail" data-id="${item.id_prestasi}">
                                                        <p class="prestasi-title text-truncate">${item.nama_prestasi}</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>`;
                            container.append(card);
                        });
                    }

                    generatePagination(response);
                },
                error: function(xhr) {
                    console.error('Gagal mengambil data prestasi:', xhr);

                    // Jika gagal memuat data, tampilkan pesan error
                    $('#prestasi-alert').html(`
                        <div class="col-12 alert alert-danger text-center" role="alert">
                            <strong>Oops!</strong> Gagal memuat data prestasi. Silakan coba lagi.
                        </div>
                    `);
                }
            });
        }

        function generatePagination(data) {
            var pagination = $('.pagination');
            pagination.empty();

            if (data.prev_page_url) {
                pagination.append(`
                    <li class="page-item"><a href="#" class="page-link" data-page="${data.current_page - 1}">
                        <span aria-hidden="true"><span class="lnr lnr-chevron-left"></span></span>
                    </a></li>
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
                    <li class="page-item"><a href="#" class="page-link" data-page="${data.current_page + 1}">
                        <span aria-hidden="true"><span class="lnr lnr-chevron-right"></span></span>
                    </a></li>
                `);
            }
        }

        // Handle klik pada pagination
        $(document).on('click', '.pagination a.page-link', function(e) {
            e.preventDefault();
            var page = $(this).data('page');
            if (page) fetchPrestasi(page);
        });

        // Load data prestasi pertama kali
        fetchPrestasi();
    });
</script>
