<script>
    $(document).ready(function() {
        // Reset form saat modal ditutup
        $('#ModalCreate').on('hidden.bs.modal', function() {
            $('#createForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#modalError').addClass('d-none').text('');
        });

        // Inisialisasi form submit
        handleFormGuruKaryawan(
            '#createForm',
            '{{ route('master-data.guru.store') }}', // Ganti dengan route sebenarnya
            'POST',
            'Data guru/karyawan berhasil ditambahkan.',
            storeGuruKaryawanData,
            true
        );
    });

    function storeGuruKaryawanData(form) {
        const formData = new FormData();

        formData.append('kategori', form.find('#kategori').val());
        formData.append('nama', form.find('#nama').val());
        formData.append('jabatan', form.find('#jabatan').val());
        formData.append('status', form.find('#status').val());
        formData.append('urutan', form.find('#urutan').val());

        const fileInput = form.find('#foto')[0];
        if (fileInput.files.length > 0) {
            formData.append('foto', fileInput.files[0]);
        }

        return formData;
    }

    function handleFormGuruKaryawan(formSelector, url, method, successMessage, getDataFn, isMultipart = false) {
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
                        handleAjaxError(xhr, form);
                    }
                }
            });
        });
    }
</script>
