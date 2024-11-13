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
        Schema::create('keluarga_siswa_baru', function (Blueprint $table) {
            $table->uuid('id_keluarga_siswa_baru')->primary(); // Primary key menggunakan UUID
            $table->uuid('siswa_baru_id')->nullable(); // Relasi dengan tabel siswa_baru
            $table->string('nama_kepala_keluarga')->nullable(); // Nama Kepala Keluarga
            $table->string('nomor_kk')->nullable(); // Nomor KK
            $table->text('alamat_rumah')->nullable(); // Alamat Rumah
            $table->enum('yang_membiayai_sekolah', ['ayah', 'ibu', 'wali']); // Yang membiayai sekolah
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
        Schema::dropIfExists('keluarga_siswa_baru');
    }
};
