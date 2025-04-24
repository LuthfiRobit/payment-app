<script>
    $(document).ready(function() {
        // Reset form saat modal ditutup
        $('#ModalCreate').on('hidden.bs.modal', function() {
            $('#createForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#modalError').addClass('d-none').text('');
        });

        // Inisialisasi form submit
        handleFormPrestasi(
            '#createForm',
            '{{ route('master-data.prestasi.store') }}',
            'POST',
            'Prestasi berhasil ditambahkan.',
            storePrestasiData,
            true
        );
    });

    function storePrestasiData(form) {
        const formData = new FormData();

        formData.append('tanggal', form.find('#tanggal').val());
        formData.append('nama_prestasi', form.find('#nama_prestasi').val());
        formData.append('keterangan', form.find('#keterangan').val());
        formData.append('status', form.find('#status').val());

        const fileInput = form.find('#foto_prestasi')[0];
        if (fileInput.files.length === 0) {
            $('#modalError').removeClass('d-none').text('Foto prestasi wajib diunggah.');
            throw new Error('Foto tidak diunggah');
        } else {
            formData.append('foto_prestasi', fileInput.files[0]);
        }

        return formData;
    }

    function handleFormPrestasi(formSelector, url, method, successMessage, getDataFn, isMultipart = false) {
        $(formSelector).on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let data;

            $('#modalError').addClass('d-none').text('');

            try {
                data = getDataFn(form);
            } catch (error) {
                return;
            }

            Swal.fire({
                title: 'Menyimpan...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: url,
                type: method,
                data: data,
                contentType: isMultipart ? false : 'application/x-www-form-urlencoded; charset=UTF-8',
                processData: !isMultipart,
                success: function(response) {
                    Swal.close();
                    $('#ModalCreate').modal('hide');
                    form[0].reset();
                    $('.selectpicker').selectpicker('refresh');
                    $('#example').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message || successMessage,
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr) {
                    Swal.close();

                    const res = xhr.responseJSON;

                    form.find('.invalid-feedback').remove();
                    form.find('.form-control').removeClass('is-invalid');

                    if (res && res.errors) {
                        Object.keys(res.errors).forEach(function(field) {
                            const input = form.find('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + res.errors[field]
                                [0] + '</div>');
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: res?.message || 'Terjadi kesalahan saat menyimpan data.',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });
    }
</script>
