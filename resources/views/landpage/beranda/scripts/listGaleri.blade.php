<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ route('landpage.galeri.show.list') }}", // Ganti dengan endpoint sesuai route
            method: "GET",
            dataType: "json",
            success: function(response) {
                const container = $('#gallery-container');
                container.empty();

                if (response.success && response.data.length > 0) {
                    $.each(response.data, function(i, galeri) {
                        const imageUrl = galeri.foto.startsWith('http') ? galeri.foto :
                            `{{ url('/') }}${galeri.foto}`;

                        const item = `
                            <div class="gallery-item" data-aos="fade-up" data-aos-delay="${i * 100}">
                                <a href="${imageUrl}" class="img-gal">
                                    <div class="custom-overlay">
                                        <div class="text">${galeri.kegiatan}</div>
                                    </div>
                                    <img src="${imageUrl}" alt="${galeri.kegiatan}">
                                </a>
                            </div>
                        `;
                        container.append(item);
                    });

                    // Inisialisasi Magnific Popup
                    $('.img-gal').magnificPopup({
                        type: 'image',
                        gallery: {
                            enabled: true
                        }
                    });

                } else {
                    container.html(`
                        <div class="col-12">
                            <div class="alert alert-warning text-center" role="alert">
                                <strong>Perhatian!</strong> Data galeri tidak tersedia saat ini.
                            </div>
                        </div>
                    `);
                }
            },
            error: function(xhr) {
                console.error(xhr);
                $('#gallery-container').html(`
                    <div class="col-12">
                        <div class="alert alert-danger text-center" role="alert">
                            <strong>Oops!</strong> Gagal memuat data galeri. Silakan coba lagi.
                        </div>
                    </div>
                `);
            }
        });
    });
</script>
