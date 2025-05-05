<script>
    // Global function for form submit data via AJAX
    function handleFormSubmission(formId, route, method, successMessage, dataMapper = null) {
        $(formId).on('submit', function(e) {
            e.preventDefault(); // Mencegah submit default

            const id = $(this).data('id');
            let data = {};

            // Jika `dataMapper` disediakan, gunakan mapper khusus untuk memproses data
            if (typeof dataMapper === 'function') {
                data = dataMapper($(this)); // Mapper khusus untuk menginisiasi data
            } else {
                // Default: Ambil data dari semua input di form
                $(this).find(':input').each(function() {
                    let input = $(this);
                    let name = input.attr('name');
                    if (name) {
                        data[name] = input.val();
                    }
                });
            }

            // Tentukan URL untuk update (jika ada ID) atau store
            let actionUrl = method === 'POST' ? route : route.replace(':id', id);

            // AJAX request
            $.ajax({
                url: actionUrl,
                type: method,
                data: data,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // SweetAlert untuk sukses
                        Swal.fire({
                            title: 'Berhasil!',
                            text: successMessage,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    handleAjaxError(xhr, formId);
                }
            });
        });
    }

    // Global function for showing error via AJAX
    function handleAjaxError(xhr, formId) {
        // Handle validation errors (status 422)
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;

            // Clear existing error messages
            $(formId + ' .invalid-feedback').remove();
            $(formId + ' .form-control').removeClass('is-invalid');

            // Loop through the errors and show them on the respective input fields
            for (const key in errors) {
                const errorMessage = errors[key][0];
                const inputElement = $(`${formId} #${key}`);

                inputElement.addClass('is-invalid');
                inputElement.after(`<div class="invalid-feedback">${errorMessage}</div>`);
            }
        }
        // Handle Unauthorized error (status 401)
        else if (xhr.status === 401) {
            Swal.fire({
                title: 'Unauthorized!',
                text: xhr.responseJSON.message || 'You do not have permission to access this resource.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
        // Handle Forbidden error (status 403)
        else if (xhr.status === 403) {
            Swal.fire({
                title: 'Forbidden!',
                text: xhr.responseJSON.message || 'You do not have permission to perform this action.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
        // Handle Not Found error (status 404)
        else if (xhr.status === 404) {
            Swal.fire({
                title: 'Not Found!',
                text: xhr.responseJSON.message || 'The requested resource could not be found.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        }
        // Handle Internal Server Error (status 500)
        else if (xhr.status === 500) {
            Swal.fire({
                title: 'Server Error!',
                text: xhr.responseJSON.message ||
                    'There was an error processing your request. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
        // Handle Bad Request error (status 400)
        else if (xhr.status === 400) {
            Swal.fire({
                title: 'Bad Request!',
                text: xhr.responseJSON.message ||
                    'The request was invalid. Please check your input and try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
        // Handle Conflict error (status 409)
        else if (xhr.status === 409) {
            Swal.fire({
                title: 'Conflict!',
                text: xhr.responseJSON.message ||
                    'There is a conflict with the current request. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
        // Handle Service Unavailable error (status 503)
        else if (xhr.status === 503) {
            Swal.fire({
                title: 'Service Unavailable!',
                text: xhr.responseJSON.message ||
                    'The service is temporarily unavailable. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
        // Handle generic errors
        else {
            Swal.fire({
                title: 'Error!',
                text: xhr.responseJSON.message || 'An unexpected error occurred. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    }


    // Global function for showing data via AJAX
    function showData(url, containerSelector, modalSelector = null, id = null) {
        // Fetch data from server
        $.ajax({
            url: url, // The endpoint where data will be fetched from
            type: 'GET',
            success: function(response) {
                if (response.success) {
                    // Populate the data into the container (e.g., form, modal, or div)
                    populateData(response.data, containerSelector);
                    // Store ID in the form for later use
                    if (id) {
                        $(containerSelector).data('id', id);
                    }
                    // Optional: Show modal if a modal selector is provided
                    if (modalSelector) {
                        $(modalSelector).modal('show');
                    }
                } else {
                    // Display error message if the server response is not successful
                    Swal.fire({
                        title: 'Error',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr) {
                // Use handleAjaxError function to handle the error
                handleAjaxError(xhr, containerSelector);
            }
        });
    }

    // Helper function to populate data in the container
    function populateData(data, containerSelector) {
        for (const key in data) {
            // Find the input or element within the container and set the value
            const inputElement = $(`${containerSelector} #${key}`);

            if (inputElement.length) {
                if (inputElement.is('select')) {
                    // If the element is a select, set the value and trigger change event
                    inputElement.val(data[key]).change();
                } else {
                    // Set the value for other input types
                    inputElement.val(data[key]);
                }
            } else {
                // If the target is not an input, populate other tags like <span>, <div>, etc.
                const tagElement = $(`${containerSelector} [data-name="${key}"]`);
                if (tagElement.length) {
                    tagElement.text(data[key]);
                }
            }
        }
        // Optional: Refresh select pickers or other custom elements
        $('.selectpicker').selectpicker('refresh').selectpicker('render');
    }
</script>
