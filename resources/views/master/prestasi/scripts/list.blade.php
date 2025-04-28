<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('master-data.prestasi.list') }}', // Ganti sesuai rute untuk prestasi
                type: 'GET',
                data: function(d) {
                    d.filter_status = $('#filter_status').val();
                }
            },
            columns: [{
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_prestasi',
                    name: 'nama_prestasi',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
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
                searchPlaceholder: "Cari nama prestasi",
                search: ''
            },
        });

        $("#example_filter input").on("input", function() {
            let searchValue = this.value;
            if (searchValue.length >= 4 || searchValue.length === 0) {
                table.column(1).search(searchValue).draw();
            }
        });

        $('#filter_status').change(function() {
            table.ajax.reload();
        });
    });
</script>
