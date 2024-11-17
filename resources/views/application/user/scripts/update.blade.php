<script>
    // Fungsi untuk mengambil data dari form update
    function updateData(form) {
        return {
            id: form.find('#user_id').val(), // ID Pengguna
            name: form.find('#name').val(), // Nama
            email: form.find('#email').val(), // Email
            role: form.find('#role').val(), // Peran
            password: form.find('#password').val(), // Password (jika diubah)
            password_confirmation: form.find('#confirm_password').val() // Konfirmasi Password
        };
    }

    // Fungsi untuk menangani pengiriman form dengan AJAX
    function handleFormSubUser(formSelector, url, method, successMessage, dataExtractor) {
        $(formSelector).on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit biasa
            const id = $(this).data('id');
            // Ambil data dari form
            var formData = dataExtractor($(formSelector));

            // Mengirim data menggunakan AJAX
            $.ajax({
                url: url.replace(':id', id), // Ganti ID dengan data yang sebenarnya
                method: method,
                data: {
                    name: formData.name,
                    email: formData.email,
                    role: formData.role,
                    password: formData.password,
                    password_confirmation: formData
                    .password_confirmation, // Kirimkan konfirmasi password
                    _token: '{{ csrf_token() }}' // Token CSRF untuk keamanan
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', successMessage, 'success');
                        $('#ModalEdit').modal('hide');
                        location.reload();
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    // Menghapus error sebelumnya
                    $(formSelector + ' .invalid-feedback').remove();
                    $(formSelector + ' .form-control').removeClass('is-invalid');

                    // Menampilkan error validasi
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            const inputField = $(formSelector).find(`#${field}`);
                            inputField.addClass('is-invalid');
                            inputField.after('<div class="invalid-feedback">' + messages
                                .join('<br>') + '</div>');
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui data pengguna.',
                            'error');
                    }
                }
            });
        });
    }

    // Meng-handle pengiriman form update
    handleFormSubUser('#updateForm',
        '{{ route('application.user.update', ':id') }}', // Sesuaikan dengan route Anda
        'PUT',
        'Pengguna berhasil diperbarui.',
        updateData // Mengambil data dari form dan menyiapkannya untuk dikirim
    );

    // Reset form input ketika modal ditutup
    $('#ModalEdit').on('hidden.bs.modal', function() {
        $('#updateForm')[0].reset();
        $('.selectpicker').selectpicker('refresh');
        $('#updateForm .invalid-feedback').remove();
        $('#updateForm .form-control').removeClass('is-invalid');
    });
</script>
