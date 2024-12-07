<script>
    const storeUrl =
        "{{ route('transaksi.setor.keuangan.store') }}"; // Ganti dengan route untuk menyimpan setoran keuangan

    $('#save-setoran-btn').click(function(event) {
        event.preventDefault(); // Mencegah pengiriman form secara default

        const tahun = $('#tahun').val(); // Mendapatkan tahun dari input
        const bulan = $('#bulan').val(); // Mendapatkan bulan dari input
        const namaBulan = $('#nama_bulan').val(); // Mendapatkan nama bulan
        const totalSetoranAll = parseFloat($('#total_setoran_all')
            .val()); // Total setoran untuk seluruh rincian
        const sisaSetoranAll = parseFloat($('#sisa_setoran_all').val()); // Sisa total setoran
        const keterangan = $('#keterangan').val(); // Keterangan tambahan dari input

        // Validasi tahun dan bulan
        if (!tahun || !bulan || !namaBulan) {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Lengkap',
                text: 'Pastikan tahun, bulan, dan nama bulan sudah diisi.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Menyiapkan data untuk disimpan
        const requestData = {
            tahun: tahun,
            bulan: bulan,
            nama_bulan: namaBulan,
            total_setoran_all: totalSetoranAll,
            sisa_setoran_all: sisaSetoranAll,
            keterangan: keterangan,
            setoran_details: [] // Untuk rincian setoran
        };

        let valid = true; // Flag untuk menghentikan proses jika ada error

        // Loop melalui setiap rincian-item dan kumpulkan data
        $('#containerInput .rincian-item').each(function(index) {
            const iuranId = $(this).data('iuran-id'); // Mendapatkan ID iuran
            const totalBayar = $(this).data('iuran-bayar'); // Mendapatkan ID iuran
            // Gunakan index untuk membentuk selector id pada input

            let totalTagihanSetoran = $(this).find('#harus_dibayar_' + index).val();
            totalTagihanSetoran = totalTagihanSetoran.replace(/[^0-9,]/g, '').replace(',', '.');
            totalTagihanSetoran = parseFloat(totalTagihanSetoran) || 0;

            const totalSetoran = parseFloat($(this).find('#total_setoran_' + index)
                .val()); // Nilai setoran yang dibayar
            const sisaSetoran = parseFloat($(this).find('#sisa_setoran_' + index)
                .val()); // Sisa setoran
            const status = sisaSetoran === 0 ? 'lunas' :
                'belum lunas'; // Status berdasarkan sisa setoran

            const namaIuran = $(this).find('#nama_iuran_' + index).val();

            // Validasi total setoran terhadap total tagihan
            if (isNaN(totalSetoran) || totalSetoran < 0 || totalSetoran > totalTagihanSetoran) {
                Swal.fire({
                    icon: 'error',
                    title: 'Jumlah Setoran Tidak Valid',
                    text: `Jumlah setoran untuk ${namaIuran} tidak boleh lebih dari Rp ${totalTagihanSetoran.toLocaleString('id-ID')},00. dan tidak boleh kurang dari 0`,
                    confirmButtonText: 'OK'
                });
                valid = false; // Set flag ke false jika ada kesalahan
                return false; // Hentikan iterasi
            }

            // Tambahkan rincian ke requestData meskipun jumlah_bayar adalah 0
            requestData.setoran_details.push({
                iuran_id: iuranId, // Menambahkan index sebagai identifikasi unik
                total_tagihan_setoran: totalBayar,
                total_setoran: totalSetoran,
                sisa_setoran: sisaSetoran,
                status: status
            });
        });


        // Jika ada rincian yang tidak valid, hentikan proses
        if (!valid || requestData.setoran_details.length === 0) {
            return;
        }

        // Kirim request AJAX untuk menyimpan data
        $.ajax({
            url: storeUrl,
            method: 'POST',
            data: requestData,
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Setoran Berhasil Disimpan',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then(function() {
                        location
                            .reload(); // Muat ulang halaman untuk menampilkan data terbaru
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: response.message ||
                            'Terjadi kesalahan saat menyimpan setoran.',
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
</script>
