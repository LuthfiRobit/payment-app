<script>
    let editorEdit; // Global CKEditor instance khusus untuk ModalEdit

    function initCKEditorEdit() {
        const el = document.querySelector("#updateForm #ckeditor-mine");

        if (!el || editorEdit) return;

        ClassicEditor
            .create(el, {
                simpleUpload: {
                    uploadUrl: 'ckeditor-upload.php' // ganti kalau kamu pakai upload
                }
            })
            .then(newEditor => {
                editorEdit = newEditor;
            })
            .catch(err => {
                console.error("CKEditor init error (Edit):", err);
            });
    }

    function destroyCKEditorEdit() {
        if (editorEdit) {
            editorEdit.destroy()
                .then(() => {
                    editorEdit = null;
                })
                .catch(error => {
                    console.error("CKEditor destroy error (Edit):", error);
                });
        }
    }

    $(document).ready(function() {
        // Tambahkan hanya sekali di sini
        $('#ModalEdit').on('shown.bs.modal', function() {
            initCKEditorEdit();
        });

        // Tombol edit diklik
        $('#example').on('click', '.edit-button', function() {
            var id = $(this).data('id');

            // Simpan ID ke form
            $('#updateForm').attr('data-id', id);
            var url = '{{ route('master-data.berita.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        $('#updateForm #judul').val(data.judul);
                        $('#updateForm #status').val(data.status);
                        $('.selectpicker').selectpicker('refresh');

                        // Tunggu editor siap lalu set data CKEditor
                        const checkEditorReady = setInterval(() => {
                            if (editorEdit) {
                                editorEdit.setData(data.isi);
                                clearInterval(checkEditorReady);
                            }
                        }, 100);

                        // Tampilkan pratinjau gambar berita jika ada
                        if (data.gambar) {
                            $('#gambar-preview').show();
                            $('#view-gambar').attr('href',
                                '{{ asset('uploads/berita/') }}/' + data.gambar);
                        } else {
                            $('#gambar-preview').hide();
                            $('#view-gambar').attr('href', '#');
                        }

                        $('#ModalEdit').modal('show');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: 'Gagal mengambil data.',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengambil data.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Reset saat modal ditutup
        $('#ModalEdit').on('hidden.bs.modal', function() {
            $('#updateForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#updateForm .invalid-feedback').remove();
            $('#updateForm .form-control').removeClass('is-invalid');
            destroyCKEditorEdit();
            $('#preview-image').remove();
        });
    });
</script>
