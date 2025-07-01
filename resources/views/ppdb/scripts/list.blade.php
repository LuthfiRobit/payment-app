<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('ppdb.list') }}', // Sesuaikan dengan route Anda
                type: 'GET',
                data: function(d) {
                    // Mengirimkan filter berdasarkan input dari pengguna
                    d.filter_tahun = $('#filter_tahun').val(); // Filter untuk tahun akademik
                    d.filter_status = $('#filter_status').val(); // Filter untuk tahun akademik
                }
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'aksi', // Kolom aksi
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'DT_RowIndex', // Kolom nomor urut
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'no_registrasi', // Menampilkan no registrasi
                    name: 'no_registrasi',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'nama_siswa', // Menampilkan nama lengkap siswa
                    name: 'nama_siswa',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'tahun_akademik', // Menampilkan tahun akademik
                    name: 'tahun_akademik',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'nik', // Menampilkan NIK
                    name: 'nik',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'sekolah_sebelum_mi', // Menampilkan sekolah sebelum MI
                    name: 'sekolah_sebelum_mi',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'usia', // Menampilkan usia
                    name: 'usia',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'status', // Menampilkan status
                    name: 'status',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'creator_nama', // Menampilkan status
                    name: 'creator_nama',
                    orderable: false,
                    searchable: true
                }
            ],
            language: {
                searchPlaceholder: "Nama ...",
                search: ''
            },
        });

        // Fungsi pencarian kustom
        $("#example_filter input").on("input", function() {
            var searchValue = this.value;
            // Hanya cari jika panjang karakter >= 4
            if (searchValue.length >= 4) {
                // Cari di kolom nama
                table.columns([3]).search(searchValue).draw();
            } else {
                // Kosongkan pencarian jika kurang dari 4 karakter
                table.columns([3]).search('').draw();
            }
        });

        // Reload DataTable saat filter berubah
        $('#filter_tahun').change(function() {
            table.ajax.reload(); // Reload DataTable dengan filter baru
        });

        // Reload DataTable saat filter berubah
        $('#filter_status').change(function() {
            table.ajax.reload(); // Reload DataTable dengan filter baru
        });

        // Select All checkbox logic
        $('#selectAll').click(function() {
            $('.siswa-checkbox').prop('checked', $(this).prop('checked'));
        });
    });
</script>
