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
        Schema::create('ayah_siswa_baru', function (Blueprint $table) {
            $table->uuid('id_ayah_siswa_baru')->primary(); // Primary key menggunakan UUID
            $table->uuid('siswa_baru_id')->nullable(); // Relasi dengan tabel siswa_baru
            $table->string('nama_ayah_kandung')->nullable(); // Nama Ayah Kandung
            $table->string('status_ayah_kandung')->nullable(); // Status Ayah Kandung
            $table->string('nik_ayah', 16)->unique(); // NIK Ayah
            $table->string('tempat_lahir_ayah')->nullable(); // Tempat Lahir Ayah
            $table->date('tanggal_lahir_ayah')->nullable(); // Tanggal Lahir Ayah
            $table->enum('pendidikan_terakhir_ayah', ['sd', 'smp', 'sma', 'diploma', 'sarjana', 'pascaSarjana']); // Pendidikan Terakhir
            $table->enum('pekerjaan_ayah', ['pegawaiNegeri', 'swasta', 'wiraswasta', 'buruh', 'lainnya']); // Pekerjaan Ayah
            $table->integer('penghasilan_per_bulan_ayah')->nullable(); // Penghasilan per bulan Ayah
            $table->text('alamat_ayah')->nullable(); // Alamat Ayah
            $table->string('scan_ktp_ayah')->nullable(); // Foto KTP Ayah
            $table->timestamps(); // Timestamps

            // Menambahkan foreign key untuk relasi ke tabel siswa_baru
            $table->foreign('siswa_baru_id')->references('id_siswa_baru')->on('siswa_baru')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayah_siswa_baru');
    }
};
