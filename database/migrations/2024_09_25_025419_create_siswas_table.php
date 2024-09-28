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
        Schema::create('siswa', function (Blueprint $table) {
            $table->uuid('id_siswa')->primary();
            $table->uuid('user_id')->nullable();
            $table->string('nis')->unique(); // NISN harus unik
            $table->string('nama_siswa'); // Nama siswa
            $table->enum('status', ['aktif', 'tidak aktif']); // Status siswa
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']); // Jenis kelamin
            $table->date('tanggal_lahir')->nullable(); // Tanggal lahir (nullable)
            $table->string('tempat_lahir')->nullable(); // Tempat lahir (nullable)
            $table->string('alamat')->nullable(); // Alamat (nullable)
            $table->string('nomor_telepon')->nullable(); // Nomor telepon (nullable)
            $table->string('email')->nullable(); // Email (nullable)
            $table->enum('kelas', ['1', '2', '3', '4', '5', '6']); // Kelas sebagai enum
            $table->timestamps();

            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('no action')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
