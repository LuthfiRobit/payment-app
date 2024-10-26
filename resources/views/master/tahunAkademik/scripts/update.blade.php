<script>
    function updateData(form) {
        return {
            tahun: form.find('#tahun').val(),
            semester: form.find('#semester').val(),
            // status: form.find('#status').val()
        };
    }

    // Meng-handle pengiriman form update
    handleFormSubmission('#updateForm',
        '{{ route('master-data.tahun-akademik.update', ':id') }}',
        'PUT',
        'Tahun Akademik berhasil diperbarui.',
        updateData // Inisialisasi data khusus
    );
</script>
