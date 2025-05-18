<script>
    $(document).ready(function() {

        function fetchGuruKaryawan(kategori, containerId, emptyText) {
            $.ajax({
                url: '{{ route('landpage.guru.show.list') }}',
                method: 'GET',
                data: {
                    kategori: kategori
                },
                success: function(response) {
                    const container = $(`#${containerId}`);
                    container.empty();

                    if (response.data.length === 0) {
                        container.html(`
                            <div class="col-12 alert alert-warning text-center" role="alert">
                                <strong>Perhatian!</strong> ${emptyText}
                            </div>
                        `);
                    } else {
                        $.each(response.data, function(i, item) {
                            const card = `
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100 d-flex flex-column text-center p-3">
                                        <img src="${item.foto}" class="img-fluid rounded mb-3 mx-auto" alt="${item.nama}" style="width: 100%;max-width:200px; max-height: 250px;">
                                        <div class="mt-auto">
                                            <h6 class="mb-1">${item.nama}</h6>
                                            <p class="text-muted mb-0">${item.jabatan}</p>
                                        </div>
                                    </div>
                                </div>`;
                            container.append(card);
                        });
                    }
                },
                error: function(xhr) {
                    console.error('Gagal mengambil data:', xhr);
                    $(`#${containerId}`).html(`
                        <div class="col-12 alert alert-danger text-center" role="alert">
                            <strong>Oops!</strong> Gagal memuat data ${kategori}. Silakan coba lagi.
                        </div>
                    `);
                }
            });
        }

        // Inisialisasi ketika halaman selesai dimuat
        fetchGuruKaryawan('guru', 'guru-container', 'Data guru belum tersedia.');
        fetchGuruKaryawan('karyawan', 'karyawan-container', 'Data karyawan belum tersedia.');
    });
</script>
