<script>
    let editor; // global

    function initCKEditor() {
        const el = document.querySelector("#ckeditor-mine");

        if (!el) return;

        // Cek apakah editor sudah dibuat
        if (editor) {
            return;
        }

        ClassicEditor
            .create(el, {
                simpleUpload: {
                    uploadUrl: 'ckeditor-upload.php' // sesuaikan dengan server upload jika dipakai
                }
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(err => {
                console.error("CKEditor init error:", err);
            });
    }

    function destroyCKEditor() {
        if (editor) {
            editor.destroy()
                .then(() => {
                    editor = null;
                })
                .catch(error => {
                    console.error("CKEditor destroy error:", error);
                });
        }
    }

    $(document).ready(function() {
        // Init CKEditor hanya saat modal terbuka
        $('#ModalCreate').on('shown.bs.modal', function() {
            initCKEditor();
        });

        // Reset form dan hancurkan CKEditor saat modal ditutup
        $('#ModalCreate').on('hidden.bs.modal', function() {
            $('#createForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#modalError').addClass('d-none').text('');
            destroyCKEditor();
            $('#ckeditor-mine').html(''); // optional
        });

        // Handler form
        handleFormArtikel(
            '#createForm',
            '{{ route('master-data.artikel.store') }}',
            'POST',
            'Artikel berhasil ditambahkan.',
            storeData,
            true
        );
    });

    function storeData(form) {
        const formData = new FormData();

        const isiArtikel = editor ? editor.getData() : '';
        if (isiArtikel.trim() === '') {
            $('#modalError').removeClass('d-none').text('Isi artikel tidak boleh kosong.');
            throw new Error('Isi artikel kosong');
        }

        formData.append('judul', form.find('#judul').val());
        formData.append('status', form.find('#status').val());
        formData.append('isi', isiArtikel);

        const fileInput = form.find('#gambar')[0];
        if (fileInput.files.length === 0) {
            $('#modalError').removeClass('d-none').text('Gambar wajib diunggah.');
            throw new Error('Gambar tidak diunggah');
        } else {
            formData.append('gambar', fileInput.files[0]);
        }

        return formData;
    }

    function handleFormArtikel(formSelector, url, method, successMessage, getDataFn, isMultipart = false) {
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

            // Tampilkan loading
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
                    Swal.close(); // Tutup loading

                    $('#ModalCreate').modal('hide');
                    form[0].reset();
                    $('.selectpicker').selectpicker('refresh');
                    if (editor) editor.setData('');
                    $('#example').DataTable().ajax.reload();

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message || successMessage,
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr) {
                    Swal.close(); // Tutup loading saat error

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
