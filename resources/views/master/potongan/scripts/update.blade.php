<script>
    function updateData(form) {
        return {
            nama_potongan: form.find('#nama_potongan').val(),
            status: form.find('#status').val()
        };
    }

    // Meng-handle pengiriman form update
    handleFormSubmission('#updateForm',
        '{{ route('master-data.potongan.update', ':id') }}',
        'PUT',
        'Potongan berhasil diperbarui.',
        updateData // Inisialisasi data khusus
    );
</script>
