<script>
    // Fungsi untuk mengambil ID siswa yang dipilih
    function getSelectedSiswaIds() {
        let selectedIds = [];
        $('.siswa-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });
        return selectedIds;
    }

    // Fungsi untuk menampilkan Swal dengan status 'warning'
    function showWarningAlert(title, text) {
        Swal.fire({
            icon: 'warning',
            title: title,
            text: text,
            confirmButtonText: 'OK'
        });
    }

    // Fungsi untuk menampilkan loading Swal
    function showLoadingSwal() {
        Swal.fire({
            title: 'Sedang memproses...',
            text: 'Tunggu sebentar, proses generate siswa sedang berjalan.',
            didOpen: () => {
                Swal.showLoading();
            },
            allowOutsideClick: false // Mencegah menutup swal sebelum selesai
        });
    }

    // Fungsi untuk menangani hasil dari AJAX request
    function handleGenerateSiswaResponse(response) {
        // Pastikan response adalah objek yang valid dengan properti success dan message
        if (response && response.success !== undefined) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Generate Berhasil!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Setelah menutup SweetAlert, reload halaman
                    window.location.reload();
                });
            } else {
                // Jika success = false, tampilkan pesan error dari response
                Swal.fire({
                    icon: 'error',
                    title: 'Generate Gagal!',
                    text: response.message, // Pesan kesalahan dari server
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Setelah menutup SweetAlert, sembunyikan loading
                    Swal.close();
                });
            }
        } else {
            // Jika format respons tidak sesuai, tangani error lain
            handleAjaxError(response); // Pastikan kita kirim response jika formatnya tidak sesuai
        }
    }

    // Fungsi untuk menangani error dari AJAX request
    function handleAjaxError(xhr) {
        // Cek status code dari server dan tangani error dengan lebih spesifik
        if (xhr && xhr.status) {
            let errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                'Terjadi masalah saat memproses permintaan.';

            // Menangani kesalahan berdasarkan status HTTP
            if (xhr.status === 400 || xhr.status === 404) {
                // Bad Request (400) atau Not Found (404)
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage, // Menampilkan pesan error dari response
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Setelah menutup SweetAlert, sembunyikan loading
                    Swal.close();
                });
            } else if (xhr.status === 500) {
                // Internal Server Error (500)
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Server!',
                    text: 'Terjadi masalah di server. Silakan coba lagi.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Setelah menutup SweetAlert, sembunyikan loading
                    Swal.close();
                });
            } else {
                // Error lainnya, tampilkan pesan umum
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: 'Terjadi masalah saat mengirim permintaan. Silakan coba lagi.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    // Setelah menutup SweetAlert, sembunyikan loading
                    Swal.close();
                });
            }
        } else {
            // Jika error tidak memiliki status atau responseJSON, tampilkan pesan umum
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: 'Terjadi masalah saat memproses permintaan. Silakan coba lagi.',
                confirmButtonText: 'OK'
            }).then(() => {
                // Setelah menutup SweetAlert, sembunyikan loading
                Swal.close();
            });
        }
    }

    // Fungsi utama untuk memulai proses generate siswa
    $('#btnGenerateSiswa').click(function() {
        const selectedIds = getSelectedSiswaIds(); // Ambil siswa yang dipilih

        // Cek jika tidak ada siswa yang dipilih
        if (selectedIds.length === 0) {
            showWarningAlert('Pilih Siswa!', 'Anda harus memilih setidaknya satu siswa baru terlebih dahulu.');
            return;
        }

        // Konfirmasi untuk melanjutkan proses
        Swal.fire({
            icon: 'warning',
            title: 'Konfirmasi Proses Generate Siswa',
            text: 'Proses ini akan mengubah kelas siswa yang sudah ada secara otomatis. ' +
                'Siswa yang berada di kelas 1 hingga 5 akan dipromosikan ke kelas berikutnya (kelas 1 menjadi kelas 2, kelas 2 menjadi kelas 3, dst.). ' +
                'Siswa yang berada di kelas 6 akan dianggap lulus dan statusnya akan diubah menjadi "Lulus". ' +
                'Perubahan ini tidak dapat dibatalkan. Apakah Anda yakin ingin melanjutkan?',
            showCancelButton: true,
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading indicator sebelum mengirim request
                showLoadingSwal();

                // Kirim permintaan AJAX untuk generate siswa
                $.ajax({
                    url: '{{ route('ppdb.generate') }}', // URL untuk controller
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                        'content'), // Token CSRF untuk keamanan
                        siswa_ids: selectedIds
                    },
                    success: function(response) {
                        handleGenerateSiswaResponse(response); // Tangani respon dari server
                    },
                    error: function(xhr, status, error) {
                        handleAjaxError(xhr); // Tangani error
                    }
                });
            }
        });
    });
</script>
