<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('master-data.siswa.list') }}', // Adjust to your route
                type: 'GET',
                data: function(d) {
                    d.filter_status = $('#filter_status').val(); // Send filter status
                }
            },
            columns: [{
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nis',
                    name: 'nis',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'nama_siswa',
                    name: 'nama_siswa',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'kelas',
                    name: 'kelas',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'nomor_telepon',
                    name: 'nomor_telepon',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                searchPlaceholder: "Cari NIS atau nama siswa",
                search: ''
            },
        });

        // Custom search functionality
        $("#example_filter input").on("input", function() {
            var searchValue = this.value;
            // Hanya cari jika panjang karakter >= 4
            if (searchValue.length >= 4) {
                // Cari di kolom NIS (kolom index 1) dan Nama Siswa (kolom index 2)
                table.columns([1, 2]).search(searchValue).draw();
            } else {
                // Kosongkan pencarian jika kurang dari 4 karakter
                table.columns([1, 2]).search('').draw();
            }
        });

        $('#filter_status').change(function() {
            table.ajax.reload(); // Reload DataTable with new filter
        });
    });
</script>
