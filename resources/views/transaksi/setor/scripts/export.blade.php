<script>
    $(document).ready(function() {
        // Open modal when export button is clicked
        $('#btnExport').on('click', function() {
            $('#modalExport').modal('show');
        });

        // Handle export submission
        $('#btnExportSubmit').on('click', function() {
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();

            // Validate input
            if (!tahun || !bulan) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Harap pilih semua opsi (Tahun Akademik dan Bulan) untuk melanjutkan export.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Send export request to server
            $.ajax({
                url: "{{ route('transaksi.setor.keuangan.export') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    tahun: tahun,
                    bulan: bulan
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    // Handle file download
                    var blob = response;
                    var link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'transaksi_bulan_' + bulan + '_tahun_' + tahun +
                        '.xlsx';
                    link.click();

                    // After success, close the modal and show success alert
                    $('#modalExport').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Data export berhasil.',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Terjadi kesalahan saat melakukan export.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Reset the modal form when it is closed
        $('#modalExport').on('hidden.bs.modal', function() {
            // Reset the form fields
            $('#formExportData')[0].reset();
            // Optionally reset select picker (if you're using one)
            $('#tahun').selectpicker('refresh');
            $('#bulan').selectpicker('refresh');
        });
    });
</script>
