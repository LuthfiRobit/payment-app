<script>
    function storeData(form) {
        return {
            tahun_akademik_id: form.find('#tahun_akademik_id').val(),
            tanggal_mulai: form.find('#tanggal_mulai').val(),
            tanggal_selesai: form.find('#tanggal_selesai').val(),
            biaya_pendaftaran: form.find('#biaya_pendaftaran').val()
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
        // Store Setting
        handleFormSubmission('#createForm',
            '{{ route('ppdb.setting.store') }}',
            'POST',
            'Setting berhasil ditambahkan.',
            storeData // Inisialisasi data khusus
        );
    });
</script>
