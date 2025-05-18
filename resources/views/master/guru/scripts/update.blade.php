<script>
    $(document).ready(function() {
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();

            const form = $('#updateForm')[0];
            const formData = new FormData(form);
            const id = $('#updateForm').attr('data-id'); // pastikan data-id di-set saat buka modal edit

            const url = '{{ route('master-data.guru.update', ':id') }}'.replace(':id', id);

            // Clear previous feedback
            $('#updateForm .is-invalid').removeClass('is-invalid');
            $('#updateForm .invalid-feedback').remove();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-HTTP-Method-Override': 'PUT'
                },
                beforeSend: function() {
                    $('#updateForm button[type="submit"]').prop('disabled', true).text(
                        'Menyimpan...');
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#ModalEdit').modal('hide');
                        $('#updateForm')[0].reset();
                        $('#foto-preview').hide();
                        $('#view-foto').attr('href', '#');
                        $('.selectpicker').selectpicker('refresh');
                        $('#example').DataTable().ajax.reload(null, false);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            const input = $('#updateForm [name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + messages[
                                0] + '</div>');
                        });
                    } else {
                        handleAjaxError(xhr, form);
                    }
                },
                complete: function() {
                    $('#updateForm button[type="submit"]').prop('disabled', false).text(
                        'Save Change');
                }
            });
        });
    });
</script>
