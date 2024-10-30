<script>
    // $(document).ready(function() {
    //     // Tombol untuk membuka modal set tagihan massal
    //     $('#setTagihanMassalBtn').click(function() {
    //         let selectedIds = [];
    //         $('.siswa-checkbox:checked').each(function() {
    //             selectedIds.push($(this).val());
    //         });

    //         if (selectedIds.length === 0) {
    //             alert('Pilih siswa terlebih dahulu.');
    //             return;
    //         }

    //         $('#setTagihanModal').modal('show');
    //         $('#setTagihanForm').off('submit').on('submit', function(e) {
    //             e.preventDefault();
    //             let iuran_id = $('#iuran_id').val();
    //             $.ajax({
    //                 url: "{{ route('setting.tagihan-siswa.store-multiple') }}",
    //                 method: "POST",
    //                 data: {
    //                     siswa_ids: selectedIds,
    //                     iuran_id: iuran_id,
    //                     _token: '{{ csrf_token() }}'
    //                 },
    //                 success: function(response) {
    //                     alert(response.success);
    //                     $('#setTagihanModal').modal('hide');
    //                     table.ajax.reload();
    //                 }
    //             });
    //         });
    //     });
    // });

    // $(document).ready(function() {
    //     // Tombol untuk membuka modal set tagihan massal
    //     $('#setTagihanMassalBtn').click(function() {
    //         let selectedIds = [];
    //         $('.siswa-checkbox:checked').each(function() {
    //             selectedIds.push($(this).val());
    //         });

    //         if (selectedIds.length === 0) {
    //             Swal.fire({
    //                 icon: 'warning',
    //                 title: 'Pilih Siswa!',
    //                 text: 'Anda harus memilih setidaknya satu siswa terlebih dahulu.',
    //                 confirmButtonText: 'OK'
    //             });
    //             return;
    //         }

    //         // Tampilkan modal
    //         $('#setTagihanModal').modal('show');

    //         // Reset form ketika modal ditutup
    //         $('#setTagihanModal').on('hidden.bs.modal', function() {
    //             $('#setTagihanForm')[0].reset(); // Reset form
    //             $('#iuran_id').val([]).trigger('change'); // Reset selectpicker
    //         });

    //         $('#setTagihanForm').off('submit').on('submit', function(e) {
    //             e.preventDefault();

    //             let iuran_ids = $('#iuran_id')
    //                 .val(); // Mendapatkan iuran yang dipilih (multiple select)

    //             if (iuran_ids.length === 0) {
    //                 Swal.fire({
    //                     icon: 'warning',
    //                     title: 'Pilih Iuran!',
    //                     text: 'Anda harus memilih setidaknya satu iuran.',
    //                     confirmButtonText: 'OK'
    //                 });
    //                 return;
    //             }

    //             $.ajax({
    //                 url: "{{ route('setting.tagihan-siswa.store-multiple') }}",
    //                 method: "POST",
    //                 data: {
    //                     siswa_ids: selectedIds, // Siswa yang dipilih
    //                     iuran_ids: iuran_ids, // Iuran yang dipilih
    //                     _token: '{{ csrf_token() }}'
    //                 },
    //                 success: function(response) {
    //                     Swal.fire({
    //                         icon: 'success',
    //                         title: 'Sukses!',
    //                         text: response.message,
    //                         confirmButtonText: 'OK'
    //                     }).then(function() {
    //                         $('#setTagihanModal').modal('hide');
    //                         location.reload(); // Reload tabel jika perlu
    //                     });
    //                 },
    //                 error: function(xhr) {
    //                     let errors = xhr.responseJSON.errors;
    //                     if (errors) {
    //                         let errorMsg = '';
    //                         $.each(errors, function(key, error) {
    //                             errorMsg += error + '\n';
    //                         });
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Error!',
    //                             text: 'Terjadi kesalahan:\n' + errorMsg,
    //                             confirmButtonText: 'OK'
    //                         });
    //                     } else {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Error!',
    //                             text: 'Terjadi kesalahan, coba lagi nanti.',
    //                             confirmButtonText: 'OK'
    //                         });
    //                     }
    //                 }
    //             });
    //         });
    //     });

    //     // Reset form input ketika modal ditutup
    //     $('#setTagihanModal').on('hidden.bs.modal', function() {
    //         $('#setTagihanForm')[0].reset();
    //         $('.selectpicker').selectpicker('refresh');
    //         $('#setTagihanForm .invalid-feedback').remove(); // Menghapus pesan error yang ada
    //         $('#setTagihanForm .form-control').removeClass('is-invalid'); // Menghapus class is-invalid
    //     });
    // });

    $(document).ready(function() {
        $('#setTagihanMassalBtn').click(function() {
            let selectedIds = [];
            $('.siswa-checkbox:checked').each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Pilih Siswa!',
                    text: 'Anda harus memilih setidaknya satu siswa terlebih dahulu.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Tampilkan modal
            $('#setTagihanModal').modal('show');

            // Reset form ketika modal ditutup
            $('#setTagihanModal').on('hidden.bs.modal', function() {
                $('#setTagihanForm')[0].reset(); // Reset form
                $('#iuran-checkboxes input[type="checkbox"]').prop('checked',
                false); // Reset checkboxes
            });

            $('#setTagihanForm').off('submit').on('submit', function(e) {
                e.preventDefault();

                // Ambil id iuran yang dipilih dari checkbox
                let iuran_ids = [];
                $('#iuran-checkboxes input[type="checkbox"]:checked').each(function() {
                    iuran_ids.push($(this).val());
                });

                if (iuran_ids.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Iuran!',
                        text: 'Anda harus memilih setidaknya satu iuran.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                $.ajax({
                    url: "{{ route('setting.tagihan-siswa.store-multiple') }}",
                    method: "POST",
                    data: {
                        siswa_ids: selectedIds, // Siswa yang dipilih
                        iuran_ids: iuran_ids, // Iuran yang dipilih dari checkbox
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: response.message,
                            confirmButtonText: 'OK'
                        }).then(function() {
                            $('#setTagihanModal').modal('hide');
                            location.reload(); // Reload tabel jika perlu
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            let errorMsg = '';
                            $.each(errors, function(key, error) {
                                errorMsg += error + '\n';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan:\n' + errorMsg,
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan, coba lagi nanti.',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });

        // Reset form input ketika modal ditutup
        $('#setTagihanModal').on('hidden.bs.modal', function() {
            $('#setTagihanForm')[0].reset();
            $('#iuran-checkboxes input[type="checkbox"]').prop('checked', false); // Reset checkboxes
            $('#setTagihanForm .invalid-feedback').remove(); // Menghapus pesan error yang ada
            $('#setTagihanForm .form-control').removeClass('is-invalid'); // Menghapus class is-invalid
        });
    });
</script>
