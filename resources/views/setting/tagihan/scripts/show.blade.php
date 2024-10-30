<script>
    $(document).ready(function() {
        // Menangani tombol detail untuk menampilkan informasi siswa dan tagihan
        $('#example').on('click', '.detail-button', function() {
            var id = $(this).data('id');
            var url = '{{ route('setting.tagihan-siswa.show', ':id') }}'.replace(':id', id);
            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    $('#show_nama_siswa').text(response.data.nama_siswa);
                    $('#show_kelas').text(response.data.kelas);
                    $('#show_status').text(response.data.status);
                    $('#tagihanList').html('');
                    if (response.data.tagihan_siswa.length > 0) {
                        response.data.tagihan_siswa.forEach(function(tagihan) {
                            $('#tagihanList').append(
                                '<li class="list-group-item">' +
                                '<div class="row align-items-center">' +
                                '<div class="col">' +
                                '<span class="text-uppercase">' + tagihan.iuran
                                .nama_iuran + '</span>' + // Nama iuran
                                '</div>' +
                                '<div class="col-auto">' +
                                '<span class="badge light badge-primary badge-pill">' +
                                tagihan.iuran.besar_iuran + '</span>' +
                                // Besar iuran
                                '</div>' +
                                '<div class="col-auto">' +
                                '<div class="form-check form-switch">' +
                                '<input class="form-check-input toggle-iuran" type="checkbox" ' +
                                (tagihan.status === 'aktif' ? 'checked' : '') +
                                ' data-id="' + tagihan.id_tagihan_siswa + '">' +
                                '</div></div></div></li>'
                            );
                        });
                    } else {
                        $('#tagihanList').append(
                            '<li class="list-group-item align-items-center text-center fw-bold text-uppercase">Belum ada tagihan</li>'
                        );
                    }

                    $('#detailTagihanModal').modal('show');
                }
            });
        });

        // Menangani perubahan status iuran
        $(document).on('change', '.toggle-iuran', function() {
            var tagihanId = $(this).data('id');
            var isActive = $(this).is(':checked') ? 'aktif' : 'tidak aktif';
            var confirmationMessage = isActive === 'aktif' ?
                'Apakah Anda yakin ingin mengaktifkan tagihan ini?' :
                'Apakah Anda yakin ingin menonaktifkan tagihan ini?';

            // Tampilkan konfirmasi SweetAlert
            Swal.fire({
                title: 'Konfirmasi',
                text: confirmationMessage,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Buat request AJAX untuk memperbarui status iuran
                    $.ajax({
                        url: '{{ route('setting.tagihan-siswa.update-status') }}', // Sesuaikan route
                        method: 'POST',
                        data: {
                            id: tagihanId,
                            status: isActive,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: response.message,
                                confirmButtonText: 'OK'
                            });
                        },
                        error: function(xhr) {
                            var errorMessage = xhr.responseJSON.message ||
                                'Terjadi kesalahan, coba lagi nanti.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                } else {
                    // Kembalikan status checkbox ke keadaan semula jika dibatalkan
                    $(this).prop('checked', !$(this).is(':checked'));
                }
            });
        });
    });
</script>
