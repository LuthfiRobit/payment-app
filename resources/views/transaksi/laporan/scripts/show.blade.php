<script>
    $(document).ready(function() {
        $('#example').on('click', '.detail-button', function() {
            const id = $(this).data('id');
            const url = '{{ route('transaksi.laporan.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    displayStudentInfo(response.siswa);
                    displayTransaksiInfo(response.data);
                    populateRincian(response.rincian);
                    $('#detailModal').modal('show');
                },
                error: function(xhr) {
                    if (xhr.status === 403) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Unauthorized',
                            text: 'You do not have permission to access this resource.',
                            confirmButtonText: 'Okay'
                        });
                    }
                }
            });

            // $('#detailModal').modal('show');
        });

        function displayStudentInfo(siswa) {
            $('#show_nis').text(siswa.nis);
            $('#show_nama_siswa').text(siswa.nama_siswa);
            $('#show_kelas').text(siswa.kelas);
        }

        function displayTransaksiInfo(data) {
            $('#show_nomor_transaksi').text(data.nomor_transaksi)
            $('#show_creator').text(data.creator_nama)

            if (data && data.jumlah_bayar !== undefined) {
                $('#show_total_bayar').text(formatCurrency(data.jumlah_bayar));
            } else {
                $('#show_total_bayar').text('Data tidak tersedia');
            }
            if (data && data.tanggal_bayar) {
                $('#show_tanggal').text(formatTanggal(data.tanggal_bayar)); // Menggunakan formatTanggal
            } else {
                $('#show_tanggal').text('Tanggal tidak tersedia');
            }
        }

        function populateRincian(rincian) {
            $('#modalRincianIuran').html(''); // Clear previous data

            if (rincian.length > 0) {
                rincian.forEach(tagihan => {
                    $('#modalRincianIuran').append(createRincianRow(tagihan));
                });
            } else {
                $('#modalRincianIuran').append(
                    '<tr class="text-center fw-bold"><td colspan="4">Tidak ada rincian tagihan</td></tr>'
                );
            }
        }

        function createRincianRow(tagihan) {
            return `
                    <tr>
                        <td>${tagihan.nama_iuran}</td>
                        <td>${formatCurrency(tagihan.total_tagihan)}</td>
                        <td>${formatCurrency(tagihan.total_bayar)}</td>
                        <td class="${tagihan.status === 'lunas' ? 'text-success' : 'text-danger'} text-uppercase">${tagihan.status}</td>
                    </tr>
                `;
        }


        function formatCurrency(value) {
            return value.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).replace('IDR', '').trim();
        }
    });
</script>
