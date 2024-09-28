<script>
    function storeData(form) {
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
            '{{ route('master-data.siswa.store') }}',
            'POST',
            'Siswa berhasil ditambahkan.',
            storeData // Inisialisasi data khusus
        );
    });
</script>
