<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('tagihan.daftar-tagihan.list') }}', // Adjust to your route
                type: 'GET',
                data: function(d) {
                    d.filter_kelas = $('#filter_kelas').val(); // Send filter status
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
                    data: 'tahun_akademik',
                    name: 'tahun_akademik',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'siswa',
                    name: 'siswa',
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
                    data: 'besar_tagihan',
                    name: 'besar_tagihan',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'besar_potongan',
                    name: 'besar_potongan',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'total_tagihan',
                    name: 'total_tagihan',
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
                table.columns([2]).search(searchValue).draw();
            } else {
                // Kosongkan pencarian jika kurang dari 4 karakter
                table.columns([2]).search('').draw();
            }
        });

        $('#filter_status').change(function() {
            table.ajax.reload(); // Reload DataTable with new filter
        });

        $('#filter_kelas').change(function() {
            table.ajax.reload(); // Reload DataTable with new filter
        });
    });
</script>
