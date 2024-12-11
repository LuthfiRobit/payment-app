<script>
    const showUrl = "{{ route('transaksi.setor.keuangan.find') }}"; // URL untuk mengambil data
    let tagihanId = null; // Variabel untuk menyimpan tagihan_id

    $(document).ready(function() {
        initializeSelectPickers();
        setupEventListeners();
    });

    // Inisialisasi select pickers
    function initializeSelectPickers() {
        $('#filter_tahun').selectpicker();
        // Initial selectpicker untuk filter bulan
        $('#filter_bulan').selectpicker();
    }

    // Menyiapkan event listener untuk perubahan filter
    function setupEventListeners() {
        $('#filter_tahun, #filter_bulan').on('change', handleFilterChange);
    }

    // Menangani perubahan filter
    function handleFilterChange() {
        const filterTahun = $('#filter_tahun').val();
        const filterBulan = $('#filter_bulan').val();

        if (filterTahun && filterBulan) {
            fetchData(filterTahun, filterBulan);
        }

        // Panggil fungsi untuk memperbarui tahun dan bulan ketika filter berubah
        const textTahun = $('#filter_tahun').find('option:selected').text(); // Ambil teks, bukan nilai
        const valBulan = $('#filter_bulan').find('option:selected').val(); // Ambil teks bulan
        const textBulan = $('#filter_bulan').find('option:selected').text(); // Ambil teks bulan
        updateYearMonthTitle(textTahun, valBulan, textBulan);
    }

    // Fungsi untuk memperbarui tahun dan bulan pada tag <h4>
    function updateYearMonthTitle(tahun, bulan, namaBulan) {
        // Update tampilan tahun dan bulan
        $('#show_tahun').text(`${tahun}`);
        $('#show_bulan').text(`${bulan}`);
        $('#tahun').val(`${tahun}`);
        $('#bulan').val(`${bulan}`);
        $('#nama_bulan').val(`${namaBulan}`);
    }

    // Mengambil data dari server berdasarkan filter
    function fetchData(tahun, bulan) {
        const url = `${showUrl}?filter_tahun=${tahun}&filter_bulan=${bulan}`;

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
            const transaksi = response.data.transaksi;
            const rincianTransaksi = response.data.rincian_transaksi;

            // Populate data transaksi (tahun, bulan, keterangan, dll)
            populateTransactionDetails(transaksi);

            // Populate tabel rincian setoran
            populatePaymentDetails(rincianTransaksi);

            // Reset input fields for creating new setoran
            resetInputFields(rincianTransaksi);

            // Update total bayar
            updateTotalBayar();

            // Nonaktifkan tombol jika statusnya 'lunas'
            if (transaksi.setoran_status === 'lunas') {
                $('#save-setoran-btn').prop('disabled', true);
                Swal.fire({
                    icon: 'info',
                    title: 'Setoran Selesai',
                    text: 'Setoran ini sudah selesai.',
                    confirmButtonText: 'OK'
                });
            } else {
                $('#save-setoran-btn').prop('disabled', false);
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

    // Mengisi detail transaksi pada antarmuka
    function populateTransactionDetails(transaksi) {
        $('#show_tahun').text(transaksi.tahun);
        $('#show_bulan').text(transaksi.bulan);
        $('#show_terbayar').text(transaksi.jumlah_bayar ?
            `Rp. ${parseFloat(transaksi.jumlah_bayar).toLocaleString('id-ID')}` : '-');
        $('#show_total').text(transaksi.total_setoran ?
            `Rp. ${parseFloat(transaksi.total_setoran).toLocaleString('id-ID')}` : '-');
        $('#show_sisa').text(transaksi.sisa_setoran ?
            `Rp. ${parseFloat(transaksi.sisa_setoran).toLocaleString('id-ID')}` : '-');
        $('#show_keterangan').text(transaksi.keterangan || '-');
        $('#show_status').text(transaksi.setoran_status || '-');
    }

    // Mengisi tabel rincian setoran pada antarmuka
    function populatePaymentDetails(rincian) {
        const $tbody = $('#setoran-details tbody');
        $tbody.empty();

        let totalTagihan = 0;
        let totalSetoran = 0;
        let totalSisa = 0;

        rincian.forEach(item => {
            // Mengambil nilai-nilai dari response
            const totalBayar = parseFloat(item.total_bayar || 0); // Nilai yang dibayar (jika ada)
            const totalTagihanFormatted = parseFloat(item.total_bayar).toLocaleString(
                'id-ID'); // Jumlah yang harus dibayar
            const totalSetoranFormatted = item.total_setoran ? parseFloat(item.total_setoran).toLocaleString(
                'id-ID') : '0'; // Total setoran (jika ada)
            const sisaSetoran = item.sisa_setoran ? parseFloat(item.sisa_setoran).toLocaleString('id-ID') :
                '0'; // Sisa setoran (jika ada, jika tidak ambil total tagihan)
            const status = item.rincian_status || '-'; // Status jika ada

            $tbody.append(`
            <tr>
                <td>${item.nama_iuran}</td>
                <td>Rp ${totalTagihanFormatted},00</td>
                <td>Rp ${totalSetoranFormatted},00</td>
                <td>Rp ${sisaSetoran},00</td>
                <td>${status}</td>
            </tr>
        `);

            // Menghitung total untuk footer
            totalTagihan += parseFloat(item.total_bayar || 0);
            totalSetoran += parseFloat(item.total_setoran || 0);
            // Sisa tagihan dihitung dari total harus dibayar - total yang sudah dibayar
            totalSisa += parseFloat(item.sisa_setoran || 0);
        });

        // Update footer totals
        $('#show_total_tagihan').text(`Rp. ${totalTagihan.toLocaleString('id-ID')}`);
        $('#show_total_setoran').text(`Rp. ${totalSetoran.toLocaleString('id-ID')}`);
        $('#show_total_sisa').text(`Rp. ${totalSisa.toLocaleString('id-ID')}`);
    }

    // Mereset input field
    function resetInputFields(rincian) {
        const $containerInput = $('#containerInput');
        $containerInput.empty();

        rincian.forEach((item, index) => {
            const isLunas = item.rincian_status === 'lunas'; // Mengecek status 'lunas'
            const totalSetoran = item.total_setoran; // Mengecek status 'lunas'
            const jumlahBayarValue = isLunas ? 0 : ''; // Jika lunas, set jumlah bayar menjadi 0

            // Jika status lunas, set nilai sisa_setoran menjadi 0
            const sisaSetoranValue = isLunas ? 0 : ''; // Sisa setoran = 0 jika lunas

            // Menambahkan logika untuk mengecek apakah total_bayar = 0
            const isTotalBayarZero = parseFloat(item.total_bayar) === 0;

            $containerInput.append(`
            <div class="row mb-3 rincian-item" data-index="${index}" data-iuran-id="${item.id_iuran}" data-iuran-bayar="${item.total_bayar}" data-iuran-status="${isLunas}">
                <div class="col-lg-3 mb-2">
                    <label for="nama_iuran_${index}" class="form-label">Iuran</label>
                    <input type="text" class="form-control" id="nama_iuran_${index}" value="${item.nama_iuran}" readonly>
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="harus_dibayar_${index}" class="form-label">Jumlah Harus Disetor</label>
                    <input type="text" class="form-control" id="harus_dibayar_${index}" value="Rp ${parseFloat(item.harus_dibayar).toLocaleString('id-ID')},00" readonly>
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="total_setoran_${index}" class="form-label">Jumlah Setoran</label>
                    <input type="number" class="form-control" id="total_setoran_${index}" placeholder="Jumlah yang dibayar" min="0" max="${item.harus_dibayar}" value="${isLunas || isTotalBayarZero ? totalSetoran : jumlahBayarValue}" ${isLunas || isTotalBayarZero ? 'readonly' : ''} required>
                    <small class="form-text text-muted">Jika tidak ada setoran, isi nilai 0</small>
                </div>
                <div class="col-lg-3 mb-2">
                    <label for="sisa_setoran_${index}" class="form-label">Sisa Setoran</label>
                    <input type="number" class="form-control" id="sisa_setoran_${index}" value="${sisaSetoranValue}" readonly>
                </div>
            </div>
        `);
        });

        // Add event listener for the amount paid input
        $('#containerInput').on('input', 'input[id^="total_setoran_"]', function() {
            // Update total bayar and sisa setoran when input changes
            updateTotalBayar();

            // Perform validation on total setoran input
            validateTotalSetoran($(this));
        });

        // Initial update of total bayar and sisa setoran after rendering
        updateTotalBayar();
    }


    // Mengupdate total bayar, total setoran, dan sisa setoran
    function updateTotalBayar() {
        let totalSetoran = 0;
        let totalHarusDibayar = 0;
        let totalSisaSetoran = 0;

        // Loop through each rincian item and update 'sisa_setoran'
        $('#containerInput .rincian-item').each(function() {
            const index = $(this).data('index');

            // Get the value of 'jumlah_bayar' and clean it up
            let jumlahBayarValue = $(`#total_setoran_${index}`).val();

            // Remove any non-numeric characters (like Rp, commas, etc.)
            jumlahBayarValue = jumlahBayarValue.replace(/[^0-9,]/g, '').replace(',', '.');
            const jumlahBayar = parseFloat(jumlahBayarValue) || 0;

            // Get the value of 'harus_dibayar' and clean it up
            let harusDibayarValue = $(`#harus_dibayar_${index}`).val();
            harusDibayarValue = harusDibayarValue.replace(/[^0-9,]/g, '').replace(',', '.');
            const harusDibayar = parseFloat(harusDibayarValue) || 0;

            // Determine if the status is 'lunas'
            const isLunas = $(this).data('iuran-status') === true; // Checking if the status is 'lunas'

            // If 'lunas', set sisa_setoran to 0, otherwise calculate the remaining amount
            const sisaSetoran = isLunas ? 0 : harusDibayar - jumlahBayar;

            // Update the individual sisa_setoran input field
            $(`#sisa_setoran_${index}`).val(sisaSetoran);

            // If it's not 'lunas', calculate the total sisa setoran
            if (!isLunas) {
                // Update the totals for all items
                totalSisaSetoran += sisaSetoran;
                totalSetoran += jumlahBayar;
                totalHarusDibayar += harusDibayar;
            }
        });

        // Update the total setoran and total sisa setoran fields
        $('#total_setoran_all').val(totalSetoran); // Total setoran bayar
        $('#sisa_setoran_all').val(totalSisaSetoran); // Total sisa setoran, excluding 'lunas' items
    }


    // Validasi input total setoran
    function validateTotalSetoran(input) {
        const maxBayar = parseFloat(input.attr('max')); // Get max value from the input
        const jumlahBayar = parseFloat(input.val()); // Get the current input value

        // Check if the input is invalid (less than 0 or more than the max value)
        if (jumlahBayar < 0 || jumlahBayar > maxBayar) {
            input.addClass('is-invalid');
            input.siblings('.invalid-feedback').remove(); // Remove existing error messages
            input.after(
                `<div class="invalid-feedback">Jumlah tidak boleh lebih dari Rp ${maxBayar.toLocaleString('id-ID')},00 dan tidak boleh kurang dari 0.</div>`
            );
        } else {
            input.removeClass('is-invalid');
            input.siblings('.invalid-feedback').remove(); // Remove error messages if valid
        }
    }

    // Mereset tampilan ke kondisi kosong
    function resetView() {
        $('#show_bulan, #show_tahun, #show_terbayar, #show_total, #show_sisa, #show_status, #show_keterangan, #show_total_tagihan, #show_total_setoran, #show_total_sisa')
            .text('-');
        $('#setoran-details tbody').empty();
        $('#containerInput').empty();
        $('#total_setoran_all').val(0);
        $('#sisa_setoran_all').val(0);
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
