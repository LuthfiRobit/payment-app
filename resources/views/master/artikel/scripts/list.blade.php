<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('master-data.artikel.list') }}', // Ganti dengan route yang sesuai
                type: 'GET',
                data: function(d) {
                    d.filter_status = $('#filter_status').val(); // Kirim data filter
                }
            },
            columns: [{
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'judul',
                    name: 'judul',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'dilihat',
                    name: 'dilihat',
                    orderable: true,
                    searchable: false
                }
            ],
            language: {
                searchPlaceholder: "Cari judul artikel",
                search: ''
            }
        });

        // Custom search behavior
        $("#example_filter input").on("input", function() {
            var searchValue = this.value;
            if (searchValue.length >= 3 || searchValue.length === 0) {
                table.column(1).search(searchValue).draw(); // search by Judul
            }
        });

        $('#filter_status').change(function() {
            table.ajax.reload(); // Apply filter
        });
    });
</script>
