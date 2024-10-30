<script>
    $('#createPotonganForm').on('submit', function(e) {
        e.preventDefault();

        // Collecting form data
        const siswaId = $('#siswa_id').val(); // Assuming siswa_id is part of the form
        const tagihanSiswaIds = [];
        const potonganIds = [];
        const potonganPersen = [];

        // Iterasi setiap tagihan-row
        $('.tagihan-row').each(function() {
            const tagihanId = $(this).data('tagihan-id');
            tagihanSiswaIds.push(tagihanId);

            const checkedPotongan = $(this).find('.potongan-checkbox:checked');
            if (checkedPotongan.length > 0) {
                checkedPotongan.each(function() {
                    const potonganId = $(this).data('potongan-id');
                    const persenInput = $(this).closest('.col-auto').find('.potongan_persen');
                    const potonganPersenValue = persenInput.val();

                    potonganIds.push(potonganId);
                    potonganPersen.push(potonganPersenValue);
                });
            } else {
                potonganIds.push(null); // Push null for unchecked
                potonganPersen.push(null); // Push null for unchecked
            }
        });

        // Kirim data melalui AJAX
        $.ajax({
            url: '{{ route('setting.potongan-siswa.store') }}',
            method: 'POST',
            data: {
                siswa_id: siswaId,
                tagihan_siswa_id: tagihanSiswaIds,
                potongan_id: potonganIds,
                potongan_persen: potonganPersen,
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then(function() {
                    location.reload(); // Reload tabel jika perlu
                });
                $('#detailTagihanModal').modal('hide');
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON.message ||
                    'Gagal menyimpan data potongan siswa.';
                Swal.fire('Error', errorMessage, 'error');
            }
        });
    });
</script>
