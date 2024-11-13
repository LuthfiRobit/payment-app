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
        Schema::create('wali_siswa_baru', function (Blueprint $table) {
            $table->uuid('id_wali_siswa_baru')->primary(); // Primary key menggunakan UUID
            $table->uuid('siswa_baru_id')->nullable(); // Relasi dengan tabel siswa_baru
            $table->string('nama_wali')->nullable(); // Nama Wali (opsional)
            $table->string('scan_kk_wali')->nullable(); // Scan KK Wali (opsional)
            $table->string('scan_kartu_pkh')->nullable(); // Scan Kartu PKH (opsional)
            $table->string('scan_kartu_kks')->nullable(); // Scan Kartu KKS (opsional)
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
        Schema::dropIfExists('wali_siswa_baru');
    }
};
