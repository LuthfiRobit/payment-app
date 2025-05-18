<script>
    $(document).ready(function() {
        // Show modal dan isi data
        $('#example').on('click', '.edit-button', function() {
            var id = $(this).data('id');

            // Simpan ID ke form
            $('#updateForm').attr('data-id', id);

            var url = '{{ route('master-data.guru.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        $('#updateForm #nama').val(data.nama);
                        $('#updateForm #jabatan').val(data.jabatan);
                        $('#updateForm #urutan').val(data.urutan || '');
                        $('#updateForm #status').val(data.status);
                        $('#updateForm #kategori').val(data.kategori);
                        $('.selectpicker').selectpicker('refresh');

                        // Tampilkan pratinjau foto jika ada
                        if (data.foto) {
                            $('#foto-preview').show();
                            $('#view-foto').attr('href',
                                '{{ asset('uploads/guru_karyawan') }}/' + data.foto);
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
