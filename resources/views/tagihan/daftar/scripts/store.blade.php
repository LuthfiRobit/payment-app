<script>
    $(document).ready(function() {
        // Tombol untuk membuka modal set tagihan massal
        $('#setTagihanMassalBtn').click(function() {
            let selectedIds = [];
            $('.siswa-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Siswa!',
                    text: 'Anda harus memilih setidaknya satu siswa terlebih dahulu.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Tampilkan modal
            $('#setTagihanModal').modal('show');
            console.log(selectedIds);

            // Reset form ketika modal ditutup
            $('#setTagihanModal').on('hidden.bs.modal', function() {
                $('#setTagihanForm')[0].reset(); // Reset form
                $('#setTagihanForm .invalid-feedback')
                    .remove(); // Menghapus pesan error yang ada
                $('#setTagihanForm .form-control').removeClass(
                    'is-invalid'); // Menghapus class is-invalid
            });

            $('#setTagihanForm').off('submit').on('submit', function(e) {
                e.preventDefault();

                // Mengirim data ke server
                $.ajax({
                    url: "{{ route('tagihan.generate-tagihan.store-multiple') }}", // Ubah ke rute store yang tepat
                    method: "POST",
                    data: {
                        siswa_ids: selectedIds, // Siswa yang dipilih
                        _token: '{{ csrf_token() }}' // CSRF token untuk keamanan
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            $('#setTagihanModal').modal('hide');
                            location.reload(); // Reload tabel jika perlu
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            let errorMsg = '';
                            $.each(errors, function(key, error) {
                                errorMsg += error + '\n';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan:\n' + errorMsg,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan, coba lagi nanti.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });

        // Reset form input ketika modal ditutup
        $('#setTagihanModal').on('hidden.bs.modal', function() {
            $('#setTagihanForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
        });
    });
</script>
