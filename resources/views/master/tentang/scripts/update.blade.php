<script>
    // Fungsi untuk menyiapkan data untuk update
    function updateData(form) {
        var formData = new FormData(form[0]);
        formData.append('deskripsi', form.find('#deskripsi').val());
        return formData; // Kembalikan FormData
    }

    // Fungsi untuk menangani form update dengan AJAX
    function handleFormUpdate(formSelector, url, method, successMessage, updateDataFunction) {
        $(formSelector).submit(function(event) {
            event.preventDefault(); // Mencegah pengiriman form secara default

            var formData = updateDataFunction($(this));
            // Retrieve the ID dynamically (e.g., from data-id attribute)
            var id = $(formSelector).data('id'); // Assuming you're storing the ID in data-id

            // Prepare the URL with the dynamic ID
            var route = url.replace(':id', id);

            // Reset error sebelum pengiriman
            $(formSelector).find('.invalid-feedback').remove();
            $(formSelector).find('.form-control').removeClass('is-invalid');

            $.ajax({
                url: route, // Endpoint Laravel untuk update
                method: method, // PUT atau PATCH
                data: formData,
                processData: false, // Jangan proses data FormData
                contentType: false, // Jangan set content-type
                beforeSend: function() {
                    $('#btnUpdateTentang').attr('disabled', true).text('Menyimpan...');
                },
                success: function(response) {
                    $('#btnUpdateTentang').attr('disabled', false).text('Simpan');

                    if (response.success) {
                        Swal.fire('Sukses!', successMessage, 'success').then(() => {
                            location.reload(); // Reload seluruh halaman
                        });
                        $('#ModalEdit').modal('hide'); // Tutup modal edit
                        $('#updateForm')[0].reset(); // Reset form
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }

                },
                error: function(xhr) {
                    $('#btnUpdateTentang').attr('disabled', false).text('Simpan');

                    if (xhr.status === 400 || xhr.status === 422) {
                        var response = xhr.responseJSON;

                        Swal.fire('Error!', response.message || 'Terjadi kesalahan validasi.',
                            'error');

                        if (response.errors) {
                            $.each(response.errors, function(field, messages) {
                                var inputField = $('#' + field);
                                inputField.addClass(
                                    'is-invalid'); // Tambah class is-invalid
                                inputField.after('<div class="invalid-feedback">' + messages
                                    .join('<br>') + '</div>');
                            });
                        }
                    } else {
                        Swal.fire('Error!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                    }
                }
            });
        });
    }

    // Inisialisasi untuk pengiriman form update
    $(document).ready(function() {
        // Reset form ketika modal ditutup
        $('#ModalEdit').on('hidden.bs.modal', function() {
            $('#updateForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#updateForm .invalid-feedback').remove();
            $('#updateForm .form-control').removeClass('is-invalid');
        });

        // Inisialisasi form update
        handleFormUpdate('#updateForm',
            '{{ route('master-data.tentang.update', ':id') }}', // Route dengan parameter ID
            'POST', // Gunakan POST jika menggunakan spoofing method (_method=PUT)
            'Tentang berhasil diperbarui.', // Pesan sukses
            updateData // Fungsi untuk menyiapkan FormData
        );
    });
</script>
