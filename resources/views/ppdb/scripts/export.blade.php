<script>
    $(document).ready(function() {
        // Tombol export siswa
        $('#btnExportSiswa').click(function() {
            let selectedIds = [];

            // Ambil ID siswa yang dipilih dari checkbox
            $('.siswa-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            // Cek jika tidak ada siswa yang dipilih
            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Siswa!',
                    text: 'Anda harus memilih setidaknya satu siswa baru terlebih dahulu.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Tampilkan modal untuk memilih data yang akan diekspor
            $('#exportModal').modal('show');
        });

        // Tombol submit ekspor dari modal
        $('#submitExport').click(function() {
            let selectedIds = [];
            let includeIbu = $('#includeIbu').prop('checked');
            let includeAyah = $('#includeAyah').prop('checked');
            let includeWali = $('#includeWali').prop('checked');
            let includeKeluarga = $('#includeKeluarga').prop('checked');

            // Ambil ID siswa yang dipilih dari checkbox
            $('.siswa-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            // Cek jika tidak ada siswa yang dipilih
            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Siswa!',
                    text: 'Anda harus memilih setidaknya satu siswa baru terlebih dahulu.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Menyusun data tambahan berdasarkan checkbox yang dipilih
            let exportOptions = {
                _token: '{{ csrf_token() }}',
                ids: selectedIds,
                include_ibu: includeIbu,
                include_ayah: includeAyah,
                include_wali: includeWali,
                include_keluarga: includeKeluarga
            };

            // Mengirimkan request untuk export data siswa
            $.ajax({
                url: '{{ route('ppdb.export') }}',
                type: 'POST',
                data: exportOptions,
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response, status, xhr) {
                    // Periksa status HTTP
                    if (xhr.status === 200) {
                        // Membuat link sementara untuk download file
                        var link = document.createElement('a');
                        link.href = URL.createObjectURL(response);
                        link.download =
                        'data_siswa_baru.xlsx'; // Nama file yang akan diunduh

                        // Men-trigger klik pada link untuk mengunduh file
                        link.click();

                        // Menampilkan SweetAlert sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Export Berhasil!',
                            text: 'Data siswa berhasil diekspor.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Jika status tidak 200, maka export gagal
                        Swal.fire({
                            icon: 'error',
                            title: 'Export Gagal!',
                            text: 'Terjadi kesalahan saat mengekspor data siswa.',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Jika terjadi kesalahan pada request (misalnya server error)
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: 'Terjadi kesalahan saat menghubungi server. Silakan coba lagi.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
