<script>
    function storeData(form) {
        return {
            nama_potongan: form.find('#nama_potongan').val(),
            status: form.find('#status').val()
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
        // Store Tahun Akademik
        handleFormSubmission('#createForm',
            '{{ route('master-data.potongan.store') }}',
            'POST',
            'Potongan berhasil ditambahkan.',
            storeData // Inisialisasi data khusus
        );
    });
</script>
