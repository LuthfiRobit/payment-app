<script>
    $(document).ready(function() {
        $('#updateForm').on('submit', function(e) {
            e.preventDefault();

            let form = $('#updateForm')[0];
            let formData = new FormData(form);
            let id = $('#updateForm').attr('data-id'); // ✅ ID dari form

            let url = '{{ route('master-data.artikel.update', ':id') }}'.replace(':id', id);

            if (editorEdit) {
                formData.set('isi', editorEdit.getData());
            }

            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
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
                        destroyCKEditorEdit();
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
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            let input = $('#updateForm [name="' + field + '"]');
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
