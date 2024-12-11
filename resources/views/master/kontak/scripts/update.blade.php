<script>
    function updateData(form) {
        return {
            kontak_telepon: form.find('#kontak_telepon').val(),
            kontak_email: form.find('#kontak_email').val(),
            kontak_alamat: form.find('#kontak_alamat').val()
        };
    }

    // Meng-handle pengiriman form update
    handleFormSubmission('#updateForm',
        '{{ route('master-data.kontak.update', ':id') }}',
        'PUT',
        'Kontak berhasil diperbarui.',
        updateData // Inisialisasi data khusus
    );
</script>
