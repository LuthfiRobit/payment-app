<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('application.user.list') }}', // Pastikan route sesuai untuk mengambil data pengguna
                type: 'GET',
                data: function(d) {
                    // Kirim filter status jika ada
                    d.filter_status = $('#filter_status')
                        .val(); // Kirim filter status dari dropdown
                }
            },
            columns: [{
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name', // Nama pengguna
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'email', // Email pengguna
                    name: 'email',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'role', // Role pengguna (admin, siswa, dll.)
                    name: 'role',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status', // Status pengguna
                    name: 'status',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                searchPlaceholder: "Cari pengguna",
                search: ''
            },
        });

        // Custom search functionality for 'Nama Pengguna' or 'Email'
        $("#example_filter input").on("input", function() {
            var searchValue = this.value;
            if (searchValue.length >= 3) { // Trigger search when 3 or more characters are typed
                table.column(1).search(searchValue).draw(); // Search in 'Nama Pengguna' column
                // table.column(2).search(searchValue).draw(); // Search in 'Email' column
            } else {
                table.column(1).search('').draw(); // Clear search if the string is too short
                // table.column(2).search('').draw();
            }
        });

        // Filter by status (aktif / tidak aktif)
        $('#filter_status').change(function() {
            table.ajax.reload(); // Reload DataTable with new filter applied
        });

        // Event listener untuk switch (status aktif/tidak aktif pengguna)
        $(document).on('change', '.form-check-input[type="checkbox"]', function() {
            var id = $(this).data('id');
            var isChecked = $(this).is(':checked');
            var status = isChecked ? 'aktif' : 'tidak aktif'; // Tentukan status berdasarkan checkbox

            // Tampilkan SweetAlert untuk konfirmasi
            Swal.fire({
                title: isChecked ? 'Aktifkan Pengguna?' : 'Nonaktifkan Pengguna?',
                text: isChecked ? "Apakah Anda yakin ingin mengaktifkan pengguna ini?" :
                    "Apakah Anda yakin ingin menonaktifkan pengguna ini? Pengguna tidak akan dapat mengakses aplikasi jika dinonaktifkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: isChecked ? 'Ya, Aktifkan!' : 'Ya, Nonaktifkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim permintaan untuk mengubah status pengguna
                    $.ajax({
                        url: '{{ route('application.user.update.status') }}', // Pastikan route sesuai
                        method: 'POST',
                        data: {
                            id: id,
                            status: status, // Kirim status yang dipilih
                            _token: '{{ csrf_token() }}' // CSRF token untuk keamanan
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire('Berhasil!', response.message, 'success');
                                table.ajax
                                    .reload(); // Reload DataTable untuk memperbarui status pengguna
                            } else {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Gagal!',
                                'Terjadi kesalahan saat mengubah status pengguna.',
                                'error');
                        }
                    });
                } else {
                    // Jika dibatalkan, set switch kembali ke kondisi sebelumnya
                    $(this).prop('checked', !isChecked); // Kembalikan status checkbox
                }
            });
        });
    });
</script>
