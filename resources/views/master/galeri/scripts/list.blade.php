<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('master-data.galeri.list') }}', // Pastikan route ini sudah terdaftar
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
                    data: 'kegiatan',
                    name: 'kegiatan',
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
                searchPlaceholder: "Cari nama kegiatan...",
                search: ''
            },
        });

        // Custom search trigger minimal 4 karakter
        $("#example_filter input").on("input", function() {
            let searchValue = this.value;
            if (searchValue.length >= 4 || searchValue.length === 0) {
                table.column(1).search(searchValue).draw();
            }
        });

        // Reload saat filter status diganti
        $('#filter_status').change(function() {
            table.ajax.reload();
        });
    });
</script>
