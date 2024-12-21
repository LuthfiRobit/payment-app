<script>
    // Fungsi untuk mengambil data dari form update password
    function getPasswordUpdateData(form) {
        return {
            current_password: form.find('#current_password').val(), // Password sebelumnya
            password: form.find('#password').val(), // Password baru
            password_confirmation: form.find('#confirm_password').val(), // Konfirmasi password baru
            _token: '{{ csrf_token() }}' // Token CSRF untuk keamanan
        };
    }

    // Fungsi untuk menangani pengiriman form dengan AJAX
    function handlePasswordFormSubmit(formSelector, url, method, successMessage, dataExtractor) {
        $(formSelector).on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit biasa

            // Kosongkan pesan error sebelumnya
            $('#current-password-error').hide();
            $('#password-error').hide();

            // Ambil data dari form
            var formData = dataExtractor($(formSelector));

            // Mengirim data menggunakan AJAX
            $.ajax({
                url: url, // URL untuk memperbarui password pengguna
                method: method,
                data: {
                    current_password: formData.current_password,
                    password: formData.password,
                    password_confirmation: formData.password_confirmation,
                    _token: formData._token, // Token CSRF
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Berhasil!', successMessage, 'success');
                        $('#updatePassword')[0].reset(); // Reset form setelah berhasil
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
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui password. ' +
                            xhr.responseJSON.message + '!',
                            'error');
                    }
                }
            });
        });
    }

    // Menangani pengiriman form update password
    handlePasswordFormSubmit(
        '#updatePassword',
        '{{ route('application.profil.update.password', Auth::user()->id_user) }}', // Sesuaikan dengan route update password
        'PUT',
        'Password berhasil diperbarui!',
        getPasswordUpdateData // Fungsi untuk mengambil data form
    );

    // Script untuk password visibility toggle
    document.getElementById('show-password').addEventListener('change', function() {
        var passwordField = document.getElementById('password');
        var confirmPasswordField = document.getElementById('confirm_password');
        var currentPasswordField = document.getElementById('current_password');

        if (this.checked) {
            passwordField.type = 'text';
            confirmPasswordField.type = 'text';
            currentPasswordField.type = 'text';
        } else {
            passwordField.type = 'password';
            confirmPasswordField.type = 'password';
            currentPasswordField.type = 'password';
        }
    });
</script>
