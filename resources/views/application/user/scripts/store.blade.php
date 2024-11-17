<script>
    // Fungsi untuk mengambil data dari form create
    function createData(form) {
        return {
            name: form.find('#name').val(), // Nama
            email: form.find('#email').val(), // Email
            role: form.find('#role').val(), // Peran
            password: form.find('#password').val(), // Password
            password_confirmation: form.find('#confirm_password').val() // Konfirmasi Password
        };
    }

    // Fungsi untuk menangani pengiriman form dengan AJAX
    function handleFormSubUserCreate(formSelector, url, method, successMessage, dataExtractor) {
        $(formSelector).on('submit', function(e) {
            e.preventDefault(); // Mencegah form submit biasa

            // Ambil data dari form
            var formData = dataExtractor($(formSelector));

            // Mengirim data menggunakan AJAX
            $.ajax({
                url: url, // URL untuk menyimpan pengguna baru
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
                        $('#ModalCreate').modal('hide');
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
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat membuat pengguna.', 'error');
                    }
                }
            });
        });
    }

    // Meng-handle pengiriman form create
    handleFormSubUserCreate('#createForm',
        '{{ route('application.user.store') }}', // Sesuaikan dengan route Anda
        'POST',
        'Pengguna baru berhasil dibuat.',
        createData // Mengambil data dari form dan menyiapkannya untuk dikirim
    );

    // Reset form input ketika modal ditutup
    $('#ModalCreate').on('hidden.bs.modal', function() {
        $('#createForm')[0].reset();
        $('.selectpicker').selectpicker('refresh');
        $('#createForm .invalid-feedback').remove();
        $('#createForm .form-control').removeClass('is-invalid');
    });
</script>
