@extends('layouts.app')

@section('this-page-style')
@endsection

@section('content')
    <div class="content-body default-height authincation fix-wrapper"
        style="background-image: url({{ asset('template/images/student-bg.jpg') }}); background-repeat:no-repeat; background-size:cover;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-input-content error-page">
                        <h1 class="error-text text-primary">403</h1>
                        <h4>Forbidden Error!</h4>
                        <p>Anda tidak memiliki izin untuk mengakses halaman ini.</p>
                        <a class="btn btn-primary"
                            href="{{ auth()->user()->role === 'petugas_emis' ? route('main.dashboard-ppdb.index') : route('main.dashboard.index') }}">
                            Kembali ke dashboard
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <img class="w-100" src="{{ asset('template/images/under-m.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection

@section('this-page-scripts')
@endsection
