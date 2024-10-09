<script>
    const storeUrl = "{{ route('transaksi.pembayaran.store') }}"; // URL untuk menyimpan pembayaran
    $('#save-payment-btn').click(function(event) {
        event.preventDefault(); // Mencegah pengiriman form secara default

        const siswaId = $('#filter_siswa').val(); // Mendapatkan siswa_id dari filter

        // Pastikan siswaId tersedia
        if (!siswaId) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Pastikan siswa telah dipilih.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Pastikan tagihan_id tersedia (dari script show)
        if (!tagihanId) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Data tagihan tidak ada.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Mendapatkan jumlah pembayaran dari input field
        const totalBayar = $('#total_bayar').val();

        // Pastikan totalBayar adalah angka yang valid sebelum melanjutkan
        if (isNaN(totalBayar) || totalBayar <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Jumlah Pembayaran Tidak Valid',
                text: 'Jumlah pembayaran harus berupa angka positif.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Menyiapkan data untuk disimpan
        const requestData = {
            siswa_id: siswaId,
            tagihan_id: tagihanId, // Menambahkan tagihan_id di sini
            jumlah_bayar: totalBayar,
            status: 'sukses',
            rincian: []
        };

        // Loop melalui setiap rincian-item dan kumpulkan data
        $('#containerInput .rincian-item').each(function() {
            const rincianTagihanId = $(this).data(
                'rincian-tagihan-id'); // Mendapatkan rincian_tagihan_id dari atribut data
            const jumlahBayarInput = $(this).find('input[id^="jumlah_bayar_"]');
            const maxBayar = parseFloat(jumlahBayarInput.attr('max')); // Mendapatkan nilai max
            const jumlahBayar = parseFloat(jumlahBayarInput.val()); // Mendapatkan nilai input pengguna

            // Pastikan jumlah yang dibayar tidak melebihi nilai max
            if (isNaN(jumlahBayar) || jumlahBayar > maxBayar) {
                Swal.fire({
                    icon: 'error',
                    title: 'Jumlah Pembayaran Tidak Valid',
                    text: `Jumlah yang dibayar tidak boleh lebih dari Rp ${maxBayar.toLocaleString('id-ID')},00.`,
                    confirmButtonText: 'OK'
                });
                return false; // Hentikan pengiriman form
            }

            // Cek apakah rincianTagihanId ada sebelum menambahkannya
            if (rincianTagihanId) {
                // Menambahkan rincian ke data permintaan
                requestData.rincian.push({
                    rincian_tagihan_id: rincianTagihanId, // Menambahkan rincian_tagihan_id di sini
                    total_bayar: jumlahBayar
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Lengkap',
                    text: 'Rincian Tagihan ID diperlukan untuk setiap rincian.',
                    confirmButtonText: 'OK'
                });
                return false; // Hentikan pengiriman form jika rincian_tagihan_id hilang
            }
        });

        // Jika ada rincian yang tidak valid, berhenti di sini dan jangan kirim request
        if (requestData.rincian.length === 0) {
            return; // Jangan kirim request AJAX jika tidak ada rincian yang valid
        }

        // Kirim request AJAX untuk menyimpan data
        $.ajax({
            url: storeUrl,
            method: 'POST',
            data: requestData,
            success: function(response) {
                if (response.success) {
                    // Jika data berhasil disimpan, tampilkan alert sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil Disimpan',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(function() {
                        location.reload(); // Muat ulang tabel jika perlu
                    });
                } else {
                    // Tampilkan alert error jika terjadi kesalahan
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: response.message ||
                            'Terjadi kesalahan saat menyimpan pembayaran.',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr) {
                // Menangani kesalahan AJAX
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Terjadi kesalahan saat memproses permintaan.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
