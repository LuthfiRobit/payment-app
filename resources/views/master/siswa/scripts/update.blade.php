<script>
    function updateData(form) {
        return {
            nis: form.find('#nis').val(),
            nama_siswa: form.find('#nama_siswa').val(),
            status: form.find('#status').val(),
            jenis_kelamin: form.find('#jenis_kelamin').val(),
            tanggal_lahir: form.find('#tanggal_lahir').val(),
            tempat_lahir: form.find('#tempat_lahir').val(),
            alamat: form.find('#alamat').val(),
            nomor_telepon: form.find('#nomor_telepon').val(),
            email: form.find('#email').val(),
            kelas: form.find('#kelas').val(),
        };
    }

    // Meng-handle pengiriman form update
    handleFormSubmission('#updateForm',
        '{{ route('master-data.siswa.update', ':id') }}',
        'PUT',
        'Siswa berhasil diperbarui.',
        updateData // Inisialisasi data khusus
    );
</script>
