<script>
    $(document).ready(function() {

        $.ajax({
            url: '{{ route('main.dashboard-ppdb.show.report.one') }}', // Ganti dengan URL yang sesuai
            method: 'GET',
            success: function(response) {
                console.log(response);

                // Menampilkan data jika ada
                if (response.message === 'data ditemukan') {
                    // Mengupdate elemen HTML dengan data yang diterima
                    $('#count-siswa-mendaftar').text(response.count_mendaftar ||
                        0); // Jumlah siswa yang mendaftar
                    $('#count-siswa-diterima').text(response.count_diterima ||
                        0); // Jumlah siswa diterima
                    $('#count-siswa-ditolak').text(response.count_ditolak ||
                        0); // Jumlah siswa ditolak
                    $('#count-siswa-digenerate').text(response.count_digenerate ||
                        0); // Jumlah siswa digenerate
                    $('#count-belum-diproses').text(response.count_belum_diproses ||
                        0); // Jumlah siswa belum diproses

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

        // Fetch today's registration
        $.ajax({
            url: '{{ route('main.dashboard-ppdb.show.report.two') }}',
            method: 'GET',
            success: function(response) {
                const tbody = $('#example tbody');
                tbody.empty(); // Clear any existing rows

                if (response.success && response.data.length > 0) {
                    // Populate the table body with the received data
                    $.each(response.data, function(index, item) {
                        // Menentukan kelas badge dan label status berdasarkan item.status
                        let badgeClass = '';
                        let statusLabel = '';

                        switch (item.status) {
                            case 'diterima':
                                badgeClass = 'badge-success';
                                statusLabel = 'DITERIMA';
                                break;
                            case 'ditolak':
                                badgeClass = 'badge-danger';
                                statusLabel = 'DITOLAK';
                                break;
                            case 'digenerate':
                                badgeClass = 'badge-warning';
                                statusLabel = 'DIGENERATE';
                                break;
                            default:
                                badgeClass = 'badge-secondary';
                                statusLabel = 'BELUM DIPROSES';
                                break;
                        }

                        // Membuat row dengan badge status
                        const row = `
                        <tr>
                            <td>${item.no_registrasi}</td>
                            <td>${item.nama_panggilan}</td>
                            <td>${item.usia_saat_mendaftar}</td>
                            <td><span class="badge ${badgeClass}">${statusLabel}</span></td>
                        </tr>
                    `;
                        tbody.append(row);
                    });
                } else {
                    // Handle the case when no data is found
                    tbody.append(
                        '<tr><td colspan="4" class="text-center">Belum ada pendaftaran</td></tr>'
                    );
                }
            },
            error: function(error) {
                console.error('Error fetching transactions:', error);
                $('#example tbody').append(
                    '<tr><td colspan="4" class="text-center">Error fetching data</td></tr>');
            }
        });

    });
</script>


<script>
    $(document).ready(function() {
        // Fungsi untuk mengambil data distribusi umur siswa
        function fetchDistribusiUsia() {
            $.ajax({
                url: '{{ route('main.dashboard-ppdb.show.report.three') }}', // Ganti dengan URL ke method controller yang mengembalikan distribusi usia
                method: 'GET',
                dataType: 'json', // Data yang diharapkan dalam format JSON
                success: function(response) {
                    // Memeriksa apakah respons statusnya 'success'
                    if (response.success === true) {
                        const usiaData = response.data; // Data distribusi usia yang diterima

                        // Verifikasi dan pastikan data tidak mengandung NaN
                        for (const ageRange in usiaData) {
                            if (isNaN(usiaData[ageRange])) {
                                usiaData[ageRange] = 0; // Gantikan NaN dengan 0
                            }
                        }

                        // Update chart dengan data yang diterima
                        updateChart(usiaData);
                    } else {
                        console.error("Error:", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        }

        // Fungsi untuk memperbarui chart dengan data distribusi usia
        function updateChart(usiaData) {
            // Pastikan data distribusi usia memiliki rentang usia sebagai key dan jumlah siswa sebagai value
            const ageRanges = Object.keys(usiaData);
            const studentCounts = ageRanges.map(function(ageRange) {
                return usiaData[ageRange]; // Mengambil jumlah siswa per rentang usia
            });

            // Persentase per kelompok usia
            const totalSiswa = studentCounts.reduce(function(sum, count) {
                return sum + count;
            }, 0);

            // Menghindari pembagian dengan 0
            const percentages = studentCounts.map(function(count) {
                return (totalSiswa > 0) ? (count / totalSiswa * 100).toFixed(2) :
                    0; // Membulatkan persentase
            });

            // Verifikasi bahwa tidak ada NaN dalam persentase
            const validPercentages = percentages.map(function(percentage) {
                return isNaN(percentage) ? 0 : parseFloat(
                    percentage); // Pastikan tidak ada NaN, ganti dengan 0
            });

            // Menggunakan ApexCharts untuk membuat Pie chart
            var options = {
                chart: {
                    type: 'pie',
                    height: 275,
                },
                series: validPercentages, // Persentase siswa per kelompok usia
                labels: ageRanges, // Rentang usia yang diambil dari data
                colors: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0', '#ff5733'], // Warna chart
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + '%'; // Menambahkan tanda persen di tooltip
                        }
                    }
                }
            };

            // Render chart ke elemen dengan id "umurChartPie"
            var chart = new ApexCharts(document.querySelector("#umurChartPie"), options);
            chart.render();
        }

        // Panggil fungsi fetchDistribusiUsia saat halaman dimuat
        fetchDistribusiUsia();
    });
</script>
