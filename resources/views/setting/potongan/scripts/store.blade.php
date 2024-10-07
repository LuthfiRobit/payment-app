// Script Store
<script>
    $(document).ready(function() {
        // Script Store
        $('#createPotonganForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah pengiriman form default

            // Ambil data dari form
            var formData = $(this).serialize();

            $.ajax({
                url: '{{ route('setting.potongan-siswa.store') }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Tampilkan SweetAlert sukses
                        Swal.fire({
                            title: 'Sukses',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Reload halaman setelah menutup SweetAlert
                                location.reload();
                            }
                        });
                    } else {
                        // Tampilkan SweetAlert error
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    // Jika ada error dari server, tampilkan SweetAlert error
                    Swal.fire('Error', 'Terjadi kesalahan saat menyimpan tagihan.',
                    'error');
                }
            });
        });
    });
</script>
