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
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;

            // Bersihkan pesan error yang ada
            $(formId + ' .invalid-feedback').remove();
            $(formId + ' .form-control').removeClass('is-invalid');

            // Loop untuk menampilkan error pada input yang sesuai
            for (const key in errors) {
                const errorMessage = errors[key][0];
                const inputElement = $(`${formId} #${key}`);

                inputElement.addClass('is-invalid');
                inputElement.after(`<div class="invalid-feedback">${errorMessage}</div>`);
            }
        } else {
            Swal.fire({
                title: 'Error!',
                text: xhr.responseJSON.message || 'Terjadi kesalahan server.',
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
                // Handle server error
                Swal.fire({
                    title: 'Error!',
                    text: 'Terjadi kesalahan server.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
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
