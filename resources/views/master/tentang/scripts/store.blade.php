<script>
    // Fungsi untuk menyimpan data dan mengembalikan objek FormData
    function storeData(form) {
        var formData = new FormData(form[0]);
        formData.append('deskripsi', form.find('#deskripsi').val());
        return formData; // Mengembalikan FormData
    }

    // Fungsi untuk menangani pengiriman form dengan AJAX
    function handleFormStore(formSelector, url, method, successMessage, storeDataFunction) {
        $(formSelector).submit(function(event) {
            event.preventDefault(); // Mencegah form untuk submit secara default

            var formData = storeDataFunction($(this));

            // Reset error messages sebelum submit
            $(formSelector).find('.invalid-feedback').remove();
            $(formSelector).find('.form-control').removeClass('is-invalid');

            $.ajax({
                url: url, // URL route di Laravel
                method: method, // POST method
                data: formData,
                processData: false, // Jangan biarkan jQuery memproses data FormData
                contentType: false, // Jangan set content-type (karena menggunakan FormData)
                beforeSend: function() {
                    $('#btnSaveTentang').attr('disabled', true).text('Menyimpan...');
                },
                success: function(response) {
                    $('#btnSaveTentang').attr('disabled', false).text('Simpan');

                    if (response.success) {
                        Swal.fire('Sukses!', response.message, 'success').then(() => {
                            location.reload(); // Reload halaman penuh
                        });
                        $('#ModalCreate').modal('hide'); // Tutup modal
                        $('#createForm')[0].reset(); // Reset form
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }

                },
                error: function(xhr) {
                    $('#btnSaveTentang').attr('disabled', false).text('Simpan');

                    // Jika terjadi kesalahan validasi (misalnya status 422 atau 400)
                    if (xhr.status === 400 || xhr.status === 422) {
                        // Mengambil respons JSON dari server
                        var response = xhr.responseJSON;

                        // Menampilkan pesan umum kesalahan di SweetAlert
                        Swal.fire('Error!', response.message || 'Terjadi kesalahan validasi.',
                            'error');

                        // Menangani dan menampilkan pesan kesalahan spesifik di bawah input
                        if (response.message) {
                            // Jika ada pesan error spesifik (seperti validasi jumlah kalimat)
                            // Menampilkan pesan pada alert SweetAlert
                            Swal.fire('Error!', response.message, 'error');
                        }

                        // Menampilkan pesan error dari server di bawah field input
                        if (response.errors) {
                            $.each(response.errors, function(field, messages) {
                                var inputField = $('#' + field);
                                inputField.addClass(
                                    'is-invalid'); // Menambahkan class is-invalid
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

    // Meng-handle pengiriman form ketika halaman siap
    $(document).ready(function() {
        // Reset form input ketika modal ditutup
        $('#ModalCreate').on('hidden.bs.modal', function() {
            $('#createForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#createForm .invalid-feedback').remove(); // Menghapus pesan error yang ada
            $('#createForm .form-control').removeClass('is-invalid'); // Menghapus class is-invalid
        });

        // Inisialisasi pengiriman form untuk 'store'
        handleFormStore('#createForm',
            '{{ route('master-data.tentang.store') }}', // URL route untuk menyimpan data
            'POST', // Method
            'Tentang berhasil ditambahkan.', // Pesan sukses
            storeData // Menginisialisasi data form
        );
    });
</script>
