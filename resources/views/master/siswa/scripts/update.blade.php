<script>
    function updateData(form) {
        return {
            nis: form.find('#nis').val(),
            nama_siswa: form.find('#nama_siswa').val(),
            status: form.find('#status').val(),
            jenis_kelamin: form.find('#jenis_kelamin').val(),
            tanggal_lahir: form.find('#tanggal_lahir').val(),
            tempat_lahir: form.find('#tempat_lahir').val(),
            alamat: form.find('#alamat').val(),
            nomor_telepon: form.find('#nomor_telepon').val(),
            email: form.find('#email').val(),
            kelas: form.find('#kelas').val(),
        };
    }

    // Meng-handle pengiriman form update
    handleFormSubmission('#updateForm',
        '{{ route('master-data.siswa.update', ':id') }}',
        'PUT',
        'Siswa berhasil diperbarui.',
        updateData // Inisialisasi data khusus
    );
</script>

<script>
    $(document).ready(function() {
        // Tombol untuk membuka modal set tagihan massal
        $('#setKelasBtn').click(function() {
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
            $('#ModalEditKelas').modal('show');
            console.log(selectedIds);

            // Set selected IDs dalam data modal
            $('#ModalEditKelas').data('selectedIds', selectedIds);

            // Reset form ketika modal ditutup
            $('#ModalEditKelas').on('hidden.bs.modal', function() {
                $('#updateFormKelas')[0].reset(); // Reset form
                $('#updateFormKelas .invalid-feedback')
                    .remove(); // Menghapus pesan error yang ada
                $('#updateFormKelas .form-control').removeClass(
                    'is-invalid'); // Menghapus class is-invalid
            });

            // Handle form submit
            $('#updateFormKelas').off('submit').on('submit', function(e) {
                e.preventDefault();

                // Ambil kelas yang dipilih dari selectpicker
                let kelas = $('#updateFormKelas #kelas').val();
                // Ambil selected IDs dari data modal
                let siswaIds = $('#ModalEditKelas').data('selectedIds');

                // Periksa jika kelas tidak dipilih
                if (!kelas) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Kelas Tidak Dipilih!',
                        text: 'Anda harus memilih kelas terlebih dahulu.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Periksa nilai kelas yang dipilih
                console.log('Kelas yang dipilih:', kelas);

                // Mengirim data ke server
                $.ajax({
                    url: "{{ route('master-data.siswa.update.kelas') }}", // Ubah ke rute store yang tepat
                    method: "POST",
                    data: {
                        ids: siswaIds, // Array berisi ID yang dipilih
                        kelas: kelas, // Kelas yang dipilih
                        _token: '{{ csrf_token() }}' // CSRF token untuk keamanan
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            $('#ModalEditKelas').modal('hide');
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
        $('#ModalEditKelas').on('hidden.bs.modal', function() {
            $('#updateFormKelas')[0].reset();
            $('.selectpicker').selectpicker('refresh'); // Refresh selectpicker untuk UI dropdown
        });
    });
</script>
