<script>
    $(document).ready(function() {
        $('#example').on('click', '.detail-button', function() {
            const id = $(this).data('id');
            const url = '{{ route('transaksi.setor.keuangan.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    if (response.success) {
                        displaySetoranInfo(response.data.setoran_keuangan);
                        populateRincian(response.data.rincian_setoran);
                        $('#detailSetoranModal').modal('show');
                    } else {
                        // Menggunakan SweetAlert untuk menampilkan pesan kesalahan
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Ditemukan',
                            text: 'Data yang Anda cari tidak tersedia.',
                            confirmButtonText: 'Tutup'
                        });
                    }
                },
                error: function() {
                    // Menggunakan SweetAlert untuk menampilkan pesan kesalahan
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat memuat data. Silakan coba lagi.',
                        confirmButtonText: 'Tutup'
                    });
                }
            });
        });

        function displaySetoranInfo(data) {
            // Menampilkan data setoran keuangan di modal
            $('#show_bulan_tahun').text(`${data.nama_bulan} - ${data.tahun}`);
            $('#show_tanggal_setor').text(formatTanggal(data.created_at));
            $('#show_total_tagihan').text(formatCurrency(data.total_tagihan_setoran));
            $('#show_total_setoran').text(formatCurrency(data.total_setoran));
            $('#show_sisa_setoran').text(formatCurrency(data.sisa_setoran));
            $('#show_status').html(data.status);
            $('#show_keterangan').text(data.keterangan);
        }

        function populateRincian(rincian) {
            $('#container-rincian').html(''); // Clear previous data

            if (rincian.length > 0) {
                rincian.forEach(tagihan => {
                    $('#container-rincian').append(createRincianRow(tagihan));
                });
            } else {
                $('#container-rincian').append(
                    '<li class="list-group-item align-items-center text-center fw-bold text-uppercase">Tidak ada rincian setoran</li>'
                );
            }
        }

        function createRincianRow(tagihan) {
            return `
                <div class="rincian-row border-bottom py-2">
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Iuran</p>
                        <span class="text-black fs-6 font-w500">${tagihan.nama_iuran}</span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Total Tagihan</p>
                        <span class="text-black fs-6 font-w500">${formatCurrency(tagihan.total_tagihan)}</span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Total Setoran</p>
                        <span class="text-black fs-6 font-w500">${formatCurrency(tagihan.total_setoran)}</span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Sisa Setoran</p>
                        <span class="text-black fs-6 font-w500">${formatCurrency(tagihan.sisa_setoran)}</span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Status</p>
                        <span class="text-black fs-6 font-w500 text-uppercase">${tagihan.status}</span>
                    </div>
                </div>
            `;
        }

        function formatCurrency(value) {
            return value.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).replace('IDR', '').trim();
        }

        // Mengubah format tanggal dari response
        function formatTanggal(tanggal) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const date = new Date(tanggal); // Konversi string ke objek Date
            return date.toLocaleDateString('id-ID', options); // Format dengan locale Indonesia
        }
    });
</script>
