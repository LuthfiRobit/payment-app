@extends('layouts.app')

@section('this-page-style')
    <link rel="stylesheet" href="{{ asset('template/vendor/sweetalert2/dist/sweetalert2.min.css') }}">
    <link href="{{ asset('template/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template/vendor/datatables/responsive/responsive.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content-body default-height">
        <div class="container-fluid">
            <div class="form-head mb-4">
                <h2 class="text-black font-w600 mb-0">Application - Profil</h2>
                <span class="fs-12">Silahkan lakukan pengaturan profil akun anda.</span>
            </div>
            <div class="row">
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="profile-personal-info">
                                        <h4 class="text-primary mb-4">Informasi Personal</h4>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 col-5">
                                                <h5 class="f-w-500">Nama <span class="pull-end">:</span>
                                                </h5>
                                            </div>
                                            <div class="col-sm-8 col-7">
                                                <span class="fs-7">{{ Auth::user()->name ?? 'Tidak Tersedia' }}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 col-5">
                                                <h5 class="f-w-500">Email <span class="pull-end">:</span>
                                                </h5>
                                            </div>
                                            <div class="col-sm-8 col-7">
                                                <span class="fs-7">{{ Auth::user()->email ?? 'Tidak Tersedia' }}</span>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-sm-4 col-5">
                                                <h5 class="f-w-500">Role <span class="pull-end">:</span>
                                                </h5>
                                            </div>
                                            <div class="col-sm-8 col-7">
                                                <span
                                                    class="fs-7 badge light badge-primary">{{ Auth::user()->role ?? 'Tidak Tersedia' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card h-auto">
                        <div class="card-body">
                            <div class="profile-tab">
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item"><a href="#about-me" data-bs-toggle="tab"
                                                class="nav-link active show">Personal</a>
                                        </li>
                                        <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab"
                                                class="nav-link">Password</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="about-me" class="tab-pane fade active show">
                                            <form id="updatePersonal" class="form-sm py-2">
                                                <!-- Nama Pengguna -->
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Pengguna</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="name" placeholder="Nama Pengguna" required minlength="3"
                                                        value="{{ Auth::user()->name ?? '' }}" />
                                                    <div id="nameError" class="text-danger"></div>
                                                    <!-- Tempat untuk menampilkan error name -->
                                                </div>
                                                <!-- Email -->
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control form-control-sm"
                                                        id="email" placeholder="Email" required
                                                        value="{{ Auth::user()->email ?? '' }}" />
                                                    <div id="emailError" class="text-danger"></div>
                                                    <!-- Tempat untuk menampilkan error email -->
                                                </div>
                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary btn-sm">Perbarui
                                                    Informasi</button>
                                            </form>
                                        </div>
                                        <div id="profile-settings" class="tab-pane fade">
                                            <form id="updatePassword" class="form-sm py-2">
                                                <!-- Password Sebelumnya Field -->
                                                <div class="mb-3">
                                                    <label for="current_password" class="form-label">Password
                                                        Sebelumnya</label>
                                                    <input type="password" class="form-control form-control-sm"
                                                        id="current_password" placeholder="Password Sebelumnya" required />
                                                    <small id="current-password-error" class="form-text text-danger"
                                                        style="display: none;">Password sebelumnya salah.</small>
                                                </div>

                                                <!-- Password Baru Field -->
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password Baru</label>
                                                    <input type="password" class="form-control form-control-sm"
                                                        id="password"
                                                        placeholder="Password Baru (kosongkan jika tidak ingin mengubah)"
                                                        minlength="6" required
                                                        title="Password harus terdiri dari minimal 6 karakter, mengandung huruf dan angka." />
                                                    <small class="form-text text-muted">Password harus terdiri dari minimal
                                                        6 karakter, mengandung huruf dan angka.</small>
                                                </div>

                                                <!-- Konfirmasi Password Baru -->
                                                <div class="mb-3">
                                                    <label for="confirm_password" class="form-label">Konfirmasi
                                                        Password</label>
                                                    <input type="password" class="form-control form-control-sm"
                                                        id="confirm_password" placeholder="Konfirmasi Password"
                                                        required />
                                                    <small id="password-error" class="form-text text-danger"
                                                        style="display: none;">Password dan konfirmasi password tidak
                                                        cocok.</small>
                                                </div>

                                                <!-- Password Visibility Toggle -->
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" id="show-password">
                                                    <label class="form-check-label" for="show-password">
                                                        Tampilkan Password
                                                    </label>
                                                </div>

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-primary btn-sm">Perbarui
                                                    Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('application.profil.views.create') --}}
    {{-- @include('application.profil.views.edit') --}}
@endsection

@section('this-page-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('application.profil.scripts.updateData')
    @include('application.profil.scripts.updatePassword')
@endsection
