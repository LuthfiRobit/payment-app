<script>
    $(document).ready(function() {
        // Handle form submission via AJAX for multiple forms
        function handleFormSubmit(formId, route, formData) {
            // Retrieve the ID dynamically (e.g., from data-id attribute)
            var id = $(formId).data('id'); // Assuming you're storing the ID in data-id

            // Prepare the URL with the dynamic ID
            var url = route.replace(':id', id);

            // Add CSRF token to FormData
            formData.append('_token', '{{ csrf_token() }}');

            // Show loading spinner with SweetAlert
            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while we update the data.',
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            // AJAX request to send the form data
            $.ajax({
                url: url, // The dynamic URL with the ID
                method: 'POST',
                data: formData, // Send the form data
                processData: false, // Don't process the data (important for file upload)
                contentType: false, // Don't set content-type header manually (FormData does this automatically)
                success: function(response) {
                    // Handle the success response
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Data updated successfully.',
                            confirmButtonText: 'OK'
                        }).then(function() {
                            location
                                .reload(); // Optionally reload the page or update the UI
                        });
                    } else {
                        // Handle error response
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'An error occurred while updating.',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr) {
                    // General error handling
                    let errors = xhr.responseJSON.errors;
                    if (errors) {
                        $.each(errors, function(key, error) {
                            // Show validation errors next to the corresponding input field
                            $('#' + key).addClass(
                                'is-invalid'); // Add error class to inputs
                            $('#' + key).next('.invalid-feedback')
                                .remove(); // Remove previous error messages
                            $('#' + key).after('<div class="invalid-feedback">' + error[0] +
                                '</div>'); // Show new error message
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        }

        // Submit event for each form
        $('#formEditSiswa').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            handleFormSubmit('#formEditSiswa', '{{ route('ppdb.update.siswa', ':id') }}', formData);
        });

        $('#formEditStatus').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            handleFormSubmit('#formEditStatus', '{{ route('ppdb.update.keluarga', ':id') }}', formData);
        });

        $('#formEditWali').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            handleFormSubmit('#formEditWali', '{{ route('ppdb.update.wali', ':id') }}', formData);
        });

        $('#formEditOrtu').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            handleFormSubmit('#formEditOrtu', '{{ route('ppdb.update.ortu', ':id') }}', formData);
        });

        $('#formEditStatusSiswa').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            handleFormSubmit('#formEditStatusSiswa', '{{ route('ppdb.update.status', ':id') }}',
                formData);
        });
    });
</script>
