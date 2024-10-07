<script>
    $(document).ready(function() {
        $('#example').on('click', '.detail-button', function() {
            var id = $(this).data('id');
            var url = '{{ route('setting.tagihan-siswa.show', ':id') }}'.replace(':id', id);
            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    $('#show_nama_siswa').text(response.data.nama_siswa);
                    $('#show_kelas').text(response.data.kelas);
                    $('#show_status').text(response.data.status);
                    $('#tagihanList').html('');
                    if (response.data.tagihan_siswa.length > 0) {
                        response.data.tagihan_siswa.forEach(function(tagihan) {
                            $('#tagihanList').append(
                                '<li class="list-group-item d-flex justify-content-between align-items-center text-uppercase">' +
                                tagihan.iuran.nama_iuran +
                                ' <span class="badge light badge-primary badge-pill">' +
                                tagihan.iuran.besar_iuran + '</span></li>');
                        });
                    } else {
                        $('#tagihanList').append(
                            '<li class="list-group-item align-items-center text-center fw-bold text-uppercase">Belum ada tagihan</li>'
                        );
                    }
                    $('#detailTagihanModal').modal('show');
                }
            });
        });
    });
</script>
