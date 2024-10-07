<script>
    $(document).ready(function() {
        $('#example').on('click', '.detail-button', function() {
            const id = $(this).data('id');
            const url = '{{ route('tagihan.daftar-tagihan.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    displayStudentInfo(response.siswa);
                    displayTagihanInfo(response.data);
                    populateRincian(response.rincian);
                    $('#detailTagihanModal').modal('show');
                }
            });
        });

        function displayStudentInfo(siswa) {
            $('#show_nis').text(siswa.nis);
            $('#show_nama_siswa').text(siswa.nama_siswa);
            $('#show_kelas').text(siswa.kelas);
        }

        function displayTagihanInfo(data) {
            $('#show_besar_tagihan').text(formatCurrency(data.besar_tagihan));
            $('#show_besar_potongan').text(formatCurrency(data.besar_potongan));
            $('#show_total_tagihan').text(formatCurrency(data.total_tagihan));
            $('#show_status').text(data.status);
        }

        function populateRincian(rincian) {
            $('#container-rincian').html(''); // Clear previous data

            if (rincian.length > 0) {
                rincian.forEach(tagihan => {
                    $('#container-rincian').append(createRincianRow(tagihan));
                });
            } else {
                $('#container-rincian').append(
                    '<li class="list-group-item align-items-center text-center fw-bold text-uppercase">Tidak ada rincian tagihan</li>'
                );
            }
        }

        function createRincianRow(tagihan) {
            return `
                <div class="rincian-row border-bottom py-2">
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Iuran</p>
                        <span class="text-black fs-6 font-w500">${tagihan.nama_iuran}</span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Besar Iuran</p>
                        <span class="text-black fs-6 font-w500">${formatCurrency(tagihan.besar_tagihan)}</span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Potongan</p>
                        <span class="text-black fs-6 font-w500">
                            ${tagihan.nama_potongan ? `${tagihan.nama_potongan} - ${tagihan.potongan_persen ? tagihan.potongan_persen + '%' : ''}` : 'Tidak ada'}
                        </span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Besar Potongan</p>
                        <span class="text-black fs-6 font-w500">${formatCurrency(tagihan.besar_potongan)}</span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Total Tagihan</p>
                        <span class="text-black fs-6 font-w500">${formatCurrency(tagihan.total_tagihan)}</span>
                    </div>
                    <div class="rincian-item">
                        <p class="fs-14 mb-1">Status</p>
                        <span class="text-black fs-6 font-w500 text-uppercase">${tagihan.status}</span>
                    </div>
                </div>
            `;
        }

        function formatCurrency(value) {
            return value.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).replace('IDR', '').trim();
        }
    });
</script>
