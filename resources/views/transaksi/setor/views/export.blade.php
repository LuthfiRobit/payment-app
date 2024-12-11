<!-- Modal Export -->
<div class="modal fade" id="modalExport" tabindex="-1" aria-labelledby="modalExportLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalExportLabel">Export Data Setoran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formExportData">
                    <!-- Tahun Akademik -->
                    <div class="mb-3">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select id="tahun" class="selectpicker form-control wide form-select-md"
                            data-live-search="true" aria-describedby="instansi-feedback" data-size="6"
                            placeholder="Pilih tahun" required>
                            <option value="">Semua</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Bulan -->
                    <div class="mb-3">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select id="bulan" class="selectpicker form-control wide form-select-md"
                            data-live-search="true" aria-describedby="instansi-feedback" data-size="6"
                            placeholder="Pilih bulan">
                            <option value="">Semua</option>
                            @foreach ($months as $index => $month)
                                <option value="{{ $index }}">{{ $month }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Informasi -->
                    <div class="alert alert-info">
                        Export hanya bisa dilakukan berdasarkan kombinasi <strong>Tahun dan Bulan</strong>.
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
