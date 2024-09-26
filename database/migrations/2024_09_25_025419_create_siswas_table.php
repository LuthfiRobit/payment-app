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
            $table->string('nisn')->unique();
            $table->string('nama');
            $table->enum('status', ['aktif', 'tidak aktif']);
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir'); // Menambahkan kolom tempat lahir
            $table->string('alamat');
            $table->string('nomor_telepon')->nullable();
            $table->string('email')->nullable();
            $table->enum('kelas', ['1', '2', '3', '4', '5', '6']); // Kelas sebagai enum dengan angka 1-6
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
