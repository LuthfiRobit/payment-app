<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();

        // Fungsi untuk menangani klik pada item dropdown Aksi
        $('#example').on('click', '.dropdown-item', function() {
            var action = $(this).data('action'); // Mendapatkan aksi yang dipilih
            var siswaId = $(this).data('id'); // Mendapatkan id_siswa_baru
            var status = $(this).data('status'); // Jika ada data-status untuk Edit Status

            // Cek action dan tampilkan modal yang sesuai
            switch (action) {
                case 'edit_siswa':
                    var url = '{{ route('ppdb.show.siswa', ':id') }}'.replace(':id', siswaId);
                    showDataSiswa(url, '#formEditSiswa', '#ModalEditSiswa', siswaId);
                    break;
                case 'edit_ortu':
                    var url = '{{ route('ppdb.show.ortu', ':id') }}'.replace(':id', siswaId);
                    showDataOrtu(url, '#formEditOrtu', '#ModalEditOrtu', siswaId);
                    break;
                case 'edit_keluarga':
                    var url = '{{ route('ppdb.show.keluarga', ':id') }}'.replace(':id', siswaId);
                    showDataKeluarga(url, '#formEditStatus', '#ModalEditStatus', siswaId);
                    break;
                case 'edit_wali':
                    var url = '{{ route('ppdb.show.wali', ':id') }}'.replace(':id', siswaId);
                    showDataWali(url, '#formEditWali', '#ModalEditWali', siswaId);
                    break;
                case 'edit_status':
                    var url = '{{ route('ppdb.show.siswa', ':id') }}'.replace(':id', siswaId);
                    showDataStatus(url, '#formEditStatusSiswa', '#ModalEditStatusSiswa', siswaId);
                    break;
                default:
                    break;
            }
        });

        // Fungsi umum untuk mereset form dan elemen terkait saat modal ditutup
        function resetForm(formId, modalId) {
            // Reset input form
            $(formId)[0].reset();
            // Refresh selectpicker
            $(formId).find('.selectpicker').selectpicker('refresh');
            // Hapus validasi error feedback
            $(formId).find('.invalid-feedback').remove();
            // Hapus class invalid dari form-control
            $(formId).find('.form-control').removeClass('is-invalid');
            // Kosongkan pratinjau foto jika ada
            $(formId).find('.preview').hide();
            // Kosongkan input file jika ada
            $(formId).find('input[type="file"]').each(function() {
                $(this).val('');
            });
        }

        // Reset form saat modal ditutup
        $('#ModalEditSiswa').on('hidden.bs.modal', function() {
            resetForm('#formEditSiswa', '#ModalEditSiswa');
        });

        $('#ModalEditOrtu').on('hidden.bs.modal', function() {
            resetForm('#formEditOrtu', '#ModalEditOrtu');
        });

        $('#ModalEditWali').on('hidden.bs.modal', function() {
            resetForm('#formEditWali', '#ModalEditWali');
        });

        $('#ModalEditStatus').on('hidden.bs.modal', function() {
            resetForm('#formEditStatus', '#ModalEditStatus');
        });

        $('#ModalEditStatusSiswa').on('hidden.bs.modal', function() {
            resetForm('#formEditStatusSiswa', '#ModalEditStatusSiswa');
        });

        function showDataSiswa(url, formId, modalId, id) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        // Isi form berdasarkan data dari response
                        $(formId).find('input, select, textarea').each(function() {
                            var name = $(this).attr('name');
                            if (data[name]) {
                                // Handling untuk foto siswa
                                if (name === 'foto_siswa') {
                                    var fotoPath = '{{ asset('uploads/foto_siswa') }}/' +
                                        data.foto_siswa;
                                    $('#foto_siswa_preview').attr('src', fotoPath);
                                } else if ($(this).attr('type') === 'file') {
                                    // Untuk file input, lewati saja
                                } else if ($(this).attr('multiple') && name ===
                                    'imunisasi') {
                                    // Parsing imunisasi yang merupakan string JSON ke array
                                    try {
                                        var selectedValues = JSON.parse(data[name]);
                                        if (Array.isArray(selectedValues)) {
                                            $(this).val(selectedValues).trigger(
                                                'change'); // Pilih nilai pada select
                                            $(this).selectpicker(
                                                'refresh'); // Refresh selectpicker
                                        }
                                    } catch (e) {
                                        console.error("Error parsing imunisasi data:", e);
                                    }
                                } else {
                                    $(this).val(data[name]);
                                }
                            }
                        });

                        // Untuk select jenis kelamin
                        if (data.jenis_kelamin) {
                            $('#jenis_kelamin').val(data.jenis_kelamin).change();
                        }

                        $(formId).attr('data-id', id);

                        // Tampilkan modal
                        $(modalId).modal('show');

                        // Refresh selectpicker untuk seluruh elemen yang perlu di-refresh
                        $('.selectpicker').selectpicker('refresh');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Ditemukan',
                            text: 'Data siswa tidak ditemukan. Pastikan data yang dimasukkan sudah benar.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengambil data:', error);
                    console.log(xhr
                        .responseText); // Menampilkan response error dari server jika ada
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengambil data: ' + error
                    });
                }
            });
        }

        function showDataOrtu(url, formId, modalId, id) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        // Isi form berdasarkan data dari response untuk Data Ayah
                        if (data.ayah) {
                            $(formId).find('input, select, textarea').each(function() {
                                var name = $(this).attr('name');
                                if (data.ayah[name]) {
                                    // Jangan set input file
                                    if (name !== 'scan_ktp_ayah') {
                                        $(this).val(data.ayah[
                                            name]); // Set value untuk input lainnya
                                    }

                                    // Jika elemen select, set value dan trigger change
                                    if ($(this).is('select')) {
                                        $(this).val(data.ayah[name]).trigger('change');
                                    }
                                }
                            });

                            // Tampilkan pratinjau foto KTP Ayah jika ada
                            if (data.ayah.scan_ktp_ayah) {
                                $('#ktp-ayah-preview').show();
                                $('#view-ktp-ayah').attr('href',
                                    '{{ asset('uploads/ktp_ayah/') }}/' + data.ayah
                                    .scan_ktp_ayah); // Menambahkan path gambar
                            } else {
                                $('#ktp-ayah-preview').hide();
                            }
                        }

                        // Isi form berdasarkan data dari response untuk Data Ibu
                        if (data.ibu) {
                            $(formId).find('input, select, textarea').each(function() {
                                var name = $(this).attr('name');
                                if (data.ibu[name]) {
                                    // Jangan set input file
                                    if (name !== 'scan_ktp_ibu') {
                                        $(this).val(data.ibu[
                                            name]); // Set value untuk input lainnya
                                    }

                                    // Jika elemen select, set value dan trigger change
                                    if ($(this).is('select')) {
                                        $(this).val(data.ibu[name]).trigger('change');
                                    }
                                }
                            });

                            // Tampilkan pratinjau foto KTP Ibu jika ada
                            if (data.ibu.scan_ktp_ibu) {
                                $('#ktp-ibu-preview').show();
                                $('#view-ktp-ibu').attr('href',
                                    '{{ asset('uploads/ktp_ibu/') }}/' + data.ibu.scan_ktp_ibu
                                ); // Menambahkan path gambar
                            } else {
                                $('#ktp-ibu-preview').hide();
                            }
                        }

                        $(formId).attr('data-id', id);

                        // Tampilkan modal
                        $(modalId).modal('show');

                        // Refresh selectpicker untuk seluruh elemen yang perlu di-refresh
                        $('.selectpicker').selectpicker('refresh');
                    } else {
                        // Menampilkan SweetAlert error jika data tidak ditemukan
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Ditemukan',
                            text: 'Data orang tua tidak ditemukan. Pastikan data yang dimasukkan sudah benar.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengambil data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengambil data: ' + error
                    });
                }
            });
        }

        // Fungsi untuk menampilkan data wali
        function showDataWali(url, formId, modalId, id) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        // Isi form dengan data Wali
                        if (data) {

                            $(formId).find('input, select, textarea').each(function() {
                                var name = $(this).attr('name');
                                if (data[name] && name !== 'scan_kk_wali' && name !==
                                    'scan_kartu_pkh' && name !== 'scan_kartu_kks') {
                                    $(this).val(data[name]);
                                }
                            });

                            // Jika scan KK Wali ada, tampilkan ikon mata
                            if (data.scan_kk_wali) {
                                $('#scan-kk-wali-preview').show();
                                $('#view-kk-wali').attr('href',
                                    '{{ asset('uploads/scan_kk_wali/') }}/' + data.scan_kk_wali
                                );
                            } else {
                                $('#scan-kk-wali-preview').hide();
                            }

                            // Jika scan Kartu PKH ada, tampilkan ikon mata
                            if (data.scan_kartu_pkh) {
                                $('#scan-kartu-pkh-preview').show();
                                $('#view-kartu-pkh').attr('href',
                                    '{{ asset('uploads/scan_kartu_pkh/') }}/' + data
                                    .scan_kartu_pkh);
                            } else {
                                $('#scan-kartu-pkh-preview').hide();
                            }

                            // Jika scan Kartu KKS ada, tampilkan ikon mata
                            if (data.scan_kartu_kks) {
                                $('#scan-kartu-kks-preview').show();
                                $('#view-kartu-kks').attr('href',
                                    '{{ asset('uploads/scan_kartu_kks/') }}/' + data
                                    .scan_kartu_kks);
                            } else {
                                $('#scan-kartu-kks-preview').hide();
                            }

                        }

                        $(formId).attr('data-id', id);

                        // Tampilkan modal
                        $(modalId).modal('show');
                        // Refresh selectpicker jika menggunakan Bootstrap-Select
                        $('.selectpicker').selectpicker('refresh');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Ditemukan',
                            text: 'Data wali tidak ditemukan.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengambil data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengambil data: ' + error
                    });
                }
            });
        }

        // Fungsi untuk menampilkan data Status Keluarga
        function showDataKeluarga(url, formId, modalId, id) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        // Isi form dengan data Status Keluarga
                        if (data) {

                            $(formId).find('input, select, textarea').each(function() {
                                var name = $(this).attr('name');
                                if (data[name] && name !== 'scan_kk_keluarga') {
                                    $(this).val(data[name]);
                                }
                            });

                            // Tampilkan pratinjau foto KTP Ibu jika ada
                            if (data.scan_kk_keluarga) {
                                $('#scan-kk-keluarga-preview').show();
                                $('#view-scan-kk-keluarga').attr('href',
                                    '{{ asset('uploads/kk_keluarga/') }}/' + data
                                    .scan_kk_keluarga
                                ); // Menambahkan path gambar
                            } else {
                                $('#scan-kk-keluarga-preview').hide();
                            }
                        }

                        $(formId).attr('data-id', id);
                        // Tampilkan modal
                        $(modalId).modal('show');
                        // Refresh selectpicker jika menggunakan Bootstrap-Select
                        $('.selectpicker').selectpicker('refresh');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Ditemukan',
                            text: 'Data status keluarga tidak ditemukan.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengambil data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengambil data: ' + error
                    });
                }
            });
        }

        // Fungsi untuk menampilkan data Status Keluarga
        function showDataStatus(url, formId, modalId, id) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        var data = response.data;

                        // Isi form dengan data Status Keluarga
                        if (data) {
                            $(formId).find('input, select, textarea').each(function() {
                                var name = $(this).attr('name');
                                if (data[name]) {
                                    $(this).val(data[name]);
                                }
                            });
                        }

                        $(formId).attr('data-id', id);
                        // Tampilkan modal
                        $(modalId).modal('show');
                        // Refresh selectpicker jika menggunakan Bootstrap-Select
                        $('.selectpicker').selectpicker('refresh');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Ditemukan',
                            text: 'Data status keluarga tidak ditemukan.'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengambil data:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Terjadi kesalahan saat mengambil data: ' + error
                    });
                }
            });
        }
    });
</script>
