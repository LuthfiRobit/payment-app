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
                    d.filter_kelas = $('#filter_kelas').val(); // Send filter status
                }
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
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
                searchPlaceholder: "NIS",
                search: ''
            },
        });

        // Custom search functionality
        $("#example_filter input").on("input", function() {
            var searchValue = this.value;
            // Hanya cari jika panjang karakter >= 4
            if (searchValue.length >= 4) {
                // Cari di kolom NIS (kolom index 2)
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

        // // Select All checkbox logic
        $('#selectAll').click(function() {
            // Dapatkan status checked dari checkbox 'selectAll'
            var isChecked = $(this).prop('checked');

            // Pilih hanya checkbox yang tidak disabled dan set checked sesuai status selectAll
            $('.siswa-checkbox:not(:disabled)').prop('checked', isChecked);
        });
    });
</script>
