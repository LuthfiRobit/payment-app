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
        Schema::create('ibu_siswa_baru', function (Blueprint $table) {
            $table->uuid('id_ibu_siswa_baru')->primary(); // Primary key menggunakan UUID
            $table->uuid('siswa_baru_id')->nullable(); // Relasi dengan tabel siswa_baru
            $table->string('nama_ibu_kandung')->nullable(); // Nama Ibu Kandung
            $table->string('status_ibu_kandung')->nullable(); // Status Ibu Kandung
            $table->string('nik_ibu', 16)->unique()->nullable(); // NIK Ibu
            $table->string('tempat_lahir_ibu')->nullable(); // Tempat Lahir Ibu
            $table->date('tanggal_lahir_ibu')->nullable(); // Tanggal Lahir Ibu
            $table->enum('pendidikan_terakhir_ibu', ['sd', 'smp', 'sma', 'diploma', 'sarjana', 'pascaSarjana']); // Pendidikan Terakhir
            $table->enum('pekerjaan_ibu', ['ibuRumahTangga', 'guru', 'pegawaiNegeri', 'swasta', 'wiraswasta', 'lainnya']); // Pekerjaan Ibu
            $table->integer('penghasilan_per_bulan_ibu')->nullable(); // Penghasilan per bulan Ibu
            $table->text('alamat_ibu')->nullable(); // Alamat Ibu
            $table->string('scan_ktp_ibu')->nullable(); // Foto KTP Ibu
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
        Schema::dropIfExists('ibu_siswa_baru');
    }
};
