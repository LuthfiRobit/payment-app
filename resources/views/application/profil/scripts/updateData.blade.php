<script>
    // Fungsi untuk mengambil data dari form update
    function getUpdatedData(form) {
        return {
            name: form.find('#name').val(), // Nama
            email: form.find('#email').val(), // Email
            _token: '{{ csrf_token() }}' // Token CSRF untuk keamanan
        };
    }

    // Fungsi untuk menangani pengiriman form dengan AJAX
    function handleFormSubmit(formSelector, url, method, successMessage, dataExtractor) {
        $(formSelector).on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit biasa

            // Kosongkan pesan error sebelumnya
            $('#nameError').text('');
            $('#emailError').text('');

            // Ambil data dari form
            var formData = dataExtractor($(formSelector));

            // Mengirim data menggunakan AJAX
            $.ajax({
                url: url, // URL untuk memperbarui data pengguna
                method: method,
                data: {
                    name: formData.name,
                    email: formData.email,
                    _token: formData._token, // Token CSRF
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', successMessage, 'success');
                        location.reload(); // Reload halaman untuk menampilkan data terbaru
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    // Menghapus error sebelumnya
                    $(formSelector + ' .invalid-feedback').remove();
                    $(formSelector + ' .form-control').removeClass('is-invalid');

                    // Menampilkan error validasi jika ada
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            const inputField = $(formSelector).find(`#${field}`);
                            inputField.addClass('is-invalid');
                            inputField.after('<div class="invalid-feedback">' + messages
                                .join('<br>') + '</div>');
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui data.', 'error');
                    }
                }
            });
        });
    }

    // Menangani pengiriman form update
    handleFormSubmit(
        '#updatePersonal',
        '{{ route('application.profil.update.data', Auth::user()->id_user) }}', // Sesuaikan dengan route update
        'PUT',
        'Informasi berhasil diperbarui!',
        getUpdatedData // Fungsi untuk mengambil data form
    );

    // Reset form input ketika modal ditutup atau setelah berhasil mengirimkan data
    $('#updatePersonal')[0].reset();
    $('.form-control').removeClass('is-invalid');
    $('#nameError').text('');
    $('#emailError').text('');
</script>
