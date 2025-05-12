<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('transaksi.laporan.list') }}', // Sesuaikan dengan route Anda
                type: 'GET',
                data: function(d) {
                    // Mengirimkan filter berdasarkan input dari pengguna
                    d.filter_tahun = $('#filter_tahun').val(); // Filter untuk tahun akademik
                    d.filter_siswa = $('#filter_siswa').val(); // Filter untuk siswa
                    d.filter_tanggal = $('#filter_tanggal').val(); // Filter untuk tanggal bayar
                }
            },
            columns: [{
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nomor_transaksi',
                    name: 'nomor_transaksi',
                    orderable: false,
                    searchable: true
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
                    data: 'jumlah_bayar',
                    name: 'jumlah_bayar',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'tanggal_bayar',
                    name: 'tanggal_bayar',
                    orderable: true,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'creator_nama',
                    name: 'creator_nama',
                    orderable: false,
                    searchable: false
                }
            ],
            language: {
                searchPlaceholder: "Cari No. Transaksi",
                search: ''
            },
        });

        // Fungsi pencarian kustom
        $("#example_filter input").on("input", function() {
            var searchValue = this.value;
            // Hanya cari jika panjang karakter >= 4
            if (searchValue.length >= 4) {
                // Cari di kolom nomor_transaksi (kolom index 1) dan siswa (kolom index 3)
                table.columns([1]).search(searchValue).draw();
            } else {
                // Kosongkan pencarian jika kurang dari 4 karakter
                table.columns([1]).search('').draw();
            }
        });

        // Reload DataTable saat filter berubah
        $('#filter_tahun, #filter_siswa, #filter_tanggal').change(function() {
            table.ajax.reload(); // Reload DataTable dengan filter baru
        });
    });
</script>
