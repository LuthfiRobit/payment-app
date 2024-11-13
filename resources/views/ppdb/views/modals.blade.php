<!--
  Modal-modals untuk edit data siswa, orang tua, status keluarga, dan wali
-->

<!-- Modal for Edit Data Siswa -->
<div class="modal fade" id="ModalEditSiswa" tabindex="-1" aria-labelledby="ModalEditSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditSiswaLabel">Edit Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form dengan ID spesifik -->
            <form id="formEditSiswa">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4 text-center">
                                <label for="foto_siswa" class="form-label required">Foto Siswa</label>
                                <div class="author-profile">
                                    <div class="author-media" style="position: relative; width: 200px; height: 250px;">
                                        <img src="{{ asset('template/images/no-img-avatar.png') }}" alt="Preview Foto"
                                            id="foto_siswa_preview" class="img-fluid"
                                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;" />
                                        <div class="upload-link" title="Update" data-toggle="tooltip"
                                            data-placement="right" data-original-title="Update"
                                            style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); border-radius: 50%;">
                                            <input type="file" class="update-file" id="foto_siswa" name="foto_siswa"
                                                accept="image/jpeg, image/png, image/jpg" onchange="previewPhoto(event)"
                                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;" />
                                            <label for="foto_siswa" style="cursor: pointer"><i
                                                    class="fas fa-camera"></i></label>
                                        </div>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Gunakan foto 3x4 dengan ukuran maksimum 2
                                    MB.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- NIK -->
                            <div class="mb-3">
                                <label for="nik" class="form-label required">NIK (sesuai KK)</label>
                                <input type="text" class="form-control" id="nik" name="nik"
                                    placeholder="eg. 0000000000000000" pattern="\d{16}" required />
                            </div>
                            <!-- Nama Lengkap dan Nama Panggilan -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="nama_lengkap_siswa" class="form-label required">Nama Lengkap
                                            Siswa</label>
                                        <input type="text" class="form-control" id="nama_lengkap_siswa"
                                            name="nama_lengkap_siswa" placeholder="eg. Luthfi" required />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nama_panggilan" class="form-label required">Nama Panggilan</label>
                                        <input type="text" class="form-control" id="nama_panggilan"
                                            name="nama_panggilan" placeholder="eg. Lutfi" required />
                                    </div>
                                </div>
                            </div>
                            <!-- Tempat Lahir dan Tanggal Lahir -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label required">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                            placeholder="eg. Probolinggo" required />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir"
                                            name="tanggal_lahir" required />
                                    </div>
                                </div>
                            </div>
                            <!-- Jenis Kelamin -->
                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                                <select class="selectpicker form-control form-select-md" data-live-search="false"
                                    aria-describedby="instansi-feedback" id="jenis_kelamin" name="jenis_kelamin"
                                    required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki">Laki-laki</option>
                                    <option value="perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Usia Saat Mendaftar dan Jumlah Saudara -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="usia_saat_mendaftar" class="form-label required">Usia saat
                                            mendaftar</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="usia_saat_mendaftar"
                                                name="usia_saat_mendaftar" placeholder="eg. 6" min="1"
                                                required />
                                            <span class="input-group-text">tahun</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jumlah_saudara" class="form-label required">Jumlah Saudara</label>
                                        <input type="number" class="form-control" id="jumlah_saudara"
                                            name="jumlah_saudara" placeholder="eg. 2" min="0" required />
                                    </div>
                                </div>
                            </div>

                            <!-- Anak ke dan Nomor Peci -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="anak_ke" class="form-label required">Anak ke</label>
                                        <input type="number" class="form-control" id="anak_ke" name="anak_ke"
                                            placeholder="eg. 1" min="1" required />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="nomor_peci" class="form-label">Nomor Songkok/Peci</label>
                                        <select class="selectpicker form-control form-select-md"
                                            data-live-search="true" data-size="5"
                                            aria-describedby="instansi-feedback" id="nomor_peci" name="nomor_peci">
                                            <option value="">Pilih Nomor</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Nomor HP/WA dan Email -->
                            <div class="mb-3">
                                <label for="nomor_hp_wa" class="form-label required">Nomor HP/WA</label>
                                <input type="tel" class="form-control" id="nomor_hp_wa" name="nomor_hp_wa"
                                    placeholder="eg. 081234567890" pattern="^\d{10,15}$" required />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label required">Alamat Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="eg. example@mail.com" required />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Jarak dari Rumah dan Perjalanan ke Sekolah -->
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="jarak_dari_rumah_ke_sekolah" class="form-label required">Jarak
                                            dari rumah ke sekolah</label>
                                        <div class="input-group">
                                            <input type="number" class="form-control"
                                                id="jarak_dari_rumah_ke_sekolah" name="jarak_dari_rumah_ke_sekolah"
                                                placeholder="eg. 1" min="0" required />
                                            <span class="input-group-text">km</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="perjalanan_ke_sekolah" class="form-label required">Perjalanan ke
                                            sekolah</label>
                                        <select class="selectpicker form-control form-select-md"
                                            data-live-search="true" data-size="5"
                                            aria-describedby="instansi-feedback" id="perjalanan_ke_sekolah"
                                            name="perjalanan_ke_sekolah" required>
                                            <option value="">Pilih Cara Perjalanan</option>
                                            <option value="jalan_kaki">Jalan Kaki</option>
                                            <option value="sepeda">Bersepeda</option>
                                            <option value="motor">Naik Motor</option>
                                            <option value="mobil">Naik Mobil</option>
                                            <option value="angkot">Naik Angkot</option>
                                            <option value="ojek">Naik Ojek</option>
                                            <option value="lainnya">Lainnya</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Sekolah Sebelum MI, Nama RA/TK, Alamat, dan Imunisasi -->
                            <div class="mb-3">
                                <label for="sekolah_sebelum_mi" class="form-label required">Sekolah sebelum MI</label>
                                <input type="text" class="form-control" id="sekolah_sebelum_mi"
                                    name="sekolah_sebelum_mi" placeholder="eg. TK Aisyiyah" />
                            </div>
                            <div class="mb-3">
                                <label for="nama_ra_tk" class="form-label required">Nama RA/TK</label>
                                <input type="text" class="form-control" id="nama_ra_tk" name="nama_ra_tk"
                                    placeholder="eg. RA Bintang" required />
                            </div>
                            <div class="mb-3">
                                <label for="alamat_ra_tk" class="form-label required">Alamat RA/TK</label>
                                <input type="text" class="form-control" id="alamat_ra_tk" name="alamat_ra_tk"
                                    placeholder="eg. Jl. Merdeka No.1" required />
                            </div>
                            <div class="mb-3">
                                <label for="imunisasi" class="form-label required">Imunisasi yang telah
                                    diikuti</label>
                                <select class="selectpicker form-control form-select-md" data-live-search="true"
                                    data-size="5" aria-describedby="instansi-feedback" id="imunisasi"
                                    name="imunisasi[]" multiple required>
                                    <option value="bCG">BCG</option>
                                    <option value="dTP">DPT</option>
                                    <option value="polio">Polio</option>
                                    <option value="campak">Campak</option>
                                    <option value="hepatitisB">Hepatitis B</option>
                                </select>

                                <small class="form-text text-muted">Tekan Ctrl untuk memilih lebih dari satu.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer dengan tombol cancel dan save -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="formEditSiswa" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Edit Data Orang Tua -->
<div class="modal fade" id="ModalEditOrtu" tabindex="-1" aria-labelledby="ModalEditOrtuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditOrtuLabel">
                    Edit Data Orang Tua
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form dengan ID spesifik untuk Data Orang Tua -->
            <form id="formEditOrtu">
                <div class="modal-body">
                    <!-- Data Ayah -->
                    <div class="row mb-3">
                        <div class="col">
                            <h5>Data Ayah</h5>
                            <div class="mb-3">
                                <label for="nama_ayah_kandung" class="form-label required">Nama Ayah Kandung</label>
                                <input type="text" class="form-control" id="nama_ayah_kandung"
                                    name="nama_ayah_kandung" placeholder="eg. Budi" required />
                            </div>
                            <div class="mb-3">
                                <label for="status_ayah_kandung" class="form-label required">Status Ayah
                                    Kandung</label>
                                <input type="text" class="form-control" id="status_ayah_kandung"
                                    name="status_ayah_kandung" placeholder="eg. Hidup" required />
                            </div>
                            <div class="mb-3">
                                <label for="nik_ayah" class="form-label required">NIK Ayah</label>
                                <input type="text" class="form-control" id="nik_ayah" name="nik_ayah"
                                    placeholder="eg. 0000000000000000" pattern="\d{16}" required />
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir_ayah" class="form-label required">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir_ayah"
                                    name="tempat_lahir_ayah" placeholder="eg. Probolinggo" required />
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir_ayah" class="form-label required">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir_ayah"
                                    name="tanggal_lahir_ayah" required />
                            </div>
                            <div class="mb-3">
                                <label for="pendidikan_terakhir_ayah" class="form-label required">Pendidikan
                                    Terakhir</label>
                                <select class="selectpicker form-control form-select-md" data-live-search="true"
                                    data-size="5" aria-describedby="instansi-feedback" id="pendidikan_terakhir_ayah"
                                    name="pendidikan_terakhir_ayah" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="sarjana">Sarjana</option>
                                    <option value="pascaSarjana">Pasca Sarjana</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_ayah" class="form-label required">Pekerjaan Ayah</label>
                                <select class="selectpicker form-control form-select-md" data-live-search="true"
                                    data-size="5" aria-describedby="instansi-feedback" id="pekerjaan_ayah"
                                    name="pekerjaan_ayah" required>
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="pegawaiNegeri">Pegawai Negeri</option>
                                    <option value="swasta">Swasta</option>
                                    <option value="wiraswasta">Wiraswasta</option>
                                    <option value="buruh">Buruh</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="penghasilan_per_bulan_ayah" class="form-label required">Penghasilan per
                                    bulan (IDR)</label>
                                <input type="number" class="form-control" id="penghasilan_per_bulan_ayah"
                                    name="penghasilan_per_bulan_ayah" placeholder="eg. 2000000" min="0"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label for="alamat_ayah" class="form-label required">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" rows="3"
                                    placeholder="eg. Jl. Kebangsaan No.10" required></textarea>
                            </div>
                            <div class="mb-3">
                                <!-- Foto KTP Ayah -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Label Foto KTP Ayah -->
                                    <label for="scan_ktp_ayah" class="form-label">Foto KTP Ayah (Lurus dan
                                        jelas)</label>

                                    <!-- Preview Foto KTP Ayah jika ada -->
                                    <span id="ktp-ayah-preview" style="display: none;">
                                        <a href="#" id="view-ktp-ayah" target="_blank"
                                            class="text-decoration-none">
                                            <i class="fas fa-eye"></i> Lihat Foto
                                        </a>
                                    </span>
                                </div>
                                <!-- Input Foto KTP Ayah (Tidak required) -->
                                <input type="file" class="form-control" id="scan_ktp_ayah" name="scan_ktp_ayah"
                                    accept="image/jpeg, image/png, image/jpg" />
                            </div>
                        </div>

                        <!-- Data Ibu -->
                        <div class="col">
                            <h5>Data Ibu</h5>
                            <div class="mb-3">
                                <label for="nama_ibu_kandung" class="form-label required">Nama Ibu Kandung</label>
                                <input type="text" class="form-control" id="nama_ibu_kandung"
                                    name="nama_ibu_kandung" placeholder="eg. Siti" required />
                            </div>
                            <div class="mb-3">
                                <label for="status_ibu_kandung" class="form-label required">Status Ibu Kandung</label>
                                <input type="text" class="form-control" id="status_ibu_kandung"
                                    name="status_ibu_kandung" placeholder="eg. Hidup" required />
                            </div>
                            <div class="mb-3">
                                <label for="nik_ibu" class="form-label required">NIK Ibu</label>
                                <input type="text" class="form-control" id="nik_ibu" name="nik_ibu"
                                    placeholder="eg. 0000000000000000" pattern="\d{16}" required />
                            </div>
                            <div class="mb-3">
                                <label for="tempat_lahir_ibu" class="form-label required">Tempat Lahir</label>
                                <input type="text" class="form-control" id="tempat_lahir_ibu"
                                    name="tempat_lahir_ibu" placeholder="eg. Probolinggo" required />
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_lahir_ibu" class="form-label required">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tanggal_lahir_ibu"
                                    name="tanggal_lahir_ibu" required />
                            </div>
                            <div class="mb-3">
                                <label for="pendidikan_terakhir_ibu" class="form-label required">Pendidikan
                                    Terakhir</label>
                                <select class="selectpicker form-control form-select-md" data-live-search="true"
                                    data-size="5" aria-describedby="instansi-feedback" id="pendidikan_terakhir_ibu"
                                    name="pendidikan_terakhir_ibu" required>
                                    <option value="">Pilih Pendidikan</option>
                                    <option value="sd">SD</option>
                                    <option value="smp">SMP</option>
                                    <option value="sma">SMA</option>
                                    <option value="diploma">Diploma</option>
                                    <option value="sarjana">Sarjana</option>
                                    <option value="pascaSarjana">Pasca Sarjana</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="pekerjaan_ibu" class="form-label required">Pekerjaan</label>
                                <select class="selectpicker form-control form-select-md" data-live-search="true"
                                    data-size="5" aria-describedby="instansi-feedback" id="pekerjaan_ibu"
                                    name="pekerjaan_ibu" required>
                                    <option value="">Pilih Pekerjaan</option>
                                    <option value="ibuRumahTangga">Ibu Rumah Tangga</option>
                                    <option value="guru">Guru</option>
                                    <option value="pegawaiNegeri">Pegawai Negeri</option>
                                    <option value="swasta">Swasta</option>
                                    <option value="wiraswasta">Wiraswasta</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="penghasilan_per_bulan_ibu" class="form-label required">Penghasilan per
                                    bulan (IDR)</label>
                                <input type="number" class="form-control" id="penghasilan_per_bulan_ibu"
                                    name="penghasilan_per_bulan_ibu" placeholder="eg. 2000000" min="0"
                                    required />
                            </div>
                            <div class="mb-3">
                                <label for="alamat_ibu" class="form-label">Alamat Ibu</label>
                                <textarea class="form-control" id="alamat_ibu" name="alamat_ibu" rows="3"
                                    placeholder="eg. Jl. Kebangsaan No.10"></textarea>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Label Foto KTP Ibu -->
                                    <label for="scan_ktp_ibu" class="form-label">Foto KTP Ibu (Lurus dan
                                        jelas)</label>

                                    <!-- Preview Foto KTP Ibu jika ada -->
                                    <span id="ktp-ibu-preview" style="display: none;">
                                        <a href="#" id="view-ktp-ibu" target="_blank"
                                            class="text-decoration-none">
                                            <i class="fas fa-eye"></i> Lihat Foto
                                        </a>
                                    </span>
                                </div>
                                <!-- Input Foto KTP Ibu (Tidak required) -->
                                <input type="file" class="form-control" id="scan_ktp_ibu" name="scan_ktp_ibu"
                                    accept="image/jpeg, image/png, image/jpg" />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer Modal -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="formEditOrtu" class="btn btn-primary">Save Change</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Edit Status Keluarga -->
<div class="modal fade" id="ModalEditStatus" tabindex="-1" aria-labelledby="ModalEditStatusLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditStatusLabel">
                    Edit Status Keluarga
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form dengan ID spesifik untuk Status Keluarga -->
            <form id="formEditStatus">
                <div class="modal-body">
                    <!-- Nama Kepala Keluarga -->
                    <div class="mb-3">
                        <label for="nama_kepala_keluarga" class="form-label required">Nama Kepala Keluarga</label>
                        <input type="text" class="form-control" id="nama_kepala_keluarga"
                            name="nama_kepala_keluarga" placeholder="eg. Ahmad" required />
                    </div>

                    <!-- Nomor KK -->
                    <div class="mb-3">
                        <label for="nomor_kk" class="form-label required">Nomor KK</label>
                        <input type="text" class="form-control" id="nomor_kk" name="nomor_kk"
                            placeholder="eg. 0000000000000000" pattern="\d{16}" required />
                    </div>

                    <!-- Alamat Rumah -->
                    <div class="mb-3">
                        <label for="alamat_rumah" class="form-label required">Alamat Rumah</label>
                        <textarea class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3"
                            placeholder="eg. Jl. Kebangsaan No.10" required></textarea>
                    </div>

                    <!-- Yang Membiayai Sekolah -->
                    <div class="mb-3">
                        <label for="yang_membiayai_sekolah" class="form-label required">Yang Membiayai Sekolah</label>
                        <select class="selectpicker form-control form-select-md" data-live-search="false"
                            aria-describedby="instansi-feedback" id="yang_membiayai_sekolah"
                            name="yang_membiayai_sekolah" required>
                            <option value="">Pilih yang membiayai</option>
                            <option value="ayah">Ayah</option>
                            <option value="ibu">Ibu</option>
                            <option value="wali">Wali</option>
                        </select>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="formEditStatus" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Edit Data Wali -->
<div class="modal fade" id="ModalEditWali" tabindex="-1" aria-labelledby="ModalEditWaliLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditWaliLabel">Edit Data Wali</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form untuk Edit Data Wali -->
            <form id="formEditWali" enctype="multipart/form-data">
                <div class="modal-body">
                    <!-- Nama Wali -->
                    <div class="mb-3">
                        <label for="nama_wali" class="form-label">Nama Wali (diisi jika yang mengurus bukan orang
                            tua)</label>
                        <input type="text" class="form-control" id="nama_wali" name="nama_wali"
                            placeholder="eg. Rahmat" />
                    </div>

                    <!-- Scan KK Wali -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="scan_kk_wali" class="form-label">Scan KK Wali (jika ada)</label>
                            <span id="scan-kk-wali-preview" style="display: none;">
                                <a href="#" id="view-kk-wali" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-eye"></i> Lihat Foto KK Wali
                                </a>
                            </span>
                        </div>
                        <input type="file" class="form-control" id="scan_kk_wali" name="scan_kk_wali"
                            accept="image/jpeg, image/png, image/jpg" />
                    </div>

                    <!-- Scan Kartu PKH -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="scan_kartu_pkh" class="form-label">Scan Kartu PKH (jika ada)</label>
                            <span id="scan-kartu-pkh-preview" style="display: none;">
                                <a href="#" id="view-kartu-pkh" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-eye"></i> Lihat Kartu PKH
                                </a>
                            </span>
                        </div>
                        <input type="file" class="form-control" id="scan_kartu_pkh" name="scan_kartu_pkh"
                            accept="image/jpeg, image/png, image/jpg" />
                    </div>

                    <!-- Scan Kartu KKS -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label for="scan_kartu_kks" class="form-label">Scan Kartu KKS (jika ada)</label>
                            <span id="scan-kartu-kks-preview" style="display: none;">
                                <a href="#" id="view-kartu-kks" target="_blank" class="text-decoration-none">
                                    <i class="fas fa-eye"></i> Lihat Kartu KKS
                                </a>
                            </span>
                        </div>
                        <input type="file" class="form-control" id="scan_kartu_kks" name="scan_kartu_kks"
                            accept="image/jpeg, image/png, image/jpg" />
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="formEditWali" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Edit Status -->
<div class="modal fade" id="ModalEditStatusSiswa" tabindex="-1" aria-labelledby="ModalEditStatusLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalEditStatusLabel">Edit Status Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Form untuk Edit Status -->
            <form id="formEditStatusSiswa">
                <div class="modal-body">
                    <!-- Nama Lengkap dan Nama Panggilan -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="nama_lengkap_siswa" class="form-label">Nama Lengkap
                                    Siswa</label>
                                <input type="text" class="form-control" id="nama_lengkap_siswa"
                                    name="nama_lengkap_siswa" placeholder="eg. Luthfi" disabled />
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Saat Ini</label>
                                <input type="text" class="form-control" id="status" name="status"
                                    placeholder="eg. Diterima" disabled />
                            </div>
                        </div>
                    </div>

                    <!-- Status Siswa -->
                    <div class="mb-3">
                        <label for="status_siswa" class="form-label required">Status</label>
                        <select class="selectpicker form-control wide form-select-md" data-live-search="false"
                            aria-describedby="instansi-feedback" placeholder="Pilih status" id="status_siswa"
                            name="status_siswa" required>
                            <option value="diterima">DITERIMA</option>
                            <option value="ditolak">DITOLAK</option>
                        </select>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal for Export -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Data Siswa Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="exportForm">
                    <!-- Informasi Tentang Data Siswa Baru -->
                    <div class="mb-4">
                        <h5 class="text-primary"><i class="bi bi-person-bounding-box"></i> Default Data Siswa Baru
                        </h5>
                        <p>Data berikut akan selalu disertakan dalam ekspor: Nama lengkap, Jenis Kelamin, Tanggal Lahir,
                            Email, dan Nomor HP.</p>
                    </div>

                    <!-- Pilihan Data Tambahan -->
                    <div class="mb-4">
                        <span class="text-muted">Pilih Data Tambahan yang Ingin Diekspor:</span>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_ibu" id="includeIbu">
                                <label class="form-check-label" for="includeIbu">
                                    <i class="bi bi-person-lines-fill text-warning"></i> Data Ibu
                                </label>
                                <span class="form-text text-muted">Informasi mengenai ibu kandung, status, pekerjaan,
                                    dan alamat.</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_ayah"
                                    id="includeAyah">
                                <label class="form-check-label" for="includeAyah">
                                    <i class="bi bi-person-fill text-success"></i> Data Ayah
                                </label>
                                <small class="form-text text-muted">Informasi mengenai ayah kandung, status, pekerjaan,
                                    dan alamat.</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_wali"
                                    id="includeWali">
                                <label class="form-check-label" for="includeWali">
                                    <i class="bi bi-person-fill-lock text-info"></i> Data Wali
                                </label>
                                <small class="form-text text-muted">Data wali siswa, seperti nama, status, dan dokumen
                                    terkait.</small>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="include_keluarga"
                                    id="includeKeluarga">
                                <label class="form-check-label" for="includeKeluarga">
                                    <i class="bi bi-house-door-fill text-danger"></i> Data Keluarga
                                </label>
                                <small class="form-text text-muted">Informasi keluarga, termasuk kepala keluarga dan
                                    yang membiayai sekolah.</small>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="submitExport">Ekspor</button>
            </div>
        </div>
    </div>
</div>
