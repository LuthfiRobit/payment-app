<script>
    $(document).ready(function() {
        $(document).on('click', '.show-prestasi-detail', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var urlShow = '{{ route('landpage.prestasi.show', ':id') }}'.replace(':id', id);

            // Reset isi modal
            $('#modalLabel').text('Loading...');
            $('#modalImage').attr('src', '');
            $('#modalDescription').text('Sedang memuat...');

            // Cek apakah ada modal lain yang masih terbuka
            if ($('.modal.show').length) {
                $('.modal.show').modal('hide');
            }

            // Tunda tampilkan modal sampai benar-benar kosong
            setTimeout(function() {
                $('#dynamicDetailModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }, 300); // cukup untuk animasi modal lain tertutup

            // Fetch data
            $.ajax({
                url: urlShow,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;
                        $('#modalLabel').text(data.nama_prestasi);
                        $('#modalImage').attr('src', data.foto_prestasi);
                        $('#modalDescription').text(data.keterangan);
                    } else {
                        $('#modalLabel').text('Prestasi tidak ditemukan');
                        $('#modalDescription').text('Silakan coba lagi.');
                    }
                },
                error: function() {
                    $('#modalLabel').text('Terjadi kesalahan');
                    $('#modalDescription').text('Tidak dapat mengambil detail prestasi.');
                }
            });
        });

        // Fokuskan modal setelah tampil (menghindari accessibility error)
        $('#dynamicDetailModal').on('shown.bs.modal', function() {
            $(this).trigger('focus');
        });
    });
</script>
