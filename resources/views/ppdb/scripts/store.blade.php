<script>
    $(document).ready(function() {
        $('#studentForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman saat form di-submit

            // Membuat FormData untuk mengirim data file dan data form lainnya
            var formData = new FormData(this);

            // Mengambil data imunisasi yang dipilih (langsung mendapatkan array)
            var imunisasi = $('#imunisasi').val();

            // Jika imunisasi adalah null atau tidak dipilih, kirimkan array kosong
            if (!imunisasi) {
                imunisasi = [];
            }

            // Menambahkan data imunisasi ke formData sebagai array
            imunisasi.forEach(function(value) {
                formData.append('imunisasi[]', value);
            });

            $.ajax({
                url: '{{ route('landpage.ppdb.store') }}', // URL tujuan (sesuaikan dengan route yang ada)
                type: 'POST',
                data: formData,
                processData: false, // Penting untuk menonaktifkan pemrosesan data, agar FormData dapat dikirim dengan benar
                contentType: false, // Penting untuk menonaktifkan contentType agar multipart/form-data dikirim
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data siswa berhasil disimpan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reset form setelah alert sukses
                            $('#studentForm')[0]
                                .reset(); // Mereset semua input form

                            // Hapus semua error dan class is-invalid
                            $('#studentForm .invalid-feedback').remove();
                            $('#studentForm .form-control').removeClass(
                                'is-invalid');

                            // Reload halaman setelah data berhasil disimpan
                            location.reload(); // Reload halaman
                        });
                    } else {
                        Swal.fire({
                            title: 'Gagal!',
                            text: response.message ||
                                'Terjadi kesalahan saat menyimpan data.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        // Bersihkan pesan error yang ada
                        $('#studentForm .invalid-feedback').remove();
                        $('#studentForm .form-control').removeClass('is-invalid');

                        // Loop untuk menampilkan error pada input yang sesuai
                        for (const key in errors) {
                            const errorMessage = errors[key][0];
                            const inputElement = $(`#studentForm #${key}`);

                            inputElement.addClass('is-invalid');
                            inputElement.after(
                                `<div class="invalid-feedback">${errorMessage}</div>`
                            );
                        }

                        // Menampilkan alert error validasi
                        Swal.fire({
                            title: 'Kesalahan Validasi!',
                            text: 'Harap perbaiki kesalahan pada form sebelum melanjutkan.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message ||
                                'Terjadi kesalahan server.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    });
</script>
