<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('master-data.guru.list') }}', // Ganti sesuai rute untuk prestasi
                type: 'GET',
                data: function(d) {
                    d.filter_status = $('#filter_status').val();
                    d.filter_kategori = $('#filter_kategori').val();
                }
            },
            columns: [{
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama',
                    name: 'nama',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'jabatan',
                    name: 'jabatan',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kategori',
                    name: 'kategori',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'urutan',
                    name: 'urutran',
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
                searchPlaceholder: "Cari nama",
                search: ''
            },
        });

        $("#example_filter input").on("input", function() {
            let searchValue = this.value;
            if (searchValue.length >= 4 || searchValue.length === 0) {
                table.column(1).search(searchValue).draw();
            }
        });

        // Filter real-time
        $('#filter_status, #filter_kategori').change(function() {
            table.ajax.reload();
        });
    });
</script>
