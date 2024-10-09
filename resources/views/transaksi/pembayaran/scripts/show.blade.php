<script>
    const showUrl = "{{ route('transaksi.pembayaran.show') }}"; // URL untuk mengambil data
    let tagihanId = null; // Variabel untuk menyimpan tagihan_id

    $(document).ready(function() {
        initializeSelectPickers();
        setupEventListeners();
    });

    // Inisialisasi select pickers
    function initializeSelectPickers() {
        $('#filter_tahun, #filter_siswa').selectpicker();
    }

    // Menyiapkan event listener untuk perubahan filter
    function setupEventListeners() {
        $('#filter_tahun, #filter_siswa').on('change', handleFilterChange);
    }

    // Menangani perubahan filter
    function handleFilterChange() {
        const filterTahun = $('#filter_tahun').val();
        const filterSiswa = $('#filter_siswa').val();

        if (filterTahun && filterSiswa) {
            fetchData(filterTahun, filterSiswa);
        }

        // Panggil fungsi untuk memperbarui judul tahun ketika filter berubah
        const textTahun = $('#filter_tahun').find('option:selected').text(); // Ambil teks, bukan nilai
        updateYearTitle(textTahun);
    }

    // Fungsi untuk memperbarui tahun pada tag <h4>
    function updateYearTitle(tahun) {
        // Gunakan nilai tahun yang dipilih langsung untuk judul
        $('#show_filter_tahun').text(`${tahun}`);
    }

    // Mengambil data dari server berdasarkan filter
    function fetchData(tahun, siswa) {
        const url = `${showUrl}?filter_tahun=${tahun}&filter_siswa=${siswa}`;

        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: handleResponse,
            error: handleError
        });
    }

    function handleResponse(response) {
        if (response.success) {
            tagihanId = response.data.id_tagihan; // Simpan tagihan_id dari respons
            populateStudentDetails(response.siswa, response.data);
            populatePaymentDetails(response.rincian);
            resetInputFields(response.rincian);
            $('#total_bayar').val('0');

            // Nonaktifkan tombol jika statusnya 'lunas'
            if (response.data.status === 'lunas') {
                $('#save-payment-btn').prop('disabled', true); // Nonaktifkan tombol
                Swal.fire({
                    icon: 'info',
                    title: 'Pembayaran Selesai',
                    text: 'Pembayaran ini sudah selesai.',
                    confirmButtonText: 'OK'
                });
            } else {
                $('#save-payment-btn').prop('disabled', false); // Aktifkan tombol
            }

        } else {
            resetView();
            showAlert('warning', 'Tidak Ditemukan!', response.message);
        }
    }

    // Menangani kesalahan respons
    function handleError(xhr) {
        resetView();
        const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat mengambil data.';
        showAlert('error', 'Error!', errorMessage);
    }

    // Mengisi detail siswa pada antarmuka
    function populateStudentDetails(siswa, tagihan) {
        $('#show_nis').text(siswa.nis);
        $('#show_nama_siswa').text(siswa.nama_siswa);
        $('#show_kelas').text(siswa.kelas);
        $('#show_status').text(tagihan.status);
    }

    // Mengisi tabel rincian pembayaran pada antarmuka
    function populatePaymentDetails(rincian) {
        const $tbody = $('#payment-details tbody');
        $tbody.empty();

        rincian.forEach(item => {
            const totalTagihan = item.total_tagihan.toLocaleString('id-ID');
            const besarTagihan = item.besar_tagihan.toLocaleString('id-ID');
            const besarPotongan = item.besar_potongan.toLocaleString('id-ID');
            const sisaTagihan = item.sisa_tagihan.toLocaleString('id-ID');

            $tbody.append(`
                <tr>
                    <td>${item.nama_iuran}</td>
                    <td>Rp ${besarTagihan},00</td>
                    <td>${item.nama_potongan || 'Tidak ada'}</td>
                    <td>Rp ${besarPotongan},00</td>
                    <td>Rp ${totalTagihan},00</td>
                    <td>Rp ${item.status === 'belum lunas' ? sisaTagihan : '0'},00</td>
                </tr>
            `);
        });
    }

    // Mereset input field
    function resetInputFields(rincian) {
        const $containerInput = $('#containerInput');
        $containerInput.empty();

        rincian.forEach((item, index) => {
            const isLunas = item.status === 'lunas'; // Cek apakah statusnya 'lunas'
            const jumlahBayarValue = isLunas ? 0 : ''; // Set nilai ke 0 jika 'lunas', jika tidak kosong

            $containerInput.append(`
                <div class="row mb-3 rincian-item" data-index="${index}" data-rincian-tagihan-id="${item.id_rincian_tagihan}">
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label for="nama_iuran_${index}" class="form-label">Iuran</label>
                        <input type="text" class="form-control" id="nama_iuran_${index}" value="${item.nama_iuran}" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label for="sisa_tagihan_${index}" class="form-label">Jumlah yang Harus Dibayar</label>
                        <input type="text" class="form-control" id="sisa_tagihan_${index}" value="Rp ${item.sisa_tagihan.toLocaleString('id-ID')},00" readonly>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 mb-2">
                        <label for="jumlah_bayar_${index}" class="form-label">Jumlah yang Dibayar</label>
                        <input type="number" class="form-control" id="jumlah_bayar_${index}" placeholder="Jumlah yang dibayar" min="0" max="${item.sisa_tagihan}" value="${jumlahBayarValue}" ${isLunas ? 'readonly' : ''} required>
                        <small class="form-text text-muted">Jika tidak ada pembayaran, isi nilai 0</small>
                    </div>
                </div>
            `);
        });

        // Tambahkan event listener untuk input jumlah_bayar
        $('#containerInput').on('input', 'input[id^="jumlah_bayar_"]', function() {
            updateTotalBayar();
        });
    }

    // Mengupdate total bayar
    function updateTotalBayar() {
        let totalBayar = 0;

        // Loop untuk setiap input 'jumlah_bayar' dan tambahkan nilainya ke total
        $('input[id^="jumlah_bayar_"]').each(function() {
            const value = parseFloat($(this).val().replace(/[^0-9.]/g, '')) || 0;
            totalBayar += value;
        });

        // Update field total bayar sebagai angka biasa (tanpa format)
        $('#total_bayar').val(totalBayar); // Ini akan menyimpan angka mentah (misalnya, 10000)
    }

    // Mereset tampilan ke kondisi kosong
    function resetView() {
        $('#show_nis, #show_nama_siswa, #show_kelas, #show_status').text('-');
        $('#payment-details tbody').empty();
        $('#containerInput').empty();
        $('#total_bayar').val(0);
    }

    // Menampilkan alert dengan pesan kustom
    function showAlert(icon, title, text) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            confirmButtonText: 'OK'
        });
    }
</script>
