@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
@endsection

@section('content')
    <div class="content-body default-height">
        <div class="container-fluid">
            <div class="form-head mb-4">
                <h2 class="text-black font-w600 mb-0">Create Payment</h2>
            </div>

            <div class="alert alert-info">
                <p>Halaman ini digunakan untuk membuat pembayaran baru.</p>
            </div>

            <!-- Tambahkan tombol Coba -->
            <button id="cobaButton" class="btn btn-primary">Coba</button>
        </div>
    </div>
@endsection

@section('this-page-scripts')
    <script src="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script>
        // Kode JavaScript khusus untuk halaman Create Payment
        document.addEventListener('DOMContentLoaded', function() {
            console.log("Halaman Create Payment telah dimuat");

            // Event listener untuk tombol Coba
            document.getElementById('cobaButton').addEventListener('click', function() {
                Swal.fire({
                    title: 'Coba SweetAlert!',
                    text: 'Ini adalah pesan contoh.',
                    icon: 'info',
                    confirmButtonText: 'Oke'
                });
            });
        });
    </script>
@endsection
