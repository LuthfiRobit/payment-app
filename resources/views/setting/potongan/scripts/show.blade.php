<script>
    $(document).ready(function() {
        $('#example').on('click', '.detail-button', function() {
            var id = $(this).data('id');
            var url = '{{ route('setting.potongan-siswa.show', ':id') }}'.replace(':id', id);

            $.ajax({
                url: url,
                method: "GET",
                success: function(response) {
                    $('#siswa_id').val(response.data.id_siswa);
                    $('#show_nama_siswa').text(response.data.nama_siswa);
                    $('#show_kelas').text(response.data.kelas);
                    $('#show_status').text(response.data.status);
                    $('#container-tagihan').empty();

                    if (response.data.tagihan_siswa.length > 0) {
                        response.data.tagihan_siswa.forEach(function(tagihan, index) {
                            $('#container-tagihan').append(createTagihanRow(tagihan,
                                response.potongan, index + 1, response.data
                                .id_siswa));
                        });
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

        function createTagihanRow(tagihan, potongan, index, siswaId) {
            return `
        <div class="row mb-2 tagihan-row" data-tagihan-id="${tagihan.id_tagihan_siswa}">
            <div class="col-1 d-flex align-items-center justify-content-center">
                <h6 class="mb-0">${index}</h6>
            </div>
            <div class="col-11">
                <div class="row mb-1">
                    <div class="col-6">
                        <label class="form-label">Jenis Iuran</label>
                        <input type="text" class="form-control form-control-sm" name="jenis_iuran[]" value="${tagihan.iuran.nama_iuran}" readonly>
                        <input type="hidden" name="tagihan_siswa_id[]" value="${tagihan.id_tagihan_siswa}">
                        <input type="hidden" class="siswa-id" value="${siswaId}">
                    </div>
                    <div class="col-6">
                        <label class="form-label">Besar Iuran (Rp.)</label>
                        <input type="number" class="form-control form-control-sm" name="besar_iuran[]" value="${tagihan.iuran.besar_iuran}" readonly>
                    </div>
                </div>
                <div class="row text-center">
                    <h6 class="my-2">Pilih Potongan</h6>
                    ${potongan.map((pot) => {
                        const potonganAktif = tagihan.potongan_siswa.find(p => p.potongan_id === pot.id_potongan);
                        const isChecked = potonganAktif && potonganAktif.status === 'aktif' ? 'checked' : '';
                        const persenValue = potonganAktif ? potonganAktif.potongan_persen : '';
                        const readonlyAttr = potonganAktif && potonganAktif.status === 'aktif' ? '' : 'readonly';
                        const potonganSiswaId = potonganAktif ? potonganAktif.id_potongan_siswa : ''; // Corrected to use id_potongan_siswa

                        return `
                            <div class="col-auto">
                                <div class="form-check form-switch">
                                    <label class="form-check-label" for="potongan_${tagihan.id_tagihan_siswa}_${pot.id_potongan}">${pot.nama_potongan}</label>
                                    <input class="form-check-input potongan-checkbox" type="checkbox" role="switch" id="potongan_${tagihan.id_tagihan_siswa}_${pot.id_potongan}" ${isChecked} data-tagihan-id="${tagihan.id_tagihan_siswa}" data-potongan-siswa-id="${potonganSiswaId}" data-potongan-id="${pot.id_potongan}" data-from-response="${!!potonganAktif}" data-persentase-response="${persenValue !== ''}">
                                </div>
                                <div class="form-group">
                                    <label for="potongan_persen_${tagihan.id_tagihan_siswa}_${pot.id_potongan}" class="form-label">Besar Potongan (%)</label>
                                    <input type="number" class="form-control form-control-sm potongan_persen" name="potongan_persen[]" id="potongan_persen_${tagihan.id_tagihan_siswa}_${pot.id_potongan}" min="1" max="100" value="${persenValue}" ${readonlyAttr} required>
                                    <input type="hidden" name="potongan_siswa_id[]" value="${potonganSiswaId}">
                                </div>
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
        </div>`;
        }


        $('#container-tagihan').on('change', 'input.potongan-checkbox', function() {
            var isChecked = $(this).is(':checked');
            var persenInput = $(this).closest('.col-auto').find('input.potongan_persen');
            var fromResponse = $(this).data('from-response') === true;
            var hasPersenValue = $(this).data('persentase-response') === true;
            var tagihanId = $(this).data('tagihan-id');
            var potonganSiswaId = $(this).data('potongan-siswa-id');
            var potonganId = $(this).data('potongan-id');
            var self = $(this);

            if (isChecked) {
                persenInput.prop('readonly', false).attr('required', true).focus();

                var activeCheckbox = $(this).closest('.tagihan-row').find(
                    'input.potongan-checkbox[data-from-response=true]:checked'
                );

                if (activeCheckbox.length && !$(this).is(activeCheckbox)) {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin mengganti potongan? Potongan sebelumnya akan dinonaktifkan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('setting.potongan-siswa.update-status') }}',
                                method: 'POST',
                                data: {
                                    id_potongan_siswa: activeCheckbox.data(
                                        'potongan-siswa-id'),
                                    potongan_id: activeCheckbox.data('potongan-id')
                                },
                                success: function(response) {
                                    Swal.fire('Berhasil',
                                        'Potongan sebelumnya berhasil dinonaktifkan.',
                                        'success');

                                    // Uncheck the previous active checkbox and update its attributes
                                    activeCheckbox.prop('checked', false)
                                        .data('from-response', false)
                                        .data('persentase-response', false);
                                    activeCheckbox.closest('.col-auto').find(
                                            'input.potongan_persen')
                                        .prop('readonly', true).removeAttr(
                                            'required');

                                    // Set `self` as active
                                    self.prop('checked', true).data('from-response',
                                        true);
                                    persenInput.prop('readonly', false).attr(
                                        'required', true);
                                },
                                error: function() {
                                    Swal.fire('Error',
                                        'Gagal menonaktifkan potongan.', 'error'
                                    );
                                }
                            });
                        } else {
                            // Revert check state if user cancels
                            self.prop('checked', false);
                            persenInput.prop('readonly', true).removeAttr('required');
                            activeCheckbox.prop('checked', true);
                        }
                    });
                }
            } else {
                if (fromResponse) {
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: 'Apakah Anda yakin ingin menonaktifkan potongan pada tagihan ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('setting.potongan-siswa.update-status') }}',
                                method: 'POST',
                                data: {
                                    id_potongan_siswa: potonganSiswaId,
                                    potongan_id: potonganId
                                },
                                success: function(response) {
                                    Swal.fire('Berhasil',
                                        'Potongan berhasil dinonaktifkan.',
                                        'success');
                                },
                                error: function() {
                                    Swal.fire('Error',
                                        'Gagal menonaktifkan potongan.', 'error'
                                    );
                                }
                            });
                            persenInput.prop('readonly', true).removeAttr('required');
                        } else {
                            self.prop('checked', true);
                        }
                    });
                } else {
                    persenInput.prop('readonly', true).removeAttr('required');
                    if (!hasPersenValue) {
                        persenInput.val('');
                    }
                }
            }


            $(this).closest('.tagihan-row').find('input.potongan-checkbox').not(this).each(function() {
                var otherPersenInput = $(this).closest('.col-auto').find(
                    'input.potongan_persen');
                $(this).prop('checked', false);
                otherPersenInput.prop('readonly', true).removeAttr('required');
                if (!$(this).data('persentase-response')) {
                    otherPersenInput.val('');
                }
            });
        });


    });
</script>
