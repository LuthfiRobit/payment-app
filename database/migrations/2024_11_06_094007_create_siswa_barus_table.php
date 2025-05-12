<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('siswa_baru', function (Blueprint $table) {
            $table->uuid('id_siswa_baru')->primary(); // Primary key menggunakan UUID
            $table->uuid('tahun_akademik_id')->nullable();
            $table->string('nik', 16)->unique(); // NIK Siswa
            $table->string('no_registrasi')->nullable(); // No Registrasi
            $table->string('nama_lengkap_siswa')->nullable(); // Nama Lengkap Siswa
            $table->string('nama_panggilan')->nullable(); // Nama Panggilan
            $table->string('tempat_lahir')->nullable(); // Tempat Lahir
            $table->date('tanggal_lahir')->nullable(); // Tanggal Lahir
            $table->enum('status', ['diterima', 'ditolak', 'digenerate'])->nullable(); // Status penerimaan
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']); // Jenis Kelamin
            $table->integer('usia_saat_mendaftar')->nullable(); // Usia saat mendaftar
            $table->integer('jumlah_saudara')->nullable(); // Jumlah Saudara
            $table->integer('anak_ke')->nullable(); // Anak Ke
            $table->integer('nomor_peci')->nullable(); // Nomor Songkok/Peci
            $table->string('nomor_hp_wa')->nullable(); // Nomor HP/WA
            $table->string('email')->nullable(); // Alamat Email
            $table->integer('jarak_dari_rumah_ke_sekolah')->nullable(); // Jarak dari rumah ke sekolah
            $table->enum('perjalanan_ke_sekolah', ['jalan_kaki', 'sepeda', 'motor', 'mobil', 'angkot', 'ojek', 'lainnya']); // Perjalanan ke sekolah
            $table->string('sekolah_sebelum_mi')->nullable(); // Sekolah sebelum MI
            $table->string('nama_ra_tk')->nullable(); // Nama RA/TK
            $table->string('alamat_ra_tk')->nullable(); // Alamat RA/TK
            $table->string('foto_siswa')->nullable(); // Foto Siswa
            $table->json('imunisasi')->nullable(); // Imunisasi yang telah diikuti
            $table->uuid('created_by')->nullable(); // Menyimpan ID user yang membuat data
            $table->uuid('updated_by')->nullable(); // Menyimpan ID user yang mengedit data terakhir
            $table->timestamps(); // Timestamps

            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik')->onDelete('no action')->onUpdate('no action');
            $table->foreign('created_by')->references('id_user')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id_user')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_baru');
    }
};
