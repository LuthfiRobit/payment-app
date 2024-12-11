<script>
    $(document).ready(function() {
        $('#example').on('click', '.edit-button', function() {
            var id = $(this).data('id');
            var url = '{{ route('master-data.tentang.show', ':id') }}'.replace(':id', id);

            // Use global handleShow function to fetch and display data in the form
            handleShow(url, '#updateForm', '#ModalEdit', id);
            // $('#updateForm').data('id', id); // Store ID in form for later use
        });

        // Reset form input ketika modal ditutup
        $('#ModalEdit').on('hidden.bs.modal', function() {
            $('#updateForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#updateForm .invalid-feedback').remove();
            $('#updateForm .form-control').removeClass('is-invalid');
        });
    });

    function handleShow(url, formSelector, modalSelector, id) {
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    console.log(id);

                    // Populate form fields with response data
                    $(formSelector).find('#deskripsi').val(response.data.deskripsi);

                    // If you have an image, set its source (don't set it on the file input)
                    if (response.data.img) {
                        $(formSelector).find('#current-img').attr('src', response.data
                            .img); // Update img tag to show the current image
                    }

                    // Optionally, store the ID in the form for later use
                    $(formSelector).attr('data-id', id);

                    // Open modal to edit
                    $(modalSelector).modal('show');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Terjadi kesalahan saat memuat data.', 'error');
            }
        });
    }
</script>
