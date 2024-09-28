<script>
    function updateData(form) {
        return {
            nama_iuran: form.find('#nama_iuran').val(),
            besar_iuran: form.find('#besar_iuran').val(),
            status: form.find('#status').val()
        };
    }

    // Meng-handle pengiriman form update
    handleFormSubmission('#updateForm',
        '{{ route('master-data.iuran.update', ':id') }}',
        'PUT',
        'Iuran berhasil diperbarui.',
        updateData // Inisialisasi data khusus
    );
</script>
