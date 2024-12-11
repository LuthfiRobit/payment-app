<script>
    function storeData(form) {
        return {
            kontak_telepon: form.find('#kontak_telepon').val(),
            kontak_email: form.find('#kontak_email').val(),
            kontak_alamat: form.find('#kontak_alamat').val()
        };
    }

    $(document).ready(function() {
        // Reset form input ketika modal ditutup
        $('#ModalCreate').on('hidden.bs.modal', function() {
            $('#createForm')[0].reset();
            $('.selectpicker').selectpicker('refresh');
            $('#createForm .invalid-feedback').remove(); // Menghapus pesan error yang ada
            $('#createForm .form-control').removeClass('is-invalid'); // Menghapus class is-invalid
        });

        // Meng-handle pengiriman form
        // Store Kontak
        handleFormSubmission('#createForm',
            '{{ route('master-data.kontak.store') }}',
            'POST',
            'Kontak berhasil ditambahkan.',
            storeData // Inisialisasi data khusus
        );
    });
</script>
