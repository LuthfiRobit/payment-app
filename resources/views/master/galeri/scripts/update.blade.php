<script>
    $(document).ready(function() {
        // Handle form submit untuk update data galeri
        $('#updateForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit default

            const form = $('#updateForm')[0];
            const formData = new FormData(form);
            const id = $('#updateForm').attr('data-id'); // Ambil ID dari form

            // URL untuk melakukan update
            const url = '{{ route('master-data.galeri.update', ':id') }}'.replace(':id', id);

            // Reset validasi sebelumnya
            $('#updateForm .is-invalid').removeClass('is-invalid');
            $('#updateForm .invalid-feedback').remove();

            // Kirim data melalui AJAX
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false, // Jangan proses data secara otomatis
                contentType: false, // Kirim data dalam bentuk FormData
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-HTTP-Method-Override': 'PUT' // Override method dengan PUT
                },
                beforeSend: function() {
                    // Nonaktifkan tombol submit selama proses
                    $('#updateForm button[type="submit"]').prop('disabled', true).text(
                        'Menyimpan...');
                },
                success: function(response) {
                    // Jika sukses
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Tutup modal dan reset form
                        $('#ModalEdit').modal('hide');
                        $('#updateForm')[0].reset();
                        $('#foto-preview').hide();
                        $('#view-foto').attr('href', '#');
                        $('.selectpicker').selectpicker('refresh');

                        // Reload data di DataTable
                        $('#example').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    // Jika error, periksa status code
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            const input = $('#updateForm [name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + messages[
                                0] + '</div>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memperbarui data.'
                        });
                    }
                },
                complete: function() {
                    // Kembalikan tombol submit ke kondisi semula
                    $('#updateForm button[type="submit"]').prop('disabled', false).text(
                        'Save Change');
                }
            });
        });
    });
</script>
