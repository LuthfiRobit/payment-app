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
        Schema::create('guru_karyawan', function (Blueprint $table) {
            $table->uuid('id_guru_karyawan')->primary();
            $table->string('nama');
            $table->string('jabatan');
            $table->enum('kategori', ['guru', 'karyawan']);
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'tidak aktif']);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_karyawan');
    }
};
