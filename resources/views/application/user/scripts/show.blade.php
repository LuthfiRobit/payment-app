<script>
    $(document).ready(function() {
        $('#example').on('click', '.edit-button', function() {
            var id = $(this).data('id');
            var url = '{{ route('application.user.show', ':id') }}'.replace(':id', id);

            // Use global showData function to fetch and display data in the form
            showData(url, '#updateForm', '#ModalEdit', id);
            // $('#updateForm').data('id', id); // Store ID in form for later use

            $('.selectpicker').selectpicker('refresh');
        });

        // Reset form input ketika modal ditutup
        $('#ModalEdit').on('hidden.bs.modal', function() {
            $('#updateForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#updateForm .invalid-feedback').remove();
            $('#updateForm .form-control').removeClass('is-invalid');
        });
    });
</script>
