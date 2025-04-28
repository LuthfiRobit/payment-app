<script>
    $(document).ready(function() {
        // Menampilkan modal dan mengisi data berdasarkan galeri yang dipilih
        $('#example').on('click', '.edit-button', function() {
            var id = $(this).data('id');

            // Menyimpan ID galeri pada form untuk referensi nanti
            $('#updateForm').attr('data-id', id);

            var url = '{{ route('master-data.galeri.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        // Isi inputan form dengan data yang ada
                        $('#ModalEdit #tanggal').val(data.tanggal);
                        $('#ModalEdit #kegiatan').val(data
                            .kegiatan); // Menyesuaikan dengan nama galeri (kegiatan)
                        $('#ModalEdit #keterangan').val(data.keterangan || '');
                        $('#ModalEdit #status').val(data.status).selectpicker('refresh');

                        // Tampilkan pratinjau foto jika ada
                        if (data.foto) {
                            $('#ModalEdit #foto-preview').show();
                            $('#ModalEdit #view-foto').attr('href',
                                '{{ asset('uploads/galeri') }}/' + data.foto);
                        } else {
                            $('#ModalEdit #foto-preview').hide();
                        }

                        // Buka modal edit
                        $('#ModalEdit').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal memuat data galeri.',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengambil data.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Reset form saat modal ditutup
        $('#ModalEdit').on('hidden.bs.modal', function() {
            $('#updateForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#updateForm .invalid-feedback').remove();
            $('#updateForm .form-control').removeClass('is-invalid');
            $('#ModalEdit #foto-preview').hide();
            $('#ModalEdit #view-foto').attr('href', '#');
        });
    });
</script>
