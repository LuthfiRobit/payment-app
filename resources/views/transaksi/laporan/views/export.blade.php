<!-- Modal Export -->
<div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalExportLabel">Export Data Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formExportData">
                    <!-- Tahun Akademik -->
                    <div class="mb-3">
                        <label for="tahunAkademik" class="form-label">Tahun Akademik</label>
                        <select id="tahunAkademik" class="selectpicker form-control wide form-select-md"
                            data-live-search="true" aria-describedby="instansi-feedback" data-size="5"
                            placeholder="Pilih tahun akademik" required>
                            @foreach ($tahunAkademik as $item)
                                <option value="{{ $item->id_tahun_akademik }}">{{ $item->tahun }} -
                                    {{ $item->semester }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bulan -->
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select id="bulan" class="selectpicker form-control wide form-select-md"
                            data-live-search="true" aria-describedby="instansi-feedback" data-size="5"
                            placeholder="Pilih bulan" required>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <!-- Informasi -->
                    <div class="alert alert-info">
                        Export hanya bisa dilakukan berdasarkan kombinasi <strong>Tahun Akademik dan Bulan</strong>.
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary" id="btnExportSubmit">Export</button>
            </div>
        </div>
    </div>
</div>
