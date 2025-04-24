<script>
    $(document).ready(function() {
        // Show modal dan isi data
        $('#example').on('click', '.edit-button', function() {
            var id = $(this).data('id');

            // Simpan ID ke form
            $('#updateForm').attr('data-id', id);

            var url = '{{ route('master-data.prestasi.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        $('#updateForm #tanggal').val(data.tanggal);
                        $('#updateForm #nama_prestasi').val(data.nama_prestasi);
                        $('#updateForm #keterangan').val(data.keterangan || '');
                        $('#updateForm #status').val(data.status);
                        $('.selectpicker').selectpicker('refresh');

                        // Tampilkan pratinjau foto jika ada
                        if (data.foto_prestasi) {
                            $('#foto-preview').show();
                            $('#view-foto').attr('href',
                                '{{ asset('uploads/prestasi') }}/' + data.foto_prestasi);
                        } else {
                            $('#foto-preview').hide();
                            $('#view-foto').attr('href', '#');
                        }

                        $('#ModalEdit').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengambil data.',
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
            $('#foto-preview').hide();
            $('#view-foto').attr('href', '#');
        });


    });
</script>
