<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('transaksi.setor.keuangan.list') }}', // Adjust to your route
                type: 'GET',
                data: function(d) {
                    d.filter_tahun = $('#filter_tahun').val(); // Send filter tahun
                    d.filter_bulan = $('#filter_bulan').val(); // Send filter status
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
                    data: 'tahun_bulan',
                    name: 'tahun_bulan',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'total_bayar',
                    name: 'total_bayar',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'total_setoran',
                    name: 'total_setoran',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'sisa_setoran',
                    name: 'sisa_setoran',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal_setoran',
                    name: 'tanggal_setoran',
                    orderable: true,
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

        $('#filter_tahun').change(function() {
            table.ajax.reload(); // Reload DataTable with new filter
        });

        $('#filter_bulan').change(function() {
            table.ajax.reload(); // Reload DataTable with new filter
        });

        $('#filter_status').change(function() {
            table.ajax.reload(); // Reload DataTable with new filter
        });
    });
</script>
