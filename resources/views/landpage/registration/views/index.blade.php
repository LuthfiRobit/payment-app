@extends('layouts.landpageApp')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
@endsection

@section('content')
    @php
        $currentDate = \Carbon\Carbon::now();
        $activeYear = \App\Helpers\AppHelper::getActiveAcademicYear();
        $activeSetting = \App\Helpers\AppHelper::getSettingPendaftaran();
        $startDate = \Carbon\Carbon::parse($activeSetting->tanggal_mulai ?? null);
        $endDate = \Carbon\Carbon::parse($activeSetting->tanggal_selesai ?? null);
    @endphp

    <!-- Container start -->
    <div class="container-large">
        <div class="custom-banner-image-section position-relative">
            <div class="custom-image">
                <img src="{{ asset('template/images/sidebar-img/3.jpg') }}" class="img-fluid w-100" alt="Banner Image">
                <div
                    class="custom-overlay position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center text-white">
                    <div class="custom-text-content text-center">
                        <h3 class="fw-bold fw-light">Pendaftaran Peserta Didik Baru</h3>
                        <span class="d-block mb-3">Daftarkan anak Anda untuk bergabung dengan Madrasah Ibtidaiyah
                            Ihyauddiniyah</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3 mt-4">
            <div class="container">
                @if ($activeSetting && $currentDate->between($startDate, $endDate))
                    <div class="card">
                        <div class="card-header d-sm-flex d-block border-0 flex-wrap">
                            <div class="pr-3 me-auto mb-sm-0 mb-3">
                                <h4 class="fs-20 text-black mb-1">Registrasi Siswa Baru</h4>
                                <span class="fs-12">Silakan mengisi data dengan lengkap dan sesuai.</span>
                                <span class="fs-12">Tanggal pendaftaran antara {{ $startDate->translatedFormat('d F Y') }}
                                    -
                                    {{ $endDate->translatedFormat('d F Y') }}</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between gap-1"></div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-primary">
                                <strong>Penting!</strong> Data yang perlu diinputkan meliputi:
                                <ul>
                                    <li>Data Diri Siswa</li>
                                    <li>Data Orang Tua</li>
                                    <li>Status Keluarga</li>
                                    <li>Data Wali</li>
                                </ul>
                                Pastikan semua data yang diinputkan sesuai dengan kenyataan
                                agar proses registrasi berjalan lancar.
                            </div>

                            <form id="studentForm">
                                <div class="alert alert-primary">
                                    <strong>Informasi Pengisian:</strong> Harap isi data dengan
                                    lengkap dan sesuai dengan dokumen resmi. Jika data kosong,
                                    silakan isi dengan tanda <strong>(-)</strong>.
                                </div>

                                <h4>Data Siswa</h4>
                                <p>Isilah data siswa berikut:</p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4 text-center">
                                            <label for="foto_siswa" class="form-label required">Foto Siswa</label>
                                            <div class="author-profile">
                                                <div class="author-media"
                                                    style=" position: relative; width: 200px;height: 250px;">
                                                    <img src="{{ asset('template/images/no-img-avatar.png') }}"
                                                        alt="Preview Foto" id="foto_siswa_preview" class="img-fluid"
                                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;" />
                                                    <div class="upload-link" title="Update" data-toggle="tooltip"
                                                        data-placement="right" data-original-title="Update"
                                                        style=" position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); border-radius: 50%; ">
                                                        <input type="file" class="update-file" id="foto_siswa"
                                                            name="foto_siswa" accept="image/jpeg, image/png, image/jpg"
                                                            onchange="previewPhoto(event)"
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
                                        <div class="mb-3">
                                            <label for="nik" class="form-label required">NIK (sesuai KK)</label>
                                            <input type="text" class="form-control" id="nik" name="nik"
                                                placeholder="eg. 0000000000000000" pattern="\d{16}" required />
                                        </div>
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
                                                    <label for="nama_panggilan" class="form-label required">Nama
                                                        Panggilan</label>
                                                    <input type="text" class="form-control" id="nama_panggilan"
                                                        name="nama_panggilan" placeholder="eg. Lutfi" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="tempat_lahir" class="form-label required">Tempat
                                                        Lahir</label>
                                                    <input type="text" class="form-control" id="tempat_lahir"
                                                        name="tempat_lahir" placeholder="eg. Probolinggo" required />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="tanggal_lahir" class="form-label required">Tanggal
                                                        Lahir</label>
                                                    <input type="date" class="form-control" id="tanggal_lahir"
                                                        name="tanggal_lahir" required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin"
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
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="usia_saat_mendaftar" class="form-label required">Usia saat
                                                        mendaftar</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            id="usia_saat_mendaftar" name="usia_saat_mendaftar"
                                                            placeholder="eg. 6" min="1" required />
                                                        <span class="input-group-text">tahun</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="jumlah_saudara" class="form-label required">Jumlah
                                                        Saudara</label>
                                                    <input type="number" class="form-control" id="jumlah_saudara"
                                                        name="jumlah_saudara" placeholder="eg. 2" min="0"
                                                        required />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="anak_ke" class="form-label required">Anak ke</label>
                                                    <input type="number" class="form-control" id="anak_ke"
                                                        name="anak_ke" placeholder="eg. 1" min="1" required />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="nomor_peci" class="form-label">Nomor
                                                        Songkok/Peci</label>
                                                    <select class="form-control" id="nomor_peci" name="nomor_peci">
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

                                        <div class="mb-3">
                                            <label for="nomor_hp_wa" class="form-label required">Nomor HP/WA</label>
                                            <input type="tel" class="form-control" id="nomor_hp_wa"
                                                name="nomor_hp_wa" placeholder="eg. 081234567890" pattern="^\d{10,15}$"
                                                required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label required">Alamat Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="eg. example@mail.com" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="jarak_dari_rumah_ke_sekolah"
                                                        class="form-label required">Jarak
                                                        dari rumah
                                                        ke sekolah</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control"
                                                            id="jarak_dari_rumah_ke_sekolah"
                                                            name="jarak_dari_rumah_ke_sekolah" placeholder="eg. 1"
                                                            min="0" required />
                                                        <span class="input-group-text">km</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-3">
                                                    <label for="perjalanan_ke_sekolah"
                                                        class="form-label required">Perjalanan
                                                        ke sekolah</label>
                                                    <select class="form-control" id="perjalanan_ke_sekolah"
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

                                        <div class="mb-3">
                                            <label for="sekolah_sebelum_mi" class="form-label required">Sekolah sebelum
                                                MI</label>
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
                                            <input type="text" class="form-control" id="alamat_ra_tk"
                                                name="alamat_ra_tk" placeholder="eg. Jl. Merdeka No.1" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="imunisasi" class="form-label required">Imunisasi yang telah
                                                diikuti</label>
                                            <select class="form-control" id="imunisasi" name="imunisasi[]" multiple
                                                required>
                                                <option value="bCG">BCG</option>
                                                <option value="dTP">DPT</option>
                                                <option value="polio">Polio</option>
                                                <option value="campak">Campak</option>
                                                <option value="hepatitisB">Hepatitis B</option>
                                            </select>
                                            <small class="form-text text-muted">Tekan Ctrl untuk memilih lebih dari
                                                satu.</small>
                                        </div>
                                    </div>
                                </div>

                                <hr />

                                <h4>Data Orang Tua</h4>
                                <p>Isilah data orang tua berikut:</p>
                                <div class="row mb-3">
                                    <div class="col">
                                        <h5>Data Ayah</h5>
                                        <div class="mb-3">
                                            <label for="nama_ayah_kandung" class="form-label required">Nama Ayah
                                                Kandung</label>
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
                                            <label for="tempat_lahir_ayah" class="form-label required">Tempat
                                                Lahir</label>
                                            <input type="text" class="form-control" id="tempat_lahir_ayah"
                                                name="tempat_lahir_ayah" placeholder="eg. Probolinggo" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="tanggal_lahir_ayah" class="form-label required">Tanggal
                                                Lahir</label>
                                            <input type="date" class="form-control" id="tanggal_lahir_ayah"
                                                name="tanggal_lahir_ayah" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="pendidikan_terakhir_ayah" class="form-label required">Pendidikan
                                                Terakhir</label>
                                            <select class="form-control" id="pendidikan_terakhir_ayah"
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
                                            <select class="form-control" id="pekerjaan_ayah" name="pekerjaan_ayah"
                                                required>
                                                <option value="">Pilih Pekerjaan</option>
                                                <option value="pegawaiNegeri">Pegawai Negeri</option>
                                                <option value="swasta">Swasta</option>
                                                <option value="wiraswasta">Wiraswasta</option>
                                                <option value="buruh">Buruh</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="penghasilan_per_bulan_ayah"
                                                class="form-label required">Penghasilan
                                                per bulan (IDR)</label>
                                            <input type="number" class="form-control" id="penghasilan_per_bulan_ayah"
                                                name="penghasilan_per_bulan_ayah" placeholder="eg. 2000000"
                                                min="0" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_ayah" class="form-label required">Alamat Lengkap</label>
                                            <textarea class="form-control" id="alamat_ayah" name="alamat_ayah" rows="3"
                                                placeholder="eg. Jl. Kebangsaan No.10" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="scan_ktp_ayah" class="form-label required">Foto KTP Ayah (Lurus
                                                dan
                                                jelas)</label>
                                            <input type="file" class="form-control" id="scan_ktp_ayah"
                                                name="scan_ktp_ayah" accept="image/jpeg, image/png, image/jpg" required />
                                        </div>
                                    </div>

                                    <div class="col">
                                        <h5>Data Ibu</h5>
                                        <div class="mb-3">
                                            <label for="nama_ibu_kandung" class="form-label required">Nama Ibu
                                                Kandung</label>
                                            <input type="text" class="form-control" id="nama_ibu_kandung"
                                                name="nama_ibu_kandung" placeholder="eg. Siti" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="status_ibu_kandung" class="form-label required">Status Ibu
                                                Kandung</label>
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
                                            <label for="tanggal_lahir_ibu" class="form-label required">Tanggal
                                                Lahir</label>
                                            <input type="date" class="form-control" id="tanggal_lahir_ibu"
                                                name="tanggal_lahir_ibu" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="pendidikan_terakhir_ibu" class="form-label required">Pendidikan
                                                Terakhir</label>
                                            <select class="form-control" id="pendidikan_terakhir_ibu"
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
                                            <select class="form-control" id="pekerjaan_ibu" name="pekerjaan_ibu"
                                                required>
                                                <option value="">Pilih Pekerjaan</option>
                                                <option value="ibuRumahTangga">
                                                    Ibu Rumah Tangga
                                                </option>
                                                <option value="guru">Guru</option>
                                                <option value="pegawaiNegeri">Pegawai Negeri</option>
                                                <option value="swasta">Swasta</option>
                                                <option value="wiraswasta">Wiraswasta</option>
                                                <option value="lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="penghasilan_per_bulan_ibu" class="form-label required">Penghasilan
                                                per
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
                                            <label for="scan_ktp_ibu" class="form-label required">Foto KTP Ibu (Lurus dan
                                                jelas)</label>
                                            <input type="file" class="form-control" id="scan_ktp_ibu"
                                                name="scan_ktp_ibu" accept="image/jpeg, image/png, image/jpg" required />
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="row mb-3">
                                    <div class="col">
                                        <h4>Status Keluarga</h4>
                                        <div class="mb-3">
                                            <label for="nama_kepala_keluarga" class="form-label required">Nama Kepala
                                                Keluarga</label>
                                            <input type="text" class="form-control" id="nama_kepala_keluarga"
                                                name="nama_kepala_keluarga" placeholder="eg. Ahmad" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor_kk" class="form-label required">Nomor KK</label>
                                            <input type="text" class="form-control" id="nomor_kk" name="nomor_kk"
                                                placeholder="eg. 0000000000000000" pattern="\d{16}" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_rumah" class="form-label required">Alamat Rumah</label>
                                            <textarea class="form-control" id="alamat_rumah" name="alamat_rumah" rows="3"
                                                placeholder="eg. Jl. Kebangsaan No.10" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="yang_membiayai_sekolah" class="form-label required">Yang Membiayai
                                                Sekolah</label>
                                            <select class="form-control" id="yang_membiayai_sekolah"
                                                name="yang_membiayai_sekolah" required>
                                                <option value="">Pilih yang membiayai</option>
                                                <option value="ayah">Ayah</option>
                                                <option value="ibu">Ibu</option>
                                                <option value="wali">Wali</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <h4>Data Wali</h4>
                                        <div class="mb-3">
                                            <label for="nama_wali" class="form-label">Nama Wali (diisi jika yang mengurus
                                                bukan orang
                                                tua)</label>
                                            <input type="text" class="form-control" id="nama_wali" name="nama_wali"
                                                placeholder="eg. Rahmat" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="scan_kk_wali" class="form-label">Scan KK Wali (jika ada)</label>
                                            <input type="file" class="form-control" id="scan_kk_wali"
                                                name="scan_kk_wali" accept="image/jpeg, image/png, image/jpg" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="scan_kartu_pkh" class="form-label">Scan Kartu PKH (jika
                                                ada)</label>
                                            <input type="file" class="form-control" id="scan_kartu_pkh"
                                                name="scan_kartu_pkh" accept="image/jpeg, image/png, image/jpg" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="scan_kartu_kks" class="form-label">Scan Kartu KKS (jika
                                                ada)</label>
                                            <input type="file" class="form-control" id="scan_kartu_kks"
                                                name="scan_kartu_kks" accept="image/jpeg, image/png, image/jpg" />
                                        </div>
                                    </div>
                                </div>
                                <hr />

                                <div class="alert alert-warning" role="alert">
                                    <strong>Penting!</strong> Semua data wajib diisi sesuai
                                    dengan kenyataan.
                                </div>

                                <div class="alert alert-info text-center" role="alert">
                                    <strong>Apakah semua data sudah sesuai?</strong>
                                    <br />
                                    <button type="submit" id="submitButton" class="btn btn-primary mb-1"> Ya, Simpan
                                        Data
                                    </button> <button type="button" class="btn btn-danger"> Tidak, Periksa Kembali
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-primary">
                        <strong>Info!</strong> Pendaftaran belum dibuka, silahkan hubungi admin
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Container end -->

    {{-- @include('main.dashboard.views.create') --}}
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('landpage.registration.scripts.picture')
    @include('landpage.registration.scripts.store')
@endsection
