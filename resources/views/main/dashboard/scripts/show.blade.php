<script>
    $(document).ready(function() {
        // Fungsi untuk format mata uang
        function formatCurrency(value) {
            return 'Rp ' + parseFloat(value).toLocaleString('id-ID', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // AJAX untuk report satu
        $.ajax({
            url: '{{ route('main.dashboard.show.report.one') }}', // Ganti dengan URL yang sesuai
            method: 'GET',
            success: function(response) {
                // Menampilkan data jika ada
                if (response.message === 'data ditemukan') {
                    // Mengupdate elemen HTML dengan data yang diterima
                    $('#count-aktif').text(response.count_aktif || 0);
                    $('#count-with-tagihan').text(response.count_with_tagihan || 0);
                    $('#total-jumlah-bayar-today').text(formatCurrency(response
                        .total_jumlah_bayar_today || 0));

                    // Menyembunyikan pesan "belum ada data"
                    $('#no-data-message').addClass('d-none').removeClass('d-block');
                } else {
                    // Menampilkan pesan jika tidak ada data
                    $('#no-data-message').removeClass('d-none').addClass('d-block').text(
                        'Belum ada data');
                }
            },
            error: function() {
                $('#no-data-message').removeClass('d-none').addClass('d-block').text(
                    'Terjadi kesalahan saat mengambil data.');
            }
        });

        // AJAX untuk report dua
        $.ajax({
            url: '{{ route('main.dashboard.show.report.two') }}', // Ganti dengan URL yang sesuai
            method: 'GET',
            success: function(response) {
                // Menampilkan data jika ada
                if (response.message === 'data ditemukan') {
                    // Mengupdate elemen HTML dengan data yang diterima
                    $('#tagihan-value').text(formatCurrency(response.total_besar_tagihan || 0));
                    $('#potongan-value').text(formatCurrency(response.total_besar_potongan || 0));
                    $('#total-tagihan-value').text(formatCurrency(response.total_tagihan || 0));
                    $('#total-bayar-value').text(formatCurrency(response.total_bayar || 0));

                    // Menyembunyikan pesan "belum ada data"
                    $('#no-data-message').addClass('d-none').removeClass('d-block');
                } else {
                    // Menampilkan pesan jika tidak ada data
                    $('#no-data-message').removeClass('d-none').addClass('d-block').text(
                        'Belum ada data');
                }
            },
            error: function() {
                $('#no-data-message').removeClass('d-none').addClass('d-block').text(
                    'Terjadi kesalahan saat mengambil data.');
            }
        });

        // Fetch today's transactions
        $.ajax({
            url: '{{ route('main.dashboard.show.report.three') }}',
            method: 'GET',
            success: function(response) {
                const tbody = $('#example tbody');
                tbody.empty(); // Clear any existing rows

                if (response.success && response.data.length > 0) {
                    // Populate the table body with the received data
                    $.each(response.data, function(index, item) {
                        const siswaName = item.nis + ' - ' + item.nama_siswa;
                        const row = `
                            <tr>
                                <td>${item.nomor_transaksi}</td>
                                <td>${siswaName}</td>
                                <td>${item.jumlah_bayar}</td>
                            </tr>
                        `;
                        tbody.append(row);
                    });
                } else {
                    // Handle the case when no data is found
                    tbody.append(
                        '<tr><td colspan="3" class="text-center">Belum ada transaksi</td></tr>'
                    );
                }
            },
            error: function(error) {
                console.error('Error fetching transactions:', error);
                $('#example tbody').append(
                    '<tr><td colspan="3" class="text-center">Error fetching data</td></tr>');
            }
        });

        // Display today's date
        const today = new Date();
        const options = {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        };
        const formattedDate = today.toLocaleDateString('id-ID', options); // Format for Indonesia
        $('span.fs-12').text(formattedDate);
    });
</script>

<script>
    // Function to initialize ApexCharts
    function initializeChart(el, labels, data, title, color) {
        return new ApexCharts(el, {
            chart: {
                type: "line",
                height: 275,
            },
            series: [{
                name: "Jumlah",
                data: data,
            }, ],
            xaxis: {
                categories: labels,
            },
            title: {
                text: title,
                align: "left",
            },
            stroke: {
                curve: "smooth",
            },
            markers: {
                size: 5,
            },
            grid: {
                borderColor: "#e0e0e0",
            },
            colors: [color], // Set color for the line
        }).render();
    }

    // Fetch weekly transactions
    $(document).ready(function() {
        $.ajax({
            url: '{{ route('main.dashboard.show.report.four') }}',
            method: 'GET',
            success: function(response) {
                console.log(response); // Log the response
                if (response.success) {
                    const labels = response.data.map(item => item.date); // Extract dates
                    const data = response.data.map(item => parseFloat(item.total_bayar) ||
                        0); // Extract totals

                    // Initialize the weekly chart
                    initializeChart(
                        document.getElementById("weeklyChart"),
                        labels,
                        data,
                        "Jumlah Transaksi Mingguan",
                        "#33FF57" // Green color
                    );
                } else {
                    console.error('Failed to fetch data:', response.message);
                }
            },
            error: function(error) {
                console.error('Error fetching transactions:', error);
            }
        });
    });
</script>
