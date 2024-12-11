<script>
    const storeUrl = "{{ route('transaksi.pembayaran.store') }}"; // URL untuk menyimpan pembayaran

    $('#save-payment-btn').click(function(event) {
        event.preventDefault(); // Mencegah pengiriman form secara default

        const siswaId = $('#filter_siswa').val(); // Mendapatkan siswa_id dari filter

        // Validasi siswa_id
        if (!siswaId) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Pastikan siswa telah dipilih.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Validasi tagihan_id
        if (!tagihanId) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Data tagihan tidak ada.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Menyiapkan data untuk disimpan
        const requestData = {
            siswa_id: siswaId,
            tagihan_id: tagihanId,
            rincian: []
        };

        let valid = true; // Flag untuk menghentikan proses jika ada error

        // Loop melalui setiap rincian-item dan kumpulkan data
        $('#containerInput .rincian-item').each(function() {
            const rincianTagihanId = $(this).data('rincian-tagihan-id');
            const jumlahBayarInput = $(this).find('input[id^="jumlah_bayar_"]');
            const maxBayar = parseFloat(jumlahBayarInput.attr('max')); // Maksimum bayar dari backend
            const jumlahBayar = parseFloat(jumlahBayarInput.val()); // Nilai input pengguna

            // Validasi jumlah bayar terhadap maxBayar
            if (isNaN(jumlahBayar) || jumlahBayar < 0 || jumlahBayar > maxBayar) {
                Swal.fire({
                    icon: 'error',
                    title: 'Jumlah Pembayaran Tidak Valid',
                    text: `Jumlah yang dibayar untuk rincian tagihan ID ${rincianTagihanId} tidak boleh lebih dari Rp ${maxBayar.toLocaleString('id-ID')},00.`,
                    confirmButtonText: 'OK'
                });
                valid = false; // Set flag ke false jika ada kesalahan
                return false; // Hentikan iterasi
            }

            // Tambahkan rincian ke requestData meskipun jumlah_bayar adalah 0
            requestData.rincian.push({
                rincian_tagihan_id: rincianTagihanId,
                total_bayar: jumlahBayar
            });
        });

        // Jika ada rincian yang tidak valid, hentikan proses
        if (!valid || requestData.rincian.length === 0) {
            return;
        }

        // Kirim request AJAX untuk menyimpan data
        $.ajax({
            url: storeUrl,
            method: 'POST',
            data: requestData,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil Disimpan',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(function() {
                        location.reload(); // Muat ulang tabel jika perlu
                    });
                } else {
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
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan',
                    text: 'Terjadi kesalahan saat memproses permintaan.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Validasi real-time jumlah bayar
    $(document).on('input', 'input[id^="jumlah_bayar_"]', function() {
        const maxBayar = parseFloat($(this).attr('max'));
        const jumlahBayar = parseFloat($(this).val());

        if (jumlahBayar < 0 || jumlahBayar > maxBayar) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
            $(this).after(
                `<div class="invalid-feedback">Jumlah tidak boleh lebih dari Rp ${maxBayar.toLocaleString('id-ID')},00 dan tidak boleh kurang dari 0.</div>`
            );
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });
</script>
