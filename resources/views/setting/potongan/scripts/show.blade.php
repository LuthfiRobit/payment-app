<script>
    $(document).ready(function() {
        // Event listener for the detail button
        $('#example').on('click', '.detail-button', function() {
            var id = $(this).data('id');
            var url = '{{ route('setting.potongan-siswa.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    console.log(response);
                    $('#siswa_id').val(response.data.id_siswa);

                    $('#show_nama_siswa').text(response.data.nama_siswa);
                    $('#show_kelas').text(response.data.kelas);
                    $('#show_status').text(response.data.status);
                    $('#container-tagihan')
                .empty(); // Clear the container before populating

                    if (response.data.tagihan_siswa.length > 0) {
                        response.data.tagihan_siswa.forEach(function(tagihan) {
                            $('#container-tagihan').append(createTagihanRow(tagihan,
                                response.potongan));
                        });
                        // Refresh selectpicker after adding options
                        $('.selectpicker').selectpicker('refresh');
                    } else {
                        $('#container-tagihan').append(
                            '<div class="alert alert-info text-center">Belum ada tagihan</div>'
                            );
                    }
                    $('#detailTagihanModal').modal('show');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Gagal mengambil data tagihan siswa.', 'error');
                }
            });
        });

        // Function to create the rows for the tagihan
        function createTagihanRow(tagihan, potongan) {
            return `
                <div class="row mb-3">
                    <div class="col-xl-3 col-lg-3 col-md-3 mb-2">
                        <label class="form-label">Jenis Iuran</label>
                        <input type="text" class="form-control form-control-sm" name="jenis_iuran[]" id="jenis_iuran_${tagihan.id_tagihan_siswa}" value="${tagihan.iuran.nama_iuran}" readonly>
                        <input type="hidden" class="form-control form-control-sm" name="tagihan_siswa_id[]" id="tagihan_siswa_id_${tagihan.id_tagihan_siswa}" value="${tagihan.id_tagihan_siswa}" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 mb-2">
                        <label class="form-label">Besar Iuran (Rp.)</label>
                        <input type="number" class="form-control form-control-sm" name="besar_iuran[]" id="besar_iuran_${tagihan.id_tagihan_siswa}" value="${tagihan.iuran.besar_iuran}" readonly>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 mb-2">
                        <label for="potongan" class="form-label">Jenis Potongan</label>
                        <select class="selectpicker form-control wide form-select-md jenis_potongan" name="jenis_potongan[]" id="potongan_${tagihan.id_tagihan_siswa}" data-live-search="false" placeholder="Pilih potongan">
                            <option value="">Tidak Memiliki Potongan</option>
                            ${potongan.map(item => `<option value="${item.id_potongan}">${item.nama_potongan}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 mb-2">
                        <label for="potongan_persen" class="form-label">Besar Potongan (%)</label>
                        <input type="number" class="form-control form-control-sm potongan_persen" name="potongan_persen[]" id="potongan_persen_${tagihan.id_tagihan_siswa}" min="1" max="100" placeholder="Presentase potongan" readonly>
                    </div>
                </div>
            `;
        }

        // Event delegation to handle the change event on jenis_potongan select
        $('#container-tagihan').on('change', 'select.jenis_potongan', function() {
            var selected = $(this).find('option:selected').val(); // Get the selected value
            var potonganPersenInput = $(this).closest('.row').find(
            'input.potongan_persen'); // Get the corresponding potongan_persen input

            // Debugging logs to ensure the correct option is being selected
            console.log('Selected value:', selected);

            // Check if a valid option is selected (not empty or null)
            if (selected && selected !== "") {
                console.log('Valid selection detected');
                potonganPersenInput.prop('readonly', false).prop('required',
                true); // Enable input and set as required
                potonganPersenInput
            .focus(); // Optional: Set focus to indicate that the input is now active
            } else {
                console.log('No valid selection detected');
                potonganPersenInput.prop('readonly', true).prop('required', false).val(
                ''); // Disable input, remove required, and reset value
            }
        });

    });
</script>
