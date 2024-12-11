<script>
    function updateData(form) {
        return {
            tahun_akademik_id: form.find('#tahun_akademik_id').val(),
            tanggal_mulai: form.find('#tanggal_mulai').val(),
            tanggal_selesai: form.find('#tanggal_selesai').val(),
            biaya_pendaftaran: form.find('#biaya_pendaftaran').val()
        };
    }

    // Meng-handle pengiriman form update
    handleFormSubmission('#updateForm',
        '{{ route('ppdb.setting.update', ':id') }}',
        'PUT',
        'Setting berhasil diperbarui.',
        updateData // Inisialisasi data khusus
    );
</script>
